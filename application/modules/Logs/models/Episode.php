<?php

namespace Logs\Models;

/**
 * Description of Episode
 *
 * @author Voß
 */
class Episode extends \Application_Model_Episode {
    
    /**
     * @var \Story_Model_EpisodenStatus
     */
    protected $status;
    
    protected $logs = array();


    /**
     * @return \Story_Model_EpisodenStatus
     */
    public function getStatus() {
        return $this->status;
    }
    
    public function setStatus(\Application_Model_Interfaces_EpisodenStatus $status) {
        $this->status = $status;
    }
    
    /**
     * @return Log
     */
    public function getLogs() {
        return $this->logs;
    }
    
    /**
     * @param Log[] $logs
     */
    public function setLogs(Array $logs = []) {
        foreach ($logs as $log) {
            if ($log instanceof Log) {
                $this->logs[] = $log;
            }
        }
    }
    
    /**
     * @param Log $log
     */
    public function addLogs(Log $log) {
        $this->logs[] = $log;
    }
    
}
