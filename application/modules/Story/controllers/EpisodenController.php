<?php

/**
 * Description of Story_EpisodenController
 *
 * @author Voß
 */
class Story_EpisodenController extends Zend_Controller_Action {
    
    /**
     * @var Application_Model_Charakter 
     */
    protected $charakter;
    protected $plotService;
    protected $episodenService;
    protected $logService;
    
    
    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->charakter = $this->charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->userId);
        $this->plotService = new Story_Service_Plot();
        $this->episodenService = new Story_Service_Episode();
        $this->logService = new Story_Service_Log();
    }
    
    
    public function indexAction() {
        if((int)$this->getRequest()->getParam('plot') <= 0){
            $this->redirect('index');
        }
        $this->redirect('new/' . (int)$this->getRequest()->getParam('plot'));
    }
    
    
    public function newAction() {
        if((int)$this->getRequest()->getParam('plot') <= 0){
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getParam('plot');
        if(!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $this->view->plot = $this->plotService->getPlotById($plotId);
        $this->view->participants = $this->plotService->getParticipantsByPlotId($plotId);
    }
    
    
    public function createAction() {
        if((int)$this->getRequest()->getPost('plotId') <= 0){
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getPost('plotId');
        if(!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $this->episodenService->createEpisode($this->getRequest());
        $this->redirect('Story/plots/sl/id/' . $plotId);
    }
    
    
    public function reviewAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->view->editSuccess = $this->getRequest()->getParam('save', 'f') === 't';
        $this->view->plot = $this->plotService->getPlotById($episode->getPlotId());
        $this->view->episode = $episode;
        $this->view->possibleParticipants = $this->plotService->getParticipantsByPlotId($episode->getPlotId());
        $this->view->participants = $this->episodenService->getParticipantsByEpisodeId($episode->getId());
    }
    
    
    public function editAction() {
        if((int)$this->getRequest()->getPost('episodeId') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getPost('episodeId');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $this->episodenService->editEpisode($this->getRequest());
        $this->redirect('Story/episoden/review/episode/' . $episodeId . '/save/t');
    }
    
    
    public function deleteAction() {
        if((int)$this->getRequest()->getPost('episodeId') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getPost('episodeId');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->episodenService->deleteEpisode($episode);
        $this->redirect('Story/plots/sl/id/' . $episode->getPlotId());
    }
    
    
    public function startAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $this->episodenService->startEpisode($episodeId);
        $this->redirect('Story/episoden/status/episode/' . $episodeId);
    }
    
    
    public function statusAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->view->episode = $episode;
        $this->view->participantsReady = $this->episodenService->getParticipantsReady($episodeId);
        $this->view->participantsPending = $this->episodenService->getParticipantsPending($episodeId);
    }
    
    
    public function detailsAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->view->episode = $episode;
        $this->view->participantsReady = $this->episodenService->getParticipantsReady($episodeId);
        $this->view->participantsPending = $this->episodenService->getParticipantsPending($episodeId);
    }
    
    
    public function readyAction() {
        if((int)$this->getRequest()->getParam('episodeId') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episodeId');
        if(!$this->episodenService->isPlayer($episodeId, $this->charakter->getCharakterId())){
            $this->redirect('index');
        }
        $this->episodenService->updateReadyStatus(1, $episodeId, $this->charakter->getCharakterid());
        $this->redirect('Story/episoden/details/episode/' . $episodeId);
    }
    
    public function unreadyAction() {
        if((int)$this->getRequest()->getParam('episodeId') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episodeId');
        if(!$this->episodenService->isPlayer($episodeId, $this->charakter->getCharakterId())){
            $this->redirect('index');
        }
        $this->episodenService->updateReadyStatus(0, $episodeId, $this->charakter->getCharakterid());
        $this->redirect('Story/episoden/details/episode/' . $episodeId);
    }
    
    
    public function logsAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $isSl = $this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId);
        if(!$this->episodenService->isPlayer($episodeId, $this->charakter->getCharakterId())
            ||
            !$isSl)
        {
            $this->redirect('index');
        }
        $this->view->isSl = $isSl;
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->view->episode = $episode;
        $this->view->logs = $this->logService->getLogsForEpisode($episodeId);
    }
    
    
    public function uploadAction() {
        if((int)$this->getRequest()->getParam('episodeId') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episodeId');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $this->logService->uploadLog($this->getRequest(), $episodeId);
        $this->redirect('Story/episoden/logs/episode/' . $episodeId);
    }
    
    
    public function downloadAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0
            ||
            (int)  $this->getRequest()->getParam('log') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $logId = (int)$this->getRequest()->getParam('log');
        $isSl = $this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId);
        if(!$this->episodenService->isPlayer($episodeId, $this->charakter->getCharakterId())
            ||
            !$isSl)
        {
            $this->redirect('index');
        }
        $log = $this->logService->getLogByLogIdAndEpisodeId($logId, $episodeId);
        if(!$this->logService->downloadLog($log)){
            $this->redirect('Story/episoden/logs/episode/' . $episodeId);
        }
    }
    
    
    public function finishAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId))
        {
            $this->redirect('index');
        }
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->view->episode = $episode;
    }
    
    
    public function closeAction() {
        if((int)$this->getRequest()->getParam('episodenId') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episodenId');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId))
        {
            $this->redirect('index');
        }
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->episodenService->finishEpisode($episodeId, $this->getRequest()->getPost('zusammenfassung', ''));
        $this->redirect('Story/plots/sl/id/' . $episode->getPlotId());
    }
    
    
    public function resultAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episode');
        if(!$this->episodenService->isSL($episodeId, Zend_Auth::getInstance()->getIdentity()->userId))
        {
            $this->redirect('index');
        }
        $episode = $this->episodenService->getEpisode($episodeId);
        $this->view->episode = $episode;
        $this->view->participants = $this->episodenService->getParticipantsByEpisode($episodeId);
    }
    
}
