<?php

/**
 * Description of Logs_Service_Plot
 *
 * @author Voß
 */
class Logs_Service_Plot extends Application_Service_Story {
    
    /**
     * @var Logs_Model_Mapper_PlotMapper 
     */
    protected $plotMapper;
    protected $episodeMapper;
    
    public function __construct() {
        $this->plotMapper = new Logs_Model_Mapper_PlotMapper();
        $this->episodeMapper = new Logs_Model_Mapper_EpisodeMapper();
    }
    
    /**
     * @param int $userId
     * @return \Logs_Model_Plot
     */
    public function getNonsecretPlotsToReview($userId) {
        $plotsToReview = $this->plotMapper->getNonsecretPlotsOpenToReviewByUser($userId);
        foreach ($plotsToReview as $plot) {
            $plot->setEpisoden($this->episodeMapper->getEpisodesToReviewByPlotId($plot->getId(), $userId));
        }
        return $plotsToReview;
    }
    
    /**
     * @param int $userId
     * @return \Logs_Model_Plot
     */
    public function getPlotsToReview($userId) {
        $plotsToReview = $this->plotMapper->getPlotsOpenToReviewByUser($userId);
        foreach ($plotsToReview as $plot) {
            $plot->setEpisoden($this->episodeMapper->getEpisodesToReviewByPlotId($plot->getId(), $userId));
        }
        return $plotsToReview;
    }
    
}
