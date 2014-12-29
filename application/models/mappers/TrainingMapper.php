<?php

class Application_Model_Mapper_TrainingMapper{
    
    protected $dbTableTraining;
    protected $dbTableVorteil;
    protected $dbTableNachteil;
    protected $changesContainer;
    protected $dbTableTrainingVorteil;
    protected $dbTableTrainingNachteil;
    protected $dbTableTrainingKlasse;
    protected $dbTableTrainingKlassengruppe;
    protected $dbTableTrainingSkill;

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

    public function getDbTableTrainingSkill() {
        if (null === $this->dbTableTrainingSkill) {
            $this->setDbTableTrainingSkill('Application_Model_DbTable_TrainingSkill');
        }
        return $this->dbTableTrainingSkill;
    }

    public function setDbTableTrainingSkill($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableTrainingSkill = $dbTable;
        return $this;
    }

    public function getDbTableTrainingKlassengruppe() {
        if (null === $this->dbTableTrainingKlassengruppe) {
            $this->setDbTableTrainingKlassengruppe('Application_Model_DbTable_TrainingKlassengruppe');
        }
        return $this->dbTableTrainingKlassengruppe;
    }

    public function setDbTableTrainingKlassengruppe($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableTrainingKlassengruppe = $dbTable;
        return $this;
    }

    public function getDbTableTrainingKlasse() {
        if (null === $this->dbTableTrainingKlasse) {
            $this->setDbTableTrainingKlasse('Application_Model_DbTable_TrainingKlasse');
        }
        return $this->dbTableTrainingKlasse;
    }

    public function setDbTableTrainingKlasse($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableTrainingKlasse = $dbTable;
        return $this;
    }

    public function getDbTableTrainingNachteil() {
        if (null === $this->dbTableTrainingNachteil) {
            $this->setDbTableTrainingNachteil('Application_Model_DbTable_TrainingNachteil');
        }
        return $this->dbTableTrainingNachteil;
    }

    public function setDbTableTrainingNachteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableTrainingNachteil = $dbTable;
        return $this;
    }

    public function getDbTableTrainingVorteil() {
        if (null === $this->dbTableTrainingVorteil) {
            $this->setDbTableTrainingVorteil('Application_Model_DbTable_TrainingVorteil');
        }
        return $this->dbTableTrainingVorteil;
    }

    public function setDbTableTrainingVorteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableTrainingVorteil = $dbTable;
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
    
    public function getDefaultTraining() {
        $select = $this->getDbTableTraining()->select();
        $select->setIntegrityCheck(false);
        $select->from('Trainingswerte');
        $result = $this->getDbTableTraining()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Trainingswerte();
                $model->setStrTraining($row->Staerke);
                $model->setAgiTraining($row->Agilitaet);
                $model->setAusTraining($row->Ausdauer);
                $model->setPraTraining($row->Uebung);
                $model->setDisTraining($row->Disziplin);
                $model->setKonTraining($row->Kontrolle);
            }
            return $model;
        }else{
            return false;
        }
    }
    
    public function getRealTraining(Application_Model_Trainingswerte $trainingswerte, Application_Model_Charakter $charakter) {
        if($charakter->getVorteile() !== null){
            foreach ($charakter->getVorteile() as $vorteil){
                $changes = $this->_checkVorteil($vorteil->getId());
                if(count($changes) > 0){
                    $this->changesContainer[] = $changes;
                }
            }
        }
        if($charakter->getNachteile() !== null){
            foreach ($charakter->getNachteile() as $nachteil){
                $changes = $this->_checkNachteil($nachteil->getId());
                if(count($changes) > 0){
                    $this->changesContainer[] = $changes;
                }
            }
        }
        if($charakter->getKlasse() !== null){
            if($this->_checkKlasse($charakter->getKlasse())){
                $changes = $this->_checkKlasse($charakter->getKlasse());
                if(count($changes) > 0){
                    $this->changesContainer[] = $changes;
                }
            }
        }
        if($charakter->getKlassengruppe() !== null){
            if($this->_checkKlassengruppe($charakter->getKlassengruppe())){
                $changes = $this->_checkKlassengruppe($charakter->getKlassengruppe());
                if(count($changes) > 0){
                    $this->changesContainer[] = $changes;
                }
            }
        }
        if(count($this->changesContainer) > 0){
            $trainingswerte = $this->_transformValues($trainingswerte);
        }
        return $trainingswerte;
    }
    
    public function setOtherValuesNull(Application_Model_Trainingswerte $trainingswerte, Application_Model_Charakter $charakter) {
        if($charakter->getKlassengruppe() == 2){
            $trainingswerte->setDisTraining(null);
            $trainingswerte->setKonTraining(null);
        }
        return $trainingswerte;
    }
    
    public function checkTraining($charakterId) {
        $select = $this->getDbTableTraining()->select();
        $select->setIntegrityCheck(false);
        $select->from('Training');
        $select->where('charakterID = ?', $charakterId);
        $result = $this->getDbTableTraining()->fetchAll($select);
        if($result->count() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function setTraining($charakterId, $training, $dauer) {
        $data['charakterID'] = $charakterId;
        $data['wert'] = $training;
        $data['dauer'] = $dauer;
        return $this->getDbTableTraining()->insert($data);
    }
    
    public function updateTraining($charakterId, $training, $dauer) {
        $data['wert'] = $training;
        $data['dauer'] = $dauer;
        return $this->getDbTableTraining()->update($data, array('charakterID = ?' => $charakterId));
    }
    
    protected function _checkVorteil($vorteilId) {
        $select = $this->getDbTableTrainingVorteil()->select();
        $select->setIntegrityCheck(false);
        $select->from('VorteilToTraining');
        $select->where('vorteilID = ?', $vorteilId);
        $result = $this->getDbTableTrainingVorteil()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $value[$row->Wert]['Effekt'] = $row->Effekt;
                $value[$row->Wert]['Art'] = $row->EffektArt;
                $return[] = $value;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    protected function _checkNachteil($nachteilId) {
        $select = $this->getDbTableTrainingNachteil()->select();
        $select->setIntegrityCheck(false);
        $select->from('NachteilToTraining');
        $select->where('nachteilID = ?', $nachteilId);
        $result = $this->getDbTableTrainingNachteil()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $value[$row->Wert]['Effekt'] = $row->Effekt;
                $value[$row->Wert]['Art'] = $row->EffektArt;
                $return = $value;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    protected function _checkKlasse($klassenId) {
        $select = $this->getDbTableTrainingKlasse()->select();
        $select->setIntegrityCheck(false);
        $select->from('KlasseToTraining');
        $select->where('klassenID = ?', $klassenId);
        $result = $this->getDbTableTrainingKlasse()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $value[$row->Wert]['Effekt'] = $row->Effekt;
                $value[$row->Wert]['Art'] = $row->EffektArt;
                $return[] = $value;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    protected function _checkKlassengruppe($gruppenId) {
        $select = $this->getDbTableTrainingKlassengruppe()->select();
        $select->setIntegrityCheck(false);
        $select->from('KlassengruppeToTraining');
        $select->where('klassengruppenID = ?', $gruppenId);
        $result = $this->getDbTableTrainingKlassengruppe()->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $value[$row->Wert]['Effekt'] = $row->Effekt;
                $value[$row->Wert]['Art'] = $row->EffektArt;
                $return[] = $value;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    protected function _transformValues($trainingswerte) {
        foreach ($this->changesContainer as $changes){
            foreach ($changes as $key => $values){
                switch ($key) {
                    case 'Staerke':
                        if($values['Art'] === 'absolut'){
                            $trainingswerte->setStrTraining($trainingswerte->getStrTraining() + $values['Effekt']);
                        }else{
                            
                        }
                        break;
                    case 'Agilitaet':
                        if($values['Art'] === 'absolut'){
                            $trainingswerte->setAgiTraining($trainingswerte->getAgiTraining() + $values['Effekt']);
                        }else{
                            
                        }
                        break;
                    case 'Ausdauer':
                        if($values['Art'] === 'absolut'){
                            $trainingswerte->setAusTraining($trainingswerte->getAusTraining() + $values['Effekt']);
                        }else{
                            
                        }
                        break;
                    case 'Uebung':
                        if($values['Art'] === 'absolut'){
                            $trainingswerte->setPraTraining($trainingswerte->getPraTraining() + $values['Effekt']);
                        }else{
                            
                        }
                        break;
                    case 'Kontrolle':
                        if($values['Art'] === 'absolut'){
                            $trainingswerte->setKonTraining($trainingswerte->getKonTraining() + $values['Effekt']);
                        }else{
                            
                        }
                        break;
                    case 'Disziplin':
                        if($values['Art'] === 'absolut'){
                            $trainingswerte->setDisTraining($trainingswerte->getDisTraining() + $values['Effekt']);
                        }else{
                            
                        }
                        break;
                }
            }
        }
        return $trainingswerte;
    }
    
}
