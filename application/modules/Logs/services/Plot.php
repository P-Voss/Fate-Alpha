<?php

namespace Logs\Services;

use Logs\Models\Mappers\EpisodeMapper;
use Logs\Models\Mappers\PlotMapper;

/**
 * Description of Plot
 *
 * @author Voß
 */
class Plot extends \Application_Service_Story {
    
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
     * @param int $userId
     * @return Plot[]
     */
    public function getNonsecretPlotsToReview($userId) {
        try {
            $plotsToReview = $this->plotMapper->getNonsecretPlotsOpenToReviewByUser($userId);
        } catch (\Exception $e) {
            $plotsToReview = [];
        }
        foreach ($plotsToReview as $plot) {
            try {
                $plot->setEpisoden($this->episodeMapper->getEpisodesToReviewByPlotId($plot->getId(), $userId));
            } catch (\Exception $e) {
                continue;
            }
        }
        return $plotsToReview;
    }
    
    /**
     * @param int $userId
     * @return Plot[]
     */
    public function getPlotsToReview($userId) {
        try {
            $plotsToReview = $this->plotMapper->getPlotsOpenToReviewByUser($userId);
        } catch (\Exception $e) {
            $plotsToReview = [];
        }
        foreach ($plotsToReview as $plot) {
            try {
                $plot->setEpisoden($this->episodeMapper->getEpisodesToReviewByPlotId($plot->getId(), $userId));
            } catch (\Exception $e) {
                continue;
            }
        }
        return $plotsToReview;
    }
    
}
