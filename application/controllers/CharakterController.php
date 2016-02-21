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
            $this->redirect('charakter/erstellung');
        }
        $this->view->charakter = $this->charakter;
    }
    
    public function profilAction() {
        if($this->charakter === false){
            $this->redirect('charakter/erstellung');
        }
        $this->view->charakter = $this->charakter;
    }
    
    public function abilitiesAction() {
        if($this->charakter === false){
            $this->redirect('charakter/erstellung');
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
    }
    
    public function inventarAction() {
        if($this->charakter === false){
            $this->redirect('charakter/erstellung');
        }
    }
    
    public function erstellungAction() {
        $this->redirect('index');
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
    
}
