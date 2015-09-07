<?php

class IndexController extends Zend_Controller_Action {

    protected $_newsService;

    public function init(){
        $this->_helper->logincheck();
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->_newsService = new Application_Service_News();
    }

    public function indexAction()
    {
        $this->view->news = $this->_newsService->getNews();
    }
    
    public function introAction(){
        
    }
    
    public function impressumAction() {
        
    }


}

