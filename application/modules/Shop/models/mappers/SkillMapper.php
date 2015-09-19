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
        $select = $this->getDbTable('Skill')->select();
        $select->where('skillartId = ?', $skillArtId);
        $result = $this->getDbTable('Skill')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $skill = new Shop_Model_Skill();
                $skill->setId($row->skillId);
                $skill->setBezeichnung($row->name);
                $skill->setBeschreibung($row->beschreibung);
                $skill->setSkillArt($skillArtId);
                $skill->setRequirementList($this->getRequirements($row->skillId));
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
        $skill = new Shop_Model_Skill();
        $select = $this->getDbTable('Skill')->select();
        $select->where('skillId = ?', $skillId);
        $result = $this->getDbTable('Skill')->fetchRow($select);
        if($result !== null){
            $row = $result->getIterator();
            $skill->setId($skillId);
            $skill->setBezeichnung($row['name']);
            $skill->setBeschreibung($row['beschreibung']);
            $skill->setSkillArt($row['skillartId']);
            $skill->setRequirementList($this->getRequirements($skillId));
            $skill->setRang($row['rang']);
            $skill->setFp($row['fp']);
        }
        return $skill;
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Shop_Model_Magie $magie
     * @return int
     */
    public function unlockSkill(Application_Model_Charakter $charakter, Shop_Model_Skill $skill) {
        $data = array(
            'charakterId' => $charakter->getCharakterid(),
            'skillId' => $skill->getId(),
        );
        $this->getDbTable('CharakterWerte')->getDefaultAdapter()
                ->query('UPDATE charakterWerte SET fp = fp - ' . $skill->getFp() . ' WHERE charakterId = ' . $charakter->getCharakterid());
        return $this->getDbTable('CharakterSkill')->insert($data);
    }
    
    /**
     * 
     * @param int $charakterId
     * @param int $skillartId
     * @return boolean
     */
    public function checkIfLearned($charakterId, $skillartId) {
        $select = $this->getDbTable('CharakterSkill')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('skillId = ?', $skillartId);
        $result = $this->getDbTable('CharakterSkill')->fetchAll($select);
        return $result->count() > 0;
    }

    /**
     * @param int $skillId
     * @return \Shop_Model_Requirementlist
     */
    public function getRequirements($skillId) {
        $requirementList = new Shop_Model_Requirementlist();
        $select = $this->getDbTable('SkillVoraussetzung')->select();
        $select->where('skillId = ?', $skillId);
        $result = $this->getDbTable('SkillVoraussetzung')->fetchAll($select);
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
