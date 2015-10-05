<?php

/**
 * Description of SkillController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_SkillController extends Zend_Controller_Action {

    protected $skillService;

    public function init(){
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->erstellungService = new Administration_Service_Erstellung();
        $this->skillService = new Administration_Service_Skill();
    }
    
    public function indexAction() {
        $this->view->list = $this->skillService->getSkillList();
    }
    
    public function showAction() {
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
    }
    
    public function newAction() {
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
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
