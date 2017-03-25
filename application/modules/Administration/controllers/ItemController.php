<?php

/**
 * Description of Administration_ItemController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_ItemController extends Zend_Controller_Action {

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
        $this->service = new Administration_Service_Klassen();
        $this->erstellungService = new Administration_Service_Erstellung();
    }
    
    public function indexAction() {
        
    }
    
    public function showAction() {
        
    }
    
    public function newAction() {
        
    }
    
    public function deleteAction() {
        
    }
    
    public function editAction() {
        $this->service->editKlasse($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->service->createKlasse($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
