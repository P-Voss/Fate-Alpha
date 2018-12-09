<?php

class Application_Model_Mapper_TraitMapper
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
    public function getAllTraits () : array
    {
        try {
            $select = $this->getDbTable('Traits')->select();
            $result = $this->getDbTable('Traits')->fetchAll($select);
        } catch (Exception $exception) {
            return [];
        }
        $return = [];
        foreach ($result as $row) {
            $model = new Application_Model_Trait();
            $model->setTraitId($row->traitId);
            $model->setName($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setKosten($row->kosten);
            $return[] = $model;
        }
        return $return;
    }

    /**
     * @param int $traitId
     *
     * @return Application_Model_Trait
     * @throws Exception
     */
    public function getTraitById(int $traitId): Application_Model_Trait
    {
        $select = $this->getDbTable('Traits')->select();
        $select->from('traits');
        $select->where('traitId = ?', $traitId);
        $row = $this->getDbTable('Traits')->fetchRow($select);
        if ($row !== null) {
            $trait = new Application_Model_Trait();
            $trait->setTraitId($row->traitId)
                ->setName($row->name)
                ->setBeschreibung($row->beschreibung)
                ->setKosten($row->kosten);
            return $trait;
        } else {
            throw new Exception('Trait does not exist.');
        }
    }

    /**
     * @param $traitId
     *
     * @return Application_Model_Trait[]
     * @throws Exception
     */
    public function getIncompatibleTraits ($traitId)
    {
        $incompatibleTraits = [];
        $select = $this->getDbTable('TraitInc')->select();
        $select->setIntegrityCheck(false)
            ->from('traitIncompatibilities', ['inkTraitId'])
            ->joinInner('traits', 'traits.traitId = traitIncompatibilities.inkTraitId', ['name'])
            ->where('traitIncompatibilities.traitId = ?', $traitId);

        $result = $this->getDbTable('TraitInc')->fetchAll($select);
        foreach ($result as $row) {
            $trait = new Application_Model_Trait();
            $trait->setName($row->name)
                ->setTraitId($row->inkTraitId);
            $incompatibleTraits[] = $trait;
        }
        return $incompatibleTraits;
    }

}
