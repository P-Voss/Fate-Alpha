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
        foreach ($programs as $program) {
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
            function (Application_Model_Training_Attribute $attr) {
                $attr->setValue(Application_Model_Training_Defaultvalues::OPTIONAL);
                return $attr;
            }, $program->getOptionalAttributes()
        );

        $decreasingAttributes = array_map(
            function (Application_Model_Training_Attribute $attr) {
                $attr->setValue(Application_Model_Training_Defaultvalues::SUB);
                return $attr;
            }, $program->getDecreasingAttributes()
        );
        $trainingAttributes = array_merge(
            [
                $primaryAttribute, $secondaryAttribute], $optionalAttributes, $decreasingAttributes
        );


        array_walk(
            $mods, function (Application_Model_Training_Mods $mod) use ($trainingAttributes) {
            /** @var $attribute Application_Model_Training_Attribute */
            foreach ($trainingAttributes as $attribute) {
                if ($attribute->getAttributeKey() !== $mod->getAttribute()) {
                    continue;
                }
                $attribute->setValue($attribute->getValue() + $mod->getValue());
            }
        }
        );
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

        if ($this->trainingsMapper->checkTraining($charakter->getCharakterid())) {
            $return = $this->trainingsMapper->updateTraining($charakter->getCharakterid(), $program);
        } else {
            $return = $this->trainingsMapper->setTraining($charakter->getCharakterid(), $program);
        }

        return $return;
    }

    public function executeTraining ()
    {
        $charakterIds = [];
        try {
            $charakterIds = $this->trainingsMapper->getCharakterIdsToTrain();
        } catch (Exception $exception) {
            error_log('CharakterIds für das Training konnten nicht geladen werden.');
        }
        foreach ($charakterIds as $id) {
            try {
                $charakter = $this->initCharakter($id);
                $currentProgram = $this->trainingsMapper->getCurrentTraining($id);

                $program = $this->getCharakterTrainingProgramById($charakter, $currentProgram->getProgramId());
                $program->setRemainingDuration($currentProgram->getRemainingDuration() - 1);

                $charakter->getCharakterwerte()->addTraining($program->getPrimaryAttribute(), $charakter->getKlassengruppe()->getId());
                $charakter->getCharakterwerte()->addTraining($program->getSecondaryAttribute(), $charakter->getKlassengruppe()->getId());

                $optionalAttributeToTrain = $program->getRandomOptionalAttribute();
                $decreasingAttribute = $program->getRandomDecreasingAttribute([$optionalAttributeToTrain->getAttributeKey()]);

                $charakter->getCharakterwerte()->addTraining($optionalAttributeToTrain, $charakter->getKlassengruppe()->getId());
                $charakter->getCharakterwerte()->addTraining($decreasingAttribute, $charakter->getKlassengruppe()->getId());

                $this->trainingsMapper->updateCharakterwerte($id, $charakter->getCharakterwerte());
                $this->trainingsMapper->updateTraining($id, $program);
            } catch (Exception $exception) {
                error_log('Charakter konnte nicht trainieren: ' . $id);
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

        $charakter->getCharakterwerte()->addTraining($program->getPrimaryAttribute(), $charakter->getKlassengruppe()->getId());
        $charakter->getCharakterwerte()->addTraining($program->getSecondaryAttribute(), $charakter->getKlassengruppe()->getId());

        $optionalAttributeToTrain = $program->getRandomOptionalAttribute();
        $decreasingAttribute = $program->getRandomDecreasingAttribute([$optionalAttributeToTrain->getAttributeKey()]);

        $charakter->getCharakterwerte()->addTraining($optionalAttributeToTrain, $charakter->getKlassengruppe()->getId());
        $charakter->getCharakterwerte()->addTraining($decreasingAttribute, $charakter->getKlassengruppe()->getId());
        $charakter->getCharakterwerte()->setStartpunkte($charakter->getCharakterwerte()->getStartpunkte() - 1);

        $this->trainingsMapper->updateCharakterwerte($charakter->getCharakterid(), $charakter->getCharakterwerte());
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
        $charakter->setElemente($charakterMapper->getCharakterElemente($charakter->getCharakterid()));
        $charakter->setCharakterwerte($charakterMapper->getCharakterwerte($charakter->getCharakterid()));
        $charakter->setTraits($charakterMapper->getTraitsByCharacterId($charakterId));
        return $charakter;
    }

}
