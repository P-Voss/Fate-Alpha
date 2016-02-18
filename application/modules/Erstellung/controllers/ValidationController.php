<?php

/**
 * Description of ValidationController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_ValidationController extends Zend_Controller_Action{
    
    protected $_charakterService;
    protected $_erstellungService;
    protected $_layoutService;
    protected $_validationService;

    public function init() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }
    }
    
    public function namevalidationAction() {
        $this->_validationService = new Application_Service_Validation();
        echo $this->_validationService->validateByRequest($this->getRequest());
    }
    
    public function infoAction() {
        $this->_erstellungService = new Application_Service_Erstellung();
        echo $this->_erstellungService->getCharakteristics($this->getRequest());
    }
    
    public function classAction() {
        $this->_erstellungService = new Application_Service_Erstellung();
        echo $this->_erstellungService->getKlassengruppe($this->getRequest());
    }
    
}
