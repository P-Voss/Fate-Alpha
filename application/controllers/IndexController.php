<?php

class IndexController extends Zend_Controller_Action{

    protected $_userService;
    protected $_layoutService;
    protected $_newsService;
    protected $_charakterService;

    public function init(){
        $this->_userService = new Application_Service_User();
        $this->_layoutService = new Application_Service_Layout();
        $this->_newsService = new Application_Service_News();
        $this->_charakterService = new Application_Service_Charakter();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $layout->setLayout('offline');
        }  else {
            $this->_charakter = $this->_charakterService->getCharakterByUserid($auth->userId);
            $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }

    public function indexAction()
    {
        $this->view->news = $this->_newsService->getNews();
    }
    
    public function testAction(){
        
    }
    
    public function impressumAction() {
        
    }


}

