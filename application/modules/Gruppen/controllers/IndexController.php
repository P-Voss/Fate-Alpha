<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Gruppen_IndexController extends Zend_Controller_Action {
    
    /**
     * @var Application_Service_Charakter 
     */
    protected $charakterService;
    
    /**
     * @var Application_Model_Charakter
     */
    protected $charakter;

    /**
     * @var Gruppen_Service_Gruppen
     */
    protected $gruppenService;
    
    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        $this->_helper->logincheck();
        if(!$this->_helper->admincheck()){
            $this->redirect('index');
        }
        $this->charakter = $this->charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->userId);
        $this->gruppenService = new Gruppen_Service_Gruppen();
    }
    
    public function indexAction() {
        $this->view->gruppen  = $this->gruppenService->getGruppenByCharakterId($this->charakter->getCharakterId());
        $this->view->eigeneGruppen = $this->gruppenService->getGruppenByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
    public function createAction() {
        $this->gruppenService->createGruppe($this->getRequest());
        $this->redirect('Gruppen');
    }
    
    public function editAction() {
        
    }
    
    public function enterAction() {
        $this->gruppenService->joinGruppe($this->getRequest(), $this->charakter->getCharakterid());
        $this->redirect('Gruppen');
    }
    
    public function exitAction() {
        $this->gruppenService->leaveGroup($this->getRequest()->getPost('gruppenId'), $this->charakter->getCharakterid());
        $this->redirect('Gruppen');
    }
    
    public function dataAction() {
        $this->gruppenService->switchDataExposure($this->getRequest(), $this->charakter->getCharakterid());
        if(!is_null($this->getRequest()->getParam('gruppenId'))){
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    public function showAction() {
        if(!$this->gruppenService->validateAccess($this->getRequest()->getParam('id'), 
                                                    $this->charakter->getCharakterid(), 
                                                    Zend_Auth::getInstance()->getIdentity()->userId
                                                )){
            $this->redirect('Gruppen');
        }
        $gruppe = $this->gruppenService->getGruppeByGruppenId($this->getRequest()->getParam('id'));
        $this->view->eigeneGruppe = ($gruppe->getGruender() === Zend_Auth::getInstance()->getIdentity()->userId);
        $this->view->exposed = $this->gruppenService->dataExposed($this->getRequest()->getParam('id'), $this->charakter->getCharakterid());
        $this->view->exposedIds = $this->gruppenService->getExposedIds($this->getRequest()->getParam('id'));
        $this->view->gruppe = $gruppe;
        $this->view->charaktere = $this->charakterService->getCharakters();
    }
    
    public function addAction() {
        $this->gruppenService->addToGroup($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        if(!is_null($this->getRequest()->getParam('gruppenId'))){
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    public function removeAction() {
        $this->gruppenService->removeFromGroup($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
        if(!is_null($this->getRequest()->getParam('gruppenId'))){
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
}
