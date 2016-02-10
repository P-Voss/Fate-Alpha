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
    
}
