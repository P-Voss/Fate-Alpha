<?php

class LoginController extends Zend_Controller_Action
{

    /**
     * @var Application_Service_Login
     */
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
            $this->service->login($this->getRequest());
        }
        $this->redirect('index');
    }
    
    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->redirect('index');
    }

    public function passwortAction() {
        
    }
    
    public function newpwAction() {
        $this->_helper->viewRenderer->setnorender(true);
        $this->_helper->layout()->disableLayout();
        try {
            $userId = $this->service->getUserIdByUsernameAndEmail($this->getRequest()->getPost('loginname'), $this->getRequest()->getPost('email'));
            try {
                $password = $this->service->resetPassword($userId);
                $this->service->sendPassword($this->getRequest()->getPost('email'), $password);
                $this->initFlashMessage("Eine Email mit dem neuen Passwort wurde verschickt.");
                $this->redirect('index');
            } catch (Exception $exception) {
                $this->initFlashMessage("Es trat ein Fehler beim Versenden des neuen Passworts auf.");
                $this->redirect('index');
            }
        } catch (Exception $exception) {
            $this->initFlashMessage("Zu dieser Email und dem Usernamen gibt es keinen Account");
            $this->redirect('index');
        }
    }
    
    private function initFlashMessage ($message){
        $flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $flashMessenger->addMessage($message);
    }
    
    public function registrierungAction() {
        
    }
    
}





