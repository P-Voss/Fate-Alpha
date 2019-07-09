<?php

class Administration_Model_Mapper_TraitMapper
{

    /**
     * @param string $tablename
     *
     * @return Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable (string $tablename): Zend_Db_Table_Abstract
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
     * @param $characterId
     *
     * @throws Exception
     */
    public function removeIndividualTraitsFromCharacter ($characterId)
    {
        $stmt = $this->getDbTable('Traits')->getAdapter()->prepare(
            'DELETE characterTraits.*
            FROM characterTraits
            INNER JOIN traits ON traits.traitId = characterTraits.traitId  AND traits.isIndividual = 1
            WHERE characterTraits.characterId = ?'
        );
        $stmt->execute([$characterId]);
    }

    /**
     * @param $traitId
     * @param $characterId
     *
     * @throws Exception
     */
    public function addTraitToCharacter ($traitId, $characterId)
    {
        $data = ['traitId' => $traitId, 'characterId' => $characterId];
        $this->getDbTable('CharakterTrait')->insert($data);
    }

    /**
     * @return Application_Model_Trait[]
     */
    public function getAllTraits ()
    {
        $mapper = new Application_Model_Mapper_TraitMapper();
        return $mapper->getAllTraits();
    }

    /**
     * @return Application_Model_Trait[]
     */
    public function getFocusTraits ()
    {
        try {
            $traits = [];
            $select = $this->getDbTable('Traits')->select()
                ->from('traits')
                ->where('traits.isFocusTrait = 1');

            $result = $this->getDbTable('Traits')->fetchAll($select);
            foreach ($result as $row) {
                $model = new Administration_Model_Trait();
                $model->setTraitId($row['traitId']);
                $model->setName($row['name']);
                $model->setBeschreibung($row['beschreibung']);
                $model->setKosten($row['kosten']);
                $model->setIsIndividual($row['isIndividual']);
                $model->setIsIndividual($row['isFocusTrait']);
                $traits[] = $model;
            }
            return $traits;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param int $characterId
     *
     * @return Application_Model_Trait[]
     */
    public function getIndividualTraitsByCharacter (int $characterId)
    {
        try {
            $traits = [];
            $select = $this->getDbTable('Traits')->select()
                ->setIntegrityCheck(false)
                ->from('traits')
                ->joinLeft('characterTraits', 'characterTraits.traitId = traits.traitId')
                ->where('characterTraits.characterId = ? AND traits.isIndividual = 1', $characterId);

            $result = $this->getDbTable('Traits')->fetchAll($select);
            foreach ($result as $row) {
                $model = new Administration_Model_Trait();
                $model->setTraitId($row['traitId']);
                $model->setName($row['name']);
                $model->setBeschreibung($row['beschreibung']);
                $model->setKosten($row['kosten']);
                $model->setIsIndividual($row['isIndividual']);
                $traits[] = $model;
            }
            return $traits;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @return Administration_Model_Trait[]
     */
    public function getIndividualTraits ()
    {
        try {
            $traits = [];
            $result = $this->getDbTable('Traits')->fetchAll(
                $this->getDbTable('Traits')->select()->where('isIndividual = 1')
            );
            foreach ($result as $row) {
                $model = new Administration_Model_Trait();
                $model->setTraitId($row['traitId']);
                $model->setName($row['name']);
                $model->setBeschreibung($row['beschreibung']);
                $model->setKosten($row['kosten']);
                $model->setIsIndividual($row['isIndividual']);
                $traits[] = $model;
            }
            return $traits;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param Administration_Model_Trait $trait
     *
     * @return int
     * @throws Exception
     */
    public function createTrait (Administration_Model_Trait $trait)
    {
        $data['name'] = $trait->getName();
        $data['beschreibung'] = $trait->getBeschreibung();
        $data['kosten'] = $trait->getKosten();
        $data['createDate'] = $trait->getCreateDate('Y-m-d H:i:s');
        $data['isIndividual'] = (int) $trait->isIndividual();
        $data['isFocusTrait'] = (int) $trait->isFocusTrait();
        $data['focustraitId'] = $trait->getFocustraitId();

        return $this->getDbTable('Traits')->insert($data);
    }

    /**
     * @param int $traitId
     *
     * @return \Administration_Model_Trait
     * @throws Exception
     */
    public function getTraitById ($traitId)
    {
        $model = new Administration_Model_Trait();
        $select = $this->getDbTable('Traits')->select();
        $select->where('traitId = ?', $traitId);
        $row = $this->getDbTable('Traits')->fetchRow($select);
        if ($row !== null) {
            $model->setTraitId($row['traitId']);
            $model->setName($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setKosten($row['kosten']);
            $model->setIsIndividual($row['isIndividual']);
            $model->setIsFocusTrait($row['isFocusTrait']);
            $model->setFocustraitId((int) $row['focustraitId']);
        }
        return $model;
    }

    /**
     * @param Administration_Model_Trait $trait
     *
     * @return int
     * @throws Exception
     */
    public function updateTrait (Administration_Model_Trait $trait)
    {
        $data['name'] = $trait->getName();
        $data['beschreibung'] = $trait->getBeschreibung();
        $data['kosten'] = $trait->getKosten();
        $data['editDate'] = $trait->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $trait->getEditor();
        $data['isIndividual'] = (int) $trait->isIndividual();
        $data['isFocusTrait'] = (int) $trait->isFocusTrait();
        $data['focustraitId'] = $trait->getFocustraitId();

        return $this->getDbTable('Traits')->update($data, ['traitId = ?' => $trait->getTraitId()]);
    }

    /**
     * @param $traitId
     *
     * @return Administration_Model_Trait[]
     * @throws Exception
     */
    public function getIncompatibleTraits ($traitId)
    {
        $incompatibleTraits = [];
        $select = $this->getDbTable('TraitInc')->select();
        $select->setIntegrityCheck(false)
            ->from('traitIncompatibilities', [])
            ->joinInner('traits', 'traits.traitId = traitIncompatibilities.inkTraitId', ['traits.traitId', 'name'])
            ->where('traitIncompatibilities.traitId = ?', $traitId);

        $result = $this->getDbTable('TraitInc')->fetchAll($select);
        foreach ($result as $row) {
            $trait = new Administration_Model_Trait();
            $trait->setName($row->name)
                ->setTraitId($row->traitId);
            $incompatibleTraits[] = $trait;
        }
        return $incompatibleTraits;
    }

    /**
     * @param $traitId
     *
     * @throws Exception
     */
    public function removeTraitIncompatibilites ($traitId)
    {
        $this->getDbTable('TraitInc')->delete(['traitId = ?' => $traitId]);
        $this->getDbTable('TraitInc')->delete(['inkTraitId = ?' => $traitId]);
    }

    /**
     * @param $traitId
     * @param $incompatibleTrait
     *
     * @throws Exception
     */
    public function addIncompatibleTrait ($traitId, $incompatibleTrait)
    {
        $data = ['traitId' => $incompatibleTrait, 'inkTraitId' => $traitId];
        $this->getDbTable('TraitInc')->insert($data);
    }


    /**
     * @param $traitId
     *
     * @throws Exception
     */
    public function setTraitsIncompatibilities ($traitId)
    {
        $stmt = $this->getDbTable('TraitInc')->getAdapter()->prepare(
            'INSERT INTO traitIncompatibilities (traitId, inkTraitId) 
                    SELECT inkTraitId, traitId FROM traitIncompatibilities WHERE inkTraitId = ?'
        );
        $stmt->execute([$traitId]);
    }

    /**
     * @param int $traitId
     *
     * @throws Exception
     */
    public function delete (int $traitId)
    {
        $this->getDbTable('Traits')->delete(['traitId = ?' => $traitId]);
    }

}
