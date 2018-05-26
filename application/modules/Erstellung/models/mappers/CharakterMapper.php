<?php

class Erstellung_Model_Mapper_CharakterMapper extends Application_Model_Mapper_CharakterMapper {

    /**
     * @param Erstellung_Model_Charakter $charakter
     *
     * @return int
     * @throws Exception
     */
    public function createCharakter(Erstellung_Model_Charakter $charakter) {
        $date = new DateTime();
        $data = array();
        $data['userId'] = $charakter->getUserid();
        $data['vorname'] = $charakter->getVorname();
        $data['nachname'] = $charakter->getNachname();
        $data['geburtsdatum'] = $charakter->getGeburtsdatum();
        $data['augenfarbe'] = $charakter->getAugenfarbe();
        $data['size'] = $charakter->getSize();
        $data['geschlecht'] = $charakter->getGeschlecht();
        $data['sexualitaet'] = $charakter->getSexualitaet();
        $data['wohnort'] = $charakter->getWohnort();
        $data['createDate'] = $date->format('Y-m-d H:i:s');
        return parent::getDbTable('Charakter')->insert($data);
    }
    
    
    public function getInactiveCharakterByUserId($userId) {
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from(array('C' => 'charakter'), array('C.*'));
        $select->where('C.userId = ?', $userId);
        $select->where('C.active = 0');
        $select->joinLeft(array('K' => 'klassen'), 'C.klassenId = K.klassenId', array('K.klassengruppenId'));
        $result = $this->getDbTable('Charakter')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Erstellung_Model_Charakter();
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
            }
            return $model;
        }else{
            return false;
        }
    }

    /**
     * @param Erstellung_Model_Charakter $charakter
     * @return int
     * @throws Exception
     */
    public function updateCharakter(Erstellung_Model_Charakter $charakter) {
        $data = array();
        $data['vorname'] = $charakter->getVorname();
        $data['nachname'] = $charakter->getNachname();
        $data['geburtsdatum'] = $charakter->getGeburtsdatum();
        $data['augenfarbe'] = $charakter->getAugenfarbe();
        $data['size'] = $charakter->getSize();
        $data['geschlecht'] = $charakter->getGeschlecht();
        $data['sexualitaet'] = $charakter->getSexualitaet();
        $data['wohnort'] = $charakter->getWohnort();
        return parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    public function activateCharakter(Erstellung_Model_Charakter $charakter) {
        $data['active'] = 1;
        return parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    
    public function setEigenschaften(Erstellung_Model_Charakter $charakter, $data) {
        return parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    
    public function removeEigenschaften(Erstellung_Model_Charakter $charakter) {
        $data['odo'] = '';
        $data['circuit'] = '';
        $data['naturElement'] = '';
        $data['luck'] = '';
        return parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    
    public function addVorteil(Erstellung_Model_Charakter $charakter, $vorteil) {
        $data = array(
            'charakterId' => $charakter->getCharakterid(),
            'vorteilId' => $vorteil,
        );
        return parent::getDbTable('CharakterVorteil')->insert($data);
    }
    
    
    public function removeVorteile(Erstellung_Model_Charakter $charakter) {
        parent::getDbTable('CharakterVorteil')->delete(array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    
    public function removeVorteil(Erstellung_Model_Charakter $charakter, $vorteilId) {
        parent::getDbTable('CharakterVorteil')->delete(array(
            'charakterId = ?' => $charakter->getCharakterid(),
            'vorteilId = ?' => $vorteilId,
            ));
    }
    
    
    public function addNachteil(Erstellung_Model_Charakter $charakter, $nachteil) {
        $data = array(
            'charakterId' => $charakter->getCharakterid(),
            'nachteilId' => $nachteil,
        );
        return parent::getDbTable('CharakterNachteil')->insert($data);
    }
    
    
    public function removeNachteile(Erstellung_Model_Charakter $charakter) {
        parent::getDbTable('CharakterNachteil')->delete(array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    
    public function removeNachteil(Erstellung_Model_Charakter $charakter, $nachteilId) {
        parent::getDbTable('CharakterNachteil')->delete(array(
            'charakterId = ?' => $charakter->getCharakterid(),
            'nachteilId = ?' => $nachteilId,
            ));
    }
    
    
    public function setKlasse(Erstellung_Model_Charakter $charakter, $klasse) {
        $data['klassengruppenId'] = $klasse;
        parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    
    public function setUnterklasse(Erstellung_Model_Charakter $charakter, $unterklasse) {
        $data['klassenId'] = $unterklasse;
        parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    public function getKlasse(Erstellung_Model_Charakter $charakter) {
        $select = parent::getDbTable('Charakter')->select();
        $select->where('charakterId = ?', $charakter->getCharakterid());
        $row = parent::getDbTable('Charakter')->fetchRow($select);
        return $row->klassengruppenId;
    }
    
    
    public function removeKlasse(Erstellung_Model_Charakter $charakter) {
        $data['klassengruppenId'] = null;
        $data['klassenId'] = null;
        parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    public function removeUnterklasse(Erstellung_Model_Charakter $charakter) {
        $data['klassenId'] = null;
        parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    public function familyname(Erstellung_Model_Charakter $charakter) {
        $select = parent::getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter');
        $select->join('klassen', 'charakter.klassenId = klassen.klassenId');
        $select->where('charakterId = ?', $charakter->getCharakterid());
        $result = $this->getDbTable('Charakter')->fetchRow($select);
        if($result !== null){
            if(strlen($result->familienname) > 0){
                $this->changeName($charakter, $result->familienname);
            }
        }
    }
    
    
    public function changeName(Erstellung_Model_Charakter $charakter, $familienname) {
        $data['nachname'] = $familienname;
        parent::getDbTable('Charakter')->update($data, array('charakterId = ?' => $charakter->getCharakterid()));
    }
    
    
    public function getVorteilCount(Application_Model_Charakter $charakter) {
        $select = parent::getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter');
        $select->join('charakterVorteile', 'charakter.charakterId = charakterVorteile.charakterId');
        $select->where('charakter.charakterId = ?', $charakter->getCharakterid());
        $result = parent::getDbTable('Charakter')->fetchAll($select);
        return count($result);
    }
    
    
    public function getNachteilCount(Application_Model_Charakter $charakter) {
        $select = parent::getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter');
        $select->join('charakterNachteile', 'charakter.charakterId = charakterNachteile.charakterId');
        $select->where('charakter.charakterId = ?', $charakter->getCharakterid());
        $result = parent::getDbTable('Charakter')->fetchAll($select);
        return count($result);
    }
    
}
