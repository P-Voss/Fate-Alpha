<?php

/**
 * Description of Story_Service_Log
 *
 * @author Voß
 */
class Story_Service_Log {
    
    protected $plotMapper;
    protected $episodeMapper;
    protected $logMapper;


    public function __construct() {
        $this->plotMapper = new Story_Model_Mapper_PlotMapper();
        $this->episodeMapper = new Story_Model_Mapper_EpisodeMapper();
        $this->logMapper = new Story_Model_Mapper_LogMapper();
    }
    
    /**
     * @param int $episodenId
     * @return array
     */
    public function getLogsForEpisode($episodenId) {
        return $this->logMapper->getLogsByEpisodenId($episodenId);
    }
    
    /**
     * @param int $plotId
     * @return array
     */
    public function getLogsForPlot($plotId) {
        return $this->plotMapper->getLogsByPlotId($plotId);
    }
    
    
    public function uploadLog(Zend_Controller_Request_Http $request, $episodenId) {
        $upload = new Zend_File_Transfer_Adapter_Http();
        if($upload->getMimeType('logfile') !== 'application/pdf'){
            return false;
        }
        $hash = $upload->getHash('md5', 'logfile');
        $fileinfo = $upload->getFileInfo();
        $filename = $fileinfo['logfile']['name'];
        
        $log = new Story_Model_Log();
        $log->setMd5($hash);
        $log->setName($filename);
        $log->setBeschreibung($request->getPost('beschreibung', ''));
        $log->setOwner(Zend_Auth::getInstance()->getIdentity()->userId);
        $date = new DateTime();
        $log->setCreatedate($date->format('Y-m-d H:i:s'));
        $log->setEpisodenId($episodenId);
        
        $upload->addFilter('Rename', APPLICATION_PATH . '/var/logs/' . $hash . '.pdf');
        $upload->receive();
        $this->logMapper->saveLog($log);
    }
    
    
    public function downloadLog(Story_Model_Log $log) {
        if(is_readable(APPLICATION_PATH . '/var/logs/' . $log->getMd5() . '.pdf')){
            $filename = preg_replace('/[^A-Za-z0-9-.]/', '', $log->getName());
            header("Content-Disposition: attachment; filename=" . $filename);
            header('Content-Type: application/octet-stream');
            header("Content-Description: File Transfer");
            readfile(APPLICATION_PATH . '/var/logs/' . $log->getMd5() . '.pdf');
            exit;
        } else {
            return false;
        }
    }
    
    
    public function getLogByLogIdAndEpisodeId($logId, $episodeId) {
        return $this->logMapper->getLogByLogIdAndEpisodeId($logId, $episodeId);
    }
    
}
