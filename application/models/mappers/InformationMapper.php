<?php

class Application_Model_Mapper_InformationMapper {

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
     * @param type $informationId
     * @return Application_Model_Information
     */
    public function getInformation($informationId) {
        $select = $this->getDbTable('Information')->select();
        $select->setIntegrityCheck(false);
        $select->from('informationen');
        $select->joinInner('informationenTexte', 'informationen.infoId = informationenTexte.infoId');
        $select->where('informationen.infoId = ?', $informationId);
        $row = $this->getDbTable('Information')->fetchRow($select);
        if($row !== false){
            $information = new Application_Model_Information();
            $information->setInformationId($row->infoId);
            $information->setName($row->name);
            $information->setInhalt($row->inhalt);
        }
        return $information;
    }
    
    
    public function getInformations() {
        $returnArray = array();
        $result = $this->getDbTable('Information')->fetchAll();
        if($result->count() > 0){
            foreach ($result as $row){
                $information = new Application_Model_Information();
                $information->setInformationId($row->infoId);
                $information->setName($row->name);
                $returnArray[] = $information;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $informationId
     * @return \Application_Model_Requirementlist
     */
    public function getRequirements($informationId) {
        $requirementList = new Application_Model_Requirementlist();
        $select = $this->getDbTable('InfoCharakterVoraussetzungen')->select();
        $select->where('infoId = ?', $informationId);
        $result = $this->getDbTable('InfoCharakterVoraussetzungen')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $requirement = new Application_Model_Requirement();
                $requirement->setArt($row->art);
                $requirement->setRequiredValue($row->voraussetzung);
                $requirementList->addRequirement($requirement);
            }
        }
        return $requirementList;
    }
    
}
