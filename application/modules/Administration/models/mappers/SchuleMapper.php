<?php

class Administration_Model_Mapper_SchuleMapper extends Application_Model_Mapper_SchuleMapper {
    
    /**
     * @param Administration_Model_Schule $schule
     * @return int
     */
    public function createSchule(Administration_Model_Schule $schule) {
        $data['name'] = $schule->getBezeichnung();
        $data['beschreibung'] = $schule->getBeschreibung();
        $data['createDate'] = $schule->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $schule->getEditor();
        
        return parent::getDbTable('Schule')->insert($data);
    }
    
    /**
     * @param int $schuleId
     * @return \Administration_Model_Schule
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
        }
        return $model;
    }
    
    /**
     * @param Administration_Model_Schule $schule
     * @return int
     */
    public function updateSchule(Administration_Model_Schule $schule) {
        $data['name'] = $schule->getBezeichnung();
        $data['beschreibung'] = $schule->getBeschreibung();
        $data['editDate'] = $schule->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $schule->getEditor();
        
        return parent::getDbTable('Schule')->update($data, array('magieschuleId = ?' => $schule->getId()));
    }
    
}
