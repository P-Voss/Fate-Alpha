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
    /**
     * @var Application_Model_Charakter
     */
    private $charakter;

    /**
     * @throws Exception
     */
    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Erstellung_Service_Charakter();
        $this->layoutService = new Application_Service_Layout();
        $this->erstellungService = new Erstellung_Service_Erstellung();
        $this->informationService = new Erstellung_Service_Information();

        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $this->charakter = $this->charakterService->getInactiveCharakterByUserId($auth->userId);
            $layout = $this->_helper->layout();
            $layout->setLayout('erstellung');
            $this->view->layoutData = $this->layoutService->getLayoutData($auth);
        }
        if($this->charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->userId) !== false){
            $this->redirect('index');
        }
    }
    
    public function indexAction() {
        
    }
    
    public function personAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->charakter = $this->charakter;
        $html = $this->view->render('charakter/person.phtml');
        $helptext = $this->view->render('helptexts/person.phtml');
        echo json_encode(array('html' => $html, 'helptext' => $helptext));
    }
    
    public function klasseAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->klassen = $this->informationService->getKlassen();
        $html = $this->view->render('charakter/klasse.phtml');
        $helptext = $this->view->render('helptexts/klasse.phtml');
        echo json_encode(array('html' => $html, 'helptext' => $helptext));
    }
    
    public function eigenschaftenAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->creationParams = $this->informationService->getCreationParams();
        $this->view->hasCircuit = $this->informationService->hasCircuit($this->charakter);
        $html = $this->view->render('charakter/eigenschaften.phtml');
        $helptext = $this->view->render('helptexts/eigenschaften.phtml');
        echo json_encode(array('html' => $html, 'helptext' => $helptext));
    }
    
    public function vornachteileAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->vorteile = $this->informationService->getVorteile();
        $this->view->nachteile = $this->informationService->getNachteile();
        $klasse = $this->erstellungService->getKlasse($this->charakter);
        $html = $this->view->render('charakter/vornachteile.phtml');
        $helptext = $this->view->render('helptexts/vornachteile.phtml');
        echo json_encode(array('html' => $html, 'helptext' => $helptext, 'vorteilCount' => ($klasse === 2) ? 4 : 3));
    }
    
    public function unterklasseAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->unterklassen = $this->informationService->getUnterklassenByCharakter($this->charakter);
        $html = $this->view->render('charakter/unterklasse.phtml');
        $helptext = $this->view->render('helptexts/unterklasse.phtml');
        echo json_encode(array('html' => $html, 'helptext' => $helptext));
    }
    
    public function detailsAction() {
        
    }
    
    public function finishAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->erstellungService->finalizeCharakter($this->charakter);
        $this->erstellungService->activateCharakter($this->charakter);
        $this->redirect('Charakter');
    }
    
    public function removeAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if ($charakter !== false) {
            $this->erstellungService->remove($this->getRequest()->getPost('attribute'), $charakter);
        }
    }
    
    public function removevorteilAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if ($charakter !== false) {
            $this->erstellungService->remove($this->getRequest()->getPost('attribute'), $charakter);
        }
    }
    
    public function removenachteilAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $charakter = $this->charakterService->getInactiveCharakterByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        if ($charakter !== false) {
            $this->erstellungService->remove($this->getRequest()->getPost('attribute'), $charakter);
        }
    }
    
}
