<?php

/**
 * Class Application_Model_Mapper_TrainingMapper
 */
class Application_Model_Mapper_TrainingMapper
{

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

        return $result->count() > 0;
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
     * @param int $charakterId
     * @param Application_Model_Charakterwerte $werte
     *
     * @throws Exception
     */
    public function updateCharakterwerte ($charakterId, Application_Model_Charakterwerte $werte)
    {
        $updateValues = array_map(
            function ($value) {return max($value, 0);},
            $werte->toArray()
        );
        $this->getDbTable('CharakterWerte')->update($updateValues, ['charakterId = ?' => $charakterId]);
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

    /**
     * @throws Exception
     */
    public function startTransaction ()
    {
        $this->getDbTable('TrainingLog')->getAdapter()->beginTransaction();
    }

    /**
     * @throws Exception
     */
    public function commit ()
    {
        $this->getDbTable('TrainingLog')->getAdapter()->commit();
    }

    /**
     * @throws Exception
     */
    public function rollback ()
    {
        $this->getDbTable('TrainingLog')->getAdapter()->rollBack();
    }

    /**
     * @param $characterId
     * @param Application_Model_TrainingLog $log
     *
     * @throws Exception
     */
    public function log ($characterId, Application_Model_TrainingLog $log)
    {
        $data = $log->toArray();
        $data['characterId'] = $characterId;
        $data['date'] = date('Y-m-d H:i:s');
        $this->getDbTable('TrainingLog')->insert($data);
    }

    /**
     * @param int $characterId
     * @param string $message
     * @param string $programName
     */
    public function logError ($characterId, $message, $programName)
    {
        $data = [
            'characterId' => $characterId,
            'isError' => 1,
            'errorMessage' => $message,
            'programName' => $programName
        ];
        try {
            $this->getDbTable('TrainingLog')->insert($data);
        } catch (Exception $exception) {}
    }

    /**
     * @param int $characterId
     *
     * @return Application_Model_TrainingLog[]
     * @throws Exception
     */
    public function fetchLog (int $characterId)
    {
        $logentries = [];
        try {
            $result = $this->getDbTable('TrainingLog')->getAdapter()->query(
                'SELECT programName, date, attributes, statsBefore, statsAfter, errorMessage
                        FROM traininglog
                        WHERE characterId = ?
                        ORDER BY id DESC',
                $characterId
            )->fetchAll();
            foreach ($result as $row) {
                $log = new Application_Model_TrainingLog();
                $log->setDate($row['date'] ?? '');
                $log->setProgramName($row['programName'] ?? '');
                $log->setErrorMessage($row['errorMessage'] ?? '');

                foreach (explode(',', $row['attributes']) as $attr) {
                    $parts = explode(':', $attr);
                    $log->addAttribute(
                        new Application_Model_Training_Attribute($parts[0], $parts[1])
                    );
                }

                $statsBefore = [];
                foreach (explode(',', $row['statsBefore']) as $stats) {
                    $parts = explode(':', $stats);
                    $statsBefore[$parts[0]] = $parts[1];
                }
                $werteBefore = new Application_Model_Charakterwerte();
                $werteBefore->fromArray($statsBefore);

                $statsAfter = [];
                foreach (explode(',', $row['statsAfter']) as $stats) {
                    $parts = explode(':', $stats);
                    $statsAfter[$parts[0]] = $parts[1];
                }
                $werteAfter = new Application_Model_Charakterwerte();
                $werteAfter->fromArray($statsAfter);

                $log->setStatsBefore($werteBefore);
                $log->setStatsAfter($werteAfter);

                $logentries[] = $log;
            }
        } catch (Exception $exception) {
            return [];
        }
        return $logentries;
    }

}