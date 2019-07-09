<?php

/**
 * Description of Administration_ItemController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_ItemController extends Zend_Controller_Action {

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
    /**
     * @var Administration_Service_Items
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
        $this->service = new Administration_Service_Items();
        $this->erstellungService = new Administration_Service_Erstellung();
        $this->skillService = new Administration_Service_Skill();
        $this->schulService = new Administration_Service_Schule();
    }
    
    public function indexAction() {
        $this->view->items = $this->service->getItemList();
    }
    
    public function showAction() {
        try {
            $this->view->item = $this->service->getItemById($this->getRequest()->getParam('id', ''));
        } catch (Exception $exception) {
            $this->redirect('Administration/item');
        }
        $characterService = new Administration_Service_Charakter();
        $this->view->characters = $characterService->getCharakters();

        $this->view->magien = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $this->view->traits = $this->erstellungService->getTraits();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }
    
    public function newAction() {
        $characterService = new Administration_Service_Charakter();
        $this->view->characters = $characterService->getCharakters();

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

    /**
     *
     */
    public function editAction() {
        $this->service->editItem($this->getRequest());
        $this->redirect('Administration');
    }

    /**
     * @throws Exception
     */
    public function createAction() {
        $this->service->createItem($this->getRequest());
        $this->redirect('Administration');
    }
    
}
