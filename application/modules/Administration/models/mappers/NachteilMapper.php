<?php

class Administration_Model_Mapper_NachteilMapper extends Application_Model_Mapper_NachteilMapper {

    /**
     * @param Administration_Model_Nachteil $nachteil
     *
     * @return int
     * @throws Exception
     */
    public function createNachteil(Administration_Model_Nachteil $nachteil) {
        $data['name'] = $nachteil->getBezeichnung();
        $data['beschreibung'] = $nachteil->getBeschreibung();
        $data['kosten'] = $nachteil->getKosten();
        $data['createDate'] = $nachteil->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $nachteil->getEditor();
        
        return parent::getDbTable('Nachteil')->insert($data);
    }

    /**
     * @param int $nachteilId
     * @return \Administration_Model_Nachteil
     * @throws Exception
     */
    public function getNachteilById($nachteilId) {
        $model = new Administration_Model_Nachteil();
        $select = parent::getDbTable('Nachteil')->select();
        $select->where('nachteilId = ?', $nachteilId);
        $row = parent::getDbTable('Nachteil')->fetchRow($select);
        if($row !== null){
            $model->setId($row['nachteilId']);
            $model->setBezeichnung($row['name']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setKosten($row['kosten']);
        }
        return $model;
    }

    /**
     * @param Administration_Model_Nachteil $nachteil
     * @return int
     * @throws Exception
     */
    public function updateNachteil(Administration_Model_Nachteil $nachteil) {
        $data['name'] = $nachteil->getBezeichnung();
        $data['beschreibung'] = $nachteil->getBeschreibung();
        $data['kosten'] = $nachteil->getKosten();
        $data['editDate'] = $nachteil->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $nachteil->getEditor();
        
        return parent::getDbTable('Nachteil')->update($data, array('nachteilId = ?' => $nachteil->getId()));
    }
    
}
