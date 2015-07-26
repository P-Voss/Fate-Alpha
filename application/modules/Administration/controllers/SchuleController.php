<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_SchuleController extends Zend_Controller_Action {

    protected $erstellungService;
    protected $skillService;
    private $service;

    public function init(){
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->service = new Administration_Service_Schule();
        $this->erstellungService = new Administration_Service_Erstellung();
        $this->skillService = new Administration_Service_Skill();
    }
    
    public function indexAction() {
        $this->view->list = $this->service->getSchulList();
    }
    
    public function showAction() {
        $this->view->schule = $this->service->getSchuleById($this->getRequest()->getParam('id'));
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
        $this->service->editSchule($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->service->createSchule($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
