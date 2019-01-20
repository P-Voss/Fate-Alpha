<?php

/**
 * Class Erstellung_Model_Mapper_AttributeMapper
 */
class Erstellung_Model_Mapper_AttributeMapper extends Application_Model_Mapper_ErstellungMapper {

    /**
     * @return array
     * @throws Exception
     */
    public function getKlassengruppen() {
        $returnArray = array();
        $select = parent::getDbTable('Klassengruppe')->select();
        $result = parent::getDbTable('Klassengruppe')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $klasse = new Erstellung_Model_Klasse();
                $klasse->setId($row->klassengruppenId);
                $klasse->setBezeichnung($row->name);
                $klasse->setBeschreibung($row->beschreibung);
                $returnArray[] = $klasse;
            }
        }
        return $returnArray;
    }
    
    
    public function getKlassengruppeById($klassengruppenId) {
        $select = parent::getDbTable('Klassengruppe')->select();
        $select->where('klassengruppenId = ?', $klassengruppenId);
        $row = parent::getDbTable('Klassengruppe')->fetchRow($select);
        if($row !== null){
            $klassengruppe = new Erstellung_Model_Klasse();
            $klassengruppe->setId($row->klassengruppenId);
            $klassengruppe->setBezeichnung($row->name);
            $klassengruppe->setBeschreibung($row->beschreibung);
            return $klassengruppe;
        }else{
            return false;
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getFamiliennamen() {
        $returnArray = array();
        $select = parent::getDbTable('Klasse')->select();
        $select->where('familienname != "" AND familienname IS NOT NULL');
        $result = parent::getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row) {
                $returnArray[] = $row->familienname;
            }
        }
        return $returnArray;
    }

    /**
     * @param $id
     *
     * @return Erstellung_Model_Circuit
     * @throws Exception
     */
    public function getCircuit ($id)
    {
        $row = $this->getDbTable('Circuit')->fetchRow(
            $this->getDbTable('Circuit')->select()->where('circuitId = ?', $id)
        );
        if ($row === null) {
            throw new Exception('cant find circuit');
        }
        $circuit = new Erstellung_Model_Circuit();
        $circuit->setId($row->circuitId);
        $circuit->setKosten($row->kosten);
        $circuit->setKategorie($row->kategorie);
        return $circuit;
    }

    /**
     * @param $id
     *
     * @return Erstellung_Model_Odo
     * @throws Exception
     */
    public function getOdo ($id)
    {
        $row = $this->getDbTable('Odo')->fetchRow(
            $this->getDbTable('Odo')->select()->where('odoId = ?', $id)
        );
        if ($row === null) {
            throw new Exception('cant find odo');
        }
        $odo = new Erstellung_Model_Odo();
        $odo->setId($row->odoId);
        $odo->setKosten($row->kosten);
        $odo->setKategorie($row->kategorie);
        return $odo;
    }

    /**
     * @param $id
     *
     * @return Erstellung_Model_Luck
     * @throws Exception
     */
    public function getLuck ($id)
    {
        $row = $this->getDbTable('Luck')->fetchRow(
            $this->getDbTable('Luck')->select()->where('luckId = ?', $id)
        );
        if ($row === null) {
            throw new Exception('cant find luck');
        }
        $luck = new Erstellung_Model_Luck();
        $luck->setId($row->luckId);
        $luck->setBeschreibung($row->beschreibung);
        $luck->setKosten($row->kosten);
        $luck->setKategorie($row->kategorie);
        return $luck;
    }

}
