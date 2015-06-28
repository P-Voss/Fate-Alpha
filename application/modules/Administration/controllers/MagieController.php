<?php

/**
 * Description of MagieController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_MagieController extends Zend_Controller_Action {

    protected $erstellungService;
    protected $skillService;
    protected $schulService;

    public function init(){
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->schulService = new Administration_Service_Schule();
        $this->erstellungService = new Administration_Service_Erstellung();
        $this->skillService = new Administration_Service_Skill();
    }
    
    public function indexAction() {
        $this->view->list = $this->skillService->getMagieList();
    }
    
    public function showAction() {
        $this->view->magie = $this->skillService->getMagieById($this->getRequest()->getParam('id'));
        $this->view->magieList = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
    }
    
    public function newAction() {
        $this->view->magieList = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
    }
    
    public function deleteAction() {
        
    }
    
    public function editAction() {
        $this->skillService->editMagie($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->skillService->createMagie($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}