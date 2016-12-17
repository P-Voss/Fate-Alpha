<?php

/**
 * Description of Administration_LogsController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_LogsController extends Zend_Controller_Action {
    
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
        
    }
    
}
