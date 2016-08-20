<?php

class Shop_Model_Mapper_SkillartMapper extends Application_Model_Mapper_SchuleMapper {
    
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
     * @return \Shop_Model_Skillart
     */
    public function getSkillArten() {
        $returnArray = array();
        $select = $this->getDbTable('Skillart')->select();
        $result = $this->getDbTable('Skillart')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row) {
                $skillArt = new Shop_Model_Skillart();
                $skillArt->setId($row->skillartId);
                $skillArt->setBezeichnung($row->name);
                $skillArt->setBeschreibung($row->beschreibung);
                $skillArt->setRequirementList($this->getRequirements($row->skillartId));
                $returnArray[] = $skillArt;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param type $skillartId
     */
    public function getSkillartById($skillartId) {
        $select = parent::getDbTable('Skillart')->select();
        $select->where('skillartId = ?', $skillartId);
        $result = parent::getDbTable('Skillart')->fetchRow($select);
        if(count($result) > 0){
            $skillArt = new Shop_Model_Skillart();
            $skillArt->setId($result->skillartId);
            $skillArt->setBezeichnung($result->name);
            $skillArt->setBeschreibung($result->beschreibung);
            $skillArt->setRequirementList($this->getRequirements($result->skillartId));
            return $skillArt;
        }
        return false;
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Shop_Model_Skillart $skillart
     */
    public function unlockSkillartForCharakter(Application_Model_Charakter $charakter, Shop_Model_Skillart $skillart) {
        $data['charakterId'] = $charakter->getCharakterid();
        $data['skillartId'] = $skillart->getId();
        parent::getDbTable('CharakterSkillart')->insert($data);
    }
    
    /**
     * @param int $charakterId
     * @param int $skillartId
     * @return boolean
     */
    public function checkIfLearned($charakterId, $skillartId) {
        $select = $this->getDbTable('CharakterSkillart')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('skillartId = ?', $skillartId);
        $result = $this->getDbTable('CharakterSkillart')->fetchAll($select);
        return $result->count() > 0;
    }
    
    /**
     * @param int $skillartId
     * @return \Shop_Model_Requirementlist
     */
    public function getRequirements($skillartId) {
        $requirementList = new Shop_Model_Requirementlist();
        $select = $this->getDbTable('SkillartVoraussetzung')->select();
        $select->where('skillartId = ?', $skillartId);
        $result = $this->getDbTable('SkillartVoraussetzung')->fetchAll($select);
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
