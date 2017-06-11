<?php

/**
 * Description of Logs_IndexController
 *
 * @author Voß
 */
class Logs_IndexController extends Zend_Controller_Action {
    
    /**
     * @var Logs_Service_Plot
     */
    private $plotService;
    
    private $auth;
    
    public function init() {
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->plotService = new Logs_Service_Plot();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
    }
    
    
    public function indexAction() {
        if (!$this->auth->isLogleser) {
            $this->view->plotsToReview = $this->plotService->getNonsecretPlotsToReview($this->auth->userId);
        } else {
            $this->view->plotsToReview = $this->plotService->getPlotsToReview($this->auth->userId);
        }
    }
    
}
