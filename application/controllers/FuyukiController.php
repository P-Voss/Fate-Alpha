<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class FuyukiController extends Zend_Controller_Action{

    /**
     * @var Application_Service_Places
     */
    protected $placesService;


    public function init() {
        $this->placesService = new Application_Service_Places();
        
        $this->_helper->layout()->disableLayout();
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
        echo json_encode($this->placesService->getOrtePreview($this->getRequest()->getPost('name')));
    }
    
    public function stadtteileAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        echo json_encode($this->placesService->getStadtteilePreview($this->getRequest()->getPost('name')));
    }
    
}
