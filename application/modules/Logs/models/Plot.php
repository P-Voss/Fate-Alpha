<?php

/**
 * Description of Logs_Model_Plot
 *
 * @author Voß
 */
class Logs_Model_Plot extends Application_Model_Plot {
    
    protected $episoden = array();
    
    /**
     * @return \Logs_Model_Episode
     */
    public function getEpisoden() {
        return $this->episoden;
    }
    
    /**
     * @param array $episoden
     */
    public function setEpisoden(array $episoden) {
        foreach ($episoden as $episode) {
            if ($episode instanceof Logs_Model_Episode) {
                $this->episoden[] = $episode;
            }
        }
    }
    
    /**
     * @param Logs_Model_Episode $episode
     */
    public function addEpisode(Logs_Model_Episode $episode) {
        $this->episoden[] = $episode;
    }
    
}
