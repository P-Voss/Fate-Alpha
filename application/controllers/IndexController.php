<?php

class IndexController extends Zend_Controller_Action {

    protected $_newsService;

    public function init(){
        if($this->_helper->logincheck() === false){
//            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->_newsService = new Application_Service_News();
        $this->view->message = '';
        $messages = $this->_helper->flashMessenger->getMessages();
        if(count($messages) > 0){
            $this->view->message = $messages[0];
        }
    }

    public function indexAction()
    {
        $this->view->news = $this->_newsService->getNews();
    }
    
    public function introAction(){
        
    }
    
    public function informationAction() {
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
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
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $service = new Application_Service_Wetter();
        $this->view->forecast = $service->getForecast();
    }
    
}

