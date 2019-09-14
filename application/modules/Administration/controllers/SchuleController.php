<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_SchuleController extends Zend_Controller_Action {

    /**
     * @var Administration_Service_Erstellung
     */
    protected $erstellungService;
    /**
     * @var Administration_Service_Skill
     */
    protected $skillService;
    /**
     * @var Administration_Service_Schule
     */
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
        $this->view->list = $this->schulService->getSchulList();
    }
    
    public function showAction() {
        $this->view->schule = $this->schulService->getSchuleById($this->getRequest()->getParam('id'));
        $this->view->magieList = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $traitService = new Administration_Service_Trait();
        $this->view->traits = $traitService->getTraits();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function newAction() {
        $this->view->magieList = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $traitService = new Administration_Service_Trait();
        $this->view->traits = $traitService->getTraits();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function deleteAction() {
        
    }
    
    public function editAction() {
        $this->schulService->editSchule($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->schulService->createSchule($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}
