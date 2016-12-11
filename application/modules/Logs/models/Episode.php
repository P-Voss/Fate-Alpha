<?php

/**
 * Description of Logs_Model_Episode
 *
 * @author Voß
 */
class Logs_Model_Episode extends Application_Model_Episode {
    
    /**
     * @var Story_Model_EpisodenStatus
     */
    protected $status;
    
    protected $logs = array();


    /**
     * @return Story_Model_EpisodenStatus
     */
    public function getStatus() {
        return $this->status;
    }
    
    public function setStatus(Application_Model_Interfaces_EpisodenStatus $status) {
        $this->status = $status;
    }
    
    /**
     * @return \Logs_Model_Log
     */
    public function getLogs() {
        return $this->logs;
    }
    
    /**
     * @param array $logs
     */
    public function setLogs(Array $logs) {
        foreach ($logs as $log) {
            if ($log instanceof Logs_Model_Log) {
                $this->logs[] = $log;
            }
        }
    }
    
    /**
     * @param Logs_Model_Log $log
     */
    public function addLogs(Logs_Model_Log $log) {
        $this->logs[] = $log;
    }
    
}
