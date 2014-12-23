<?php

/**
 * Description of TrainingController
 *
 * @author Vosser
 */
class TrainingController extends Zend_Controller_Action{
    
    protected $userService;
    protected $trainingService;
    protected $charakterService;
    protected $trainingswerte;


    public function init(){
        $this->userService = new Application_Service_User();
        $this->layoutService = new Application_Service_Layout();
        $this->charakterService = new Application_Service_Charakter();
        $this->trainingService = new Application_Service_Training();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $layout->setLayout('offline');
        }  else {
            $this->trainingswerte = $this->trainingService->getTrainingswerte($this->userService->getCharakter($auth->ID)->getCharakterid());
            
            $this->view->layoutData = $this->layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction(){
        
    }
    
}
