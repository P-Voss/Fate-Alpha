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
    /**
     *
     * @var Application_Model_Charakter
     */
    private $_charakter;

    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->_userService = new Application_Service_User();
        $this->_layoutService = new Application_Service_Layout();
        $this->_charakterService = new Application_Service_Charakter();
        $this->_trainingService = new Application_Service_Training();
        
        $layout = $this->_helper->layout();
        $this->_auth = Zend_Auth::getInstance()->getIdentity();
        if($this->_auth === null){
            $layout->setLayout('offline');
        }  else {
            $this->_charakter = $this->_charakterService->getCharakterByUserid($this->_auth->userId);
            $this->_trainingswerte = $this->_trainingService->getTrainingswerte($this->_charakter);
            $this->view->layoutData = $this->_layoutService->getLayoutData($this->_auth);
            $layout->setLayout('training');
        }
    }
    
    public function indexAction(){
        $this->view->trainingswerte = $this->_trainingswerte;
    }
    
    public function trainingAction() {
        if($this->getRequest()->isPost()){
            if(!$this->_trainingService->startTraining($this->_charakter, $this->_trainingswerte, $this->getRequest())){
                $this->view->fehlermeldung = 'Es wurden fehlerhafte Werte übertragen. Try Again.';
            }
        }
        $this->redirect('training');
    }
    
    public function executeAction() {
        $this->redirect('index');
//        $this->_helper->viewRenderer->setNoRender(true);
//        $layout = $this->_helper->layout();
//        $layout->disableLayout();
//        $this->_trainingService->executeTraining();
    }
    
}
