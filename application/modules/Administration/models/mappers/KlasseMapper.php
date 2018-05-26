<?php

class Administration_Model_Mapper_KlasseMapper extends Application_Model_Mapper_KlasseMapper {

    /**
     * @param Administration_Model_Klasse $klasse
     *
     * @return int
     * @throws Exception
     */
    public function createClass(Administration_Model_Klasse $klasse) {
        $data['klasse'] = $klasse->getBezeichnung();
        $data['beschreibung'] = $klasse->getBeschreibung();
        $data['klassengruppenId'] = $klasse->getGruppe();
        $data['familienname'] = $klasse->getFamilienname();
        $data['kosten'] = $klasse->getKosten();
        $data['createDate'] = $klasse->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $klasse->getCreator();
        
        return parent::getDbTable('Klasse')->insert($data);
    }

    /**
     * @param int $klassenId
     * @return \Administration_Model_Klasse
     * @throws Exception
     */
    public function getClassById($klassenId) {
        $model = new Administration_Model_Klasse();
        $select = parent::getDbTable('Klasse')->select();
        $select->where('klassenId = ?', $klassenId);
        $row = parent::getDbTable('Klasse')->fetchRow($select);
        if($row !== null){
            $model->setId($row['klassenId']);
            $model->setBezeichnung($row['klasse']);
            $model->setBeschreibung($row['beschreibung']);
            $model->setFamilienname($row['familienname']);
            $model->setGruppe($row['klassengruppenId']);
            $model->setKosten($row['kosten']);
        }
        return $model;
    }

    /**
     * @param Administration_Model_Klasse $klasse
     * @return int
     * @throws Exception
     */
    public function updateClass(Administration_Model_Klasse $klasse) {
        $data['klasse'] = $klasse->getBezeichnung();
        $data['beschreibung'] = $klasse->getBeschreibung();
        $data['familienname'] = $klasse->getFamilienname();
        $data['klassengruppenId'] = $klasse->getGruppe();
        $data['kosten'] = $klasse->getKosten();
        $data['editDate'] = $klasse->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $klasse->getEditor();
        return parent::getDbTable('Klasse')->update($data, array('klassenId = ?' => $klasse->getId()));
    }
    
}
