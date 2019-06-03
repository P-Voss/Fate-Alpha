<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class CharakterController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_Charakter
     */
    protected $charakter;
    /**
     * @var Application_Service_Charakter
     */
    protected $charakterService;
    /**
     * @var Application_Service_Layout
     */
    protected $layoutService;


    /**
     */
    public function init ()
    {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        $this->layoutService = new Application_Service_Layout();

        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if ($auth === null) {
            $this->redirect('index');
        } else {
            try {
                $this->charakter = $this->charakterService->getCharakterByUserid($auth->userId);
                $this->view->layoutData = $this->layoutService->getLayoutData($auth);
                $layout->setLayout('online');
            } catch (Throwable $exception) {
                $this->redirect('Erstellung/creation');
            }
        }
    }

    /**
     *
     */
    public function indexAction ()
    {
        if ($this->charakter === false) {
            $this->redirect('Erstellung/creation');
        }
        $this->view->charakter = $this->charakter;
    }

    /**
     *
     */
    public function profilAction ()
    {
        if ($this->charakter === false) {
            $this->redirect('Erstellung/creation');
        }
        $this->view->charakter = $this->charakter;
    }

    /**
     *
     */
    public function abilitiesAction ()
    {
        if ($this->charakter === false) {
            $this->redirect('Erstellung/creation');
        }
        $magieService = new Shop_Service_Magie();
        $this->view->magieschulen = $magieService->getSchoolsByCharacter($this->charakter->getCharakterid());
        $this->view->magien = $this->charakter->getMagien();

        $skillService = new Shop_Service_Skill();
        $skillarten = $skillService->getSkillArtenForCharakter($this->charakter);
        foreach ($skillarten as $skillart) {
            if ($skillart->getLearned() === false) {
                unset($skillart);
            } else {
                $skillart->setSkills($skillService->getLearnedSkillBySkillart($this->charakter->getCharakterid(), $skillart));
            }
        }
        $this->view->skillarten = $skillarten;
        $this->view->charakter = $this->charakter;
    }

    /**
     *
     */
    public function inventarAction ()
    {
        if ($this->charakter === false) {
            $this->redirect('Erstellung/creation');
        }
        $this->view->charakter = $this->charakter;
    }

    /**
     * @throws Exception
     */
    public function charpicAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveCharpic($this->charakter, $this->getRequest());
        $this->redirect('charakter/profil');
    }

    /**
     * @throws Exception
     */
    public function profilpicAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveProfilpic($this->charakter, $this->getRequest());
        $this->redirect('charakter/profil');
    }

    /**
     *
     */
    public function storyAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveStory($this->charakter, $this->getRequest());
        $this->redirect('charakter/profil');
    }

    /**
     *
     */
    public function privateAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->savePrivate($this->charakter, $this->getRequest());
        $this->redirect('charakter/profil');
    }

    /**
     * @throws Exception
     */
    public function bonusAction ()
    {
        if ($this->charakter->getCharakterwerte()->getStartpunkte() <= 0) {
            $this->redirect('charakter');
        }
        $this->view->accessKey = Zend_Auth::getInstance()->getIdentity()->accessKey;
        $this->view->charakter = $this->charakter;
    }

    public function attributesAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();

        if ($this->getRequest()->getParam('key', '') === '') {
            echo json_encode(
                [
                    'success' => false,
                    'error' => 'Auth Error',
                ]
            );
            exit;
        }

        try {
            $charakter = $this->charakterService->getCharakterByAccessKey($this->getRequest()->getParam('key'));
            echo json_encode(
                [
                    'success' => true,
                    'attributes' => $charakter->getCharakterwerte()->toArray(),
                ]
            );
        } catch (Throwable $exception) {
            echo json_encode([]);
            exit;
        }
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        echo json_encode(
            [
                'success' => true,
                'data' => $this->charakter->getCharakterwerte()->toArray(),
            ]
        );
        exit;
    }


    public function traitsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $trait = new Application_Model_Trait();
        $trait->setStoryType($this->getRequest()->getPost('storyType', 0));
        $trait->setStory($this->getRequest()->getPost('story', ''));
        $trait->setTraitId($this->getRequest()->getPost('traitId', 0));
        $this->charakterService->updateTraitStory($trait, $this->charakter->getCharakterid());
        $this->redirect('charakter/profil');
    }

    /**
     * @param $userId
     *
     * @return Application_Model_Charakter|bool
     * @throws Zend_Db_Statement_Exception
     * @throws Exception
     */
    private function initCharakter ($userId)
    {
        $charakterBuilder = new Application_Service_CharakterBuilder();
        if ($charakterBuilder->initCharakterByUserId($userId)) {
            $charakterBuilder
                ->setTraits()
                ->setCircuit()
                ->setNaturelement()
                ->setClassData()
                ->setLuck()
                ->setMagien()
                ->setMagieschulen()
                ->setOdo()
                ->setProfile()
                ->setSkills()
                ->setItems()
                ->setVermoegen()
                ->setWerte();
            return $charakterBuilder->getCharakter();
        } else {
            return false;
        }
    }

}
