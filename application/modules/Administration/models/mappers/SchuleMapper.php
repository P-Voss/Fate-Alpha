<?php

class Administration_Model_Mapper_SchuleMapper extends Application_Model_Mapper_SchuleMapper {

    /**
     * @param Administration_Model_Schule $schule
     *
     * @return int
     * @throws Exception
     */
    public function createSchule(Administration_Model_Schule $schule) {
        $data['name'] = $schule->getBezeichnung();
        $data['beschreibung'] = $schule->getBeschreibung();
        $data['createDate'] = $schule->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $schule->getCreator();
        $data['organization'] = $schule->getMagiOrganization();
        
        return parent::getDbTable('Schule')->insert($data);
    }

    /**
     * @param int $schuleId
     *
     * @return \Administration_Model_Schule
     * @throws Exception
     */
    public function getSchuleById($schuleId) {
        $model = new Administration_Model_Schule();
        $select = parent::getDbTable('Schule')->select();
        $select->where('magieschuleId = ?', $schuleId);
        $row = parent::getDbTable('Schule')->fetchRow($select);
        if($row !== null){
            $model->setId($row['magieschuleId']);
            $model->setBezeichnung($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setMagiOrganization($row['organization']);
        }
        return $model;
    }

    /**
     * @param Administration_Model_Schule $schule
     *
     * @return int
     * @throws Exception
     */
    public function updateSchule(Administration_Model_Schule $schule) {
        $data['name'] = $schule->getBezeichnung();
        $data['beschreibung'] = $schule->getBeschreibung();
        $data['editDate'] = $schule->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $schule->getEditor();
        $data['organization'] = $schule->getMagiOrganization();

        return parent::getDbTable('Schule')->update($data, array('magieschuleId = ?' => $schule->getId()));
    }

    /**
     * @param int $schuleId
     *
     * @return Administration_Model_Requirementlist
     * @throws Exception
     */
    public function getRequirementListSchool($schuleId) {
        $requirementList = new Administration_Model_Requirementlist();
        $select = $this->getDbTable('SchuleVoraussetzung')->select();
        $select->where('magieschuleId = ?', $schuleId);
        $result = $this->getDbTable('SchuleVoraussetzung')->fetchAll($select);
        foreach ($result as $row){
            $requirement = new Administration_Model_Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

    /**
     * @param Administration_Model_Schule $schule
     *
     * @return int
     * @throws Exception
     */
    public function deleteDependencies(Administration_Model_Schule $schule) {
        return $this->getDbTable('SchuleVoraussetzung')->delete(array(
            'magieschuleId = ?' => $schule->getId()
        ));
    }

    /**
     * @param Administration_Model_Schule $schule
     *
     * @throws Exception
     */
    public function setDependencies(Administration_Model_Schule $schule) {
        $data['magieschuleId'] = $schule->getId();
        foreach ($schule->getRequirementList()->getRequirements() as $requirement) {
            $data['art'] = $requirement->getArt();
            $data['voraussetzung'] = $requirement->getRequiredValue();
            $this->getDbTable('SchuleVoraussetzung')->insert($data);
        }
    }
    
}
