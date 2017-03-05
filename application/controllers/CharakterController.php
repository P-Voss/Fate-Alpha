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
     * @var Application_Service_Erstellung
     */
    protected $erstellungsService;


    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        $this->layoutService = new Application_Service_Layout();
        $this->erstellungsService = new Application_Service_Erstellung();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $this->charakter = $this->charakterService->getCharakterByUserid($auth->userId);
            if($this->charakter !== false){
                $this->charakter->setCharakterprofil($this->charakterService->getProfile($this->charakter->getCharakterid()));
            }
            $this->view->layoutData = $this->layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction() {
        if($this->charakter === false){
            $this->redirect('Erstellung/Charakter');
        }
        $this->view->charakter = $this->charakter;
    }
    
    public function profilAction() {
        if($this->charakter === false){
            $this->redirect('Erstellung/Charakter');
        }
        $this->view->charakter = $this->charakter;
    }
    
    public function abilitiesAction() {
        if($this->charakter === false){
            $this->redirect('Erstellung/Charakter');
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
    
    public function inventarAction() {
        if($this->charakter === false){
            $this->redirect('Erstellung/Charakter');
        }
        $this->view->charakter = $this->charakter;
    }
    
    public function erstellungAction() {
        $this->redirect('Erstellung/Charakter');
        $layout = $this->_helper->layout();
        $layout->setLayout('erstellung');
        $this->view->creationParams = $this->erstellungsService->getCreationParams();
    }
    
    public function mapAction() {
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
    }
    
    public function createAction() {
        $charakter = $this->erstellungsService->createCharakter($this->getRequest());
        if($charakter === false){
            $this->redirect('charakter/erstellung');
        }
        $this->redirect('charakter/index');
    }
    
    public function charpicAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveCharpic($this->charakter, $this->getRequest());
        $this->redirect('charakter/index');
    }
    
    public function profilpicAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveProfilpic($this->charakter, $this->getRequest());
        $this->redirect('charakter/index');
    }
    
    public function storyAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->saveStory($this->charakter, $this->getRequest());
    }
    
    public function privateAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->charakterService->savePrivate($this->charakter, $this->getRequest());
    }
    
    public function bonusAction() {
        if($this->charakter->getCharakterwerte()->getStartpunkte() <= 0){
            $this->redirect('charakter');
        }
        $service = new Application_Service_Training();
        $this->view->trainingswerte = $service->getTrainingswerte($this->charakter);
        $this->view->charakter = $this->charakter;
    }
    
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
    
    public function bonustrainingAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        if(!in_array($this->getRequest()->getParam('attribute'), array('staerke', 'agilitaet', 'ausdauer', 'disziplin', 'kontrolle'))
                ||
            (int)$this->getRequest()->getParam('days') <= 0){
            echo json_encode(array(
                'success' => false,
                'html' => '',
            ));
        }
        $service = new Application_Service_Training();
        $service->addBonusTraining($this->charakter, (int)$this->getRequest()->getParam('days'), $this->getRequest()->getParam('attribute'));
        $this->view->charakter = $this->charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->userId);
        $this->view->trainingswerte = $service->getTrainingswerte($this->charakter);
        $html = $this->view->render('charakter/bonustraining.phtml');
        echo json_encode(array(
            'success' => true, 
            'html' => $html,
        ));
    }
    
}
