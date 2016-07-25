<?php

class Administration_Model_Mapper_InformationMapper extends Application_Model_Mapper_InformationMapper {
    
    
    public function getAllInformations() {
        
    }
    
    public function createInformation(Administration_Model_Information $information) {
        $data['name'] = $information->getName();
//        $data['createDate'] = $information->getCreateDate('Y-m-d H:i:s');
//        $data['creator'] = $information->getCreator();
        
        $id = parent::getDbTable('Information')->insert($data);
        $data = array(
            'infoId' => $id,
            'inhalt' => $information->getInhalt(),
        );
        parent::getDbTable('InformationText')->insert($data);
        return $id;
    }
    
    
    public function updateInformation(Administration_Model_Information $information) {
        
    }
    
    
    public function setDependencies(Administration_Model_Information $information) {
        $data['infoId'] = $information->getInformationId();
        foreach ($information->getRequirementList()->getRequirements() as $requirement) {
            $data['art'] = $requirement->getArt();
            $data['voraussetzung'] = $requirement->getRequiredValue();
            $this->getDbTable('InfoCharakterVoraussetzungen')->insert($data);
        }
    }
    
}
