<?php

class LoginController extends Zend_Controller_Action
{

    protected $service;


    public function init()
    {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->service = new Application_Service_Login();
        $layout = $this->_helper->layout();
        $layout->setLayout('offline');
        $this->view->message = '';
        $messages = $this->_helper->flashMessenger->getMessages();
        if(count($messages) > 0){
            $this->view->message = $messages[0];
        }
    }

    public function indexAction()
    {
        
    }

    public function loginAction() {
        $this->_helper->viewRenderer->setnorender(true);
        $this->_helper->layout()->disableLayout();
        if ($this->getRequest()->isPost() AND $this->getRequest()->getPost('username') !== '' AND $this->getRequest()->getPost('passwort') !== '') {
            $login = $this->service->login($this->getRequest());
            $this->_redirect('index');
        }  else {
            $this->redirect('index');
        }
    }
    
    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->redirect('index');
    }

    public function passwortAction() {
        
    }
    
    public function registrierungAction() {
        
    }
    
}





