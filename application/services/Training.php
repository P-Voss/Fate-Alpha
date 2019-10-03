<?php

/**
 * Description of Training
 *
 * @author Vosser
 */
class Application_Service_Training
{

    /**
     * @var Application_Model_Mapper_TrainingMapper
     */
    private $trainingsMapper;

    public function __construct ()
    {
        $this->trainingsMapper = new Application_Model_Mapper_TrainingMapper();
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return Application_Model_Training_Program[]
     * @throws Exception
     */
    public function getTrainingPrograms ($charakter)
    {
        $programs = $this->trainingsMapper->getTrainingPrograms();
        $mods = $this->trainingsMapper->getTrainingMods($charakter);
        $trainings = [];
        foreach ($programs as $program)
        {
            $trainings[] = $this->calculateTrainingValues($program, $mods);
        }
        return $trainings;
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $programId
     *
     * @return Application_Model_Training_Program
     *
     * @throws Exception
     */
    public function getCharakterTrainingProgramById (Application_Model_Charakter $charakter, $programId)
    {
        $program = $this->trainingsMapper->getTrainingProgramById($programId);
        $mods = $this->trainingsMapper->getTrainingMods($charakter);
        return $this->calculateTrainingValues($program, $mods);
    }

    /**
     * @param Application_Model_Training_Program $program
     * @param Application_Model_Training_Mods[] $mods
     *
     * @return Application_Model_Training_Program
     */
    private function calculateTrainingValues (Application_Model_Training_Program $program, array $mods)
    {
        $primaryAttribute = $program->getPrimaryAttribute();
        $primaryAttribute->setValue(Application_Model_Training_Defaultvalues::PRIMARY);
        $secondaryAttribute = $program->getSecondaryAttribute();
        $secondaryAttribute->setValue(Application_Model_Training_Defaultvalues::SECONDARY);

        $optionalAttributes = array_map(
            function (Application_Model_Training_Attribute $attr)
            {
                $attr->setValue(Application_Model_Training_Defaultvalues::OPTIONAL);
                return $attr;
            }, $program->getOptionalAttributes()
        );

        $decreasingAttributes = array_map(
            function (Application_Model_Training_Attribute $attr)
            {
                $attr->setValue(Application_Model_Training_Defaultvalues::SUB);
                return $attr;
            }, $program->getDecreasingAttributes()
        );
        $trainingAttributes = array_merge(
            [
                $primaryAttribute,
                $secondaryAttribute,
            ],
            $optionalAttributes,
            $decreasingAttributes
        );


        array_walk(
            $mods, function (Application_Model_Training_Mods $mod) use ($trainingAttributes)
            {
                /** @var $attribute Application_Model_Training_Attribute */
                foreach ($trainingAttributes as $attribute)
                {
                    if ($attribute->getAttributeKey() !== $mod->getAttribute())
                    {
                        continue;
                    }
                    $attribute->setValue($attribute->getValue() + $mod->getValue());
                }
            }
        );
        foreach ($decreasingAttributes as $decreasingAttribute) {
            /** @var $decreasingAttribute Application_Model_Training_Attribute */
            $decreasingAttribute->setValue(
                min($decreasingAttribute->getValue(), 0)
            );
        }
        $program->setDecreasingAttributes($decreasingAttributes);
        return $program;
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Application_Model_Training_Program $program
     *
     * @return bool|int|mixed
     * @throws Exception
     */
    public function startTraining (Application_Model_Charakter $charakter, Application_Model_Training_Program $program)
    {

        if ($this->trainingsMapper->checkTraining($charakter->getCharakterid()))
        {
            $return = $this->trainingsMapper->updateTraining($charakter->getCharakterid(), $program);
        } else
        {
            $return = $this->trainingsMapper->setTraining($charakter->getCharakterid(), $program);
        }

        return $return;
    }

    /**
     * @throws Exception
     */
    public function executeTraining ()
    {
        $charakterIds = [];
        try
        {
            $charakterIds = $this->trainingsMapper->getCharakterIdsToTrain();
        } catch (Exception $exception)
        {
            error_log('CharakterIds für das Training konnten nicht geladen werden.');
        }
        foreach ($charakterIds as $id)
        {
            try
            {
                $this->trainingsMapper->startTransaction();

                $charakter = $this->initCharakter($id);
                $werte = $charakter->getCharakterwerte();
                $werteLog = clone $werte;
                $currentProgram = $this->trainingsMapper->getCurrentTraining($id);

                $program = $this->getCharakterTrainingProgramById($charakter, $currentProgram->getProgramId());
                $program->setRemainingDuration($currentProgram->getRemainingDuration() - 1);

                $werte->addTraining($program->getPrimaryAttribute(), $charakter->getKlassengruppe()->getId());
                $werte->addTraining($program->getSecondaryAttribute(), $charakter->getKlassengruppe()->getId());

                $optionalAttributeToTrain = $program->getRandomOptionalAttribute();
                $decreasingAttribute = $program->getRandomDecreasingAttribute([$optionalAttributeToTrain->getAttributeKey()]);

                $werte->addTraining($optionalAttributeToTrain, $charakter->getKlassengruppe()->getId());
                $werte->addTraining($decreasingAttribute, $charakter->getKlassengruppe()->getId());

                $this->trainingsMapper->updateCharakterwerte($id, $werte);
                $this->trainingsMapper->updateTraining($id, $program);

                $log = new Application_Model_TrainingLog();
                $log->setProgramName($program->getName())
                    ->setStatsBefore($werteLog)
                    ->setStatsAfter($werte)
                    ->addAttribute($program->getPrimaryAttribute())
                    ->addAttribute($program->getSecondaryAttribute())
                    ->addAttribute($optionalAttributeToTrain)
                    ->addAttribute($decreasingAttribute);

                $this->trainingsMapper->log($id, $log);
                $this->trainingsMapper->commit();
            } catch (Exception $exception)
            {
                $this->trainingsMapper->rollback();
                $this->trainingsMapper->logError($id, $exception->getMessage(), $program->getName());
                continue;
            }
        }
    }

    /**
     * @param $charakter
     * @param $currentProgramId
     *
     * @throws Exception
     */
    public function executeBonusTraining (Application_Model_Charakter $charakter, $currentProgramId)
    {
        $program = $this->getCharakterTrainingProgramById($charakter, $currentProgramId);
        try
        {
            $this->trainingsMapper->startTransaction();
            $werte = $charakter->getCharakterwerte();
            $werteLog = clone $werte;

            $werte->addTraining($program->getPrimaryAttribute(), $charakter->getKlassengruppe()->getId());
            $werte->addTraining($program->getSecondaryAttribute(), $charakter->getKlassengruppe()->getId());

            $optionalAttributeToTrain = $program->getRandomOptionalAttribute();
            $decreasingAttribute = $program->getRandomDecreasingAttribute([$optionalAttributeToTrain->getAttributeKey()]);

            $werte->addTraining($optionalAttributeToTrain, $charakter->getKlassengruppe()->getId());
            $werte->addTraining($decreasingAttribute, $charakter->getKlassengruppe()->getId());
            $werte->setStartpunkte($werte->getStartpunkte() - 1);

            $this->trainingsMapper->updateCharakterwerte($charakter->getCharakterid(), $werte);
            $log = new Application_Model_TrainingLog();
            $log->setProgramName($program->getName())
                ->setStatsBefore($werteLog)
                ->setStatsAfter($werte)
                ->addAttribute($program->getPrimaryAttribute())
                ->addAttribute($program->getSecondaryAttribute())
                ->addAttribute($optionalAttributeToTrain)
                ->addAttribute($decreasingAttribute);

            $this->trainingsMapper->log($charakter->getCharakterid(), $log, true);
            $this->trainingsMapper->commit();
        } catch (Exception $exception)
        {
            $this->trainingsMapper->rollback();
            $this->trainingsMapper->logError($charakter->getCharakterid(), $exception->getMessage(), $program->getName());
        }
    }

    /**
     * @throws Exception
     */
    public function addFp ()
    {
        $this->trainingsMapper->addFp();
    }

    /**
     * @throws Exception
     */
    public function addBirthdayFp ()
    {
        $this->trainingsMapper->addBirthdayFp();
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Charakter
     * @throws Exception
     */
    private function initCharakter ($charakterId)
    {
        $charakterMapper = new Application_Model_Mapper_CharakterMapper();
        $klassenMapper = new Application_Model_Mapper_KlasseMapper();
        $charakter = $charakterMapper->getCharakter($charakterId);
        $charakter->setKlasse($charakterMapper->getCharakterKlasse($charakter->getCharakterid()));
        $charakter->setKlassengruppe($klassenMapper->getKlassengruppe($charakter->getKlasse()->getId()));
        $charakter->setCharakterwerte($charakterMapper->getCharakterwerte($charakter->getCharakterid()));
        $charakter->setTraits($charakterMapper->getTraitsByCharacterId($charakterId));
        return $charakter;
    }

    /**
     * @param int $characterId
     *
     * @return Application_Model_TrainingLog[]
     */
    public function fetchTraininglog (int $characterId)
    {
        return $this->trainingsMapper->fetchLog($characterId);
    }

}
