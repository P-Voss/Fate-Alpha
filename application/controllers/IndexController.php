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
    
    public function informationAction() {
        $informationService = new Application_Service_Information();
        $information = $informationService->getInformation($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        if($information !== false){
            $this->view->information = $information;
        } else {
            $this->_redirect('index');
        }
    }
    
    public function impressumAction() {
        
    }
    
    public function newsAction() {
        
    }
    
    public function wetterAction() {
        $service = new Application_Service_Wetter();
        $this->view->forecast = $service->getForecast();
    }
    
}

