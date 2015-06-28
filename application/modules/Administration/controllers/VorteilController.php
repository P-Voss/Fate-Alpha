<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_VorteilController extends Zend_Controller_Action {

    protected $erstellungService;
    private $service;

    public function init(){
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->service = new Administration_Service_Vorteil();
        $this->erstellungService = new Administration_Service_Erstellung();
    }
    
    public function indexAction() {
        $this->view->list = $this->erstellungService->getVorteilList();
    }
    
    public function showAction() {
        $this->view->vorteil = $this->service->getVorteilById($this->getRequest()->getParam('id'));
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
        $this->service->editVorteil($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->service->createVorteil($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
