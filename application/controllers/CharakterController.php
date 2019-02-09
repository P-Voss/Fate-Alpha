<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class CharakterController extends Zend_Controller_Action{
    
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
     * @throws Zend_Db_Statement_Exception
     */
    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        $this->layoutService = new Application_Service_Layout();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $this->charakter = $this->initCharakter($auth->userId);
            if($this->charakter !== false){
                $this->charakter->setCharakterprofil($this->charakterService->getProfile($this->charakter->getCharakterid()));
            }
            $this->view->layoutData = $this->layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }

    /**
     *
     */
    public function indexAction() {
        if($this->charakter === false){
            $this->redirect('Erstellung/creation');
        }
        $this->view->charakter = $this->charakter;
    }

    /**
     *
     */
    public function profilAction() {
        if($this->charakter === false){
            $this->redirect('Erstellung/creation');
        }
        $this->view->charakter = $this->charakter;
    }

    /**
     *
     */
    public function abilitiesAction() {
        if($this->charakter === false){
            $this->redirect('Erstellung/creation');
        }
        $magieService = new Shop_Service_Magie();
        $magieschulen = $magieService->getMagieschulenForCharakter($this->charakter);
        $schulen = array();
        foreach ($magieschulen as $schule){
            if($schule->getLearned() === true){
                $schule->setMagien($magieService->getLearnedMagieBySchule($this->charakter->getCharakterid(), $schule));
                $schulen[] = $schule;
            }
        }
        $this->view->magieschulen = $schulen;
        
        $skillService = new Shop_Service_Skill();
        $skillarten = $skillService->getSkillArtenForCharakter($this->charakter);
        foreach ($skillarten as $skillart) {
            if($skillart->getLearned() === false){
                unset($skillart);
            }else{
                $skillart->setSkills($skillService->getLearnedSkillBySkillart($this->charakter->getCharakterid(), $skillart));
            }
        }
        $this->view->skillarten = $skillarten;
        $this->view->charakter = $this->charakter;
    }

    /**
     *
     */
    public function inventarAction() {
        if($this->charakter === false){
            $this->redirect('Erstellung/creation');
        }
        $this->view->charakter = $this->charakter;
    }
    /**
     * @throws Exception
     */
    public function charpicAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveCharpic($this->charakter, $this->getRequest());
        $this->redirect('charakter/index');
    }

    /**
     * @throws Exception
     */
    public function profilpicAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveProfilpic($this->charakter, $this->getRequest());
        $this->redirect('charakter/index');
    }

    /**
     *
     */
    public function storyAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveStory($this->charakter, $this->getRequest());
    }

    /**
     *
     */
    public function privateAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->savePrivate($this->charakter, $this->getRequest());
    }

    /**
     * @todo Auf neues Trainingssystem umstellen
     *
     * @throws Exception
     */
    public function bonusAction() {
        if($this->charakter->getCharakterwerte()->getStartpunkte() <= 0){
            $this->redirect('charakter');
        }
        $this->view->accessKey = Zend_Auth::getInstance()->getIdentity()->accessKey;
        $this->view->charakter = $this->charakter;
    }

    /**
     * @throws Exception
     */
    public function trainingpreviewAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $attributes = [
            'staerke' => 'str',
            'agilitaet' => 'agi',
            'ausdauer' => 'aus',
            'disziplin' => 'dis',
            'kontrolle' => 'kon',
        ];
        if(!array_key_exists($this->getRequest()->getParam('attribute'), $attributes)
                ||
            (int)$this->getRequest()->getParam('days') < 0){
            echo json_encode(array(
                'success' => false,
                'wert' => '',
                'kategorie' => '',
            ));
        }
        
        $service = new Application_Service_Training();
        $trainingswerte = $service->getTrainingswerte($this->charakter);
        $werte = $this->charakter->getCharakterwerte();
        
        for($i = 0; $i < (int)$this->getRequest()->getParam('days') && $i < $werte->getStartpunkte(); $i++){
            $werte->addTraining(array('training' => $this->getRequest()->getParam('attribute')), $trainingswerte);
        }
        
        $category = $werte->getCategory($attributes[$this->getRequest()->getParam('attribute')])->getCategory();
        $function = "get" . ucfirst($this->getRequest()->getParam('attribute'));
        $wert = $werte->$function();
        
        echo json_encode(array(
            'success' => true,
            'wert' => $wert,
            'kategorie' => $category,
        ));
        
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
                    'error' => 'Auth Error'
                ]
            );
            exit;
        }

        try {
            $charakter = $this->charakterService->getCharakterByAccessKey($this->getRequest()->getParam('key'));
            echo json_encode(
                [
                    'success' => true,
                    'attributes' => $charakter->getCharakterwerte()->toArray()
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
                'data' => $this->charakter->getCharakterwerte()->toArray()
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
    private function initCharakter($userId) {
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
                ->setVermoegen()
                ->setWerte();
            return $charakterBuilder->getCharakter();
        } else {
            return false;
        }
    }
    
}
