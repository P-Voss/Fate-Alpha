<?php

/**
 * Description of Story_Model_Mapper_ShopMapper
 *
 * @author Voß
 */
class Story_Model_Mapper_ShopMapper
{

    /**
     * @param string $tablename
     *
     * @return \Zend_Db_Table_Abstract
     * @throws Exception
     */
    private function getDbTable ($tablename)
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
     * @return Application_Model_Item[]
     * @throws Exception
     */
    public function getItemsToAcquire ($characterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Items')->select();
        $select->setIntegrityCheck(false);
        $select->from('items', []);
        $select->joinInner(
            'charakterItems',
            'charakterItems.itemId = items.itemId',
            ['itemId', 'name']
        );
        $select->where('charakterItems.charakterId = ? AND items.bedingung = "RPG"', $characterId);
        $result = $this->getDbTable('Items')->fetchAll($select);
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
     *
     * @throws Exception
     */
    public function addItemRequest ($episodeId, $characterId, $itemId)
    {
        $stmt = $this->getDbTable('Items')->getAdapter()->prepare(
            'INSERT INTO episodenCharakterItemRequest (episodenId, charakterId, itemId) VALUES (?, ?, ?)'
        );
        $stmt->execute([$episodeId, $characterId, $itemId]);
    }

    /**
     * @param $episodeId
     * @param $characterId
     * @param $itemId
     *
     * @throws Exception
     */
    public function removeItemRequest ($episodeId, $characterId, $itemId)
    {
        $stmt = $this->getDbTable('Items')->getAdapter()->prepare(
            'DELETE FROM episodenCharakterItemRequest WHERE episodenId = ? AND charakterId = ? AND itemId = ?'
        );
        $stmt->execute([$episodeId, $characterId, $itemId]);
    }

}
