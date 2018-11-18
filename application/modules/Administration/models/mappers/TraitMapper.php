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
     * @return Application_Model_Trait[]
     */
    public function getAllTraits ()
    {
        $mapper = new Application_Model_Mapper_TraitMapper();
        return $mapper->getAllTraits();
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
        $data['creator'] = $trait->getEditor();

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
        }
        return $model;
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
            ->joinInner('traits', 'traits.traitId = traitIncompatibilities.traitId', ['traits.traitId', 'name'])
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

        return $this->getDbTable('Traits')->update($data, ['traitId = ?' => $trait->getTraitId()]);
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
