<?php

/**
 * Description of StoryController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Gruppen_StoryController extends Zend_Controller_Action {
    
    /**
     * @var Application_Service_Charakter 
     */
    protected $charakterService;
    
    /**
     * @var Application_Model_Charakter
     */
    protected $charakter;

    /**
     * @var Gruppen_Service_Gruppen
     */
    protected $gruppenService;
    
    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        $this->_helper->logincheck();
//        if(!$this->_helper->admincheck()){
//            $this->redirect('index');
//        }
        $this->gruppenService = new Gruppen_Service_Gruppen();
    }
    
    public function indexAction() {
        if(!is_null($this->getRequest()->getPost('gruppenId'))){
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getPost('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    public function createAction() {
        if(!is_null($this->getRequest()->getPost('gruppenId'))){
            $service = new Gruppen_Service_Story();
            $service->createStoryline($this->getRequest());
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getPost('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
}
