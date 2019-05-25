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
     * @param int $charakterId
     *
     * @return Story_Model_Skill[]
     * @throws Exception
     */
    public function getSkillsToLearnByRpg ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Skill')->select();
        $select->setIntegrityCheck(false);
        $select->from('skills');
        $select->joinLeft(
            'charakterSkills',
            'skills.skillId = charakterSkills.skillId AND charakterSkills.charakterId = ' . (int)$charakterId,
            []
        );
        $select->where('skills.lernbedingung = "RPG-Ereignis" AND charakterSkills.skillId IS NULL');
        $result = $this->getDbTable('Skill')->fetchAll($select);
        foreach ($result as $row) {
            $skill = new Story_Model_Skill();
            $skill->setId($row->skillId);
            $skill->setBezeichnung($row->name);
            $returnArray[] = $skill;
        }
        return $returnArray;
    }


    /**
     * @param $episodenId
     * @param $charakterId
     * @param $art
     * @param $request
     *
     * @throws Exception
     */
    public function removeSkillrequest ($episodenId, $charakterId, $art, $request)
    {
        $db = $this->getDbTable('Magie')->getDefaultAdapter();
        $stmt = $db->prepare(
            'DELETE FROM episodenCharakterSkillRequest 
                                WHERE episodenId = ? 
                                AND charakterId = ? 
                                AND request = ? 
                                AND art = ?'
        );
        $stmt->execute([$episodenId, $charakterId, $request, $art]);
    }


    /**
     * @param $episodenId
     * @param $charakterId
     * @param $art
     * @param $request
     * @param array $ids
     *
     * @throws Exception
     */
    public function addSkillrequest ($episodenId, $charakterId, $art, $request, $ids = [])
    {
        $db = $this->getDbTable('Magie')->getDefaultAdapter();
        $stmt = $db->prepare(
            'INSERT INTO episodenCharakterSkillRequest 
                                (episodenId, charakterId, art, id, request)
                                VALUES (?, ?, ?, ?, ?)'
        );
        foreach ($ids as $id) {
            $stmt->execute([$episodenId, $charakterId, $art, $id, $request]);
        }
    }


    /**
     * @param int $charakterId
     *
     * @return Application_Model_Skill[]
     * @throws Exception
     */
    public function getCharakterSkills ($charakterId)
    {
        $returnArray = [];
        $select = $this->getDbTable('CharakterSkill')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterSkills', []);
        $select->joinInner(
            'skills',
            'charakterSkills.skillId = skills.skillId',
            ['skillId', 'name', 'beschreibung']
        );
        $select->where('charakterSkills.charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterSkill')->fetchAll($select);
        foreach ($result as $row) {
            $skill = new Story_Model_Skill();
            $skill->setId($row->skillId);
            $skill->setBezeichnung($row->name);
            $skill->setBeschreibung($row->beschreibung);
            $returnArray[] = $skill;
        }
        return $returnArray;
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
