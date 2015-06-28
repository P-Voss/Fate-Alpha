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
    
    public function getKlassengruppe($klassenId) {
        $return = false;
        $select = $this->getDbTable('Klasse')->select();
        $select->setIntegrityCheck(false);
        $select->from('klassen', array('klassengruppenId'));
        $select->where('klassenID = ?', $klassenId);
        $result = $this->getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->klassengruppenId;
            }
        }
        return $return;
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
