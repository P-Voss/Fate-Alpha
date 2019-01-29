<?php

/**
 * Description of Administration_InformationController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_InformationController extends Zend_Controller_Action
{

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
     * @var Administration_Service_Information
     */
    private $informationService;
    /**
     * @var array
     */
    private $kategorien = [
        'Charakter', 'Regeln', 'Welt', 'Fähigkeiten', 'Magien', 'Familien', 'Clans', 'Magi', 'Menschen', 'Spiel',
        'Orte', 'Geschichte',
    ];


    public function init ()
    {
        if ($this->_helper->logincheck() === false) {
            $this->redirect('index');
        }
        if (!$this->_helper->admincheck()) {
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->schulService = new Administration_Service_Schule();
        $this->erstellungService = new Administration_Service_Erstellung();
        $this->skillService = new Administration_Service_Skill();
        $this->informationService = new Administration_Service_Information();
    }

    public function indexAction ()
    {
        $this->view->list = $this->informationService->getInformationList();
    }

    public function showAction ()
    {
        $this->view->kategorien = $this->kategorien;
        $this->view->information = $this->informationService->getInformationById($this->getRequest()->getParam('id'));
        $this->view->magien = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $this->view->traits = $this->erstellungService->getTraits();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }

    public function newAction ()
    {
        $this->view->kategorien = $this->kategorien;
        $this->view->magien = $this->skillService->getMagieList();
        $this->view->schulen = $this->schulService->getSchulList();
        $this->view->elemente = $this->erstellungService->getElementList();
        $this->view->klassengruppen = $this->erstellungService->getKlassengruppenList();
        $this->view->traits = $this->erstellungService->getTraits();
        $this->view->skills = $this->skillService->getSkillList();
        $this->view->klassen = $this->erstellungService->getKlassenList();
    }

    public function deleteAction ()
    {

    }

    public function createAction ()
    {
        $this->informationService->createInformation($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }

    public function editAction ()
    {
        $this->informationService->editInformation($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }

}
