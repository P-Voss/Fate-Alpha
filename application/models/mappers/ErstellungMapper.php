<?php

/**
 * Description of ErstellungMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Mapper_ErstellungMapper {
    
    protected $dbTableVorteil;
    protected $dbTableNachteil;
    protected $dbTableKlasse;
    protected $dbTableKlassengruppe;
    protected $dbTableVorteilToVorteil;
    protected $dbTableVorteilToNachteil;
    protected $dbTableNachteilToVorteil;
    protected $dbTableNachteilToNachteil;
    protected $dbTableLuck;
    protected $dbTableCircuit;
    protected $dbTableElement;
    protected $dbTableOdo;
    
    
    public function getDbTableVorteil() {
        if (null === $this->dbTableVorteil) {
            $this->setDbTableVorteil('Application_Model_DbTable_Vorteil');
        }
        return $this->dbTableVorteil;
    }

    public function setDbTableVorteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableVorteil = $dbTable;
        return $this;
    }

    public function getDbTableLuck() {
        if (null === $this->dbTableLuck) {
            $this->setDbTableLuck('Application_Model_DbTable_Luck');
        }
        return $this->dbTableLuck;
    }

    public function setDbTableLuck($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableLuck = $dbTable;
        return $this;
    }

    public function getDbTableOdo() {
        if (null === $this->dbTableOdo) {
            $this->setDbTableOdo('Application_Model_DbTable_Odo');
        }
        return $this->dbTableOdo;
    }

    public function setDbTableOdo($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableOdo = $dbTable;
        return $this;
    }

    public function getDbTableElement() {
        if (null === $this->dbTableElement) {
            $this->setDbTableElement('Application_Model_DbTable_Element');
        }
        return $this->dbTableElement;
    }

    public function setDbTableElement($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableElement = $dbTable;
        return $this;
    }

    public function getDbTableCircuit() {
        if (null === $this->dbTableCircuit) {
            $this->setDbTableCircuit('Application_Model_DbTable_Circuit');
        }
        return $this->dbTableCircuit;
    }

    public function setDbTableCircuit($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCircuit = $dbTable;
        return $this;
    }
    
    public function getDbTableNachteil() {
        if (null === $this->dbTableNachteil) {
            $this->setDbTableNachteil('Application_Model_DbTable_Nachteil');
        }
        return $this->dbTableNachteil;
    }

    public function setDbTableNachteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableNachteil = $dbTable;
        return $this;
    }
    
    public function getDbTableKlasse() {
        if (null === $this->dbTableKlasse) {
            $this->setDbTableKlasse('Application_Model_DbTable_Klasse');
        }
        return $this->dbTableKlasse;
    }

    public function setDbTableKlasse($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableKlasse = $dbTable;
        return $this;
    }
    
    public function getDbTableKlassengruppe() {
        if (null === $this->dbTableKlassengruppe) {
            $this->setDbTableKlassengruppe('Application_Model_DbTable_Klassengruppe');
        }
        return $this->dbTableKlassengruppe;
    }

    public function setDbTableKlassengruppe($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableKlassengruppe = $dbTable;
        return $this;
    }
    
    public function getDbTableVorteilToVorteil() {
        if (null === $this->dbTableVorteilToVorteil) {
            $this->setDbTableVorteilToVorteil('Application_Model_DbTable_VorteilToVorteil');
        }
        return $this->dbTableVorteilToVorteil;
    }

    public function setDbTableVorteilToVorteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableVorteilToVorteil = $dbTable;
        return $this;
    }
    
    public function getDbTableVorteilToNachteil() {
        if (null === $this->dbTableVorteilToNachteil) {
            $this->setDbTableVorteilToNachteil('Application_Model_DbTable_VorteilToNachteil');
        }
        return $this->dbTableVorteilToNachteil;
    }

    public function setDbTableVorteilToNachteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableVorteilToNachteil = $dbTable;
        return $this;
    }
    
    public function getDbTableNachteilToVorteil() {
        if (null === $this->dbTableNachteilToVorteil) {
            $this->setDbTableNachteilToVorteil('Application_Model_DbTable_NachteilToVorteil');
        }
        return $this->dbTableNachteilToVorteil;
    }

    public function setDbTableNachteilToVorteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableNachteilToVorteil = $dbTable;
        return $this;
    }
    
    public function getDbTableNachteilToNachteil() {
        if (null === $this->dbTableNachteilToNachteil) {
            $this->setDbTableNachteilToNachteil('Application_Model_DbTable_NachteilToNachteil');
        }
        return $this->dbTableNachteilToNachteil;
    }

    public function setDbTableNachteilToNachteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableNachteilToNachteil = $dbTable;
        return $this;
    }
    
    public function getAllVorteile() {
        $select = $this->getDbTableVorteil()->select();
        $result = $this->getDbTableVorteil()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Vorteil();
                $model->setId($row->VorteilID);
                $model->setBezeichnung($row->Vorteil);
                $model->setBeschreibung($row->Beschreibung);
                $model->setKosten($row->Kosten);
                $model->setGruppe($row->Kombo);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getVorteilIncompatibilities($vorteilIds = null, $nachteilIds = null) {
        $disabledVorteile = array();
        foreach ($vorteilIds as $vorteilId){
            $select1 = $this->getDbTableVorteilToVorteil()->select();
            $select1->from('InkVorteilToVorteil', array('id' => 'id2'));
            $select1->where('id1 = ?', $vorteilId);

            $select2 = $this->getDbTableVorteilToVorteil()->select();
            $select2->from('InkVorteilToVorteil', array('id' => 'id1'));
            $select2->Where('id2 = ?', $vorteilId);

            $select = $this->getDbTableVorteilToVorteil()->select();
            $select->union(array($select1, $select2));
            $result = $this->getDbTableVorteilToVorteil()->fetchAll($select);
            if($result->count() > 0){
                foreach ($result as $row){
                    $disabledVorteile[] = $row->id;
                }
            }
        }
        foreach ($nachteilIds as $nachteilId){
            $select = $this->getDbTableNachteilToVorteil()->select();
            $select->from('InkNachteilToVorteil', array('id' => 'vorteil_id'));
            $select->where('nachteil_id = ?', $nachteilId);

            $result = $this->getDbTableNachteilToVorteil()->fetchAll($select);
            if($result->count() > 0){
                foreach ($result as $row){
                    $disabledVorteile[] = $row->id;
                }
            }
        }
        return $disabledVorteile;
    }
    
    public function getNachteilIncompatibilities($nachteilIds = null, $vorteilIds = null) {
        $disabledNachteile = array();
        foreach ($nachteilIds as $nachteilId){
            $select1 = $this->getDbTableNachteilToNachteil()->select();
            $select1->from('InkNachteilToNachteil', array('id' => 'id2'));
            $select1->where('id1 = ?', $nachteilId);

            $select2 = $this->getDbTableNachteilToNachteil()->select();
            $select2->from('InkNachteilToNachteil', array('id' => 'id1'));
            $select2->Where('id2 = ?', $nachteilId);

            $select = $this->getDbTableNachteilToNachteil()->select();
            $select->union(array($select1, $select2));
            $result = $this->getDbTableNachteilToNachteil()->fetchAll($select);
            if($result->count() > 0){
                foreach ($result as $row){
                    $disabledNachteile[] = $row->id;
                }
            }
        }
        foreach ($vorteilIds as $vorteilId){
            $select = $this->getDbTableVorteilToNachteil()->select();
            $select->from('InkVorteilToNachteil', array('id' => 'nachteil_id'));
            $select->where('vorteil_id = ?', $vorteilId);

            $result = $this->getDbTableVorteilToNachteil()->fetchAll($select);
            if($result->count() > 0){
                foreach ($result as $row){
                    $disabledNachteile[] = $row->id;
                }
            }
        }
        return $disabledNachteile;
    }
    
    public function getAllNachteile() {
        $select = $this->getDbTableNachteil()->select();
        $result = $this->getDbTableNachteil()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Nachteil();
                $model->setId($row->NachteilID);
                $model->setBezeichnung($row->Nachteil);
                $model->setBeschreibung($row->Beschreibung);
                $model->setKosten($row->Kosten);
                $model->setGruppe($row->Kombo);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllClasses() {
        $select = $this->getDbTableKlasse()->select();
        $result = $this->getDbTableKlasse()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Klasse();
                $model->setId($row->KlassenID);
                $model->setBezeichnung($row->Klasse);
                $model->setBeschreibung($row->Beschreibung);
                $model->setKosten($row->Kosten);
                $model->setGruppe($row->Gruppe);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllCircuits() {
        $select = $this->getDbTableCircuit()->select();
        $result = $this->getDbTableCircuit()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Circuit();
                $model->setId($row->ID);
                $model->setKategorie($row->Kategorie);
                $model->setBeschreibung($row->Besonderheit);
                $model->setMenge($row->Menge);
                $model->setKosten($row->Kosten);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllLuckvalues() {
        $select = $this->getDbTableLuck()->select();
        $result = $this->getDbTableLuck()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Luck();
                $model->setId($row->ID);
                $model->setKategorie($row->Kategorie);
                $model->setBeschreibung($row->Beschreibung);
                $model->setKosten($row->Kosten);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllElements() {
        $select = $this->getDbTableElement()->select();
        $result = $this->getDbTableElement()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Element();
                $model->setId($row->ID);
                $model->setBezeichnung($row->Element);
                $model->setBeschreibung($row->Beschreibung);
                $model->setCharakterisierung($row->Charakterisierung);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllOdo() {
        $select = $this->getDbTableOdo()->select();
        $result = $this->getDbTableOdo()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Odo();
                $model->setId($row->ID);
                $model->setKategorie($row->Kategorie);
                $model->setMenge($row->Menge);
                $model->setKosten($row->Kosten);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
}
