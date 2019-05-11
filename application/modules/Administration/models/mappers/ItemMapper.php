<?php

/**
 * Description of Administration_Model_Mapper_ItemMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Model_Mapper_ItemMapper extends Application_Model_Mapper_ItemMapper
{

    /**
     * @param Administration_Model_Item $item
     *
     * @return int
     * @throws Exception
     */
    public function createItem (Administration_Model_Item $item)
    {
        $data = [
            'name' => $item->getName(),
            'type' => $item->getType(),
            'rank' => $item->getRank(),
            'description' => $item->getDescription(),
            'cost' => $item->getCost(),
        ];
        return $this->getDbTable('Item')->insert($data);
    }

    /**
     * @param $itemId
     *
     * @return Administration_Model_Item
     * @throws Exception
     */
    public function getItemById ($itemId)
    {
        $row = $this->getDbTable('Item')->fetchRow(['itemId = ?' => $itemId]);
        if ($row !== null) {
            $item = new Administration_Model_Item();
            $item->setId($row->itemId)
                ->setName($row->name)
                ->setType($row->type)
                ->setRank($row->rank)
                ->setDescription($row->description)
                ->setCost($row->cost);
            return $item;
        } else {
            throw new Exception('item does not exist');
        }
    }

    /**
     * @param Administration_Model_Item $item
     *
     * @return int
     * @throws Exception
     */
    public function updateItem (Administration_Model_Item $item)
    {
        $data = [
            'name' => $item->getName(),
            'type' => $item->getType(),
            'rank' => $item->getRank(),
            'description' => $item->getDescription(),
            'cost' => $item->getCost(),
        ];
        return $this->getDbTable('Item')->update($data, ['itemId = ?' => $item->getId()]);
    }

    /**
     * @return Administration_Model_Item[]
     */
    public function getAllItems ()
    {
        $items = [];
        try {
            $result = $this->getDbTable('Item')->fetchAll();
        } catch (Exception $exception) {
            return [];
        }
        foreach ($result as $row) {
            $item = new Administration_Model_Item();
            $item->setId($row->itemId)
                ->setName($row->name)
                ->setType($row->type)
                ->setRank($row->rank)
                ->setDescription($row->description)
                ->setCost($row->cost);
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param Administration_Model_Item $item
     *
     * @return int
     * @throws Exception
     */
    public function deleteDependencies (Administration_Model_Item $item)
    {
        return $this->getDbTable('ItemCharakterVoraussetzungen')->delete(
            ['itemId = ?' => $item->getId()]
        );
    }

    /**
     * @param Administration_Model_Item $item
     *
     * @throws Exception
     */
    public function setDependencies (Administration_Model_Item $item)
    {
        $data['itemId'] = $item->getId();
        foreach ($item->getRequirementList()->getRequirements() as $requirement) {
            if ($requirement->getRequiredValue() === '') {
                continue;
            }
            $data['art'] = $requirement->getArt();
            foreach (explode(':', $requirement->getRequiredValue()) as $value) {
                $data['voraussetzung'] = $value;
                $this->getDbTable('ItemCharakterVoraussetzungen')->insert($data);
            }
        }
    }

    /**
     * @param int $itemId
     *
     * @return Administration_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirementsList($itemId) {
        $requirementList = new Administration_Model_Requirementlist();
        $select = $this->getDbTable('ItemCharakterVoraussetzungen')->select();
        $select->where('itemId = ?', $itemId);
        $result = $this->getDbTable('ItemCharakterVoraussetzungen')->fetchAll($select);
        foreach ($result as $row){
            $requirement = new Administration_Model_Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

}
