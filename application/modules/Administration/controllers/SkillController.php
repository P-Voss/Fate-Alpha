<?php

/**
 * Description of SkillController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_SkillController extends Zend_Controller_Action {

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
        $this->view->list = $this->skillService->getSkillList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function rpgAction() {
        $this->view->list = $this->skillService->getRpgSkillList();
    }
    
    public function showAction() {
        $characterService = new Administration_Service_Charakter();
        $this->view->characters = $characterService->getCharakters();

        $this->view->skill = $this->skillService->getSkillById((int) $this->getRequest()->getParam('id'));
        $this->view->magien = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $traitService = new Administration_Service_Trait();
        $this->view->traits = $traitService->getTraits();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function newAction() {
        $characterService = new Administration_Service_Charakter();
        $this->view->characters = $characterService->getCharakters();

        $this->view->skills = $this->skillService->getSkillList();
        $this->view->magien = $this->skillService->getMagieList();
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
        $this->skillService->editSkill($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->skillService->createSkill($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function filterAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->view->list = $this->skillService->getFilteredSkillList($this->getRequest());
        $html = $this->view->render('skill/list.phtml');
        echo json_encode(['success' => true, 'html' => $html]);
    }
    
}
