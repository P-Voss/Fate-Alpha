<?php

class Shop_Model_Mapper_SchuleMapper extends Application_Model_Mapper_SchuleMapper {
    
    /**
     * @return \Shop_Model_Schule
     */
    public function getAllSchools() {
        $returnArray = array();
        $select = parent::getDbTable('Schule')->select();
        $result = parent::getDbTable('Schule')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $schule = new Shop_Model_Schule();
                $schule->setId($row->magieschuleId);
                $schule->setBeschreibung($row->beschreibung);
                $schule->setBezeichnung($row->name);
                $returnArray[] = $schule;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $charakterId
     * @param int $magieschuleId
     */
    public function checkIfLearned($charakterId, $magieschuleId) {
        $select = parent::getDbTable('CharakterSchule')->select();
        $select->where('charakterId = ?', $charakterId);
        $select->where('magieschuleId = ?', $magieschuleId);
        $result = parent::getDbTable('CharakterSchule')->fetchAll($select);
        return $result->count() > 0;
    }
    
    /**
     * @param type $magieschuleId
     * @return \Shop_Model_Requirementlist
     */
    public function getRequirements($magieschuleId) {
        $requirementList = new Shop_Model_Requirementlist();
        $select = parent::getDbTable('SchuleVoraussetzung')->select();
        $select->where('magieschuleId = ?', $magieschuleId);
        $result = parent::getDbTable('SchuleVoraussetzung')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $requirement = new Shop_Model_Requirement();
                $requirement->setArt($row->art);
                $requirement->setRequiredValue($row->voraussetzung);
                $requirementList->addRequirement($requirement);
            }
        }
        return $requirementList;
    }
    
    /**
     * @param string $art
     * @return \Shop_Model_Requirement
     */
    private function addFixedRequirements($art){
        switch ($art) {
            case 'FP':
                $requirement = new Shop_Model_Requirement();
                $requirement->setArt('FP');
                $requirement->setRequiredValue(50);
                break;
        }
        return $requirement;
    }
    
    /**
     * @param type $magieschuleId
     * @return \Shop_Model_Schule|boolean
     */
    public function getMagieschuleById($magieschuleId) {
        $select = parent::getDbTable('Schule')->select();
        $select->where('magieschuleId = ?', $magieschuleId);
        $result = parent::getDbTable('Schule')->fetchRow($select);
        if(count($result) > 0){
            $magieschule = new Shop_Model_Schule();
            $magieschule->setId($result->magieschuleId);
            $magieschule->setBeschreibung($result->beschreibung);
            $magieschule->setBezeichnung($result->name);
            return $magieschule;
        }
        return false;
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Shop_Model_Schule $magieschule
     */
    public function unlockMagieschuleForCharakter(Application_Model_Charakter $charakter, Shop_Model_Schule $magieschule) {
        $kostenfaktor = $this->getMagieschulenKostenFaktor($charakter->getCharakterid());
        $data['charakterId'] = $charakter->getCharakterid();
        $data['magieschuleId'] = $magieschule->getId();
        parent::getDbTable('CharakterSchule')->insert($data);
        if($magieschule->getId() !== 17){
            parent::getDbTable('CharakterWerte')
                    ->getAdapter()
                    ->query('UPDATE charakterWerte SET fp = fp - ? WHERE charakterId = ?', array(($kostenfaktor * 50), $charakter->getCharakterid()));
        }
    }
    
    /**
     * @param int $magieschuleId
     * @return \Shop_Model_Magie
     */
    public function getMagienByMagieschuleId($magieschuleId) {
        $returnArray = array();
        $select = parent::getDbTable('Magie')->select();
        $select->where('magieschuleId = ?', $magieschuleId);
        $result = parent::getDbTable('Magie')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $magie = new Shop_Model_Magie();
                $magie->setBeschreibung($row->beschreibung);
                $magie->setBezeichnung($row->name);
                $magie->setId($row->magieId);
                $magie->setFp($row->fp);
                $magie->setPrana($row->prana);
                $magie->setElement($row->element);
                $magie->setRang($row->rang);
                $magie->setKlasse($row->klasse);
                $magie->setGruppe($row->gruppe);
                $magie->setStufe($row->stufe);
                $magie->setLernbedingung($row->lernbedingung);
                
                $returnArray[] = $magie;
            }
        }
        return $returnArray;
    }
    
    /**
     * @param int $charakterId
     * @return \Shop_Model_Schule
     */
    public function getMagieschulenByCharakterId($charakterId) {
        $returnArray = array();
        $select = parent::getDbTable('Schule')->select();
        $select->setIntegrityCheck(false);
        $select->from('magieschulen');
        $select->joinInner('charakterMagieschulen', 'magieschulen.magieschuleId = charakterMagieschulen.magieschuleId');
        $select->where('charakterMagieschulen.charakterId = ?', $charakterId);
        $result = parent::getDbTable('Schule')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $magieschule = new Shop_Model_Schule();
                $magieschule->setId($row->magieschuleId);
                $magieschule->setBeschreibung($row->beschreibung);
                $magieschule->setBezeichnung($row->name);
                
                $returnArray[] = $magieschule;
            }
        }
        return $returnArray;
    }
    
    /**
     * 
     * @param int $charakterId
     * @return int
     */
    public function getMagieschulenKostenFaktor($charakterId) {
        $select = parent::getDbTable('Schule')->select();
        $select->setIntegrityCheck(false);
        $select->from('magieschulen');
        $select->joinInner('charakterMagieschulen', 'magieschulen.magieschuleId = charakterMagieschulen.magieschuleId');
        $select->where('charakterMagieschulen.charakterId = ? AND magieschulen.magieschuleId != 17', $charakterId);
        $result = parent::getDbTable('Schule')->fetchAll($select);
        return min([$result->count(), 3]);
    }
    
}
