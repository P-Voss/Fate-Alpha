<?php

namespace Logs\Services;

use Logs\Models\Mappers\EpisodeMapper;
use Logs\Models\Mappers\LogMapper;
use Logs\Models\Mappers\PlotMapper;
use Logs\Models\Log as LogModel;

/**
 * Description of Log
 *
 * @author Voß
 */
class Log {

    /**
     * @var PlotMapper
     */
    protected $plotMapper;
    /**
     * @var EpisodeMapper
     */
    protected $episodeMapper;
    /**
     * @var LogMapper
     */
    protected $logMapper;


    public function __construct() {
        $this->plotMapper = new PlotMapper();
        $this->episodeMapper = new EpisodeMapper();
        $this->logMapper = new LogMapper();
    }

    /**
     * @param int $userId
     *
     * @return boolean
     */
    public function isLogleser($userId) {
        return $this->logMapper->isLogleser($userId);
    }

    /**
     * @param int $episodenId
     *
     * @return array
     */
    public function getLogsForEpisode($episodenId) {
        try {
            return $this->logMapper->getLogsByEpisodenId($episodenId);
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param LogModel $log
     *
     * @return bool
     */
    public function downloadLog(LogModel $log) {
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
     * @param LogModel[] $logs
     * @param $episodeName
     *
     * @return bool
     * @throws \Zend_Pdf_Exception
     */
    public function downloadGesamtlog(Array $logs, $episodeName) {
        $resultPdf = new \Zend_Pdf();
        $extractor = new \Zend_Pdf_Resource_Extractor();
        foreach ($logs as $log) {
            if(!is_readable(APPLICATION_PATH . '/var/logs/' . $log->getMd5() . '.pdf')){
                continue;
            }
            $pdf = \Zend_Pdf::load(APPLICATION_PATH . '/var/logs/' . $log->getMd5() . '.pdf');
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
     * @return LogModel
     * @throws \Exception
     */
    public function getLogByLogIdAndEpisodeId($logId, $episodeId) {
        return $this->logMapper->getLogByLogIdAndEpisodeId($logId, $episodeId);
    }
    
}
