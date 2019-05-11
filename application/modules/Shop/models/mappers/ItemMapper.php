<?php

/**
 * Class Shop_Model_Mapper_ItemMapper
 */
class Shop_Model_Mapper_ItemMapper
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
     * @return Shop_Model_Item[]
     */
    public function getItems ()
    {
        $returnArray = [];
        try {
            $result = $this->getDbTable('Item')->fetchAll();
        } catch (Exception $exception) {
            return [];
        }
        foreach ($result as $row) {
            $item = new Shop_Model_Item();
            $item->setId($row->itemId)
                ->setName($row->name)
                ->setDescription($row->description)
                ->setCost($row->cost)
                ->setType($row->type)
                ->setRank($row->rank);

            $returnArray[] = $item;
        }
        return $returnArray;
    }

    /**
     * @param int $itemId
     *
     * @return Shop_Model_Item
     * @throws Exception
     */
    public function getItem ($itemId)
    {
        $row = $this->getDbTable('Item')->fetchRow(['itemId = ?' => $itemId]);

        if ($row === null) {
            throw new Exception('Item does not exist');
        }
        $item = new Shop_Model_Item();
        $item->setId($itemId)
            ->setName($row->name)
            ->setDescription($row->description)
            ->setCost($row->cost)
            ->setType($row->type)
            ->setRank($row->rank);

        return $item;
    }

    /**
     * @param int $characterId
     * @param Shop_Model_Item $item
     *
     * @return int
     * @throws Exception
     */
    public function unlock ($characterId, Shop_Model_Item $item)
    {
        $data = [
            'charakterId' => $characterId,
            'itemId' => $item->getId(),
        ];
        $this->getDbTable('charakterWerte')->getDefaultAdapter()
            ->query('UPDATE charakterWerte SET fp = fp - ' . $item->getCost() . ' WHERE charakterId = ' . $characterId);
        return $this->getDbTable('charakterItems')->insert($data);
    }

    /**
     *
     * @param int $charakterId
     * @param int $itemId
     *
     * @return bool
     * @throws Exception
     */
    public function checkIfLearned ($charakterId, $itemId)
    {
        $select = $this->getDbTable('CharakterItems')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('itemId = ?', $itemId);
        $result = $this->getDbTable('CharakterMagie')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param int $itemId
     *
     * @return Shop_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirements ($itemId)
    {
        $requirementList = new Shop_Model_Requirementlist();
        $select = $this->getDbTable('ItemCharakterVoraussetzungen')->select();
        $select->where('itemId = ?', $itemId);
        $result = $this->getDbTable('ItemCharakterVoraussetzungen')->fetchAll($select);
        if ($result->count() > 0) {
            foreach ($result as $row) {
                $requirement = new Shop_Model_Requirement();
                $requirement->setArt($row->art);
                $requirement->setRequiredValue($row->voraussetzung);
                $requirementList->addRequirement($requirement);
            }
        }
        return $requirementList;
    }

}
