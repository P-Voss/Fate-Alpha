<?php

/**
 * Description of Administration_Service_Logs
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Logs extends Logs_Service_Log {
    
    CONST EPISODE_ACCEPTED_STATUS = 6;
    CONST EPISODE_REJECTED_STATUS = 7;
    
    
    /**
     * @var Administration_Model_Mapper_LogsMapper
     */
    private $mapper;
    
    
    public function __construct() {
        parent::__construct();
        $this->mapper = new Administration_Model_Mapper_LogsMapper();
    }
    
    
    public function getEpisodesToReview() {
        return $this->mapper->getEpisodesToReview();
    }
    
    
    public function getEpisode($episodeId) {
        $episode = $this->mapper->getEpisodeToReview($episodeId);
        $episode->setAuswertungen($this->mapper->getLogreaderResults($episodeId));
        return $episode;
    }
    
    
    public function rejectEpisode($episodeId, Zend_Controller_Request_Http $request) {
        $auswertung = new Administration_Model_Auswertung();
        $auswertung->setUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        $auswertung->setDescription($request->getPost('feedback', ''));
        $this->mapper->insertRejection($episodeId, $auswertung);
        $this->mapper->updateStatus($episodeId, self::EPISODE_REJECTED_STATUS);
    }
    
}
