<?php

class IndexController extends Zend_Controller_Action{

    protected $userService;
    protected $layoutService;
    protected $newsService;

    public function init(){
        $this->userService = new Application_Service_User();
        $this->layoutService = new Application_Service_Layout();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $layout->setLayout('offline');
        }  else {
            $this->view->layoutData = $this->layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }

    public function indexAction()
    {
        $this->newsService = new Application_Service_News();
        $this->view->news = $this->newsService->getNews();
    }
    
    public function testAction(){
        
    }
    
    public function impressumAction() {
        
    }


}

