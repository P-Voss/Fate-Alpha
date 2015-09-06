<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class CharakterController extends Zend_Controller_Action{
    
    /**
     * @var Application_Model_Charakter
     */
    protected $_charakter;
    /**
     * @var Application_Service_Charakter
     */
    protected $_charakterService;
    /**
     * @var Application_Service_Layout
     */
    protected $_layoutService;
    /**
     * @var Application_Service_Erstellung
     */
    protected $_erstellungsService;


    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->_charakterService = new Application_Service_Charakter();
        $this->_layoutService = new Application_Service_Layout();
        $this->_erstellungsService = new Application_Service_Erstellung();
        
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
        if($this->_charakter === false){
            $this->redirect('charakter/erstellung');
        }
    }
    
    public function profilAction() {
        if($this->_charakter === false){
            $this->redirect('charakter/erstellung');
        }
    }
    
    public function abilitiesAction() {
        if($this->_charakter === false){
            $this->redirect('charakter/erstellung');
        }
    }
    
    public function inventarAction() {
        if($this->_charakter === false){
            $this->redirect('charakter/erstellung');
        }
    }
    
    public function erstellungAction() {
        $layout = $this->_helper->layout();
        $layout->setLayout('erstellung');
        $this->view->creationParams = $this->_erstellungsService->getCreationParams();
    }
    
    public function mapAction() {
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
    }
    
    public function createAction() {
        $charakter = $this->_erstellungsService->createCharakter($this->getRequest());
        if($charakter === false){
            $this->redirect('charakter/erstellung');
        }
        $this->redirect('charakter/index');
    }
    
}
