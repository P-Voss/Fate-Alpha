<?php

namespace Logs\Services;

use Exception;
use Logs\Models\Auswertung;
use Logs\Models\Episode as EpisodeModel;
use Logs\Models\Mappers\EpisodeMapper;
use Logs\Models\Mappers\PlotMapper;

/**
 * Description of Episode
 *
 * @author Voß
 */
class Episode {

    /**
     * @var PlotMapper
     */
    protected $plotMapper;
    /**
     * @var EpisodeMapper
     */
    protected $episodeMapper;

    public function __construct() {
        $this->plotMapper = new PlotMapper();
        $this->episodeMapper = new EpisodeMapper();
    }

    /**
     * @param int $episodeId
     *
     * @return EpisodeModel
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
     * @return \Story_Model_Charakter[]
     */
    public function getParticipantsByEpisode($episodeId) {
        $storyEpisodeService = new \Story_Service_Episode();
        return $storyEpisodeService->getParticipantsByEpisode($episodeId);
    }

    /**
     * @param Auswertung $auswertung
     * @param int $episodenId
     *
     * @throws Exception
     */
    public function saveAuswertung(Auswertung $auswertung, $episodenId) {
        $this->episodeMapper->removeAuswertung($auswertung->getUserId(), $episodenId);
        $this->episodeMapper->saveAuswertung($auswertung, $episodenId);
    }
    
}
