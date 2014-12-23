<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class CharakterController extends Zend_Controller_Action{
    
    protected $service;
    
    public function init() {
        $this->service = new Application_Service_Charakter();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $this->view->layoutData = $this->layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction() {
        
    }
    
    public function friendsAction() {
        
    }
    
}
