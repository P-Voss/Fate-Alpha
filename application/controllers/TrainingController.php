<?php

/**
 * Description of TrainingController
 *
 * @author Vosser
 */
class TrainingController extends Zend_Controller_Action{

    /**
     * @var Application_Service_Layout
     */
    protected $layoutService;
    /**
     * @var Application_Service_Training
     */
    protected $trainingService;
    /**
     * @var Application_Service_Charakter
     */
    protected $charakterService;
    private $auth;
    /**
     *
     * @var Application_Model_Charakter
     */
    private $charakter;

    /**
     * @throws Zend_Db_Statement_Exception
     * @throws Exception
     */
    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->layoutService = new Application_Service_Layout();
        $this->charakterService = new Application_Service_Charakter();
        $this->trainingService = new Application_Service_Training();

        $layout = $this->_helper->layout();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        if($this->auth === null){
            $layout->setLayout('offline');
        }  else {
            $this->charakter = $this->charakterService->getCharakterByUserid($this->auth->userId);
            $this->view->layoutData = $this->layoutService->getLayoutData($this->auth);
            $layout->setLayout('training');
        }
    }

//    public function indexAction(){
//        $this->view->trainingswerte = $this->trainingswerte;
//    }

    public function indexAction ()
    {
        $this->view->trainingsprograms = $this->trainingService->getTrainingPrograms($this->charakter->getCharakterid());
    }

    /**
     * @throws Exception
     */
    public function trainingAction() {
        if($this->getRequest()->isPost()){
            if(!$this->trainingService->startTraining($this->charakter, $this->trainingswerte, $this->getRequest())){
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
