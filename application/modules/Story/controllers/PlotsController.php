<?php

/**
 * Description of Story_PlotsController
 *
 * @author Voß
 */
class Story_PlotsController extends Zend_Controller_Action {
    
    protected $charakter;
    protected $plotService;
    protected $episodenService;
    
    
    public function init() {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->charakter = $this->charakterService->getCharakterByUserid(Zend_Auth::getInstance()->getIdentity()->userId);
        $this->plotService = new Story_Service_Plot();
        $this->episodenService = new Story_Service_Episode();
    }
    
    
    public function newAction() {
        $gruppenService = new Gruppen_Service_Gruppen();
        $this->view->eigeneGruppen = $gruppenService->getGruppenByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
    
    public function createAction() {
        if(!is_null($this->getRequest()->getPost('gruppenId'))){
            $plotId = $this->plotService->createStoryline($this->getRequest());
            $this->redirect('Story');
        }else{
            $this->redirect('Gruppen');
        }
    }
    
    
    public function showAction() {
        if((int)$this->getRequest()->getParam('id') <= 0){
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getParam('id');
        $userId = Zend_Auth::getInstance()->getIdentity()->userId;
        if(!$this->plotService->isPlayer($plotId, $userId)){
            if($this->plotService->isSL($plotId, $userId)){
                $this->redirect('Story/plots/sl/id/' . $plotId);
            } else {
                $this->redirect('index');
            }
        }
        $this->view->plot = $this->plotService->getPlotById($plotId);
        $this->view->episodes = $this->episodenService->getEpisodesByPlotIdForUser($plotId, $userId);
        $this->view->freigabe = $this->plotService->checkDatenfreigabe($plotId, $userId);
    }
    
    public function slAction() {
        if((int)$this->getRequest()->getParam('id') <= 0){
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getParam('id');
        if(!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $this->view->plot = $this->plotService->getPlotById((int)$this->getRequest()->getParam('id'));
        $this->view->episodes = $this->episodenService->getEpisodesByPlotId($plotId);
        $this->view->participants = $this->plotService->getParticipantsByPlotId($plotId);
        $this->view->invitables = $this->plotService->getPossibleParticipants($plotId);
    }
    
    
    public function editAction() {
        
    }
    
    
    public function deleteAction() {
        
    }
    
    
    public function addAction() {
        if((int)$this->getRequest()->getPost('plotId') <= 0){
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getPost('plotId');
        if(!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
        $invitables = $this->plotService->getPossibleParticipants($plotId);
        $invitableIds = array();
        foreach ($invitables as $charakter) {
            $invitableIds[] = $charakter->getCharakterId();
        }
        $invites = array_intersect($invitableIds, $this->getRequest()->getPost('invites'));
        $this->plotService->addParticipants($plotId, $invites);
        $this->redirect('Story/plots/sl/id/' . $plotId);
    }
    
    public function removeAction() {
        if((int)$this->getRequest()->getPost('plotId') <= 0){
            $this->redirect('index');
        }
        $plotId = (int)$this->getRequest()->getPost('plotId');
        if(!$this->plotService->isSL($plotId, Zend_Auth::getInstance()->getIdentity()->userId)){
            $this->redirect('index');
        }
//        $this->plotService->removeParticipant($plotId, (int)$this->getRequest()->getPost('charakterId'));
        $this->redirect('Story/plots/sl/id/' . $plotId);
    }
    
}
