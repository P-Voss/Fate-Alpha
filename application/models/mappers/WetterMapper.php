<?php

class Application_Model_Mapper_WetterMapper {
    
    /**
     * @param string $tablename
     * @return Zend_Db_Table_Abstract
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
     * @param DateTime $date
     *
     * @return Administration_Model_Tageswetter
     * @throws Exception
     */
    public function getWetterByDate(DateTime $date) {
        try {
            $select = $this->getDbTable('Wetterbericht')
                ->select()
                ->setIntegrityCheck(false)
                ->where('datum = ?', $date->format('Y-m-d'));
            $result = $this->getDbTable('Wetterbericht')->fetchRow($select);
        } catch (Throwable $throwable) {
            Zend_Debug::dump($throwable);
            exit;
        }
        if($result !== null){
            $row = $result->toArray();
            $tageswetter = new Administration_Model_Tageswetter();
            $tageswetter->setTag($row['datum']);

            $wetterVormittag = new Administration_Model_Wetter();
            $wetterVormittag->setName($row['vormittag']);
            $tageswetter->setWetterVormittag($wetterVormittag);

            $wetterMittag = new Administration_Model_Wetter();
            $wetterMittag->setName($row['mittag']);
            $tageswetter->setWetterMittag($wetterMittag);

            $wetterNachmittag = new Administration_Model_Wetter();
            $wetterNachmittag->setName($row['nachmittag']);
            $tageswetter->setWetterNachmittag($wetterNachmittag);

            $wetterAbend = new Administration_Model_Wetter();
            $wetterAbend->setName($row['abend']);
            $tageswetter->setWetterAbend($wetterAbend);

            $wetterNacht = new Administration_Model_Wetter();
            $wetterNacht->setName($row['nacht']);
            $tageswetter->setWetterNacht($wetterNacht);
            return $tageswetter;
        }
        throw new Exception('Eintrag nicht gefunden');
    }

    /**
     * @return array
     * @throws Exception
     */
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
