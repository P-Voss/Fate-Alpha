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
     *
     * @return int
     * @throws Exception
     */
    public function createStoryline(Zend_Controller_Request_Http $request) {
        $plot = new Story_Model_Plot();
        $plot->setSlId(Zend_Auth::getInstance()->getIdentity()->userId);
        $plot->setName($request->getPost('plotname'));
        $plot->setBeschreibung($request->getPost('beschreibung'));
        $plot->setCreateDate(new DateTime());
        $plot->setIsSecret((int) $request->getPost('secret', 0) === 1);
        $plot->setGenres($request->get('genre', []));
        $plotId = $this->plotMapper->createPlot($plot);

        $plot->setId($plotId);
        $this->plotMapper->setPlotDescription($plot);
        $this->plotMapper->connectGroupToPlot($plotId, $request->getPost('gruppenId'));
        return $plotId;
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @return int
     * @throws Exception
     */
    public function editPlot(Zend_Controller_Request_Http $request) {
        $plot = new Story_Model_Plot();
        $plot->setId($request->getPost('plotId'));
        $plot->setName($request->getPost('plotname'));
        $plot->setBeschreibung($request->getPost('beschreibung'));
        $plotId = $this->plotMapper->renamePlot($plot);
        $this->plotMapper->setPlotDescription($plot);
        return $plotId;
    }
    
    
    public function deletePlot($plotId) {
        $this->plotMapper->deactivatePlot($plotId);
    }
    
    public function getSpielgruppenBySLId($slId) {

    }

    /**
     * @param int $slId
     * @return array
     * @throws Exception
     */
    public function getPlotsBySLId($slId) {
        $plots = $this->plotMapper->getPlotsBySLId($slId);

        foreach ($plots as $plot) {
            $plot->setCharacters($this->getParticipantsByPlotId($plot->getId()));
        }

        return $plots;
    }

    /**
     * @param int $playerId
     * @return array
     * @throws Exception
     */
    public function getPlotsByPlayerId($playerId) {
        $plots = $this->plotMapper->getPlotsByPlayerId($playerId);

        foreach ($plots as $plot) {
            $plot->setCharacters($this->getParticipantsByPlotId($plot->getId()));
        }

        return $plots;
    }

    /**
     * @param int $plotId
     * @param int $userId
     * @return boolean
     * @throws Exception
     */
    public function isSL($plotId, $userId) {
        return $this->plotMapper->verifySl($plotId, $userId);
    }

    /**
     * @param int $plotId
     * @param int $userId
     * @return boolean
     * @throws Exception
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
     * @throws Exception
     */
    public function getParticipantsByPlotId($plotId) {
        return $this->plotMapper->getParticipantsByPlotId($plotId);
    }

    /**
     * @param int $plotId
     * @return array
     * @throws Exception
     */
    public function getPossibleParticipants($plotId) {
        return $this->plotMapper->getParticipantsNotInPlot($plotId);
    }

    /**
     * @param int $plotId
     * @param array $inviteIds
     * @throws Exception
     */
    public function addParticipants($plotId, $inviteIds) {
        foreach ($inviteIds as $charakterId) {
            $this->plotMapper->addParticipant($plotId, $charakterId);
        }
    }

    /**
     * @param int $charakterId
     * @param int $plotId
     * @throws Exception
     */
    public function removeParticipant($charakterId, $plotId) {
        $this->plotMapper->removeParticipant($charakterId, $plotId);
    }
    
    
    public function updateFreigabe($status, $userId, $plotId) {
        $this->plotMapper->updateFreigabe($status, $userId, $plotId);
    }
    
}
