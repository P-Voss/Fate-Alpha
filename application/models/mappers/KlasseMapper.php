<?php

class Application_Model_Mapper_KlasseMapper implements Application_Model_Erstellung_Information_InformationInterface{

    
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
    
    public function getPunkte($ids){
        $select = $this->getDbTable('Klasse')->select();
        $select->setIntegrityCheck(false);
        $select->from('klassen', array('Punkte' => new Zend_Db_Expr('SUM(kosten)')));
        $select->where('klassenID IN(?)', $ids);
        $result = $this->getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->Punkte;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getBeschreibung($ids) {
        $select = $this->getDbTable('Klasse')->select();
        $select->setIntegrityCheck(false);
        $select->from('klassen', array('beschreibung'));
        $select->where('klassenID IN (?)', $ids);
        $result = $this->getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->beschreibung;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    /**
     * @param int $klassenId
     * @return \Application_Model_Klassengruppe
     * @throws Exception
     */
    public function getKlassengruppe($klassenId) {
        $select = $this->getDbTable('Klasse')->select();
        $select->setIntegrityCheck(false);
        $select->from('klassen', array('klassengruppenId'));
        $select->joinInner('klassengruppen', 'klassengruppen.klassengruppenId = klassen.klassengruppenId', array(
            'name',
            'beschreibung'
        ));
        $select->where('klassenID = ?', $klassenId);
        $result = $this->getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $klassengruppe = new Application_Model_Klassengruppe();
                $klassengruppe->setId($row->klassengruppenId);
                $klassengruppe->setBezeichnung($row->name);
                $klassengruppe->setBeschreibung($row->beschreibung);
            }
            return $klassengruppe;
        }else{
            throw new Exception('Klassengruppe konnte nicht gefunden werden');
        }
    }
    
    /**
     * @param int $klassenId
     * @return \Application_Model_Klasse
     */
    public function getKlasseById($klassenId) {
        $select = $this->getDbTable('Klasse')->select();
        $select->where('klassenId = ?', $klassenId);
        $result = $this->getDbTable('Klasse')->fetchAll($select)->current();
        $klasse = new Application_Model_Klasse();
        $klasse->setId($klassenId);
        $klasse->setBezeichnung($result['klasse']);
        $klasse->setBeschreibung($result['beschreibung']);
        $klasse->setKosten($result['kosten']);
        return $klasse;
    }
    
    public function getFamilienname($klassenId) {
        $return = '';
        $select = $this->getDbTable('Klasse')->select();
        $select->setIntegrityCheck(false);
        $select->from('klassen', array('klassenId', 'familienname'));
        $select->where('klassenId = ?', $klassenId);
        $result = $this->getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                if($row->klassenId == 10){
                    $return = (rand(0, 1)) ? 'Makiri' : 'Matou';
                }else{
                    $return = $row->familienname;
                }
            }
        }
        return $return;
    }
    
    
}
