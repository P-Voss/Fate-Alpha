<?php

/**
 * Description of Logs_ReviewController
 *
 * @author Voß
 */
class Logs_ReviewController extends Zend_Controller_Action {
    
    /**
     * @var Logs_Service_Plot
     */
    private $plotService;
    private $episodenService;
    private $logService;
    
    
    public function init() {
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $this->logService = new Logs_Service_Log();
        if(!$this->logService->isLogleser(Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->plotService = new Logs_Service_Plot();
        $this->episodenService = new Logs_Service_Episode();
    }
    
    
    public function indexAction() {
        $this->redirect('Logs');
    }
    
    
    public function showAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->view->episode = $episode;
        $this->view->participants = $this->episodenService->getParticipantsByEpisode($episodeId);
        $this->view->logs = $this->logService->getLogsForEpisode($episodeId);
    }
    
    
    public function downloadAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0
            ||
            (int)  $this->getRequest()->getParam('log') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $logId = (int)$this->getRequest()->getParam('log');
        
        $log = $this->logService->getLogByLogIdAndEpisodeId($logId, $episodeId);
        if(!$this->logService->downloadLog($log)){
            $this->redirect('Logs/review/show/episode/' . $episodeId);
        }
    }
    
    public function gesamtlogAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $episode = $this->episodenService->getEpisode($episodeId);
        $logs = $this->logService->getLogsForEpisode($episodeId);
        if(!$this->logService->downloadGesamtlog($logs, $episode->getName())){
            $this->redirect('Logs/review/show/episode/' . $episodeId);
        }
    }
    
    public function reviewAction() {
        if((int)$this->getRequest()->getParam('episodenId') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episodenId');
        $auswertung = new Logs_Model_Auswertung();
        $auswertung->setDescription($this->getRequest()->getPost('feedback', ''));
        $auswertung->setUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        $auswertung->setIsAccepted((int)$this->getRequest()->getPost('isAccepted', 0) === 1);
        $this->episodenService->saveAuswertung($auswertung, $episodeId);
        $this->redirect('Logs');
    }
    
}
