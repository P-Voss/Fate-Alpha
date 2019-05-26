<?php


class Story_Service_Result_Item
{

    /**
     * @var Story_Model_Mapper_Result_ItemMapper
     */
    protected $itemMapper;

    /**
     * Story_Service_Shop constructor.
     */
    public function __construct ()
    {
        $this->itemMapper = new Story_Model_Mapper_Result_ItemMapper();
    }

    /**
     * @param $characterId
     *
     * @return Application_Model_Item[]
     */
    public function getItemsToAcquire ($characterId)
    {
        try {
            return $this->itemMapper->getItemsToAcquire($characterId);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param $characterId
     *
     * @return Application_Model_Item[]
     */
    public function getItemsToRemove ($characterId)
    {
        try {
            return $this->itemMapper->getItemsToRemove($characterId);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param $episodeId
     * @param $characterId
     * @param $itemIds
     *
     * @throws Exception
     */
    public function addRequests ($episodeId, $characterId, $itemIds = [])
    {
        $this->itemMapper->removeItemRequests($episodeId, $characterId, Story_Model_RequestTypes::ADD);
        foreach ($itemIds as $itemId) {
            $this->itemMapper->addItemrequest(
                $episodeId,
                $characterId,
                $itemId,
                Story_Model_RequestTypes::ADD
            );
        }
    }

    /**
     * @param $episodeId
     * @param $characterId
     * @param $itemIds
     *
     * @throws Exception
     */
    public function addItemRemovalrequest ($episodeId, $characterId, $itemIds = [])
    {
        $this->itemMapper->removeItemRequests($episodeId, $characterId, Story_Model_RequestTypes::REMOVE);
        foreach ($itemIds as $itemId) {
            $this->itemMapper->addItemrequest(
                $episodeId,
                $characterId,
                $itemId,
                Story_Model_RequestTypes::REMOVE
            );
        }
    }
}