<?php

/**
 * Class Shop_Model_Mapper_ItemMapper
 */
class Shop_Model_Mapper_ItemMapper extends Application_Model_Mapper_ItemMapper
{


    /**
     * @return Shop_Model_Item[]
     */
    public function getItems ()
    {
        $returnArray = [];
        try {
            $result = $this->getDbTable('Item')->fetchAll('bedingung = "Standard"');
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
                ->setRank($row->rank)
                ->setDiscountDays($this->getDiscountDays($row->itemId));

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
            ->setRank($row->rank)
            ->setDiscountDays($this->getDiscountDays($itemId));

        return $item;
    }

    /**
     * @param Application_Model_Charakter $character
     * @param Shop_Model_Item $item
     *
     * @return int
     * @throws Exception
     */
    public function unlock (Application_Model_Charakter $character, Shop_Model_Item $item)
    {
        $data = [
            'charakterId' => $character->getCharakterid(),
            'itemId' => $item->getId(),
        ];
        $cost = $item->getActualCost($character);
        $this->getDbTable('charakterWerte')->getDefaultAdapter()
            ->query('UPDATE charakterWerte SET fp = fp - ' . $cost . ' WHERE charakterId = ' . $character->getCharakterid());
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

    /**
     * @param $characterId
     * @param $itemId
     *
     * @return int
     * @throws Exception
     */
    public function unlockByRpg ($characterId, $itemId)
    {
        $data = [
            'charakterId' => $characterId,
            'itemId' => $itemId,
        ];
        return $this->getDbTable('charakterItems')->insert($data);
    }

    /**
     * @param int $charakterId
     * @param int $itemId
     *
     * @throws Exception
     */
    public function removeItem ($charakterId, $itemId)
    {
        $data = [
            'charakterId = ?' => $charakterId,
            'itemId = ?' => $itemId,
        ];
        $this->getDbTable('charakterItems')->delete($data);
    }

}
