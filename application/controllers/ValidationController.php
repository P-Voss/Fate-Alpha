<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class ValidationController extends Zend_Controller_Action{
    
    protected $_charakterService;
    protected $_layoutService;
    
    public function init() {
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $layout->disableLayout();
        }
    }
    
    public function ajaxAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $validationService = new Application_Service_Validation();
        echo $validationService->validateByRequest($this->getRequest());
    }
    
}
