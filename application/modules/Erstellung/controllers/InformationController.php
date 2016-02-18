<?php

/**
 * Description of InformationController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_InformationController extends Zend_Controller_Action{
    
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
    
    public function infoAction() {
        $this->_erstellungService = new Application_Service_Erstellung();
        echo $this->_erstellungService->getCharakteristics($this->getRequest());
    }
    
    public function classAction() {
        $this->_erstellungService = new Application_Service_Erstellung();
        echo $this->_erstellungService->getKlassengruppe($this->getRequest());
    }
    
}
