<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_NachteilController extends Zend_Controller_Action {

    protected $erstellungService;
    private $service;

    public function init(){
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->service = new Administration_Service_Nachteil();
        $this->erstellungService = new Administration_Service_Erstellung();
    }
    
    public function indexAction() {
        $this->view->list = $this->erstellungService->getNachteilList();
    }
    
    public function showAction() {
        $this->view->nachteil = $this->service->getNachteilById($this->getRequest()->getParam('id'));
        $this->view->nachteile = $this->erstellungService->getNachteilList();
        $this->view->vorteile = $this->erstellungService->getVorteilList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function newAction() {
        $this->view->nachteile = $this->erstellungService->getNachteilList();
        $this->view->vorteile = $this->erstellungService->getVorteilList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function deleteAction() {
        
    }
    
    public function editAction() {
        $this->service->editNachteil($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->service->createNachteil($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
