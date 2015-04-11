<?php

/**
 * Description of UserController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class UserController extends Zend_Controller_Action {

    protected $_userService;
    protected $_layoutService;

    public function init(){
        $this->_userService = new Application_Service_User();
        $this->_layoutService = new Application_Service_Layout();
        
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
        
    }
    
    public function createAction(){
        if($this->getRequest()->isPost()){
            if($this->_userService->createUser($this->getRequest())){
                $this->redirect('index');
            }else{
                $this->redirect('login/registrierung');
            }
        }
    }

}
