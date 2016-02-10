<?php

class Administration_Model_Mapper_WetterMapper extends Application_Model_Mapper_WetterMapper {
    
    public function initWetter() {
        $db = parent::getDbTable('Wetterbericht')->getAdapter();
        $date = new DateTime();
        Zend_Debug::dump($date);
        exit;
        $date->setDate(2016, 1, 1);
        $interval = new DateInterval('P1D');
        $stmt = $db->prepare('INSERT INTO wetterbericht (datum, wetterVormittag, wetterMittag, wetterNachmittag, wetterAbend, wetterNacht) VALUES(?, 1, 1, 1, 1, 1)');
        $stmt->execute(array($date->format('Y-m-d')));
        for($i = 0; $i < 10000; $i++){
            $date->add($interval);
            $stmt->execute(array($date->format('Y-m-d')));
        }
    }
    
    public function getWetterByYear($date) {
        $returnArray = array();
        $select = $this->getDbTable('Wetterbericht')->select();
        $select->setIntegrityCheck(false);
        $select->from('wetterbericht');
        $select->where('DATE_FORMAT(wetterbericht.datum, "%Y") = ?', $date);
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
    
    public function getWetterByDate(DateTime $date) {
        $wetter = new Administration_Model_Tageswetter();
        $select = parent::getDbTable('Wetterbericht')->select();
        $select->setIntegrityCheck(false);
        $select->from('wetterbericht');
        $select->where('datum = ?', $date->format('Y-m-d'));
        $row = parent::getDbTable('Wetterbericht')->fetchRow($select);
        if($row !== null){
            $wetter->setTag($date->format('Y-m-d'));
            
            $wetterVormittag = new Administration_Model_Wetter();
            $wetterVormittag->setName($row['vormittag']);
            $wetter->setWetterVormittag($wetterVormittag);
            
            $wetterMittag = new Administration_Model_Wetter();
            $wetterMittag->setName($row['mittag']);
            $wetter->setWetterMittag($wetterMittag);
            
            $wetterNachmittag = new Administration_Model_Wetter();
            $wetterNachmittag->setName($row['nachmittag']);
            $wetter->setWetterNachmittag($wetterNachmittag);
            
            $wetterAbend = new Administration_Model_Wetter();
            $wetterAbend->setName($row['abend']);
            $wetter->setWetterAbend($wetterAbend);
            
            $wetterNacht = new Administration_Model_Wetter();
            $wetterNacht->setName($row['nacht']);
            $wetter->setWetterNacht($wetterNacht);
        }else{
            return new Exception('ungültiges Wetter');
        }
        return $wetter;
    }
    
    
    public function updateWeather($wetter = array()) {
        $date = $wetter['date'];
        unset($wetter['date']);
        return parent::getDbTable('Wetterbericht')->update($wetter, array('datum = ?' => $date));
    }
    
    public function deleteNews($newsId) {
        return parent::getDbTable('News')->delete(array('newsId = ?' => $newsId));
    }
    
}
