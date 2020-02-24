<?php

use Shop\Services\Character;
use Shop\Services\Skill;

/**
 * Description of SkillController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_SkillController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_Charakter;
     */
    private $charakter;
    /**
     * @var Character;
     */
    private $characterService;

    public function init ()
    {
        if (!$this->_helper->logincheck()) {
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->characterService = new Character();

        $auth = Zend_Auth::getInstance()->getIdentity();
        try {
            $this->charakter = $this->characterService->getCharakterByUserid($auth->userId);
            $this->view->charakter = $this->charakter;
        } catch (Exception $exception) {
            $this->redirect('index/index');
        }
    }

    public function indexAction ()
    {
        $service = new Skill();
        $this->view->skillarten = $service->getSkillArtenForCharakter($this->charakter);
    }

    public function showAction ()
    {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $service = new Skill();
        $this->view->skills = $service->getUnlearnedSkillsByArtId($this->charakter, $this->getRequest()->getParam('id'));
        $html = $this->view->render('skill/show.phtml');
        echo json_encode(['html' => $html]);
    }

    public function unlockAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $service = new Skill();
        echo json_encode($service->unlockSkill($this->charakter, $this->getRequest()->getParam('id')));
    }

    public function previewAction ()
    {
        $service = new Skill();
        $skill = $service->getSkillById($this->charakter, $this->getRequest()->getParam('id'));
        if ($this->getRequest()->getParam('tooltip') !== null) {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            echo json_encode($skill);
        } else {
            $layout = $this->_helper->layout();
            $layout->setLayout('partials');
            $this->view->skill = $skill;
        }
    }

}
