<?php

/**
 * Description of CharakterController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_CharakterController extends Zend_Controller_Action
{

    /**
     * @var Administration_Service_Charakter
     */
    private $charakterService;


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
        $this->charakterService = new Administration_Service_Charakter();
    }

    public function indexAction ()
    {
        $this->view->charakters = $this->charakterService->getCharakters();
    }


    public function showAction ()
    {
        $charakter = $this->charakterService->getCharakterById($this->getRequest()->getParam('charakter', 0));
        $this->view->charakter = $charakter;

        $informationService = new Erstellung_Service_Information();
        $this->view->creationParams = $informationService->getCreationParams();

        $magieService = new Shop_Service_Magie();
        $this->view->magieschulen = $magieService->getSchoolsByCharacter($charakter->getCharakterid());
        $this->view->schoolsToChoose = $magieService->getSchoolByOrganization($charakter->getMagiOrganization());
        $this->view->magien = $charakter->getMagien();

        $skillService = new Shop_Service_Skill();
        $skillarten = $skillService->getSkillArtenForCharakter($charakter);
        foreach ($skillarten as $skillart) {
            if (!$skillart->getLearned()) {
                unset($skillart);
            } else {
                $skillart->setSkills($skillService->getLearnedSkillBySkillart($charakter->getCharakterid(), $skillart));
            }
        }
        $this->view->skillarten = $skillarten;

        $traitMapper = new Administration_Model_Mapper_TraitMapper();
        $this->view->individualTraits = $traitMapper->getIndividualTraits();
        $this->view->characterTraits = $traitMapper->getIndividualTraitsByCharacter($charakter->getCharakterid());

        $informationMapper = new Administration_Model_Mapper_InformationMapper();
        $this->view->informations = $informationMapper->getAllInformations();
        $this->view->characterInformations = $informationMapper->getCharacterInformation($charakter->getCharakterid());
    }

    public function traitsAction ()
    {
        if (!(int) $this->getRequest()->getPost('characterId', 0) > 0) {
            $this->redirect('Administration/charakter/show/charakter/' . $this->getRequest()->getPost('charakterId'));
        }
        $traitMapper = new Administration_Model_Mapper_TraitMapper();
        $traitMapper->removeIndividualTraitsFromCharacter($this->getRequest()->getPost('characterId'));
        foreach ($this->getRequest()->getPost('traitIds', []) as $traitId) {
            $traitMapper->addTraitToCharacter($traitId, (int) $this->getRequest()->getPost('characterId'));
        }
        $this->redirect('Administration/charakter/show/charakter/' . $this->getRequest()->getPost('characterId'));
    }

    public function informationsAction ()
    {
        if (!(int) $this->getRequest()->getPost('characterId', 0) > 0) {
            $this->redirect('Administration/charakter/show/charakter/' . $this->getRequest()->getPost('charakterId'));
        }
        $informationMapper = new Administration_Model_Mapper_InformationMapper();
        $informationMapper->removeCharacterInformation($this->getRequest()->getPost('characterId'));
        foreach ($this->getRequest()->getPost('infoIds', []) as $infoId) {
            $informationMapper->addCharacterInformation($infoId, (int) $this->getRequest()->getPost('characterId'));
        }
        $this->redirect('Administration/charakter/show/charakter/' . $this->getRequest()->getPost('characterId'));
    }


    public function editdataAction ()
    {
        if ($this->getRequest()->getParam('charakterId') === null) {
            $this->redirect('index');
        }
        $this->charakterService->saveCharakterData($this->getRequest());
        $this->redirect('Administration/charakter/show/charakter/' . $this->getRequest()->getPost('charakterId'));
    }


    public function editstatsAction ()
    {
        if ($this->getRequest()->getParam('charakterId') === null) {
            $this->redirect('index');
        }
        $this->charakterService->saveCharakterWerte($this->getRequest());
        $this->redirect('Administration/charakter/show/charakter/' . $this->getRequest()->getPost('charakterId'));
    }


    public function birthdaysAction ()
    {
        $this->view->charakters = $this->charakterService->getCharaktersByNextBirthdays();
    }

}
