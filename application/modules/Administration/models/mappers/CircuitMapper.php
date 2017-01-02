<?php


class Administration_Model_Mapper_CircuitMapper extends Application_Model_Mapper_CircuitMapper {
    
    /**
     * @param Administration_Model_Circuit $circuit
     * @return int
     */
    public function createCircuit(Administration_Model_Circuit $circuit) {
        $data['kategorie'] = $circuit->getKategorie();
        $data['besonderheit'] = $circuit->getBeschreibung();
        $data['kosten'] = (int) $circuit->getKosten();
        $data['kostenanzeige'] = (int) $circuit->getKosten() < 0 ? '+' . ($circuit->getKosten() * -1) : $circuit->getKosten();
        $data['menge'] = $circuit->getMenge();
        $data['createDate'] = $circuit->getCreateDate('Y-m-d H:i:s');
        $data['creator'] = $circuit->getCreator();
        
        return parent::getDbTable('Circuit')->insert($data);
    }
    
    /**
     * @param int $circuitId
     * @return \Administration_Model_Circuit
     */
    public function getCircuitById($circuitId) {
        $model = new Administration_Model_Circuit();
        $select = parent::getDbTable('Circuit')->select();
        $select->where('circuitId = ?', $circuitId);
        $row = parent::getDbTable('Circuit')->fetchRow($select);
        if($row !== null){
            $model->setId($row['circuitId']);
            $model->setKategorie($row['kategorie']);
            $model->setBeschreibung($row['besonderheit']);
            $model->setMenge($row['menge']);
            $model->setKosten($row['kosten']);
        }
        return $model;
    }
    
    /**
     * @param Administration_Model_Circuit $circuit
     * @return int
     */
    public function updateCircuit(Administration_Model_Circuit $circuit) {
        $data['kategorie'] = $circuit->getKategorie();
        $data['besonderheit'] = $circuit->getBeschreibung();
        $data['menge'] = $circuit->getMenge();
        $data['kosten'] = (int) $circuit->getKosten();
        $data['kostenanzeige'] = (int) $circuit->getKosten() < 0 ? '+' . ($circuit->getKosten() * -1) : $circuit->getKosten();
        $data['editDate'] = $circuit->getEditDate('Y-m-d H:i:s');
        $data['editor'] = $circuit->getEditor();
        
        return parent::getDbTable('Circuit')->update($data, array('circuitId = ?' => $circuit->getId()));
    }

    
}
