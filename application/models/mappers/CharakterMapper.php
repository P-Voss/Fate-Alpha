<?php

class Application_Model_Mapper_CharakterMapper{
    
    /**
     * @param string $tablename
     * @return \Zend_Db_Table_Abstract
     * @throws Exception
     */
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
    
    /**
     * @param Application_Model_Charakter $charakter
     * @return int
     */
    public function deleteCharakter(Application_Model_Charakter $charakter) {
        $db = $this->getDbTable('Charakter')->getAdapter();
        $db->beginTransaction();
        $db->delete('charakter', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterElemente', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterItemAusruestung', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterItemRPG', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterItems', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterMagien', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterMagieschulen', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterNachteile', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterProfil', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterSkillarten', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterSkills', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterVermoegen', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterVorteile', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->delete('charakterWerte', array('charakterId = ?' => $charakter->getCharakterid()));
        $db->commit();
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @return int
     */
    public function createCharakter(Application_Model_Charakter $charakter) {
        $data = array();
        $data['userId'] = $charakter->getUserid();
        $data['vorname'] = $charakter->getVorname();
        $data['nachname'] = $charakter->getNachname();
        $data['geburtsdatum'] = $charakter->getGeburtsdatum();
        $data['geschlecht'] = $charakter->getGeschlecht();
        $data['augenfarbe'] = $charakter->getAugenfarbe();
        $data['size'] = $charakter->getSize();
        $data['geschlecht'] = $charakter->getGeschlecht();
        $data['wohnort'] = $charakter->getWohnort();
        $data['naturElement'] = $charakter->getElemente()[0];
        $data['klassenId'] = $charakter->getKlasse();
        $data['odo'] = $charakter->getOdo();
        $data['circuit'] = $charakter->getMagiccircuit();
        $data['luck'] = $charakter->getLuck();
        $data['tage'] = 1;
        return $this->getDbTable('Charakter')->insert($data);
    }
    
    /**
     * @param int $elementId
     * @param int $charakterId
     * @return int
     */
    public function saveCharakterElement($elementId, $charakterId) {
        $data = array();
        $data['charakterId'] = $charakterId;
        $data['elementId'] = $elementId;
        return $this->getDbTable('CharakterElement')->insert($data);
    }
    
    /**
     * @param int $vorteilId
     * @param int $charakterId
     * @return int
     */
    public function saveCharakterVorteil($vorteilId, $charakterId) {
        $data = array();
        $data['charakterId'] = $charakterId;
        $data['vorteilId'] = $vorteilId;
        return $this->getDbTable('CharakterVorteil')->insert($data);
    }
    
    /**
     * @param int $nachteilId
     * @param int $charakterId
     * @return int
     */
    public function saveCharakterNachteil($nachteilId, $charakterId) {
        $data = array();
        $data['charakterId'] = $charakterId;
        $data['nachteilId'] = $nachteilId;
        return $this->getDbTable('CharakterNachteil')->insert($data);
    }
    
    /**
     * @param type $charakterId
     * @return int
     */
    public function saveCharakterWerte($charakterId) {
        $data = array();
        $data['charakterId'] = $charakterId;
        $data['staerke'] = 10;
        $data['agilitaet'] = 10;
        $data['ausdauer'] = 10;
        $data['disziplin'] = 10;
        $data['kontrolle'] = 10;
        $data['uebung'] = 10;
        $data['startpunkte'] = 300;
        return $this->getDbTable('CharakterWerte')->insert($data);
    }
    
    /**
     * @param int $userId
     * @return boolean|\Application_Model_Charakter
     */
    public function getCharakterByUserId($userId){
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(array('C' => 'charakter'), array('C.*'));
        $select->where('C.userId = ?', $userId);
        $select->joinLeft(array('K' => 'klassen'), 'C.klassenId = K.klassenId', array('K.klassengruppenId'));
        $result = $this->getDbTable('Charakter')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Charakter();
                $model->setVorname($row->vorname);
                $model->setNachname($row->nachname);
                $model->setCharakterid($row->charakterId);
                $model->setAugenfarbe($row->augenfarbe);
                $model->setGeburtsdatum($row->geburtsdatum);
                $model->setGeschlecht($row->geschlecht);
                $model->setMagiccircuit($row->circuit);
                $model->addElement($row->naturelement);
                $model->setNickname($row->nickname);
                $model->setSize($row->size);
                $model->setWohnort($row->wohnort);
                $model->setKlasse($row->klassenId);
                $model->setKlassengruppe($row->klassengruppenId);
            }
            return $model;
        }else{
            return false;
        }
    }
    
    /**
     * @param int $charakterId
     */
    public function createCharakterProfile($charakterId) {
        $data['charakterId'] = $charakterId;
        $data['kennenlernCode'] = Application_Service_Utility::generateShortHash();
        $data['privatCode'] = Application_Service_Utility::generateShortHash();
        return $this->getDbTable('CharakterProfil')->insert($data);
    }
    
    /**
     * @param int $charakterId
     * @return \Application_Model_Charakterprofil
     */
    public function getCharakterProfil($charakterId) {
        $model = new Application_Model_Charakterprofil();
        $select = $this->getDbTable('CharakterProfil')->select();
        $select->from('charakterProfil');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterProfil')->fetchAll($select);
        if($result->count() > 0){
            $row = $result->current();
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

    /**
     * @param int $profilId
     * @param int $charakterId
     * @return array
     */
    public function getDatenfreigabe($profilId, $charakterId) {
        $freigabe = array('public' => 0, 'privat' => 0);
        $select = $this->getDbTable('Beziehungen')->select();
        $select->from('beziehungen');
        $select->where('profilId = ?', $profilId);
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Beziehungen')->fetchRow($select);
        if($result !== null){
            $freigabe['public'] = $result->public;
            $freigabe['privat'] = $result->privat;
        }
        return $freigabe;
    }
    
    /**
     * @param int $charakterId
     * @return \Application_Model_Charakterwerte
     */
    public function getCharakterwerte($charakterId) {
        $select = $this->getDbTable('CharakterWerte')->select();
        $select->from('charakterWerte');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('CharakterWerte')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Charakterwerte();
                $model->setStaerke($row->staerke);
                $model->setAgilitaet($row->agilitaet);
                $model->setAusdauer($row->ausdauer);
                $model->setDisziplin($row->disziplin);
                $model->setKontrolle($row->kontrolle);
                $model->setUebung($row->uebung);
                $model->setFp($row->fp);
                $model->setStartpunkte($row->startpunkte);
            }
            return $model;
        }
        return null;
    }
    
    /**
     * @param int $charakterId
     * @return boolean
     */
    public function getCurrentTraining($charakterId){
        $select = $this->getDbTable('Training')->select();
        $select->setIntegrityCheck(FALSE);
        $select->from('training');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Training')->fetchAll($select);
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
    
    /**
     * @param int $charakterId
     * @return \Application_Model_Vorteil
     */
    public function getVorteileByCharakterId($charakterId){
        $returnArray = array();
        $select = $this->getDbTable('Vorteil')->select();
        $select->setIntegrityCheck(false);
        $select->from(array('CV' => 'charakterVorteile'), array('V.vorteilId', 'V.name', 'V.beschreibung'));
        $select->where('CV.charakterId = ?', $charakterId);
        $select->join(array('V' => 'vorteile'), 'CV.vorteilId = V.vorteilId');
        $result = $this->getDbTable('Vorteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $vorteilModel = new Application_Model_Vorteil();
                $vorteilModel->setId($row->vorteilId);
                $vorteilModel->setBezeichnung($row->name);
                $vorteilModel->setBeschreibung($row->beschreibung);
                
                $returnArray[] = $vorteilModel;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $charakterId
     * @return \Application_Model_Nachteil
     */
    public function getNachteileByCharakterId($charakterId){
        $returnArray = array();
        $select = $this->getDbTable('Nachteil')->select();
        $select->setIntegrityCheck(false);
        $select->from(array('CN' => 'charakterNachteile'), array('N.nachteilId', 'N.name', 'N.beschreibung'));
        $select->where('CN.charakterId = ?', $charakterId);
        $select->join(array('N' => 'nachteile'), 'CN.nachteilId = N.nachteilId');
        $result = $this->getDbTable('Nachteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $nachteilModel = new Application_Model_Nachteil();
                $nachteilModel->setId($row->nachteilId);
                $nachteilModel->setBezeichnung($row->name);
                $nachteilModel->setBeschreibung($row->beschreibung);
                
                $returnArray[] = $nachteilModel;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $charakterId
     */
    public function getFriendlist($charakterId) {
        $returnArray = array();
        $select = $this->getDbTable('Beziehungen')->select();
        $select->setIntegrityCheck(false);
        $select->from('beziehungen');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Beziehungen')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $returnArray[] = $this->getCharakter($row->profilId);
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $charakterId
     * @return \Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakter($charakterId) {
        $model = new Application_Model_Charakter();
        $select = $this->getDbTable('Charakter')->select();
        $select->where('charakterId = ?', $charakterId);
        $row = $this->getDbTable('Charakter')->fetchRow($select);
        if($row !== null){
            $model->setVorname($row->vorname);
            $model->setNachname($row->nachname);
            $model->setCharakterid($row->charakterId);
            $model->setSize($row->size);
            $model->setAugenfarbe($row->augenfarbe);
            $model->setGeburtsdatum($row->geburtsdatum);
            $model->setGeschlecht($row->geschlecht);
            $model->setNickname($row->nickname);
            $model->setWohnort($row->wohnort);
        }
        return $model;
    }
    
    /**
     * @param int $charakterId
     * @param int $charakterIdToCheck
     * @return boolean
     */
    public function checkAssociation($charakterId, $charakterIdToCheck) {
        $select = $this->getDbTable('Beziehungen')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('profilId = ?', $charakterIdToCheck);
        $row = $this->getDbTable('Beziehungen')->fetchRow($select);
        if($row !== null){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * @param array $profile
     * @param int $charakterId
     * @return int
     */
    public function setAssociation(array $profile, $charakterId) {
        $data = [
            'charakterId' => $charakterId,
            'profilId' => $profile['charakterId']
        ];
        if($profile['type'] === 'public'){
            $data['public'] = 1;
        }
        if($profile['type'] === 'private'){
            $data['private'] = 1;
        }
        $select = $this->getDbTable('Beziehungen')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('profilId = ?', $profile['charakterId']);
        $result = $this->getDbTable('Beziehungen')->fetchRow();
        if($result !== null){
            $return = $this->updateAssociation($data, $result['zuordnungId']);
        } else {
            $return = $this->createAssociation($data);
        }
        return $return;
    }
    
    /**
     * @param array $data
     * @param int $associateId
     * @return int
     */
    private function updateAssociation(array $data, $associateId) {
        return $this->getDbTable('Beziehungen')->update($data, array('zuordnungId =?' => $associateId));
    }
    
    /**
     * @param array $data
     * @return int
     */
    private function createAssociation(array $data) {
        return $this->getDbTable('Beziehungen')->insert($data);
    }
    
    /**
     * @param string $profileCode
     * @param int $charakterId
     * @return array|boolean
     */
    public function verifyProfilecode($profileCode, $charakterId) {
        $selectPublic = $this->getDbTable('CharakterProfil')->select();
        $selectPublic->setIntegrityCheck(false);
        $selectPublic->from(array('cp' => 'charakterProfil'), array(new Zend_Db_Expr('"public" AS type'), 'charakterId'));
        $selectPublic->where('kennenlernCode = ?', $profileCode);
        $selectPublic->where('charakterId != ?', $charakterId);
        
        $selectPrivate = $this->getDbTable('CharakterProfil')->select();
        $selectPrivate->setIntegrityCheck(false);
        $selectPrivate->from(array('cp' => 'charakterProfil'), array(new Zend_Db_Expr('"private" AS type'), 'charakterId'));
        $selectPrivate->where('privatCode = ?', $profileCode);
        $selectPrivate->where('charakterId != ?', $charakterId);
        
        $select = $this->getDbTable('CharakterProfil')->select();
        $select->union(array($selectPrivate, $selectPublic));
        $result = $this->getDbTable('CharakterProfil')->fetchRow($select);
        if($result !== null){
            $return['charakterId'] = $result['charakterId'];
            $return['type'] = $result['type'];
            return $return;
        }
        return false;
    }
    
    /**
     * @param int $charakterId
     * @return int
     */
    public function setNewProfileCode($charakterId) {
        $data = [
            'kennenlernCode' => Application_Service_Utility::generateShortHash(),
            'privatCode' => Application_Service_Utility::generateShortHash(),
        ];
        return $this->getDbTable('CharakterProfil')->update($data, array('charakterId = ?' => $charakterId));
    }
    
}
