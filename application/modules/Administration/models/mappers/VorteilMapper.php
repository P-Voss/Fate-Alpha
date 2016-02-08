<?php

class Administration_Model_Mapper_VorteilMapper extends Application_Model_Mapper_VorteilMapper {
    
    /**
     * @param Administration_Model_Vorteil $vorteil
     * @return int
     */
    public function createVorteil(Administration_Model_Vorteil $vorteil) {
        $data['name'] = $vorteil->getBezeichnung();
        $data['beschreibung'] = $vorteil->getBeschreibung();
        $data['kosten'] = $vorteil->getKosten();
        $data['createDate'] = $vorteil->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $vorteil->getCreator();
        
        return parent::getDbTable('Vorteil')->insert($data);
    }
    
    /**
     * @param int $vorteilId
     * @return \Administration_Model_Vorteil
     */
    public function getVorteilById($vorteilId) {
        $model = new Administration_Model_Vorteil();
        $select = parent::getDbTable('Vorteil')->select();
        $select->where('vorteilId = ?', $vorteilId);
        $row = parent::getDbTable('Vorteil')->fetchRow($select);
        if($row !== null){
            $model->setId($row['vorteilId']);
            $model->setBezeichnung($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setKosten($row['kosten']);
        }
        return $model;
    }
    
    /**
     * @param Administration_Model_Vorteil $vorteil
     * @return int
     */
    public function updateVorteil(Administration_Model_Vorteil $vorteil) {
        $data['name'] = $vorteil->getBezeichnung();
        $data['beschreibung'] = $vorteil->getBeschreibung();
        $data['kosten'] = $vorteil->getKosten();
        $data['editDate'] = $vorteil->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $vorteil->getEditor();
        
        return parent::getDbTable('Vorteil')->update($data, array('vorteilId = ?' => $vorteil->getId()));
    }
    
}
