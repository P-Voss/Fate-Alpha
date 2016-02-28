<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class Erstellung_ErstellungController extends Zend_Controller_Action{
    
    protected $charakterService;
    protected $erstellungService;
    protected $validationService;

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $layout->disableLayout();
        }
        $this->validationService = new Erstellung_Service_Validation();
        $this->charakterService = new Erstellung_Service_Charakter();
        $this->erstellungService = new Erstellung_Service_Erstellung();
    }
    
    public function personAction() {
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if($charakter === false){
            echo json_encode($this->erstellungService->savePersonaldata($this->getRequest()));
        }else{
            echo json_encode($this->erstellungService->updatePersonaldata($this->getRequest(), $charakter->getCharakterid()));
        }
    }
    
    public function klasseAction() {
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if($charakter !== false){
            echo json_encode($this->erstellungService->setKlasse($this->getRequest(), $charakter));
        }else{
            echo json_encode(array('success' => false, 'errors' => array('kein Charakter vorhanden')));
        }
    }
    
    public function eigenschaftenAction() {
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if($charakter !== false){
            echo json_encode($this->erstellungService->setEigenschaften($this->getRequest(), $charakter));
        }else{
            echo json_encode(array('success' => false, 'errors' => array('kein Charakter vorhanden')));
        }
    }
    
    public function vorteilAction() {
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if($charakter !== false){
            echo json_encode($this->erstellungService->addVorteil($this->getRequest(), $charakter));
        }else{
            echo json_encode(array('success' => false, 'errors' => array('kein Charakter vorhanden')));
        }
    }
    
    public function nachteilAction() {
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if($charakter !== false){
            echo json_encode($this->erstellungService->addNachteil($this->getRequest(), $charakter));
        }else{
            echo json_encode(array('success' => false, 'errors' => array('kein Charakter vorhanden')));
        }
    }
    
    public function unterklasseAction() {
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if($charakter !== false){
            echo json_encode($this->erstellungService->setUnterklasse($this->getRequest(), $charakter));
        }else{
            echo json_encode(array('success' => false, 'errors' => array('kein Charakter vorhanden')));
        }
    }
    
}
