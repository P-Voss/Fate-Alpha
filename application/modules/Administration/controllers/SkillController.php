<?php

/**
 * Description of SkillController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_SkillController extends Zend_Controller_Action {

    protected $skillService;

    public function init(){
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->skillService = new Administration_Service_Skill();
    }
    
    public function indexAction() {
        $this->view->list = $this->skillService->getSkillList();
    }
    
    public function showAction() {
        $this->view->skill = $this->skillService->getSkillById($this->getRequest()->getParam('id'));
    }
    
    public function newAction() {
        
    }
    
    public function deleteAction() {
        
    }
    
    public function editAction() {
        $this->skillService->editSkill($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
    public function createAction() {
        $this->skillService->createSkill($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        $this->redirect('Administration');
    }
    
}