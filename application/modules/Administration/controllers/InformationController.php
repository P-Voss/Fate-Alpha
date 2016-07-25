<?php

/**
 * Description of Administration_InformationController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_InformationController extends Zend_Controller_Action {

    protected $erstellungService;
    protected $skillService;
    protected $schulService;
    private $informationService;

    public function init(){
        $this->_helper->logincheck();
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->schulService = new Administration_Service_Schule();
        $this->erstellungService = new Administration_Service_Erstellung();
        $this->skillService = new Administration_Service_Skill();
        $this->informationService = new Administration_Service_Information();
    }
    
    public function indexAction() {
        
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
    
    public function createAction() {
        $this->informationService->createInformation($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function updateAction() {
        $this->informationService->editInformation($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
