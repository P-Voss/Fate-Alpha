<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_ElementController extends Zend_Controller_Action {

    protected $erstellungService;
    private $service;

    public function init(){
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->service = new Administration_Service_Element();
        $this->erstellungService = new Administration_Service_Erstellung();
    }
    
    public function indexAction() {
        $this->view->list = $this->erstellungService->getElementList();
    }
    
    public function showAction() {
        $this->view->element = $this->service->getElementById($this->getRequest()->getParam('id'));
    }
    
    public function newAction() {
        
    }
    
    public function deleteAction() {
        
    }
    
    public function editAction() {
        $this->service->editElement($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->service->createElement($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
