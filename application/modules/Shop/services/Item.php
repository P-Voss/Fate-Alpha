<?php

/**
 * Class Shop_Service_Item
 */
class Shop_Service_Item {

    /**
     * @var Shop_Model_Mapper_ItemMapper
     */
    private $mapper;

    private $requirementService;

    public function __construct (Shop_Service_Requirement $requirementService)
    {
        $this->mapper = new Shop_Model_Mapper_ItemMapper;
        $this->requirementService = $requirementService;
    }

    /**
     * @param $characterId
     *
     * @return array
     * @throws Exception
     */
    public function getItems ($characterId)
    {
        $itemsToBuy = [];
        try {
            $items = $this->mapper->getItems();
            foreach ($items as $item) {
                if ($this->mapper->checkIfLearned($characterId, $item->getId())) {
                    continue;
                }
                if (!$this->requirementService->validate($this->mapper->getRequirements($item->getId()))) {
                    continue;
                }
                $itemsToBuy[] = $item;
            }
        } catch (Exception $exception) {
            return [];
        }

        return $itemsToBuy;
    }

    /**
     * @param $itemId
     * @param $characterId
     *
     * @throws Exception
     */
    public function buy ($itemId, $characterId)
    {
        if ($this->mapper->checkIfLearned($characterId, $itemId)) {
            throw new Exception('Gegenstand wurde schon gekauft.');
        }
        if (!$this->requirementService->validate($this->mapper->getRequirements($itemId))) {
            throw new Exception('Charakter erfüllt nicht alle Voraussetzungen.');
        }
        $item = $this->mapper->getItem($itemId);
        if ($item->getBedingung() === 'Standard') {
            $this->mapper->unlock($characterId, $item);
        } else {
            throw new Exception('Item kann nur über RPG erhalten werden.');
        }
    }

}