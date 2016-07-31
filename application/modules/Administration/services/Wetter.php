<?php

/**
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Wetter {
    
    /**
     * @var Administration_Model_Mapper_WetterMapper
     */
    private $mapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_WetterMapper();
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return array
     */
    public function getOverview(Zend_Controller_Request_Http $request = null) {
        $date = new DateTime();
        $year = $date->format('Y');
        if(!is_null($request) AND !is_null($request->getParam('year'))){
            $yearRequested = $request->getParam('year');
        }
        return $this->mapper->getWetterByYear((isset($yearRequested) AND $yearRequested >= $year) ? $yearRequested : $year);
    }
    
    
    public function getWeatherForDay(Zend_Controller_Request_Http $request) {
        try {
            $date = new DateTime($request->getParam('year') . '-' . $request->getParam('month') . '-' . $request->getParam('day'));
        } catch (Exception $exc) {
            return $exc;
        }
        return $this->mapper->getWetterByDate($date);
    }
    
    
    public function editWeather(Zend_Controller_Request_Http $request) {
        try {
            $date = new DateTime($request->getPost('date'));
        } catch (Exception $exc) {
            return $exc;
        }
        return $this->mapper->updateWeather($request->getPost());
    }
    
    public function generateRandomWeather(Zend_Controller_Request_Http $request) {
        $this->setSpringWeather($request->getParam('spring'), $request->getParam('year'));
        $this->setSummerWeather($request->getParam('summer'), $request->getParam('year'));
        $this->setFallWeather($request->getParam('fall'), $request->getParam('year'));
        $this->setWinterWeather($request->getParam('winter'), $request->getParam('year'));
    }
    
    
    private function setSpringWeather($propabilities, $year){
        $date = new DateTime($year . '-03-20');
        $interval = new DateInterval('P1D');
        $dateEnd = new DateTime($year . '-06-20');
        
        $propabilitiesMerged = array();
        foreach ($propabilities as $key => $value) {
            $propabilitiesMerged = array_merge($propabilitiesMerged, array_fill(count($propabilitiesMerged), $value, $key));
        }
        while($date <= $dateEnd){
            $wetter[$date->format('Y-m-d')]['vormittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['mittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nachmittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['abend'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nacht'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $date->add($interval);
        }
        $mapper = new Administration_Model_Mapper_WetterMapper();
        $mapper->generateWeather($wetter);
    }
    
    
    private function setSummerWeather($propabilities, $year){
        $date = new DateTime($year . '-06-21');
        $interval = new DateInterval('P1D');
        $dateEnd = new DateTime($year . '-09-20');
        
        $propabilitiesMerged = array();
        foreach ($propabilities as $key => $value) {
            $propabilitiesMerged = array_merge($propabilitiesMerged, array_fill(count($propabilitiesMerged), $value, $key));
        }
        while($date <= $dateEnd){
            $wetter[$date->format('Y-m-d')]['vormittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['mittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nachmittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['abend'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nacht'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $date->add($interval);
        }
        $mapper = new Administration_Model_Mapper_WetterMapper();
        $mapper->generateWeather($wetter);
    }
    
    private function setFallweather($propabilities, $year){
        $date = new DateTime($year . '-09-22');
        $interval = new DateInterval('P1D');
        $dateEnd = new DateTime($year . '-12-20');
        
        $propabilitiesMerged = array();
        foreach ($propabilities as $key => $value) {
            $propabilitiesMerged = array_merge($propabilitiesMerged, array_fill(count($propabilitiesMerged), $value, $key));
        }
        while($date <= $dateEnd){
            $wetter[$date->format('Y-m-d')]['vormittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['mittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nachmittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['abend'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nacht'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $date->add($interval);
        }
        $mapper = new Administration_Model_Mapper_WetterMapper();
        $mapper->generateWeather($wetter);
    }
    
    private function setWinterWeather($propabilities, $year){
        $date = new DateTime($year . '-12-21');
        $interval = new DateInterval('P1D');
        $dateEnd = new DateTime($year . '-12-31');
        
        $propabilitiesMerged = array();
        foreach ($propabilities as $key => $value) {
            $propabilitiesMerged = array_merge($propabilitiesMerged, array_fill(count($propabilitiesMerged), $value, $key));
        }
        while($date <= $dateEnd){
            $wetter[$date->format('Y-m-d')]['vormittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['mittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nachmittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['abend'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nacht'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $date->add($interval);
        }
        $date = new DateTime($year . '-01-01');
        $interval = new DateInterval('P1D');
        $dateEnd = new DateTime($year . '-03-20');
        
        $propabilitiesMerged = array();
        foreach ($propabilities as $key => $value) {
            $propabilitiesMerged = array_merge($propabilitiesMerged, array_fill(count($propabilitiesMerged), $value, $key));
        }
        while($date <= $dateEnd){
            $wetter[$date->format('Y-m-d')]['vormittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['mittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nachmittag'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['abend'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $wetter[$date->format('Y-m-d')]['nacht'] = $propabilitiesMerged[mt_rand(1, 100) - 1];
            $date->add($interval);
        }
        $mapper = new Administration_Model_Mapper_WetterMapper();
        $mapper->generateWeather($wetter);
    }
    
}
