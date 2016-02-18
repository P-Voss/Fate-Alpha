<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class FuyukiController extends Zend_Controller_Action{
    
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
        $this->charakterService = new Application_Service_Charakter();
        $this->layoutService = new Application_Service_Layout();
        $this->erstellungsService = new Application_Service_Erstellung();
        
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }
    }
    
    public function mapAction() {
        $layout = $this->_helper->layout();
        $layout->setLayout('partials');
    }
    
    public function orteAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_erstellungService = new Application_Service_Erstellung();
        echo json_encode($this->_erstellungService->getOrtePreview($this->getRequest()));
    }
    
    public function stadtteileAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_erstellungService = new Application_Service_Erstellung();
        echo json_encode($this->_erstellungService->getStadtteilePreview($this->getRequest()));
    }
    
}
