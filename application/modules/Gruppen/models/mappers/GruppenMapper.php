<?php

class Gruppen_Model_Mapper_GruppenMapper {
    
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
     * @return array
     */
    public function getGruppenByCharakterId($charakterId) {
        $returnArray = array();
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('spielergruppen');
        $select->joinInner('charakterGruppen', 'spielergruppen.gruppenId = charakterGruppen.gruppenId');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Spielergruppen')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $gruppe = new Gruppen_Model_Gruppe();
                $gruppe->setId($row->gruppenId);
                $gruppe->setName($row->name);
                $gruppe->setBeschreibung($row->beschreibung);
                $gruppe->setPasswort($row->passwort);
                $gruppe->setGruender($row->userId);
                $gruppe->setCreateDate($row->createDate);
                $returnArray[] = $gruppe;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $userId
     * @return array
     */
    public function getGruppenByUserId($userId) {
        $returnArray = array();
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('spielergruppen');
        $select->where('userId = ?', $userId);
        $result = $this->getDbTable('Spielergruppen')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $gruppe = new Gruppen_Model_Gruppe();
                $gruppe->setId($row->gruppenId);
                $gruppe->setName($row->name);
                $gruppe->setBeschreibung($row->beschreibung);
                $gruppe->setPasswort($row->passwort);
                $gruppe->setGruender($row->userId);
                $gruppe->setCreateDate($row->createDate);
                $returnArray[] = $gruppe;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $gruppenId
     * @return array
     */
    public function getGruppeByGruppenId($gruppenId) {
        $returnArray = array();
        $select = $this->getDbTable('Spielergruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('spielergruppen');
        $select->where('gruppenId = ?', $gruppenId);
        $row = $this->getDbTable('Spielergruppen')->fetchRow($select);
        if($row !== null){
            $gruppe = new Gruppen_Model_Gruppe();
            $gruppe->setId($row->gruppenId);
            $gruppe->setName($row->name);
            $gruppe->setBeschreibung($row->beschreibung);
            $gruppe->setPasswort($row->passwort);
            $gruppe->setGruender($row->userId);
            $gruppe->setCreateDate($row->createDate);
            return $gruppe;
        }
        return false;
    }
    
    
    public function getGruppenmitglieder($gruppenId) {
        $returnArray = array();
        $select = $this->getDbTable('CharakterGruppen')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterGruppen', array());
        $select->joinInner('charakter', 'charakter.charakterId = charakterGruppen.charakterId');
        $select->where('charakterGruppen.gruppenId = ?', $gruppenId);
        $result = $this->getDbTable('CharakterGruppen')->fetchAll($select);
        if($result->count() >  0){
            foreach ($result as $row) {
                $model = new Application_Model_Charakter();
                $model->setVorname($row->vorname);
                $model->setNachname($row->nachname);
                $model->setCharakterid($row->charakterId);
                $model->setAugenfarbe($row->augenfarbe);
                $model->setGeburtsdatum($row->geburtsdatum);
                $model->setGeschlecht($row->geschlecht);
                $model->setSexualitaet($row->sexualitaet);
                $model->setMagiccircuit($row->circuit);
                $model->setNickname($row->nickname);
                $model->setSize($row->size);
                $model->setWohnort($row->wohnort);
                $date = new DateTime($row->createDate);
                $model->setCreatedate($date);
                $returnArray[] = $model;
            }
        }
        return $returnArray;
    }
    
    
    public function validateAccess($gruppenId, $charakterId, $userId) {
        $selectOwner = $this->getDbTable('Spielergruppen')->select();
        $selectOwner->from('spielergruppen', array('gruppenId'));
        $selectOwner->where('userId = ?', $userId);
        $selectOwner->where('gruppenId = ?', $gruppenId);
        $selectCharakter = $this->getDbTable('CharakterGruppen')->select();
        $selectCharakter->from('charakterGruppen', array('gruppenId'));
        $selectCharakter->where('charakterId = ?', $charakterId);
        $selectCharakter->where('gruppenId = ?', $gruppenId);
        $select = $this->getDbTable('CharakterGruppen')->select();
        $select->union(array($selectOwner, $selectCharakter));
        $result = $this->getDbTable('Spielergruppen')->fetchAll($select);
        return $result->count() > 0;
    }
    
    /**
     * @param Gruppen_Model_Gruppe $gruppe
     * @return int
     */
    public function createGruppe(Gruppen_Model_Gruppe $gruppe) {
        $data = array(
            'name' => $gruppe->getName(),
            'beschreibung' => $gruppe->getBeschreibung(),
            'passwort' => $gruppe->getPasswort(),
            'createDate' => $gruppe->getCreateDate(),
            'userId' => $gruppe->getGruender(),
        );
        return $this->getDbTable('Spielergruppen')->insert($data);
    }
    
    
    public function setFreigabe($charakterId, $gruppenId, $exposure) {
        $data = array(
            'freigabe' => ($exposure == 0)
        );
        $this->getDbTable('CharakterGruppen')->update($data, array(
            'charakterId = ?' => $charakterId,
            'gruppenId = ?' => $gruppenId,
        ));
    }
    
}
