<?php

/**
 * Description of Story_Model_Mapper_ShopMapper
 *
 * @author Voß
 */
class Story_Model_Mapper_ShopMapper {
    
    /**
     * @param string $tablename
     * @return \Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable($tablename) {
        $className = 'Application_Model_DbTable_' . $tablename;
        if(!class_exists($className)){
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if(!$dbTable instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }
    
    /**
     * @param int $charakterId
     * @return \Story_Model_Magie
     */
    public function getMagienToLearnByRpg($charakterId) {
        $returnArray = [];
        $select = $this->getDbTable('Magie')->select();
        $select->setIntegrityCheck(false);
        $select->from('magien');
        $select->joinLeft('charakterMagien', 
                'magien.magieId = charakterMagien.magieId AND charakterMagien.charakterId = ' . (int)$charakterId, 
        []);
        $select->where('magien.lernbedingung = "RPG-Ereignis" AND charakterMagien.magieId IS NULL');
        $result = $this->getDbTable('Magie')->fetchAll($select);
        foreach ($result as $row) {
            $magie = new Story_Model_Magie();
            $magie->setId($row->magieId);
            $magie->setBezeichnung($row->name);
            $returnArray[] = $magie;
        }
        return $returnArray;
    }
    
    /**
     * @param int $charakterId
     * @return \Story_Model_Skill
     */
    public function getSkillsToLearnByRpg($charakterId) {
        $returnArray = [];
        $select = $this->getDbTable('Skill')->select();
        $select->setIntegrityCheck(false);
        $select->from('skills');
        $select->joinLeft('charakterSkills', 
                'skills.skillId = charakterSkills.skillId AND charakterSkills.charakterId = ' . (int)$charakterId, 
        []);
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
    
    
    public function removeSkillrequest($episodenId, $charakterId, $art, $request) {
        $db = $this->getDbTable('Magie')->getDefaultAdapter();
        $stmt = $db->prepare('DELETE FROM episodenCharakterSkillRequest 
                                WHERE episodenId = ? 
                                AND charakterId = ? 
                                AND request = ? 
                                AND art = ?');
        $stmt->execute([$episodenId, $charakterId, $request, $art]);
    }
    
    
    public function addSkillrequest($episodenId, $charakterId, $art, $request, $ids = []) {
        $db = $this->getDbTable('Magie')->getDefaultAdapter();
        $stmt = $db->prepare('INSERT INTO episodenCharakterSkillRequest 
                                (episodenId, charakterId, art, id, request)
                                VALUES (?, ?, ?, ?, ?)');
        foreach ($ids as $id) {
            $stmt->execute([$episodenId, $charakterId, $art, $id, $request]);
        }
    }
    
    
    /**
     * @param type $charakterId
     * @return Application_Model_Skill[]
     */
    public function getCharakterSkills($charakterId) {
        $returnArray = array();
        $select = $this->getDbTable('CharakterSkill')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterSkills', array());
        $select->joinInner('skills', 
                            'charakterSkills.skillId = skills.skillId',
                            array('skillId', 'name', 'beschreibung')
                );
        $select->where('charakterSkills.charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterSkill')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $skill = new Story_Model_Skill();
                $skill->setId($row->skillId);
                $skill->setBezeichnung($row->name);
                $skill->setBeschreibung($row->beschreibung);
                $returnArray[] = $skill;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param type $charakterId
     * @return Application_Model_Magie[]
     */
    public function getCharakterMagien($charakterId) {
        $returnArray = array();
        $select = $this->getDbTable('CharakterMagie')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterMagien', array());
        $select->joinInner('magien', 
                            'charakterMagien.magieId = magien.magieId',
                            array('magieId', 'name', 'beschreibung')
                );
        $select->where('charakterMagien.charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterMagie')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $magie = new Story_Model_Magie();
                $magie->setId($row->magieId);
                $magie->setBezeichnung($row->name);
                $magie->setBeschreibung($row->beschreibung);
                $returnArray[] = $magie;
            }
        }
        return $returnArray;
    }
    
}
