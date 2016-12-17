<?php

/**
 * Description of Administration_Service_Logs
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Logs {
    
    /**
     * @var Administration_Model_Mapper_LogsMapper
     */
    private $mapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_LogsMapper();
    }
    
    
    public function getEpisodesToReview() {
        return $this->mapper->getEpisodesToReview();
    }
    
    
}
