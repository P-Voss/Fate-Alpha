<?php

/**
 * Description of KlasseController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_KlasseController extends Zend_Controller_Action {

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
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function showAction() {
        $this->view->klasse = $this->service->getKlasseById($this->getRequest());
        $this->view->nachteile = $this->erstellungService->getNachteilList();
        $this->view->vorteile = $this->erstellungService->getVorteilList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
    }
    
    public function newAction() {
        $this->view->nachteile = $this->erstellungService->getNachteilList();
        $this->view->vorteile = $this->erstellungService->getVorteilList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
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
