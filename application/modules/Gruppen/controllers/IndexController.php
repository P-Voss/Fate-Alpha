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
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->charakter = $this->charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->userId);
        $this->gruppenService = new Gruppen_Service_Gruppen();
    }
    
    public function indexAction() {
        if($this->charakter !== false){
            $this->view->gruppen  = $this->gruppenService->getGruppenByCharakterId($this->charakter->getCharakterId());
        }else{
            $this->view->gruppen = array();
        }
        $this->view->eigeneGruppen = $this->gruppenService->getGruppenByLeaderId(Zend_Auth::getInstance()->getIdentity()->userId);
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
        if(!is_null($this->getRequest()->getParam('gruppenId'))){
            $this->gruppenService->switchDataExposure($this->getRequest(), $this->charakter->getCharakterid());
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    public function showAction() {
        $charakterId = ($this->charakter !== false) ? $this->charakter->getCharakterid() : 0;
        if(!$this->gruppenService->validateAccess($this->getRequest()->getParam('id'), 
                                                    $charakterId, 
                                                    Zend_Auth::getInstance()->getIdentity()->userId
                                                )){
            $this->redirect('Gruppen');
        }
//        $storyService = new Gruppen_Service_Story();
//        $this->view->plots = $storyService->getPlotsByGruppe($this->getRequest()->getParam('id'));
        $gruppe = $this->gruppenService->getGruppeByGruppenId($this->getRequest()->getParam('id'));
//        $this->view->logs = $this->gruppenService->getLogsByGruppenId($this->getRequest()->getParam('id'));
        $this->view->eigeneGruppe = ($gruppe->getGruender() === Zend_Auth::getInstance()->getIdentity()->userId);
        $this->view->exposed = $this->gruppenService->dataExposed($this->getRequest()->getParam('id'), $charakterId);
        $this->view->exposedIds = $this->gruppenService->getExposedIds($this->getRequest()->getParam('id'));
        $this->view->gruppe = $gruppe;
        $this->view->charaktere = $this->charakterService->getCharakters();
        $this->view->gruppenchat = $this->gruppenService->getGruppenchat($this->getRequest()->getParam('id'));
    }
    
    public function addAction() {
        if(!$this->gruppenService->isLeader(Zend_Auth::getInstance()->getIdentity()->userId, $this->getRequest()->getParam('gruppenId'))){
            $this->redirect('Gruppen');
        }
        if(!is_null($this->getRequest()->getParam('gruppenId'))){
            $this->gruppenService->addToGroup($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    public function removeAction() {
        if(!$this->gruppenService->isLeader(Zend_Auth::getInstance()->getIdentity()->userId, $this->getRequest()->getParam('gruppenId'))){
            $this->redirect('Gruppen');
        }
        if(!is_null($this->getRequest()->getParam('gruppenId'))){
            $this->gruppenService->removeFromGroup($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    public function chatAction() {
        $charakterId = ($this->charakter !== false) ? $this->charakter->getCharakterid() : 0;
        if(!$this->gruppenService->validateAccess($this->getRequest()->getParam('gruppenId'), 
                                                    $charakterId, 
                                                    Zend_Auth::getInstance()->getIdentity()->userId
                                                )){
            $this->redirect('Gruppen');
        }
        if(!is_null($this->getRequest()->getParam('gruppenId'))){
            $this->gruppenService->addNachricht($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    public function uploadAction() {
        $charakterId = ($this->charakter !== false) ? $this->charakter->getCharakterid() : 0;
        if(!$this->gruppenService->validateAccess($this->getRequest()->getParam('gruppenId'), 
                                                    $charakterId, 
                                                    Zend_Auth::getInstance()->getIdentity()->userId
                                                )){
            $this->redirect('Gruppen');
        }
        if(!is_null($this->getRequest()->getParam('gruppenId'))){
            $service = new Gruppen_Service_File();
            $service->uploadLog($this->getRequest(), Zend_Auth::getInstance()->getIdentity()->userId);
            $this->redirect('Gruppen/index/show/id/' . $this->getRequest()->getParam('gruppenId'));
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    
    public function downloadAction() {
        $charakterId = ($this->charakter !== false) ? $this->charakter->getCharakterid() : 0;
        if(!$this->gruppenService->validateAccess($this->getRequest()->getParam('id'), 
                                                    $charakterId, 
                                                    Zend_Auth::getInstance()->getIdentity()->userId
                                                )){
            $this->redirect('Gruppen');
        }
        if(!is_null($this->getRequest()->getParam('id'))){
            $service = new Gruppen_Service_File();
            $service->downloadLog($this->getRequest());
        }else{
            $this->redirect('Gruppen');
        }
    }
    
}
