<?php

/**
 * Class Application_Model_Mapper_TrainingMapper
 */
class Application_Model_Mapper_TrainingMapper
{

    /**
     * @var array
     */
    private $changesContainer = [];

    /**
     * @param string $tablename
     *
     * @return \Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable ($tablename)
    {
        $className = 'Application_Model_DbTable_' . $tablename;
        if (!class_exists($className)) {
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }


    /**
     * @return Application_Model_Trainingswerte|bool
     * @throws Exception
     */
    public function getDefaultTraining ()
    {
        $select = $this->getDbTable('Training')->select();
        $select->setIntegrityCheck(false);
        $select->from('trainingswerte');
        $result = $this->getDbTable('Training')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                $model = new Application_Model_Trainingswerte();
                $model->setStrTraining($row->staerke);
                $model->setAgiTraining($row->agilitaet);
                $model->setAusTraining($row->ausdauer);
                $model->setPraTraining($row->uebung);
                $model->setDisTraining($row->disziplin);
                $model->setKonTraining($row->kontrolle);
            }
            return $model;
        } else {
            return false;
        }
    }

    /**
     * @return Application_Model_Training_Program[]
     * @throws Exception
     */
    public function getTrainingPrograms ()
    {
        $programs = [];
        foreach ($this->getDbTable('TrainingProgram')->fetchAll() as $row) {
            $program = new Application_Model_Training_Program();
            $program->setName($row->name);
            $program->setProgramId($row->trainingprogramId);
            $program->setDescription($row->description);
            foreach ($this->getAttributesByProgram($row->trainingprogramId) as $attribute) {
                switch ($attribute->focus) {
                    case 'primary':
                        $program->setPrimaryAttribute(new Application_Model_Training_Attribute($attribute->attribute));
                        break;
                    case 'secondary':
                        $program->setSecondaryAttribute(new Application_Model_Training_Attribute($attribute->attribute));
                        break;
                    case 'optional':
                        $program->addOptionalAttribute(new Application_Model_Training_Attribute($attribute->attribute));
                        break;
                }
            }
            $programs[] = $program;
        }
        return $programs;
    }

    /**
     * @param int $programId
     *
     * @return Application_Model_Training_Program
     * @throws Exception
     */
    public function getTrainingProgramById ($programId)
    {
        $select = $this->getDbTable('TrainingProgram')
            ->select()
            ->where('trainingprogramId = ?', $programId);

        $row = $this->getDbTable('TrainingProgram')->fetchRow($select);
        if ($row === null) {
            throw new Exception("Das Trainingsprgramm existiert nicht.");
        }
        $program = new Application_Model_Training_Program();
        $program->setName($row->name);
        $program->setProgramId($row->trainingprogramId);
        $program->setDescription($row->description);
        foreach ($this->getAttributesByProgram($row->trainingprogramId) as $attribute) {
            switch ($attribute->focus) {
                case 'primary':
                    $program->setPrimaryAttribute(new Application_Model_Training_Attribute($attribute->attribute));
                    break;
                case 'secondary':
                    $program->setSecondaryAttribute(new Application_Model_Training_Attribute($attribute->attribute));
                    break;
                case 'optional':
                    $program->addOptionalAttribute(new Application_Model_Training_Attribute($attribute->attribute));
                    break;
            }
        }
        return $program;
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Training_Program
     * @throws Exception
     */
    public function getCurrentTraining ($charakterId)
    {
        $select = $this->getDbTable('Training')
            ->select()
            ->setIntegrityCheck(false)
            ->from('training', ['trainingprogramId', 'days'])
            ->joinInner('trainingprogram', 'training.trainingprogramId = trainingprogram.trainingprogramId', ['name'])
            ->where('charakterId = ?', $charakterId);
        $row = $this->getDbTable('Training')->fetchRow($select);
        if ($row !== null) {
            $program = new Application_Model_Training_Program();
            $program->setProgramId($row->trainingprogramId);
            $program->setName($row->name);
            $program->setRemainingDuration($row->days);
            return $program;
        } else {
            throw new Exception();
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return array
     * @throws Exception
     */
    public function getTrainingMods (Application_Model_Charakter $charakter)
    {
        $changesContainer = [];
        foreach ($charakter->getTraits() as $trait) {
            $changesContainer = array_merge($changesContainer, $this->checkTrait($trait->getTraitId()));
        }
        if ($charakter->getKlasse() !== null) {
            $changesContainer = array_merge($changesContainer, $this->checkKlasse($charakter->getKlasse()->getId()));
        }
        if ($charakter->getKlassengruppe()->getId() !== null) {
            $changesContainer = array_merge($changesContainer, $this->checkKlassengruppe($charakter->getKlassengruppe()->getId()));
        }
        return $changesContainer;
    }

    /**
     * @param $programId
     *
     * @return Zend_Db_Table_Rowset_Abstract
     * @throws Exception
     */
    public function getAttributesByProgram ($programId)
    {
        return $this->getDbTable('TrainingProgramAttributes')->fetchAll(['trainingprogramId = ?' => $programId]);
    }


    /**
     * @param Application_Model_Trainingswerte $defaultTraining
     * @param Application_Model_Charakter $charakter
     *
     * @return Application_Model_Trainingswerte
     * @throws Exception
     */
    public function getRealTraining (Application_Model_Trainingswerte $defaultTraining, Application_Model_Charakter $charakter)
    {
        $this->changesContainer = [];
        $trainingswerte = new Application_Model_Trainingswerte();
        $trainingswerte->setAgiTraining($defaultTraining->getAgiTraining());
        $trainingswerte->setStrTraining($defaultTraining->getStrTraining());
        $trainingswerte->setAusTraining($defaultTraining->getAusTraining());
        $trainingswerte->setDisTraining($defaultTraining->getDisTraining());
        $trainingswerte->setPraTraining($defaultTraining->getPraTraining());
        $trainingswerte->setKonTraining($defaultTraining->getKonTraining());
        foreach ($charakter->getVorteile() as $vorteil) {
            $changes = $this->_checkVorteil($vorteil->getId());
            if (count($changes) > 0) {
                $this->changesContainer[] = $changes;
            }
        }
        foreach ($charakter->getNachteile() as $nachteil) {
            $changes = $this->_checkNachteil($nachteil->getId());
            if (count($changes) > 0) {
                $this->changesContainer[] = $changes;
            }
        }
        if ($this->_checkKlasse($charakter->getKlasse()->getId())) {
            $changes = $this->_checkKlasse($charakter->getKlasse()->getId());
            if (count($changes) > 0) {
                $this->changesContainer[] = $changes;
            }
        }
        if ($this->_checkKlassengruppe($charakter->getKlassengruppe()->getId())) {
            $changes = $this->_checkKlassengruppe($charakter->getKlassengruppe()->getId());
            if (count($changes) > 0) {
                $this->changesContainer[] = $changes;
            }
        }
        if (count($this->changesContainer) > 0) {
            $trainingswerte = $this->_transformValues($trainingswerte);
        }
        return $trainingswerte;
    }


    /**
     * @param Application_Model_Trainingswerte $trainingswerte
     * @param Application_Model_Charakter $charakter
     *
     * @return Application_Model_Trainingswerte
     */
    public function setOtherValuesNull (Application_Model_Trainingswerte $trainingswerte, Application_Model_Charakter $charakter)
    {
        //        if($charakter->getKlassengruppe()->getId() == 2){
        //            $trainingswerte->setDisTraining(null);
        //            $trainingswerte->setKonTraining(null);
        //        }
        return $trainingswerte;
    }


    /**
     * @param $charakterId
     *
     * @return bool
     * @throws Exception
     */
    public function checkTraining ($charakterId)
    {
        $select = $this->getDbTable('Training')->select();
        $select->setIntegrityCheck(false);
        $select->from('training');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Training')->fetchAll($select);
        if ($result->count() > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $charakterId
     * @param Application_Model_Training_Program $program
     *
     * @return mixed
     * @throws Exception
     */
    public function setTraining ($charakterId, Application_Model_Training_Program $program)
    {
        $data = [
            'charakterId' => $charakterId,
            'trainingprogramId' => $program->getProgramId(),
            'days' => $program->getRemainingDuration(),
        ];
        return $this->getDbTable('Training')->insert($data);
    }


    /**
     * @param $charakterId
     * @param Application_Model_Training_Program $program
     *
     * @return int
     * @throws Exception
     */
    public function updateTraining ($charakterId, Application_Model_Training_Program $program)
    {
        $data = [
            'trainingprogramId' => $program->getProgramId(),
            'days' => $program->getRemainingDuration(),
        ];
        return $this->getDbTable('Training')->update($data, ['charakterId = ?' => $charakterId]);
    }

    /**
     * @param $traitId
     *
     * @return array
     * @throws Exception
     */
    protected function checkTrait ($traitId)
    {
        $return = [];
        $select = $this->getDbTable('TraitTraining')->select();
        $select->setIntegrityCheck(false);
        $select->from('traitToTraining');
        $select->where('traitId = ?', $traitId);
        $result = $this->getDbTable('TraitTraining')->fetchAll($select);
        foreach ($result as $row) {
            $return[] = new Application_Model_Training_Mods($row->attribute, $row->value);
        }
        return $return;
    }

    /**
     * @param $klassenId
     *
     * @return array
     * @throws Exception
     */
    protected function checkKlasse ($klassenId)
    {
        $return = [];
        $select = $this->getDbTable('TrainingKlasse')->select();
        $select->setIntegrityCheck(false);
        $select->from('klasseToTraining');
        $select->where('klassenId = ?', $klassenId);
        $result = $this->getDbTable('TrainingKlasse')->fetchAll($select);
        foreach ($result as $row) {
            $return[] = new Application_Model_Training_Mods($row->wert, $row->effekt);
        }
        return $return;
    }

    /**
     * @param int $gruppenId
     *
     * @return array
     * @throws Exception
     */
    protected function checkKlassengruppe ($gruppenId)
    {
        $return = [];
        $select = $this->getDbTable('TrainingKlassengruppe')->select();
        $select->setIntegrityCheck(false);
        $select->from('klassengruppeToTraining');
        $select->where('klassengruppenId = ?', $gruppenId);
        $result = $this->getDbTable('TrainingKlassengruppe')->fetchAll($select);
        foreach ($result as $row) {
            $return[] = new Application_Model_Training_Mods($row->wert, $row->effekt);
        }
        return $return;
    }

    /**
     * @param Application_Model_Trainingswerte $trainingswerte
     *
     * @return Application_Model_Trainingswerte
     */
    protected function _transformValues ($trainingswerte)
    {
        foreach ($this->changesContainer as $changesCategories) {
            foreach ($changesCategories as $key => $values) {
                switch ($key) {
                    case 'Staerke':
                        $trainingswerte->setStrTraining($trainingswerte->getStrTraining() + $values['Effekt']);
                        break;
                    case 'Agilitaet':
                        $trainingswerte->setAgiTraining($trainingswerte->getAgiTraining() + $values['Effekt']);
                        break;
                    case 'Ausdauer':
                        $trainingswerte->setAusTraining($trainingswerte->getAusTraining() + $values['Effekt']);
                        break;
                    case 'Uebung':
                        $trainingswerte->setPraTraining($trainingswerte->getPraTraining() + $values['Effekt']);
                        break;
                    case 'Kontrolle':
                        $trainingswerte->setKonTraining($trainingswerte->getKonTraining() + $values['Effekt']);
                        break;
                    case 'Disziplin':
                        $trainingswerte->setDisTraining($trainingswerte->getDisTraining() + $values['Effekt']);
                        break;
                }
            }
        }
        return $trainingswerte;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCharakterIdsToTrain ()
    {
        $returnArray = [];
        $select = $this->getDbTable('Training')->select();
        $select->setIntegrityCheck(false);
        $select->from('training');
        $select->joinInner('charakter', 'charakter.charakterId = training.charakterId', []);
        $select->where('active = 1');
        $result = $this->getDbTable('Training')->fetchAll($select);
        foreach ($result as $row) {
            $returnArray[] = $row['charakterId'];
        }
        return $returnArray;
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Application_Model_Trainingswerte $trainingswerte
     *
     * @throws Exception
     */
    public function updateStats (Application_Model_Charakter $charakter, Application_Model_Trainingswerte $trainingswerte)
    {
        $training = $this->getCurrentTraining($charakter->getCharakterid());
        $charakter->getCharakterwerte()->addTraining($training, $trainingswerte, $charakter->getKlassengruppe()->getId());
        $this->getDbTable('CharakterWerte')->update($charakter->getCharakterwerte()->toArray(), ['charakterId = ?' => $charakter->getCharakterid()]);
        $this->updateTraining($charakter->getCharakterid(), $training['training'], $training['dauer'] - 1);
    }

    /**
     * @param int $charakterId
     * @param Application_Model_Charakterwerte $werte
     *
     * @throws Exception
     */
    public function updateCharakterwerte ($charakterId, Application_Model_Charakterwerte $werte)
    {
        $this->getDbTable('CharakterWerte')->update($werte->toArray(), ['charakterId = ?' => $charakterId]);
    }


    /**
     * @throws Exception
     */
    public function addFp ()
    {
        $this->getDbTable('Training')->
        getDefaultAdapter()->
        query('UPDATE charakterWerte SET fp = fp +2');
        $this->getDbTable('Training')->
        getDefaultAdapter()->
        query(
            'UPDATE charakterWerte
                        INNER JOIN charakter 
                            ON charakter.charakterId = charakterWerte.charakterId 
                            AND charakter.klassenId = 4
                        SET fp = fp + 1'
        );
    }


    /**
     * @throws Exception
     */
    public function addBirthdayFp ()
    {
        $sql = <<<SQL
UPDATE 
    charakterWerte AS werte
INNER JOIN 
    charakter 
        ON charakter.charakterId = werte.charakterId 
        AND DATE_FORMAT(charakter.geburtsdatum, "%m-%d") = DATE_FORMAT(CURDATE(), "%m-%d")
SET fp = fp + 50
SQL;
        $this->getDbTable('CharakterWerte')->getDefaultAdapter()->query($sql);
    }

    /**
     * @param int $charakterId
     * @param Application_Model_Charakterwerte $werte
     *
     * @throws Exception
     */
    public function addBonusTraining ($charakterId, Application_Model_Charakterwerte $werte)
    {
        $this->getDbTable('CharakterWerte')->update($werte->toArray(), ['charakterId = ?' => $charakterId]);
    }

}
