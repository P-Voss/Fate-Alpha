<?php


/**
 * Description of Story_Model_Log
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Story_Model_Log extends Application_Model_Log {
   
    protected $episodenId;
    
    public function getEpisodenId() {
        return $this->episodenId;
    }

    public function setEpisodenId($episodenId) {
        $this->episodenId = $episodenId;
    }
    
}
