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


    public function indexAction ()
    {
        try {
            $this->view->trainingsprograms = $this->trainingService->getTrainingPrograms($this->charakter);
        } catch (Throwable $exception) {
            $this->view->trainingsprograms = [];
        }
    }

    /**
     * @todo FlashMessage wenn das speichern fehlschlägt
     */
    public function setAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        if(!$this->getRequest()->isPost()){
            $this->redirect('training');
        }
        try {
            $program = $this->trainingService->getCharakterTrainingProgramById(
                $this->charakter,
                $this->getRequest()->getPost('program', 0)
            );
            $program->setRemainingDuration($this->getRequest()->getPost('days', 0));
            $this->trainingService->startTraining($this->charakter, $program);
        } catch (Exception $exception) {
            $this->redirect('training');
        } catch (Throwable $exception) {
            $this->redirect('training');
        }
        $this->redirect('training');
    }


    public function executeAction() {
        $this->redirect('training');
    }
    
}
