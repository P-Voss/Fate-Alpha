<?php

/**
 * Description of SkillController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_SkillController extends Zend_Controller_Action {
    
    /**
     * @var Application_Model_Charakter;
     */
    private $charakter;
    /**
     * @var Application_Service_Charakter;
     */
    private $charakterService;

    public function init(){
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $this->charakterService = new Application_Service_Charakter();
        $auth = Zend_Auth::getInstance()->getIdentity();
        $this->charakter = $this->charakterService->getCharakterByUserid($auth->userId);
        $this->charakter->setSkills($this->charakterService->getSkills($this->charakter->getCharakterid()));
        if($this->charakter === false){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
    }
    
    public function indexAction() {
        $service = new Shop_Service_Skill();
        $this->view->skillarten = $service->getSkillArtenForCharakter($this->charakter);
    }
    
    public function showAction() {
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
        $service = new Shop_Service_Skill();
        $this->view->skills = $service->getUnlearnedSkillsByArtId($this->charakter, $this->getRequest()->getParam('id'));
    }
    
    public function unlockskillartAction() {
        $service = new Shop_Service_Skill();
        $service->unlockSkillart($this->charakter, $this->getRequest()->getPost('skillartId'));
        $this->redirect('Shop/skill/index');
    }
    
    public function unlockAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $service = new Shop_Service_Skill();
        echo json_encode($service->unlockSkill($this->charakter, $this->getRequest()->getParam('id')));
    }
    
    public function previewAction() {
        $service = new Shop_Service_Skill();
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
//        $this->_helper->viewRenderer->setNoRender(true);
//        $this->_helper->layout()->disableLayout();
//        echo json_encode($service->getSkillById($this->charakter, $this->getRequest()->getParam('id')));
        $this->view->skill = $service->getSkillById($this->charakter, $this->getRequest()->getParam('id'));
    }
    
}
