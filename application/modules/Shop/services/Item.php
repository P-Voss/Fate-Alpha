<?php

namespace Shop\Services;


use Exception;
use Shop\Models\Mappers\ItemMapper;

/**
 * Class Item
 * @package Shop\Services
 */
class Item
{

    /**
     * @var ItemMapper
     */
    private $mapper;

    /**
     * @var Requirement
     */
    private $requirementService;

    /**
     * Item constructor.
     *
     * @param Requirement $requirementService
     */
    public function __construct (Requirement $requirementService)
    {
        $this->mapper = new ItemMapper;
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
     * @param \Application_Model_Charakter $character
     *
     * @throws Exception
     */
    public function buy ($itemId, \Application_Model_Charakter $character)
    {
        if ($this->mapper->checkIfLearned($character->getCharakterid(), $itemId)) {
            throw new Exception('Der Gegenstand wurde schon gekauft.');
        }
        if (!$this->requirementService->validate($this->mapper->getRequirements($itemId))) {
            throw new Exception('Dein Charakter erfüllt nicht alle Voraussetzungen.');
        }
        $item = $this->mapper->getItem($itemId);
        if ($character->getCharakterwerte()->getFp() < $item->getActualCost($character)) {
            throw new Exception('Nicht genug FP um den Gegenstand zu kaufen.');
        }
        if ($item->getBedingung() === 'Standard') {
            $this->mapper->unlock($character, $item);
        } else {
            throw new Exception('Das Item kann nur über RPG erhalten werden.');
        }
    }

}