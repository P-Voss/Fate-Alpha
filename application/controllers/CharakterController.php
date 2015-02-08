<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class CharakterController extends Zend_Controller_Action{
    
    protected $_charakterService;
    protected $_layoutService;
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
            $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction() {
//        Zend_Debug::dump($this->_charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->ID));
//        exit;
        $this->view->charakter = $this->_charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->ID);
    }
    
    public function profilAction() {
        
    }
    
    public function abilitiesAction() {
        
    }
    
    public function inventarAction() {
        
    }
    
    public function friendsAction() {
        
    }
    
    public function erstellungAction() {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $layout = $this->_helper->layout();
        $layout->setLayout('empty');
        $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
        $erstellungsService = new Application_Service_Erstellung();
        $this->view->creationParams = $erstellungsService->getCreationParams();
    }
    
    public function createAction() {
        $this->_erstellungService = new Application_Service_Erstellung();
        if(!$this->_erstellungService->createCharakter($this->getRequest())){
            $this->redirect('Charakter/Erstellung');
        }
        $this->redirect('Charakter/index');
    }
    
}
