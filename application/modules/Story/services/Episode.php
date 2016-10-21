<?php

/**
 * Description of Plot
 *
 * @author Voß
 */
class Story_Service_Episode {
    
    protected $plotMapper;
    
    
    public function __construct() {
        $this->plotMapper = new Story_Model_Mapper_PlotMapper();
    }
    
    
    public function createEpisode(Zend_Controller_Request_Http $request) {
        
    }
    
    
    public function getEpisodenByPlotId($plotId) {
        return $this->plotMapper->getEpisodes($plotId);
    }
    
    
}
