<?php

/**
 * Description of Logs_Service_Episode
 *
 * @author Voß
 */
class Logs_Service_Episode {
    
    protected $plotMapper;
    protected $episodeMapper;

    public function __construct() {
        $this->plotMapper = new Logs_Model_Mapper_PlotMapper();
        $this->episodeMapper = new Logs_Model_Mapper_EpisodeMapper();
    }

    /**
     * @param int $episodeId
     *
     * @return Logs_Model_Episode
     * @throws Exception
     */
    public function getEpisode($episodeId) {
        return $this->episodeMapper->getEpisodeToJudgeById($episodeId);
    }

    /**
     * @param int $episodenId
     *
     * @return boolean
     */
    public function needsLogleser($episodenId) {
        try {
            return $this->episodeMapper->episodeBelongsToSecretPlot($episodenId);
        } catch (Exception $exception) {
            return true;
        }
    }

    /**
     * @param int $episodeId
     *
     * @return array
     * @throws Exception
     */
    public function getParticipantsByEpisode($episodeId) {
        $participants = $this->episodeMapper->getParticipantsByEpisode($episodeId);
        foreach ($participants as $participant) {
            $participant->setResult($this->episodeMapper->getCharakterResult($episodeId, $participant->getCharakterid()));
        }
        return $participants;
    }

    /**
     * @param Logs_Model_Auswertung $auswertung
     * @param int $episodenId
     *
     * @throws Exception
     */
    public function saveAuswertung(Logs_Model_Auswertung $auswertung, $episodenId) {
        $this->episodeMapper->removeAuswertung($auswertung, $episodenId);
        $this->episodeMapper->saveAuswertung($auswertung, $episodenId);
    }
    
}
