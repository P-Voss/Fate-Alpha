<?php

/**
 * Description of InformationController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_InformationController extends Zend_Controller_Action{
    
    protected $informationService;

    public function init() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }
        $this->informationService = new Erstellung_Service_Information();
    }
    
    public function klasseAction() {
        echo json_encode($this->informationService->getKlasse($this->getRequest()->getPost('id')));
    }
    
    public function odoAction() {
        echo json_encode($this->informationService->getOdo($this->getRequest()->getPost('id')));
    }
    
    public function circuitAction() {
        echo json_encode($this->informationService->getCircuit($this->getRequest()->getPost('id')));
    }
    
    public function luckAction() {
        echo json_encode($this->informationService->getLuck($this->getRequest()->getPost('id')));
    }
    
    public function vorteilAction() {
        echo json_encode($this->informationService->getVorteil($this->getRequest()->getPost('id')));
    }
    
    public function nachteilAction() {
        echo json_encode($this->informationService->getNachteil($this->getRequest()->getPost('id')));
    }
    
    public function incompatibilitiesAction() {
        echo json_encode($this->informationService->getIncompatibilities($this->getRequest()));
    }
    
    public function unterklasseAction() {
        echo json_encode($this->informationService->getUnterklasse($this->getRequest()->getPost('id')));
    }
    
    public function clansAction() {
        echo json_encode($this->informationService->getFamiliennamen());
    }
    
    public function vorteileAction() {
        echo json_encode($this->informationService->vorteilIncompatibilities());
    }
    
    public function nachteileAction() {
        echo json_encode($this->informationService->nachteilIncompatibilities());
    }
}
