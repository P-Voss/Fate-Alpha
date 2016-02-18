<?php

/**
 * Description of CharakterController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_CharakterController extends Zend_Controller_Action {
    
    /**
     * @var Application_Service_Charakter 
     */
    private $charakterService;
    /**
     * @var Erstellung_Service_Erstellung 
     */
    private $erstellungService;
    /**
     * @var Erstellung_Service_Information
     */
    private $informationService;

    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        $this->layoutService = new Application_Service_Layout();
//        $this->erstellungsService = new Application_Service_Erstellung();
        
        $this->erstellungService = new Erstellung_Service_Erstellung();
        $this->informationService = new Erstellung_Service_Information();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $this->charakter = $this->charakterService->getCharakterByUserid($auth->userId);
            $layout = $this->_helper->layout();
            $layout->setLayout('erstellung');
        }
    }
    
    public function indexAction() {
        $this->redirect('Erstellung/Charakter/person');
    }
    
    public function personAction() {
        
    }
    
    public function klasseAction() {
        $this->erstellungService->savePersonaldata($this->getRequest());
        $this->view->Klassengruppen = $this->informationService->getKlassengruppen();
    }
    
    public function vorteilAction() {
        
    }
    
    public function nachteilAction() {
        
    }
    
    public function unterklasseAction() {
        
    }
    
    public function detailsAction() {
        
    }
    
}
