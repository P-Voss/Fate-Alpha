<?php

/**
 * Description of TrainingController
 *
 * @author Vosser
 */
class TrainingController extends Zend_Controller_Action{
    
    protected $_userService;
    protected $_trainingService;
    protected $_charakterService;
    protected $_trainingswerte;
    private $_auth;

    public function init(){
        $this->_userService = new Application_Service_User();
        $this->_layoutService = new Application_Service_Layout();
        $this->_charakterService = new Application_Service_Charakter();
        $this->_trainingService = new Application_Service_Training();
        
        $layout = $this->_helper->layout();
        $this->_auth = Zend_Auth::getInstance()->getIdentity();
        if($this->_auth === null){
            $layout->setLayout('offline');
        }  else {
            $this->_trainingswerte = $this->_trainingService->getTrainingswerte($this->_userService->getCharakter($this->_auth->ID));
            
            $this->view->layoutData = $this->_layoutService->getLayoutData($this->_auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction(){
        $this->view->trainingswerte = $this->_trainingswerte;
    }
    
    public function trainingAction() {
        if($this->getRequest()->isPost()){
            if(!$this->_trainingService->startTraining($this->_userService->getCharakter($this->_auth->ID), $this->_trainingswerte, $this->getRequest())){
                $this->view->fehlermeldung = 'Es wurden fehlerhafte Werte übertragen. Try Again.';
            }
        }
        $this->redirect('training');
    }
    
}
