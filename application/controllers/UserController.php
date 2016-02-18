<?php

/**
 * Description of UserController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class UserController extends Zend_Controller_Action {

    protected $_userService;
    protected $_layoutService;
    protected $_charakterService;

    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->_userService = new Application_Service_User();
        $this->_layoutService = new Application_Service_Layout();
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

    public function indexAction(){
        $this->view->user = $this->_userService->getUserById(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
    public function createAction(){
        if($this->getRequest()->isPost()){
            if($this->_userService->createUser($this->getRequest())){
                $this->login();
            }else{
                $this->redirect('login/registrierung');
            }
        }
    }
    
    private function login() {
        $this->_helper->viewRenderer->setnorender(true);
        $this->_helper->layout()->disableLayout();
        if ($this->getRequest()->isPost() AND $this->getRequest()->getPost('loginname') !== '' AND $this->getRequest()->getPost('password') !== '') {
            $this->getRequest()->setPost('username', $this->getRequest()->getPost('loginname'));
            $this->getRequest()->setPost('passwort', $this->getRequest()->getPost('password'));
            $service = new Application_Service_Login();
            $login = $service->login($this->getRequest());
        }
        $this->redirect('index');
    }
    
    public function passwordAction() {
        if($this->getRequest()->getParam('newPw') !== null){
            $this->_userService->changePassword(
                $this->getRequest(),
                Zend_Auth::getInstance()->getIdentity()->userId
            );
            $this->redirect('/user');
        }
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
    }
    
    public function mailAction() {
        if($this->getRequest()->getParam('newMail') !== null){
            $this->_userService->changeEmail(
                $this->getRequest(),
                Zend_Auth::getInstance()->getIdentity()->userId
            );
            $this->redirect('/user');
        }
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
    }
    
    public function charakterAction() {
        if($this->getRequest()->getParam('deleteCharakter') !== null){
            $this->_userService->deleteCharakter(
                $this->getRequest(),
                Zend_Auth::getInstance()->getIdentity()->userId
            );
            $this->redirect('/user');
        }
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
    }
    
    public function accountAction() {
        if($this->getRequest()->getParam('deleteAccount') !== null){
            $this->_userService->deleteAccount(
                $this->getRequest(),
                Zend_Auth::getInstance()->getIdentity()->userId
            );
            $this->redirect('index');
        }
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
    }

}
