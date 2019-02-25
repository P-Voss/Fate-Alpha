<?php

class InformationController extends Zend_Controller_Action {

    /**
     * @var Application_Service_Information
     */
    protected $informationService;

    public function init(){
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->informationService = new Application_Service_Information();
    }
    
    
    public function indexAction() {
        if ((int) $this->getRequest()->getParam('id', 0) > 0) {{
            $information = $this->informationService->getInformation(
                $this->getRequest()->getParam('id', 0),
                Zend_Auth::getInstance()->getIdentity()->userId
            );
            $this->view->information = $information;
        }}
    }
    
}

