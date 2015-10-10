<?php

class Application_Model_Mapper_ProfilMapper{
    
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
    
    /**
     * @param int $charakterId
     * @param string $picUrl
     */
    public function saveCharakterpic($charakterId, $picUrl) {
        $data = ['charpic' => $picUrl];
        $this->getDbTable('CharakterProfil')->update($data, array('charakterId' => $charakterId));
    }
    
    /**
     * @param int $charakterId
     * @param string $picUrl
     */
    public function saveProfilpic($charakterId, $picUrl) {
        $data = ['profilpic' => $picUrl];
        $this->getDbTable('CharakterProfil')->update($data, array('charakterId' => $charakterId));
    }
    
    
    public function saveStory($charakterId, $story) {
        $data = ['charaktergeschichte' => $story];
        $this->getDbTable('CharakterProfil')->update($data, array('charakterId' => $charakterId));
    }
    
    
    public function savePrivate($charakterId, $private) {
        $data = ['privatDaten' => $private];
        $this->getDbTable('CharakterProfil')->update($data, array('charakterId' => $charakterId));
    }
    
}
