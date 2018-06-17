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
     * @param Application_Model_Charakter $charakter
     *
     * @return array
     * @throws Exception
     */
    public function getTrainingMods (Application_Model_Charakter $charakter)
    {
        $changesContainer = [];
        foreach ($charakter->getVorteile() as $vorteil) {
            $changes = $this->_checkVorteil($vorteil->getId());
            if (count($changes) > 0) {
                $changesContainer[] = $changes;
            }
        }
        foreach ($charakter->getNachteile() as $nachteil) {
            $changes = $this->_checkNachteil($nachteil->getId());
            if (count($changes) > 0) {
                $changesContainer[] = $changes;
            }
        }
        if ($charakter->getKlasse() !== null) {
            if ($this->_checkKlasse($charakter->getKlasse()->getId())) {
                $changes = $this->_checkKlasse($charakter->getKlasse()->getId());
                if (count($changes) > 0) {
                    $changesContainer[] = $changes;
                }
            }
        }
        if ($charakter->getKlassengruppe()->getId() !== null) {
            if ($this->_checkKlassengruppe($charakter->getKlassengruppe()->getId())) {
                $changes = $this->_checkKlassengruppe($charakter->getKlassengruppe()->getId());
                if (count($changes) > 0) {
                    $changesContainer[] = $changes;
                }
            }
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
        if ($charakter->getKlasse() !== null) {
            if ($this->_checkKlasse($charakter->getKlasse()->getId())) {
                $changes = $this->_checkKlasse($charakter->getKlasse()->getId());
                if (count($changes) > 0) {
                    $this->changesContainer[] = $changes;
                }
            }
        }
        if ($charakter->getKlassengruppe()->getId() !== null) {
            if ($this->_checkKlassengruppe($charakter->getKlassengruppe()->getId())) {
                $changes = $this->_checkKlassengruppe($charakter->getKlassengruppe()->getId());
                if (count($changes) > 0) {
                    $this->changesContainer[] = $changes;
                }
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
     * @param $training
     * @param $dauer
     *
     * @return mixed
     * @throws Exception
     */
    public function setTraining ($charakterId, $training, $dauer)
    {
        $data['charakterId'] = $charakterId;
        $data['wert'] = $training;
        $data['dauer'] = $dauer;
        return $this->getDbTable('Training')->insert($data);
    }


    /**
     * @param $charakterId
     * @param $training
     * @param $dauer
     *
     * @return int
     * @throws Exception
     */
    public function updateTraining ($charakterId, $training, $dauer)
    {
        $data['wert'] = $training;
        $data['dauer'] = $dauer;
        return $this->getDbTable('Training')->update($data, ['charakterId = ?' => $charakterId]);
    }


    /**
     * @param $vorteilId
     *
     * @return array
     * @throws Exception
     */
    protected function _checkVorteil ($vorteilId)
    {
        $return = [];
        $select = $this->getDbTable('TrainingVorteil')->select();
        $select->setIntegrityCheck(false);
        $select->from('vorteilToTraining');
        $select->where('vorteilId = ?', $vorteilId);
        $result = $this->getDbTable('TrainingVorteil')->fetchAll($select);
        foreach ($result as $row) {
            $value['Effekt'] = $row->effekt;
            $value['Art'] = $row->effektArt;
            $return[$row->wert] = $value;
        }
        return $return;
    }


    /**
     * @param $nachteilId
     *
     * @return array
     * @throws Exception
     */
    protected function _checkNachteil ($nachteilId)
    {
        $return = [];
        $select = $this->getDbTable('TrainingNachteil')->select();
        $select->setIntegrityCheck(false);
        $select->from('nachteilToTraining');
        $select->where('nachteilId = ?', $nachteilId);
        $result = $this->getDbTable('TrainingNachteil')->fetchAll($select);
        foreach ($result as $row) {
            $value['Effekt'] = $row->effekt;
            $value['Art'] = $row->effektArt;
            $return[$row->wert] = $value;
        }
        return $return;
    }


    /**
     * @param $klassenId
     *
     * @return array
     * @throws Exception
     */
    protected function _checkKlasse ($klassenId)
    {
        $return = [];
        $select = $this->getDbTable('TrainingKlasse')->select();
        $select->setIntegrityCheck(false);
        $select->from('klasseToTraining');
        $select->where('klassenId = ?', $klassenId);
        $result = $this->getDbTable('TrainingKlasse')->fetchAll($select);
        foreach ($result as $row) {
            $value['Effekt'] = $row->effekt;
            $value['Art'] = $row->effektArt;
            $return[$row->wert] = $value;
        }
        return $return;
    }

    /**
     * @param int $gruppenId
     *
     * @return array
     * @throws Exception
     */
    protected function _checkKlassengruppe ($gruppenId)
    {
        $return = [];
        $select = $this->getDbTable('TrainingKlassengruppe')->select();
        $select->setIntegrityCheck(false);
        $select->from('klassengruppeToTraining');
        $select->where('klassengruppenId = ?', $gruppenId);
        $result = $this->getDbTable('TrainingKlassengruppe')->fetchAll($select);
        foreach ($result as $row) {
            $value['Effekt'] = $row->effekt;
            $value['Art'] = $row->effektArt;
            $return[$row->wert] = $value;
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
                        if ($values['Art'] === 'absolut') {
                            $trainingswerte->setStrTraining($trainingswerte->getStrTraining() + $values['Effekt']);
                        } else {

                        }
                        break;
                    case 'Agilitaet':
                        if ($values['Art'] === 'absolut') {
                            $trainingswerte->setAgiTraining($trainingswerte->getAgiTraining() + $values['Effekt']);
                        } else {

                        }
                        break;
                    case 'Ausdauer':
                        if ($values['Art'] === 'absolut') {
                            $trainingswerte->setAusTraining($trainingswerte->getAusTraining() + $values['Effekt']);
                        } else {

                        }
                        break;
                    case 'Uebung':
                        if ($values['Art'] === 'absolut') {
                            $trainingswerte->setPraTraining($trainingswerte->getPraTraining() + $values['Effekt']);
                        } else {

                        }
                        break;
                    case 'Kontrolle':
                        if ($values['Art'] === 'absolut') {
                            $trainingswerte->setKonTraining($trainingswerte->getKonTraining() + $values['Effekt']);
                        } else {

                        }
                        break;
                    case 'Disziplin':
                        if ($values['Art'] === 'absolut') {
                            $trainingswerte->setDisTraining($trainingswerte->getDisTraining() + $values['Effekt']);
                        } else {

                        }
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
     * @todo existiert schon im Charaktermapper
     *
     * @param int $charakterId
     *
     * @return boolean
     * @throws Exception
     */
    public function getCurrentTraining ($charakterId)
    {
        $select = $this->getDbTable('Training')->select();
        $select->setIntegrityCheck(false);
        $select->from('training');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Training')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                $return = [];
                $return['training'] = $row->wert;
                $return['dauer'] = $row->dauer;
            }
            return $return;
        } else {
            return false;
        }
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
