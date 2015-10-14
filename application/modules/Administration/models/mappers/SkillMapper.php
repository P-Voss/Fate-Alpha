<?php

class Administration_Model_Mapper_SkillMapper {

    
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
    
    public function getSkills() {
        $returnArray = array();
        $select = $this->getDbTable('Skill')->select();
        $select->distinct();
        $result = $this->getDbTable('Skill')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Administration_Model_Skill();
                $model->setId($row->skillId);
                $model->setBezeichnung($row->name);
                $model->setBeschreibung($row->beschreibung);
                $model->setFp($row->fp);
                $model->setRang($row->rang);
                $model->setSkillArt($row->skillartId);
                $model->setDisziplin($row->disziplin);
                $model->setUebung($row->uebung);
                $returnArray[] = $model;
            }
        }
        return $returnArray;
    }
    
    public function getSkillById($skillId) {
        $model = new Administration_Model_Skill();
        $select = $this->getDbTable('Skill')->select();
        $select->where('skillId = ?', $skillId);
        $row = $this->getDbTable('Skill')->fetchRow($select);
        if($row !== null){
            $model->setId($skillId);
            $model->setBezeichnung($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setDisziplin($row['disziplin']);
            $model->setUebung($row['uebung']);
            $model->setFp($row['fp']);
            $model->setRang($row['rang']);
        }
        return $model;
    }
    
    
    public function createSkill(Administration_Model_Skill $skill) {
        $data['name'] = $skill->getBezeichnung();
        $data['beschreibung'] = $skill->getBeschreibung();
        $data['fp'] = $skill->getFp();
        $data['skillartId'] = $skill->getSkillArt();
        $data['uebung'] = $skill->getUebung();
        $data['disziplin'] = $skill->getDisziplin();
        $data['rang'] = $skill->getRang();
        $data['createDate'] = $skill->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $skill->getCreator();
        
        return $this->getDbTable('Skill')->insert($data);
    }
    
    
    public function updateSkill(Administration_Model_Skill $skill) {
        $data['name'] = $skill->getBezeichnung();
        $data['beschreibung'] = $skill->getBeschreibung();
        $data['fp'] = $skill->getFp();
        $data['skillartId'] = $skill->getSkillArt();
        $data['uebung'] = $skill->getUebung();
        $data['disziplin'] = $skill->getDisziplin();
        $data['rang'] = $skill->getRang();
        $data['editDate'] = $skill->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $skill->getEditor();
        
        $this->deleteRequirementsSkill($skill);
        $this->setRequirementsSkill($skill);
        return $this->getDbTable('Skill')->update($data, array(
            'skillId = ?' => $skill->getId()
        ));
    }
    
    
    public function setRequirementsSkill(Administration_Model_Skill $skill) {
        $data['skillId'] = $skill->getId();
        foreach ($skill->getRequirementList()->getRequirements() as $requirement) {
            $data['art'] = $requirement->getArt();
            $data['voraussetzung'] = $requirement->getRequiredValue();
            $this->getDbTable('SkillVoraussetzung')->insert($data);
        }
    }
    
    
    public function deleteRequirementsSkill(Administration_Model_Skill $skill) {
        $this->getDbTable('SkillVoraussetzung')->delete(['skillId = ?' => $skill->getId()]);
    }
    
    /**
     * @param int $skillId
     * @return \Administration_Model_Requirementlist
     */
    public function getRequirementsSkill($skillId) {
        $requirementList = new Administration_Model_Requirementlist();
        $select = $this->getDbTable('SkillVoraussetzung')->select();
        $select->where('skillId = ?', $skillId);
        $result = $this->getDbTable('SkillVoraussetzung')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $requirement = new Administration_Model_Requirement();
                $requirement->setArt($row->art);
                $requirement->setRequiredValue($row->voraussetzung);
                $requirementList->addRequirement($requirement);
            }
        }
        return $requirementList;
    }
    
    /**
     * @return array Administration_Model_Magie
     */
    public function getMagien() {
        $schuleMapper = new Administration_Model_Mapper_SchuleMapper();
        $returnArray = array();
        $select = $this->getDbTable('Magie')->select();
        $select->distinct();
        $select->order('magieschuleId');
        $result = $this->getDbTable('Magie')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Administration_Model_Magie();
                $model->setId($row->magieId);
                $model->setBezeichnung($row->name);
                $model->setBeschreibung($row->beschreibung);
                $model->setFp($row->fp);
                $model->setPrana($row->prana);
                $model->setRang($row->rang);
                $model->setStufe($row->stufe);
                $model->setSchule($schuleMapper->getSchuleById($row->magieschuleId));
                $model->setLernbedingung($row->lernbedingung);
                $returnArray[] = $model;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $magieId
     * @return \Administration_Model_Magie
     */
    public function getMagieById($magieId) {
        $model = new Administration_Model_Magie();
        $select = $this->getDbTable('Magie')->select();
        $select->where('magieId = ?', $magieId);
        $row = $this->getDbTable('Magie')->fetchRow($select);
        if($row !== null){
            $model->setId($magieId);
            $model->setBezeichnung($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setFp($row['fp']);
            $model->setPrana($row['prana']);
            $model->setRang($row['rang']);
            $model->setStufe($row['stufe']);
            $model->setLernbedingung($row['lernbedingung']);
        }
        return $model;
    }
    
    /**
     * @param Administration_Model_Magie $magie
     * @return int
     */
    public function createMagie(Administration_Model_Magie $magie) {
        $data['name'] = $magie->getBezeichnung();
        $data['beschreibung'] = $magie->getBeschreibung();
        $data['fp'] = $magie->getFp();
        $data['prana'] = $magie->getPrana();
        $data['rang'] = $magie->getRang();
        $data['element'] = $magie->getElement()->getId();
        $data['stufe'] = $magie->getStufe();
        $data['magieschuleId'] = $magie->getSchule()->getId();
        $data['gruppe'] = $magie->getGruppe();
        $data['lernbedingung'] = $magie->getLernbedingung();
        $data['createDate'] = $magie->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $magie->getCreator();
        
        return $this->getDbTable('Magie')->insert($data);
    }
    
    /**
     * @param Administration_Model_Magie $magie
     * @return int
     */
    public function updateMagie(Administration_Model_Magie $magie) {
        $data['name'] = $magie->getBezeichnung();
        $data['beschreibung'] = $magie->getBeschreibung();
        $data['fp'] = $magie->getFp();
        $data['prana'] = $magie->getPrana();
        $data['rang'] = $magie->getRang();
        $data['element'] = $magie->getElement()->getId();
        $data['stufe'] = $magie->getStufe();
        $data['magieschuleId'] = $magie->getSchule()->getId();
        $data['gruppe'] = $magie->getGruppe();
        $data['lernbedingung'] = $magie->getLernbedingung();
        $data['createDate'] = $magie->getEditDate('Y-m-d H:i:s');
        $data['creator'] = $magie->getEditor();
        
        return $this->getDbTable('Magie')->update($data, array(
            'magieId = ?' => $magie->getId()
        ));
    }
    
    /**
     * @param Administration_Model_Magie $magie
     * @return int
     */
    public function deleteDependencies(Administration_Model_Magie $magie) {
        return $this->getDbTable('MagieCharakterVoraussetzungen')->delete(array(
            'magieId = ?' => $magie->getId()
        ));
    }
    
    /**
     * @param Administration_Model_Magie $magie
     * @return int
     */
    public function setDependencies(Administration_Model_Magie $magie) {
        $data['magieId'] = $magie->getId();
        foreach ($magie->getRequirementList()->getRequirements() as $requirement) {
            $data['art'] = $requirement->getArt();
            $data['voraussetzung'] = $requirement->getRequiredValue();
            $this->getDbTable('MagieCharakterVoraussetzungen')->insert($data);
        }
    }
    
}
