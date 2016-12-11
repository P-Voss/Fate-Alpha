<?php

/**
 * Description of Story_ResultController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Story_ResultController extends Zend_Controller_Action {
    
    /**
     * @var Application_Service_Charakter 
     */
    protected $charakterService;
    /**
     * @var Application_Model_Charakter
     */
    protected $charakter;
    /**
     * @var Story_Service_Shop
     */
    protected $shopService;
    protected $episodenService;
    protected $userId;


    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->charakterService = new Application_Service_Charakter();
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->userId = Zend_Auth::getInstance()->getIdentity()->userId;
        $this->charakter = $this->charakterService->getCharakterByUserid($this->userId);
        $this->shopService = new Story_Service_Shop();
        $this->episodenService = new Story_Service_Episode();
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function indexAction() {
        $this->redirect('index');
    }
    
    
    public function requestAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        
        if(!in_array($this->getRequest()->getParam('requesttype'), ['add', 'remove'])){
            
        } else {
            if($this->getRequest()->getParam('requesttype') === 'add'){
                $this->shopService->addRequests($this->getRequest());
            } else {
                $this->shopService->removalRequests($this->getRequest());
            }
        }
        echo json_encode([]);
        exit;
    }
    
    
    public function magieAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $this->view->magien = $this->shopService->getLearnableMagien($charakterId);
        $html = $this->view->render('add/magie.phtml');
        echo json_encode(['html' => $html]);
    }
    
    public function removemagieAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $this->view->magien = $this->shopService->getLearnedMagien($charakterId);
        $html = $this->view->render('remove/magie.phtml');
        echo json_encode(['html' => $html]);
    }
    
    
    public function skillAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $this->view->skills = $this->shopService->getLearnableSkills($charakterId);
        $html = $this->view->render('add/skill.phtml');
        echo json_encode(['html' => $html]);
    }
    
    public function removeskillAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $this->view->skills = $this->shopService->getLearnedSkills($charakterId);
        $html = $this->view->render('remove/skill.phtml');
        echo json_encode(['html' => $html]);
    }
    
    
    public function itemAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $html = $this->view->render('add/item.phtml');
        echo json_encode(['html' => $html]);
    }
    
    public function removeitemAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $html = $this->view->render('remove/item.phtml');
        echo json_encode(['html' => $html]);
    }
    
    
    public function injuryAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $html = $this->view->render('add/injury.phtml');
        echo json_encode(['html' => $html]);
    }
    
    public function removeinjuryAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $html = $this->view->render('remove/injury.phtml');
        echo json_encode(['html' => $html]);
    }
    
    
    public function attributeAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $html = $this->view->render('result/attribute.phtml');
        echo json_encode(['html' => $html]);
    }
    
    
    public function killerAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->participants = $this->episodenService->getParticipantsByEpisodeId($this->getRequest()->getPost('episode'));
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $html = $this->view->render('result/killer.phtml');
        echo json_encode(['html' => $html]);
    }
    
    
    public function commentAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakter = $this->episodenService->getParticipant($episodeId, $charakterId);
        $html = $this->view->render('result/comment.phtml');
        echo json_encode(['html' => $html]);
    }
    
    
    public function setcommentAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->episodenService->updateCharakterComment($episodeId, $charakterId, $this->getRequest()->getPost('comment', ''));
        echo json_encode([]);
        exit;
    }
    
    
    public function killsAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->episodenService->updateCharakterKills($episodeId, $charakterId, $this->getRequest());
        $this->view->participants = $this->episodenService->getParticipantsByEpisodeId($this->getRequest()->getPost('episode'));
        $this->view->charakterId = $this->getRequest()->getPost('charakterId');
        $html = $this->view->render('result/killer.phtml');
        echo json_encode(['html' => $html]);
    }
    
    
    public function npcAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        if((int)$this->getRequest()->getPost('killcount') >= 0){
            $this->episodenService->updateCharakterNpckills($episodeId, $charakterId, $this->getRequest()->getPost('killcount'));
        }
        echo json_encode([]);
        exit;
    }
    
    
    public function deathAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->episodenService->updateCharakterGotKilled($episodeId, $charakterId, $this->getRequest()->getPost('gotKilled'));
        echo json_encode([]);
        exit;
    }
    
    
    public function refreshAction() {
        $episodeId = (int)$this->getRequest()->getParam('episode');
        $charakterId = $this->getRequest()->getPost('charakterId');
        if(!$this->episodenService->isPlayer($episodeId, $charakterId)){
            echo json_encode([]);
            exit;
        }
        $this->view->charakter = $this->episodenService->getParticipant($episodeId, $charakterId);
        $html = $this->view->render('result/zusammenfassung.phtml');
        echo json_encode(['html' => $html]);
    }
    
}
