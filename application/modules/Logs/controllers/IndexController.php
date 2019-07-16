<?php

use Logs\Services\Plot;

/**
 * Description of Logs_IndexController
 *
 * @author Voß
 */
class Logs_IndexController extends Zend_Controller_Action {
    
    /**
     * @var Logs\Services\Plot
     */
    private $plotService;
    
    private $auth;
    
    public function init() {
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $this->plotService = new Plot();
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
