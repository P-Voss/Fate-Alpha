<?php

/**
 * Description of Administration_TraitController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_TraitController extends Zend_Controller_Action {

    /**
     * @var Administration_Service_Erstellung
     */
    protected $erstellungService;
    /**
     * @var Administration_Service_Trait
     */
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
        $this->service = new Administration_Service_Trait();
        $this->erstellungService = new Administration_Service_Erstellung();
    }
    
    public function indexAction() {
        $this->view->list = $this->service->getTraits();
    }
    
    public function showAction() {
        $this->view->trait = $this->service->getTraitById($this->getRequest()->getParam('id'));
        $this->view->traits = $this->service->getTraits();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function newAction() {
        $this->view->traits = $this->service->getTraits();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function deleteAction() {
        
    }
    
    public function editAction() {
        $this->service->editTrait($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->service->createTrait($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
