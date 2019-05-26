<?php

/**
 * Description of Logs_Service_Log
 *
 * @author Voß
 */
class Logs_Service_Log {

    /**
     * @var Logs_Model_Mapper_PlotMapper
     */
    protected $plotMapper;
    /**
     * @var Logs_Model_Mapper_EpisodeMapper
     */
    protected $episodeMapper;
    /**
     * @var Logs_Model_Mapper_LogMapper
     */
    protected $logMapper;


    public function __construct() {
        $this->plotMapper = new Logs_Model_Mapper_PlotMapper();
        $this->episodeMapper = new Logs_Model_Mapper_EpisodeMapper();
        $this->logMapper = new Logs_Model_Mapper_LogMapper();
    }

    /**
     * @param int $userId
     *
     * @return boolean
     * @throws Zend_Db_Statement_Exception
     */
    public function isLogleser($userId) {
        return $this->logMapper->isLogleser($userId);
    }

    /**
     * @param int $episodenId
     *
     * @return array
     * @throws Exception
     */
    public function getLogsForEpisode($episodenId) {
        return $this->logMapper->getLogsByEpisodenId($episodenId);
    }

    /**
     * @param Logs_Model_Log $log
     *
     * @return bool
     */
    public function downloadLog(Logs_Model_Log $log) {
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

    /**
     * @param array $logs
     * @param $episodeName
     *
     * @return bool
     * @throws Zend_Pdf_Exception
     */
    public function downloadGesamtlog(Array $logs, $episodeName) {
        $resultPdf = new Zend_Pdf();
        $extractor = new Zend_Pdf_Resource_Extractor();
        foreach ($logs as $log) {
            if(!is_readable(APPLICATION_PATH . '/var/logs/' . $log->getMd5() . '.pdf')){
                continue;
            }
            $pdf = Zend_Pdf::load(APPLICATION_PATH . '/var/logs/' . $log->getMd5() . '.pdf');
            foreach ($pdf->pages as $page) {
                $resultPdf->pages[] = $extractor->clonePage($page);
            }
        }
        if(count($resultPdf->pages) > 0){
            $filename = str_replace(' ', '', $episodeName);
            $resultPdf->save(APPLICATION_PATH . '/var/logs/Log_' . $filename . '.pdf');
            header('Content-Disposition: attachment; filename=' . escapeshellcmd($filename) . '.pdf');
            header('Content-Type: application/octet-stream');
            header('Content-Description: File Transfer');
            readfile(APPLICATION_PATH . '/var/logs/Log_' . $filename . '.pdf');
            exit;
        } else {
            return false;
        }
    }

    /**
     * @param $logId
     * @param $episodeId
     *
     * @return Logs_Model_Log
     * @throws Exception
     */
    public function getLogByLogIdAndEpisodeId($logId, $episodeId) {
        return $this->logMapper->getLogByLogIdAndEpisodeId($logId, $episodeId);
    }
    
}
