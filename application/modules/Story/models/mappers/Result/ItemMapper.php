<?php

/**
 * Class Story_Model_Mapper_Result_ItemMapper
 */
class Story_Model_Mapper_Result_ItemMapper
{

    use Story_Model_Mapper_DbTableTrait;

    /**
     * @param $characterId
     *
     * @return Application_Model_Item[]
     * @throws Exception
     */
    public function getItemsToAcquire ($characterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Item')->select();
        $select->setIntegrityCheck(false);
        $select->from('items', ['itemId', 'name']);
        $select->joinLeft(
            'charakterItems',
            'charakterItems.itemId = items.itemId AND charakterItems.charakterId = ' . (int) $characterId,
            []
        );
        $select->where('charakterItems.charakterId IS NULL AND items.bedingung = "RPG"', $characterId);
        $result = $this->getDbTable('Item')->fetchAll($select);
        foreach ($result as $row) {
            $item = new Application_Model_Item();
            $item->setId($row->itemId);
            $item->setName($row->name);
            $returnArray[] = $item;
        }
        return $returnArray;
    }

    /**
     * @param $characterId
     *
     * @return Application_Model_Item[]
     * @throws Exception
     */
    public function getItemsToRemove ($characterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Item')->select();
        $select->setIntegrityCheck(false);
        $select->from('items', ['itemId', 'name']);
        $select->joinInner(
            'charakterItems',
            'charakterItems.itemId = items.itemId',
            []
        );
        $select->where('charakterItems.charakterId = ?', $characterId);
        $result = $this->getDbTable('Item')->fetchAll($select);
        foreach ($result as $row) {
            $item = new Application_Model_Item();
            $item->setId($row->itemId);
            $item->setName($row->name);
            $returnArray[] = $item;
        }
        return $returnArray;
    }

    /**
     * @param $episodeId
     * @param $characterId
     * @param $itemId
     * @param $requestType
     *
     * @throws Exception
     */
    public function addItemRequest ($episodeId, $characterId, $itemId, $requestType)
    {
        $stmt = $this->getDbTable('Item')->getAdapter()->prepare(
            'INSERT INTO episodenCharakterItemRequest (episodenId, charakterId, itemId, requestType) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$episodeId, $characterId, $itemId, $requestType]);
    }

    /**
     * @param $episodeId
     * @param $characterId
     * @param $requestType
     *
     * @throws Exception
     */
    public function removeItemRequests ($episodeId, $characterId, $requestType)
    {
        $stmt = $this->getDbTable('Item')->getAdapter()->prepare(
            'DELETE FROM episodenCharakterItemRequest WHERE episodenId = ? AND charakterId = ? AND requestType = ?'
        );
        $stmt->execute([$episodeId, $characterId, $requestType]);
    }

    /**
     * @param int $episodeId
     * @param int $characterId
     *
     * @return array
     * @throws Exception
     */
    public function getRequestedItems ($episodeId, $characterId)
    {
        $returnArray = [];
        $db = $this->getDbTable('Episoden')->getDefaultAdapter();
        $sql = 'SELECT items.itemId, items.name, requestType
                FROM episodenCharakterItemRequest AS eCIR
                INNER JOIN items 
                    ON eCIR.itemId = items.itemId
                WHERE episodenId = ? AND charakterId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$episodeId, $characterId]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $item = new Story_Model_Item();
            $item->setId($row['itemId']);
            $item->setName($row['name']);
            $item->setRequestType($row['requestType']);
            $returnArray[] = $item;
        }
        return $returnArray;
    }

}