<?php


/**
 * Description of Logs_Model_Log
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Logs_Model_Log extends Application_Model_Log {
   
    protected $episodenId;
    
    public function getEpisodenId() {
        return $this->episodenId;
    }

    public function setEpisodenId($episodenId) {
        $this->episodenId = $episodenId;
    }
    
}
