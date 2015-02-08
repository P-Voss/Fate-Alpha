<?php

class Application_Model_Mapper_CharakterMapper{
    
    protected $dbTableCharakter;
    protected $dbTableCharakterElement;
    protected $dbTableCharakterVorteil;
    protected $dbTableCharakterNachteil;
    protected $dbTableCharakterWerte;
    protected $dbTableCharakterProfil;
    protected $dbTableTraining;
    protected $dbTableVorteil;
    protected $dbTableNachteil;

    public function getDbTableCharakter() {
        if (null === $this->dbTableCharakter) {
            $this->setDbTableCharakter('Application_Model_DbTable_Charakter');
        }
        return $this->dbTableCharakter;
    }

    public function setDbTableCharakter($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCharakter = $dbTable;
        return $this;
    }

    public function getDbTableCharakterElement() {
        if (null === $this->dbTableCharakterElement) {
            $this->setDbTableCharakterElement('Application_Model_DbTable_CharakterElement');
        }
        return $this->dbTableCharakterElement;
    }

    public function setDbTableCharakterElement($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCharakterElement = $dbTable;
        return $this;
    }

    public function getDbTableCharakterWerte() {
        if (null === $this->dbTableCharakterWerte) {
            $this->setDbTableCharakterWerte('Application_Model_DbTable_CharakterWerte');
        }
        return $this->dbTableCharakterWerte;
    }

    public function setDbTableCharakterWerte($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCharakterWerte = $dbTable;
        return $this;
    }

    public function getDbTableCharakterProfil() {
        if (null === $this->dbTableCharakterProfil) {
            $this->setDbTableCharakterProfil('Application_Model_DbTable_CharakterProfil');
        }
        return $this->dbTableCharakterProfil;
    }

    public function setDbTableCharakterProfil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCharakterProfil = $dbTable;
        return $this;
    }

    public function getDbTableCharakterNachteil() {
        if (null === $this->dbTableCharakterNachteil) {
            $this->setDbTableCharakterNachteil('Application_Model_DbTable_CharakterNachteil');
        }
        return $this->dbTableCharakterNachteil;
    }

    public function setDbTableCharakterNachteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCharakterNachteil = $dbTable;
        return $this;
    }

    public function getDbTableCharakterVorteil() {
        if (null === $this->dbTableCharakterVorteil) {
            $this->setDbTableCharakterVorteil('Application_Model_DbTable_CharakterVorteil');
        }
        return $this->dbTableCharakterVorteil;
    }

    public function setDbTableCharakterVorteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCharakterVorteil = $dbTable;
        return $this;
    }

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
    
    public function getDbTableTraining() {
        if (null === $this->dbTableTraining) {
            $this->setDbTableTraining('Application_Model_DbTable_Training');
        }
        return $this->dbTableTraining;
    }

    public function setDbTableTraining($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableTraining = $dbTable;
        return $this;
    }
    
    public function createCharakter(Application_Model_Charakter $charakter) {
        $data = array();
        $data['userID'] = $charakter->getUserid();
        $data['Vorname'] = $charakter->getVorname();
        $data['Nachname'] = $charakter->getNachname();
        $data['Geburtsdatum'] = $charakter->getGeburtsdatum();
        $data['Geschlecht'] = $charakter->getGeschlecht();
        $data['Augenfarbe'] = $charakter->getAugenfarbe();
        $data['Size'] = $charakter->getSize();
        $data['Sex'] = $charakter->getGeschlecht();
        $data['Wohnort'] = $charakter->getWohnort();
        $data['Klasse'] = $charakter->getKlasse();
        $data['Odo'] = $charakter->getOdo();
        $data['MagicCircuit'] = $charakter->getMagiccircuit();
        $data['Luck'] = $charakter->getLuck();
        $data['Tage'] = 1;
        return $this->getDbTableCharakter()->insert($data);
    }
    
    public function saveCharakterElement($elementId, $charakterId) {
        $data = array();
        $data['CharakterID'] = $charakterId;
        $data['ElementID'] = $elementId;
        return $this->getDbTableCharakterElement()->insert($data);
    }
    
    public function saveCharakterVorteil($vorteilId, $charakterId) {
        $data = array();
        $data['CharakterID'] = $charakterId;
        $data['VorteilID'] = $vorteilId;
        return $this->getDbTableCharakterVorteil()->insert($data);
    }
    
    public function saveCharakterNachteil($nachteilId, $charakterId) {
        $data = array();
        $data['CharakterID'] = $charakterId;
        $data['NachteilID'] = $nachteilId;
        return $this->getDbTableCharakterNachteil()->insert($data);
    }
    
    public function saveCharakterWerte($charakterId) {
        $data = array();
        $data['CharakterID'] = $charakterId;
        $data['Staerke'] = 10;
        $data['Agilitaet'] = 10;
        $data['Ausdauer'] = 10;
        $data['Disziplin'] = 10;
        $data['Kontrolle'] = 10;
        $data['Uebung'] = 10;
        $data['Startpunkte'] = 300;
        $this->getDbTableCharakterWerte()->insert($data);
    }
    
    public function getCharakterById($userId){
        $select = $this->getDbTableCharakter()->select();
        $select->setIntegrityCheck(false);
        $select->from(array('C' => 'Charakter'), array('C.*'));
        $select->where('C.userid = ?', $userId);
        $select->joinLeft(array('K' => 'Klassen'), 'C.Klasse = K.KlassenID', array('K.Gruppe'));
        $result = $this->getDbTableCharakter()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Charakter();
                $model->setVorname($row->Vorname);
                $model->setNachname($row->Nachname);
                $model->setCharakterid($row->ID);
                $model->setAlter($row->Jahre);
                $model->setAugenfarbe($row->Augenfarbe);
                $model->setGeburtsdatum($row->Geburtsdatum);
                $model->setGeschlecht($row->Sex);
                $model->setMagiccircuit($row->MagicCircuit);
                $model->addElement($row->Naturelement);
                $model->setNickname($row->Nickname);
                $model->setSize($row->Size);
                $model->setWohnort($row->Wohnort);
                $model->setKlasse($row->Klasse);
                $model->setKlassengruppe($row->Gruppe);
                $model->setVorteile($this->getVorteileByCharakterId($row->ID));
                $model->setNachteile($this->getNachteileByCharakterId($row->ID));
                if(!is_null($this->getCharakterwerte($row->ID))){
                    $model->setCharakterwerte($this->getCharakterwerte($row->ID));
                }
                if(!is_null($this->getCharakterProfil($row->ID))){
                    $model->setCharakterprofil($this->getCharakterProfil($row->ID));
                }
            }
            return $model;
        }else{
            return false;
        }
    }
    
    public function getCharakterProfil($charakterId) {
        $select = $this->getDbTableCharakterProfil()->select();
        $select->from('CharakterProfil');
        $select->where('CharakterID = ?', $charakterId);
        $result = $this->getDbTableCharakterProfil()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Charakterprofil();
                $model->setCharaktergeschichte($row->charaktergeschichte);
                $model->setProfilpic($row->profilpic);
                $model->setCharpic($row->charpic);
                $model->setPrivatdaten($row->privatDaten);
                $model->setSldaten($row->slDaten);
                $model->setKennenlerncode($row->kennenlernCode);
                $model->setPrivatcode($row->privatCode);
            }
            return $model;
        }
        return null;
    }
    
    public function getCharakterwerte($charakterId) {
        $select = $this->getDbTableCharakterWerte()->select();
        $select->from('CharakterWerte');
        $select->where('CharakterID = ?', $charakterId);
        $result = $this->getDbTableCharakterWerte()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Charakterwerte();
                $model->setStaerke($row->Staerke);
                $model->setAgilitaet($row->Agilitaet);
                $model->setAusdauer($row->Ausdauer);
                $model->setDisziplin($row->Disziplin);
                $model->setKontrolle($row->Kontrolle);
                $model->setUebung($row->Uebung);
                $model->setFp($row->FP);
                $model->setStartpunkte($row->Startpunkte);
            }
            return $model;
        }
        return null;
    }
    
    public function getCurrentTraining($charakterId){
        $select = $this->getDbTableTraining()->select();
        $select->setIntegrityCheck(FALSE);
        $select->from('Training');
        $select->where('charakterID = ?', $charakterId);
        $result = $this->getDbTableTraining()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = array();
                $return['training'] = $row->wert;
                $return['dauer'] = $row->dauer;
            }
            return $return;
        }else{
            return false;
        }
    }
    
    public function getVorteileByCharakterId($charakterId){
        $select = $this->getDbTableVorteil()->select();
        $select->setIntegrityCheck(false);
        $select->from(array('CV' => 'CharakterVorteil'), array('V.VorteilID', 'V.Vorteil', 'V.Beschreibung'));
        $select->where('CV.CharakterID = ?', $charakterId);
        $select->join(array('V' => 'Vorteile'), 'CV.VorteilID = V.VorteilID');
        $result = $this->getDbTableVorteil()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $vorteilModel = new Application_Model_Vorteil();
                $vorteilModel->setId($row->VorteilID);
                $vorteilModel->setBezeichnung($row->Vorteil);
                $vorteilModel->setBeschreibung($row->Beschreibung);
                
                $returnArray[] = $vorteilModel;
            }
            return $returnArray;
        }else{
            return null;
        }
    }
    
    public function getNachteileByCharakterId($charakterId){
        $select = $this->getDbTableNachteil()->select();
        $select->setIntegrityCheck(false);
        $select->from(array('CN' => 'CharakterNachteil'), array('N.NachteilID', 'N.Nachteil', 'N.Beschreibung'));
        $select->where('CN.CharakterID = ?', $charakterId);
        $select->join(array('N' => 'Nachteile'), 'CN.NachteilID = N.NachteilID');
        $result = $this->getDbTableNachteil()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $nachteilModel = new Application_Model_Nachteil();
                $nachteilModel->setId($row->NachteilID);
                $nachteilModel->setBezeichnung($row->Nachteil);
                $nachteilModel->setBeschreibung($row->Beschreibung);
                
                $returnArray[] = $nachteilModel;
            }
            return $returnArray;
        }else{
            return null;
        }
    }
    
}
