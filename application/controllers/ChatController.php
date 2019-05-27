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


    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        $this->layoutService = new Application_Service_Layout();

        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null) {
            $this->redirect('index');
        }  else {
            try {
                $this->charakter = $this->charakterService->getCharakterByUserid($auth->userId);
            } catch (Exception $exception) {

            }
            $this->view->layoutData = $this->layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction() {
        
    }
    
}
