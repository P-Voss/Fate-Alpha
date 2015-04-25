<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class CharakterController extends Zend_Controller_Action{
    
    /**
     * @var Application_Service_Charakter
     */
    protected $_charakterService;
    /**
     * @var Application_Service_Layout
     */
    protected $_layoutService;
    /**
     * @var Application_Service_Erstellung
     */
    protected $_erstellungsService;


    public function init() {
        $this->_charakterService = new Application_Service_Charakter();
        $this->_layoutService = new Application_Service_Layout();
        $this->_erstellungsService = new Application_Service_Erstellung();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $this->_charakter = $this->_charakterService->getCharakterByUserid($auth->userId);
            $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction() {
        
    }
    
    public function profilAction() {
        
    }
    
    public function abilitiesAction() {
        
    }
    
    public function inventarAction() {
        
    }
    
    public function erstellungAction() {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $layout = $this->_helper->layout();
        $layout->setLayout('erstellung');
        $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
        $erstellungsService = new Application_Service_Erstellung();
        $this->view->creationParams = $erstellungsService->getCreationParams();
    }
    
    public function createAction() {
        $charakter = $this->_erstellungsService->createCharakter($this->getRequest());
        if($charakter === false){
            $this->redirect('Charakter/Erstellung');
        }
        $this->redirect('Charakter/index');
    }
    
}
