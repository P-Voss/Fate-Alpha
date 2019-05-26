<?php

/**
 * Description of Administration_LogsController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_LogsController extends Zend_Controller_Action {

    /**
     * @var Administration_Service_Logs
     */
    protected $logsService;

    public function init(){
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->logsService = new Administration_Service_Logs();
    }
    
    
    public function indexAction() {
        $this->view->episodes = $this->logsService->getEpisodesToReview();
    }
    
    
    public function reviewAction() {
        if((int)$this->getRequest()->getParam('episode') <= 0
            || $this->logsService->alreadyJudged((int)$this->getRequest()->getParam('episode'))
        ){
            $this->redirect('index');
        }
        $logsEpisodenService = new Logs_Service_Episode();
        
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $this->view->episode = $this->logsService->getEpisode($episodeId);
        
        $this->view->participants = $logsEpisodenService->getParticipantsByEpisode($episodeId);
        $this->view->logs = $this->logsService->getLogsForEpisode($episodeId);
    }
    
    
    public function judgeAction() {
        if(
            (int)$this->getRequest()->getParam('episodenId') <= 0
            || $this->logsService->alreadyJudged((int)$this->getRequest()->getParam('episodenId'))
        ){
            $this->redirect('index');
        }
        $episodeId = (int)$this->getRequest()->getParam('episodenId');
        if((int)$this->getRequest()->getParam('isAccepted', 0) === 1){
            $this->logsService->acceptEpisode($episodeId);
        } else {
            $this->logsService->rejectEpisode($episodeId, $this->getRequest());
        }
        $this->redirect('Logs');
    }
    
}
