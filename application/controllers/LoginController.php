<?php

class LoginController extends Zend_Controller_Action
{

    protected $service;


    public function init()
    {
        $this->service = new Application_Service_Login();
        $layout = $this->_helper->layout();
        $layout->setLayout('offline');
    }

    public function indexAction()
    {
        
    }

    public function loginAction() {
        if ($this->getRequest()->isPost()) {
            $login = $this->service->login($this->getRequest());
            if ($login === true) {
                $this->_redirect('index/index');
            } else {
                $this->view->fehlermeldung = $login;
            }
        }
    }
    
    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->redirect('index');
    }

    public function passwortAction()
    {
        Zend_Debug::dump($this->getRequest());exit;
        // action body
    }
    
    public function registrierungAction() {
        
    }
    
}





