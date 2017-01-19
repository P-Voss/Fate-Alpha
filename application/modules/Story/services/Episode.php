<?php

/**
 * Description of Story_Service_Episode
 *
 * @author Voß
 */
class Story_Service_Episode {
    
    protected $plotMapper;
    protected $episodeMapper;

    public function __construct() {
        $this->plotMapper = new Story_Model_Mapper_PlotMapper();
        $this->episodeMapper = new Story_Model_Mapper_EpisodeMapper();
    }
    
    /**
     * @param int $episodeId
     * @param int $userId
     * @return boolean
     */
    public function isSL($episodeId, $userId) {
        return $this->episodeMapper->verifySl($episodeId, $userId);
    }
    
    /**
     * @param int $episodeId
     * @param int $charakterId
     * @return boolean
     */
    public function isPlayer($episodeId, $charakterId) {
        return $this->episodeMapper->verifyPlayer($episodeId, $charakterId);
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return int
     */
    public function createEpisode(Zend_Controller_Request_Http $request) {
        $episode = new Story_Model_Episode();
        $episode->setName($request->getPost('episodename'));
        $episode->setBeschreibung($request->getPost('beschreibung'));
        $episode->setPlotId($request->getPost('plotId'));
        $episodenId = $this->episodeMapper->createEpisode($episode);
        if(count($request->getPost('participants')) > 0){
            $this->episodeMapper->addParticipants($episodenId, $request->getPost('participants'));
        }
        $episode->setId($episodenId);
        $this->episodeMapper->setBeschreibung($episode);
        return $episodenId;
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     */
    public function editEpisode(Zend_Controller_Request_Http $request) {
        $episode = new Story_Model_Episode();
        $episode->setId($request->getPost('episodeId'));
        $episode->setName($request->getPost('episodename'));
        $episode->setBeschreibung($request->getPost('beschreibung'));
        $this->episodeMapper->removeParticipants($episode->getId());
        $this->episodeMapper->updateEpisode($episode);
        if(count($request->getPost('participants')) > 0){
            $this->episodeMapper->addParticipants($episode->getId(), $request->getPost('participants'));
        }
        $this->episodeMapper->setBeschreibung($episode);
        $status = new Story_Model_EpisodenStatus();
        $status->setId(1);
        $this->episodeMapper->updateStatus($status, $episode->getId());
    }
    
    
    public function deleteEpisode(Story_Model_Episode $episode) {
        $this->episodeMapper->deleteEpisode($episode->getId());
    }
    
    /**
     * @param int $episodeId
     */
    public function startEpisode($episodeId) {
        $status = new Story_Model_EpisodenStatus();
        $status->setId(2);
        $this->episodeMapper->updateStatus($status, $episodeId);
    }
    
    /**
     * @param int $episodeId
     * @param int $zusammenfassung
     */
    public function finishEpisode($episodeId, $zusammenfassung) {
        $episode = new Story_Model_Episode();
        $episode->setId($episodeId);
        $episode->setZusammenfassung($zusammenfassung);
        $status = new Story_Model_EpisodenStatus();
        $status->setId(4);
        $this->episodeMapper->updateStatus($status, $episodeId);
        $this->episodeMapper->setZusammenfassung($episode);
        $this->episodeMapper->resetEvaluations($episodeId);
        $this->episodeMapper->resetRejection($episodeId);
    }
    
    /**
     * @param int $plotId
     * @return array
     */
    public function getEpisodesByPlotId($plotId) {
        return $this->episodeMapper->getEpisodesByPlotId($plotId);
    }
    
    /**
     * @param int $plotId
     * @param int $userId
     * @return array
     */
    public function getEpisodesByPlotIdForUser($plotId, $userId) {
        return $this->episodeMapper->getEpisodesByPlotIdForUser($plotId, $userId);
    }
    
    /**
     * @param int $episodeId
     * @return Story_Model_Episode
     */
    public function getEpisode($episodeId) {
        return $this->episodeMapper->getEpisodeById($episodeId);
    }
    
    /**
     * @param int $episodeId
     * @return array
     */
    public function getParticipantsByEpisodeId($episodeId) {
        return $this->episodeMapper->getParticipants($episodeId);
    }
    
    
    public function getParticipant($episodenId, $charakterId) {
        $participant = $this->episodeMapper->getParticipant($episodenId, $charakterId);
        $participant->setResult($this->episodeMapper->getCharakterResult($episodenId, $charakterId));
        return $participant;
    }
    
    /**
     * @param int $episodeId
     * @return array
     */
    public function getParticipantsReady($episodeId) {
        return $this->episodeMapper->getParticipantsByEpisodeAndStatus($episodeId, 1);
    }
    
    /**
     * @param int $episodeId
     * @return array
     */
    public function getParticipantsByEpisode($episodeId) {
        $participants = $this->episodeMapper->getParticipantsByEpisode($episodeId);
        foreach ($participants as $participant) {
            $participant->setResult($this->episodeMapper->getCharakterResult($episodeId, $participant->getCharakterid()));
        }
        return $participants;
    }
    
    /**
     * @param int $episodeId
     * @return array
     */
    public function getParticipantsPending($episodeId) {
        return $this->episodeMapper->getParticipantsByEpisodeAndStatus($episodeId, 0);
    }
    
    
    public function updateReadyStatus($status, $episodeId, $charakterId) {
        if(!$this->episodeMapper->allReady($episodeId)){
            $this->episodeMapper->updateCharakterStatus($status, $episodeId, $charakterId);
        }
        if($this->episodeMapper->allReady($episodeId)){
            $status = new Story_Model_EpisodenStatus();
            $status->setId(3);
            $this->episodeMapper->updateStatus($status, $episodeId);
            $this->episodeMapper->initCharakterResult($episodeId);
        }
    }
    
    
    public function updateCharakterNpckills($episodenId, $charakterId, $killcount) {
        $this->episodeMapper->updateCharakterNpckills($episodenId, $charakterId, $killcount);
    }
    
    
    public function updateCharakterComment($episodenId, $charakterId, $comment) {
        $this->episodeMapper->updateCharakterComment($episodenId, $charakterId, $comment);
    }
    
    public function updateCharakterGotKilled($episodenId, $charakterId, $gotKilled) {
        $this->episodeMapper->updateCharakterGotKilled($episodenId, $charakterId, $gotKilled);
    }
    
    public function updateCharakterKills($episodenId, $charakterId, Zend_Controller_Request_Http $request) {
        if($request->getPost('ids') === null) {
            $ids = [];
        } else {
            $ids = is_array($request->getPost('ids')) ? $request->getPost('ids') : [$request->getPost('ids')];
        }
        $this->episodeMapper->removeCharakterKillRequests($episodenId, $charakterId);
        $this->episodeMapper->addCharakterKillRequests($episodenId, $charakterId, $ids);
    }
    
    
    public function getRejection($episodeId) {
        return $this->episodeMapper->getRejection($episodeId);
    }
    
}
