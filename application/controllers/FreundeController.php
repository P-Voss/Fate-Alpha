<?php

/**
 * Description of UserController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class FreundeController extends Zend_Controller_Action {
    
    /**
     * @var Application_Service_Charakter
     */
    protected $_charakterService;
    /**
     * @var Application_Service_Layout
     */
    protected $_layoutService;
    /**
     *
     * @var Application_Model_Charakter
     */
    protected $_charakter;


    public function init() {
        $this->_charakterService = new Application_Service_Charakter();
        $this->_layoutService = new Application_Service_Layout();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $this->_charakter = $this->_charakterService->getCharakterByUserid($auth->userId);
            $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }

    public function indexAction() {
        $this->view->profile = $this->_charakterService->getProfile($this->_charakter->getCharakterid());
        $this->view->friendlist = $this->_charakterService->getAssociates($this->_charakter->getCharakterid());
    }
    
    public function previewAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper-> viewRenderer-> setNoRender();
        $profile = $this->_charakterService->getVisibleProfile($this->getRequest(), $this->_charakter->getCharakterid());
        Zend_Debug::dump($profile);
        exit;
        echo 'sddsf';
    }
    
    public function addAction() {
        
    }

}
