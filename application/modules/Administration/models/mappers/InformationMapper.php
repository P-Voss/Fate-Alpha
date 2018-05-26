<?php

class Administration_Model_Mapper_InformationMapper extends Application_Model_Mapper_InformationMapper {

    /**
     * @return array
     * @throws Exception
     */
    public function getAllInformations() {
        $returnArray = array();
        $select = $this->getDbTable('Information')->select();
        $select->order('kategorie');
        $result = $this->getDbTable('Information')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row) {
                $model = new Application_Model_Information();
                $model->setInformationId($row->infoId);
                $model->setName($row->name);
                $model->setKategorie($row->kategorie);
                $returnArray[] = $model;
            }
        }
        return $returnArray;
    }

    /**
     * @param int $informationId
     *
     * @return \Administration_Model_Information
     * @throws Exception
     */
    public function getInformationById($informationId) {
        $model = new Administration_Model_Information();
        $select = parent::getDbTable('Information')->select();
        $select->setIntegrityCheck(false);
        $select->from('informationen');
        $select->joinLeft('informationenTexte', 'informationen.infoId = informationenTexte.infoId', array('inhalt'));
        $select->where('informationen.infoId = ?', $informationId);
        $row = parent::getDbTable('Information')->fetchRow($select);
        if($row !== null){
            $model->setInformationId($row['infoId']);
            $model->setName($row['name']);
            $model->setKategorie($row->kategorie);
            $model->setInhalt($row['inhalt']);
        }
        return $model;
    }

    /**
     * @param Administration_Model_Information $information
     * @return int
     * @throws Exception
     */
    public function createInformation(Administration_Model_Information $information) {
        $data['name'] = $information->getName();
        $data['createDate'] = $information->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $information->getCreator();
        $data['kategorie'] = $information->getKategorie();
        
        $id = parent::getDbTable('Information')->insert($data);
        $data = array(
            'infoId' => $id,
            'inhalt' => $information->getInhalt(),
        );
        parent::getDbTable('InformationText')->insert($data);
        return $id;
    }

    /**
     * @param Administration_Model_Information $information
     * @return int
     * @throws Exception
     */
    public function updateInformation(Administration_Model_Information $information) {
        $data['name'] = $information->getName();
        $data['editDate'] = $information->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $information->getEditor();
        $data['kategorie'] = $information->getKategorie();
        
        parent::getDbTable('Information')->update($data, array('infoId = ?' => $information->getInformationId()));
        $data = array(
            'inhalt' => $information->getInhalt(),
        );
        return parent::getDbTable('InformationText')->update($data, array('infoId = ?' => $information->getInformationId()));
    }

    /**
     * @param Administration_Model_Information $information
     * @throws Exception
     */
    public function setDependencies(Administration_Model_Information $information) {
        $data['infoId'] = $information->getInformationId();
        foreach ($information->getRequirementList()->getRequirements() as $requirement) {
            $data['art'] = $requirement->getArt();
            $data['voraussetzung'] = $requirement->getRequiredValue();
            $this->getDbTable('InfoCharakterVoraussetzungen')->insert($data);
        }
    }

    /**
     * @param Administration_Model_Information $information
     * @return int
     * @throws Exception
     */
    public function deleteDependencies(Administration_Model_Information $information) {
        return $this->getDbTable('InfoCharakterVoraussetzungen')->delete(array(
            'infoId = ?' => $information->getInformationId()
        ));
    }
    
}
