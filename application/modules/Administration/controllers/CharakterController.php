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
        $magieschulen = $magieService->getMagieschulenForCharakter($charakter);
        $schulen = [];
        foreach ($magieschulen as $schule) {
            if ($schule->getLearned()) {
                $schule->setMagien($magieService->getLearnedMagieBySchule($charakter->getCharakterid(), $schule));
                $schulen[] = $schule;
            }
        }
        $this->view->magieschulen = $schulen;

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
