<?php

/**
 * Description of Plot
 *
 * @author Voß
 */
class Story_Service_Plot extends Application_Service_Story {
    
    /**
     * @var Story_Model_Mapper_PlotMapper 
     */
    protected $plotMapper;
    
    
    public function __construct() {
        $this->plotMapper = new Story_Model_Mapper_PlotMapper();
    }
    
    
    public function getPlotById($plotId) {
        return $this->plotMapper->getPlotById($plotId);
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @return int
     */
    public function createStoryline(Zend_Controller_Request_Http $request) {
        $plot = new Story_Model_Plot();
        $plot->setSlId(Zend_Auth::getInstance()->getIdentity()->userId);
        $plot->setName($request->getPost('plotname'));
        $plot->setBeschreibung($request->getPost('beschreibung'));
        $plotId = $this->plotMapper->createPlot($plot);
        if(!is_null($request->getPost('genre'))){
            $this->plotMapper->setGenres($plotId, $request->getPost('genre'));
        }
        $plot->setId($plotId);
        $this->plotMapper->setPlotDescription($plot);
        $this->plotMapper->connectGroupToPlot($plotId, $request->getPost('gruppenId'));
        return $plotId;
    }
    
    
    public function getSpielgruppenBySLId($slId) {
        
    }
    
    /**
     * @param int $slId
     * @return array
     */
    public function getPlotsBySLId($slId) {
        return $this->plotMapper->getPlotsBySLId($slId);
    }
    
    /**
     * @param int $playerId
     * @return array
     */
    public function getPlotsByPlayerId($playerId) {
        return $this->plotMapper->getPlotsByPlayerId($playerId);
    }
    
    /**
     * @param int $plotId
     * @param int $userId
     * @return boolean
     */
    public function isSL($plotId, $userId) {
        return $this->plotMapper->verifySl($plotId, $userId);
    }
    
    /**
     * @param int $plotId
     * @param int $userId
     * @return boolean
     */
    public function isPlayer($plotId, $userId) {
        return $this->plotMapper->verifyPlayer($plotId, $userId);
    }
    
    
    public function checkDatenfreigabe($plotId, $userId) {
        return $this->plotMapper->datenFreigegeben($plotId, $userId);
    }
    
    
    public function checkDatenfreigabeCharakter($plotId, $charakterId) {
        return $this->plotMapper->datenFreigebenCharakter($plotId, $charakterId);
    }
    
    /**
     * @param int $plotId
     * @return array
     */
    public function getParticipantsByPlotId($plotId) {
        return $this->plotMapper->getParticipantsByPlotId($plotId);
    }
    
    /**
     * @param int $plotId
     * @return array
     */
    public function getPossibleParticipants($plotId) {
        return $this->plotMapper->getParticipantsNotInPlot($plotId);
    }
    
    /**
     * @param int $plotId
     * @param array $inviteIds
     */
    public function addParticipants($plotId, $inviteIds) {
        foreach ($inviteIds as $charakterId) {
            $this->plotMapper->addParticipant($plotId, $charakterId);
        }
    }
    
    /**
     * @param int $charakterId
     * @param int $plotId
     */
    public function removeParticipant($charakterId, $plotId) {
        $this->plotMapper->removeParticipant($charakterId, $plotId);
    }
    
    
    public function updateFreigabe($status, $userId, $plotId) {
        $this->plotMapper->updateFreigabe($status, $userId, $plotId);
    }
    
}
