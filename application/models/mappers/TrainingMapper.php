<?php

class Application_Model_Mapper_TrainingMapper{
    
    private $changesContainer = array();

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
    
    
    public function getDefaultTraining() {
        $select = $this->getDbTable('Training')->select();
        $select->setIntegrityCheck(false);
        $select->from('trainingswerte');
        $result = $this->getDbTable('Training')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Trainingswerte();
                $model->setStrTraining($row->staerke);
                $model->setAgiTraining($row->agilitaet);
                $model->setAusTraining($row->ausdauer);
                $model->setPraTraining($row->uebung);
                $model->setDisTraining($row->disziplin);
                $model->setKonTraining($row->kontrolle);
            }
            return $model;
        }else{
            return false;
        }
    }
    
    
    public function getRealTraining(Application_Model_Trainingswerte $defaultTraining, Application_Model_Charakter $charakter) {
        $this->changesContainer = array();
        $trainingswerte = new Application_Model_Trainingswerte();
        $trainingswerte->setAgiTraining($defaultTraining->getAgiTraining());
        $trainingswerte->setStrTraining($defaultTraining->getStrTraining());
        $trainingswerte->setAusTraining($defaultTraining->getAusTraining());
        $trainingswerte->setDisTraining($defaultTraining->getDisTraining());
        $trainingswerte->setPraTraining($defaultTraining->getPraTraining());
        $trainingswerte->setKonTraining($defaultTraining->getKonTraining());
        foreach ($charakter->getVorteile() as $vorteil){
            $changes = $this->_checkVorteil($vorteil->getId());
            if(count($changes) > 0){
                $this->changesContainer[] = $changes;
            }
        }
        foreach ($charakter->getNachteile() as $nachteil){
            $changes = $this->_checkNachteil($nachteil->getId());
            if(count($changes) > 0){
                $this->changesContainer[] = $changes;
            }
        }
        if($charakter->getKlasse() !== null){
            if($this->_checkKlasse($charakter->getKlasse()->getId())){
                $changes = $this->_checkKlasse($charakter->getKlasse()->getId());
                if(count($changes) > 0){
                    $this->changesContainer[] = $changes;
                }
            }
        }
        if($charakter->getKlassengruppe()->getId() !== null){
            if($this->_checkKlassengruppe($charakter->getKlassengruppe()->getId())){
                $changes = $this->_checkKlassengruppe($charakter->getKlassengruppe()->getId());
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
//        if($charakter->getKlassengruppe()->getId() == 2){
//            $trainingswerte->setDisTraining(null);
//            $trainingswerte->setKonTraining(null);
//        }
        return $trainingswerte;
    }
    
    
    public function checkTraining($charakterId) {
        $select = $this->getDbTable('Training')->select();
        $select->setIntegrityCheck(false);
        $select->from('training');
        $select->where('charakterId = ?', $charakterId);
        $result = $this->getDbTable('Training')->fetchAll($select);
        if($result->count() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    
    public function setTraining($charakterId, $training, $dauer) {
        $data['charakterId'] = $charakterId;
        $data['wert'] = $training;
        $data['dauer'] = $dauer;
        return $this->getDbTable('Training')->insert($data);
    }
    
    
    public function updateTraining($charakterId, $training, $dauer) {
        $data['wert'] = $training;
        $data['dauer'] = $dauer;
        return $this->getDbTable('Training')->update($data, array('charakterId = ?' => $charakterId));
    }
    
    
    protected function _checkVorteil($vorteilId) {
        $select = $this->getDbTable('TrainingVorteil')->select();
        $select->setIntegrityCheck(false);
        $select->from('vorteilToTraining');
        $select->where('vorteilId = ?', $vorteilId);
        $result = $this->getDbTable('TrainingVorteil')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $value['Effekt'] = $row->effekt;
                $value['Art'] = $row->effektArt;
                $return[$row->wert] = $value;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    
    protected function _checkNachteil($nachteilId) {
        $select = $this->getDbTable('TrainingNachteil')->select();
        $select->setIntegrityCheck(false);
        $select->from('nachteilToTraining');
        $select->where('nachteilId = ?', $nachteilId);
        $result = $this->getDbTable('TrainingNachteil')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $value['Effekt'] = $row->effekt;
                $value['Art'] = $row->effektArt;
                $return[$row->wert] = $value;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    
    protected function _checkKlasse($klassenId) {
        $select = $this->getDbTable('TrainingKlasse')->select();
        $select->setIntegrityCheck(false);
        $select->from('klasseToTraining');
        $select->where('klassenId = ?', $klassenId);
        $result = $this->getDbTable('TrainingKlasse')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $value['Effekt'] = $row->effekt;
                $value['Art'] = $row->effektArt;
                $return[$row->wert] = $value;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    /**
     * @param int $gruppenId
     * @return array|null
     */
    protected function _checkKlassengruppe($gruppenId) {
        $select = $this->getDbTable('TrainingKlassengruppe')->select();
        $select->setIntegrityCheck(false);
        $select->from('klassengruppeToTraining');
        $select->where('klassengruppenId = ?', $gruppenId);
        $result = $this->getDbTable('TrainingKlassengruppe')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $value['Effekt'] = $row->effekt;
                $value['Art'] = $row->effektArt;
                $return[$row->wert] = $value;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    /**
     * @param Application_Model_Trainingswerte $trainingswerte
     * @return Application_Model_Trainingswerte
     */
    protected function _transformValues($trainingswerte) {
        foreach ($this->changesContainer as $changesCategories){
            foreach ($changesCategories as $key => $values){
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
    
    /**
     * @return array
     */
    public function getCharakterIdsToTrain() {
        $returnArray = array();
        $select = $this->getDbTable('Training')->select();
        $select->setIntegrityCheck(false);
        $select->from('training');
        $select->joinInner('charakter', 'charakter.charakterId = training.charakterId', array());
        $result = $this->getDbTable('Training')->fetchAll($select);
        foreach ($result as $row) {
            $returnArray[] = $row['charakterId'];
        }
        return $returnArray;
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Application_Model_Trainingswerte $trainingswerte
     */
    public function updateStats(Application_Model_Charakter $charakter, Application_Model_Trainingswerte $trainingswerte) {
        $training = $this->getCurrentTraining($charakter->getCharakterid());
        $charakter->getCharakterwerte()->addTraining($training, $trainingswerte, $charakter->getKlassengruppe()->getId());
        $this->getDbTable('CharakterWerte')->update($charakter->getCharakterwerte()->toArray(), array('charakterId = ?' => $charakter->getCharakterid()));
        $this->updateTraining($charakter->getCharakterid(), $training['training'], $training['dauer']-1);
    }
    
    
    public function addFp() {
        $this->getDbTable('Training')->getDefaultAdapter()->query('UPDATE charakterWerte SET fp = fp +2');
    }
    
    /**
     * @todo existiert schon im Charaktermapper
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
     * @param Application_Model_Charakterwerte $werte
     */
    public function addBonusTraining($charakterId, Application_Model_Charakterwerte $werte) {
        $this->getDbTable('CharakterWerte')->update($werte->toArray(), array('charakterId = ?' => $charakterId));
    }
    
}
