<?php

class Shop_Model_Mapper_SkillMapper {
    
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
     * @param int $skillArtId
     */
    public function getSkillsBySkillArtId($skillArtId) {
        $returnArray = array();
        
        $result = $this->getDbTable('Skill')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                
                
                $returnArray[] = $skill;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $skillId
     * @return 
     */
    public function getSkillById($skillId) {
        $magie = new Shop_Model_Magie();
        
        $result = $this->getDbTable('Skill')->fetchRow($select);
        if($result !== null){
            $row = $result->getIterator();
            
        }
        return $magie;
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Shop_Model_Magie $magie
     * @return int
     */
    public function unlockSkill(Application_Model_Charakter $charakter) {
        $data = array(
            'charakterId' => $charakter->getCharakterid(),
            'magieId' => $magie->getId(),
        );
        $this->getDbTable('charakterWerte')->getDefaultAdapter()
                ->query('UPDATE charakterWerte SET fp = fp - ' . $magie->getFp() . ' WHERE charakterId = ' . $charakter->getCharakterid());
        return $this->getDbTable('charakterMagie')->insert($data);
    }
    
    /**
     * @param int $charakterId
     * @param int $magieId
     * @return boolean
     */
    public function checkIfLearned($charakterId, $magieId) {
        $select = $this->getDbTable('CharakterMagie')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('magieId = ?', $magieId);
        $result = $this->getDbTable('CharakterMagie')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param int $magieId
     * @return \Shop_Model_Requirementlist
     */
    public function getRequirements($magieId) {
        $requirementList = new Shop_Model_Requirementlist();
        $select = $this->getDbTable('MagieVoraussetzungen')->select();
        $select->where('magieId = ?', $magieId);
        $result = $this->getDbTable('MagieVoraussetzungen')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $requirement = new Shop_Model_Requirement();
                $requirement->setArt($row->art);
                $requirement->setRequiredValue($row->voraussetzung);
                $requirementList->addRequirement($requirement);
            }
        }
        return $requirementList;
    }
    
}
