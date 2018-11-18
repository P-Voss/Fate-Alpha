<?php

class InformationController extends Zend_Controller_Action {

    protected $informationService;

    public function init(){
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->informationService = new Application_Service_Information();
    }
    
    
    public function indexAction() {
        
    }
    
    
    public function loadAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $informationService = new Application_Service_Information();
        $information = $informationService->getInformation(
            $this->getRequest()->getParam('id', 0),
            Zend_Auth::getInstance()->getIdentity()->userId
        );
        $this->view->information = $information;
        $html = $this->view->render('information/load.phtml');
        echo json_encode(array('html' => $html));
    }
    
}

