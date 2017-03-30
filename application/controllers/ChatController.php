<?php

/**
 * Description of ChatController
 *
 * @author Vosser
 */
class ChatController extends Zend_Controller_Action{
    
    /**
     * @var Application_Model_Charakter
     */
    protected $charakter;
    /**
     * @var Application_Service_Charakter
     */
    protected $charakterService;
    /**
     * @var Application_Service_Layout
     */
    protected $layoutService;
    /**
     * @var Application_Service_Erstellung
     */
    protected $erstellungsService;


    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        $this->layoutService = new Application_Service_Layout();
        $this->erstellungsService = new Application_Service_Erstellung();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null
                || !in_array($auth->userId, [1, 3, 4, 6, 23, 26])){
            $this->redirect('index');
        }  else {
            $this->charakter = $this->charakterService->getCharakterByUserid($auth->userId);
            if($this->charakter !== false){
                $this->charakter->setCharakterprofil($this->charakterService->getProfile($this->charakter->getCharakterid()));
            }
            $this->view->layoutData = $this->layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction() {
        
    }
    
}
