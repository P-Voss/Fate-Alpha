<?php

/**
 * Description of SkillController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_SkillController extends Zend_Controller_Action {

    protected $skillService;

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
        $this->view->list = $this->skillService->getSkillList();
    }
    
    public function rpgAction() {
        $this->view->list = $this->skillService->getRpgSkillList();
    }
    
    public function showAction() {
        $this->view->skill = $this->skillService->getSkillById($this->getRequest()->getParam('id'));
        $this->view->magien = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $this->view->vorteile = $this->erstellungService->getVorteilList();
        $this->view->nachteile = $this->erstellungService->getNachteilList();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function newAction() {
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->magien = $this->skillService->getMagieList();
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
        $this->skillService->editSkill($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->skillService->createSkill($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
