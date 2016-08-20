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
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
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
        $this->view->schulen = $this->schulService->getSchulList();
    }
    
    public function rpgAction() {
        $this->view->list = $this->skillService->getRpgMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
    }
    
    public function showAction() {
        $this->view->magie = $this->skillService->getMagieById($this->getRequest()->getParam('id'));
        $this->view->magieList = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $this->view->vorteile = $this->erstellungService->getVorteilList();
        $this->view->nachteile = $this->erstellungService->getNachteilList();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function newAction() {
        $this->view->magieList = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $this->view->vorteile = $this->erstellungService->getVorteilList();
        $this->view->nachteile = $this->erstellungService->getNachteilList();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
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
