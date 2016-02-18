<?php

class Application_Model_Mapper_WetterMapper {
    
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
    
    public function getWetterByDate(DateTime $date) {
        $wetter = new Administration_Model_Tageswetter();
        $select = parent::getDbTable('Wetter')->select();
        $select->where('date = ?', $date->format('Y-m-D'));
        $row = parent::getDbTable('Wetter')->fetchRow($select);
        if($row !== null){
            
        }
        return $wetter;
    }
    
    public function getForecast() {
        $returnArray = array();
        $date = new DateTime();
        $intervalIncrease = new DateInterval('P9D');
        $intervalDecrease = new DateInterval('P2D');
        $date->sub($intervalDecrease);
        $dateStart = $date->format('Y-m-d');
        $date->add($intervalIncrease);
        $dateEnd = $date->format('Y-m-d');
        
        $select = $this->getDbTable('Wetterbericht')->select();
        $select->setIntegrityCheck(false);
        $select->from('wetterbericht');
        $select->where('wetterbericht.datum >= ?', $dateStart);
        $select->where('wetterbericht.datum < ?', $dateEnd);
        $result = $this->getDbTable('Wetterbericht')->fetchAll($select);
        foreach ($result as $day) {
            $tageswetter = new Administration_Model_Tageswetter();
            $tageswetter->setTag($day['datum']);
            
            $wetterVormittag = new Administration_Model_Wetter();
            $wetterVormittag->setName($day['vormittag']);
            $tageswetter->setWetterVormittag($wetterVormittag);
            
            $wetterMittag = new Administration_Model_Wetter();
            $wetterMittag->setName($day['mittag']);
            $tageswetter->setWetterMittag($wetterMittag);
            
            $wetterNachmittag = new Administration_Model_Wetter();
            $wetterNachmittag->setName($day['nachmittag']);
            $tageswetter->setWetterNachmittag($wetterNachmittag);
            
            $wetterAbend = new Administration_Model_Wetter();
            $wetterAbend->setName($day['abend']);
            $tageswetter->setWetterAbend($wetterAbend);
            
            $wetterNacht = new Administration_Model_Wetter();
            $wetterNacht->setName($day['nacht']);
            $tageswetter->setWetterNacht($wetterNacht);
            
            $returnArray[] = $tageswetter;
        }
        return $returnArray;
    }
    
}
