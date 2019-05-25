<?php

/**
 * Class Story_AchievementController
 */
class Story_AchievementController extends Zend_Controller_Action
{

    /**
     * @var Story_Service_Episode
     */
    private $episodeService;
    /**
     * @var Application_Service_Charakter
     */
    private $characterService;
    /**
     * @var int
     */
    private $episodeId;
    /**
     * @var Application_Model_Charakter
     */
    private $character;
    /**
     * @var Story_Service_Result_Achievement
     */
    private $resultService;

    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->characterService = new Application_Service_Charakter();
        $this->episodeService = new Story_Service_Episode();
        $this->resultService = new Story_Service_Result_Achievement();
        $userId = Zend_Auth::getInstance()->getIdentity()->userId;
        if(
            !$this->_helper->logincheck()
            || (!$this->episodeService->isSl($this->getRequest()->getPost('episodeId'), $userId)
            && !$this->episodeService->isPlayer(
                (int)$this->getRequest()->getParam('episode'),
                $this->getRequest()->getPost('characterId')
            ))
        ){
            $this->redirect('index');
        }
        $this->episodeId = (int)$this->getRequest()->getParam('episodeId');
        $this->character = $this->characterService->getCharakterById($this->getRequest()->getPost('characterId'));

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }


    public function indexAction() {
        $this->redirect('index');
    }


    public function showAction() {
        $this->view->charakterId = $this->character->getCharakterid();
        $html = $this->view->render('achievement/show.phtml');
        echo json_encode(['html' => $html]);
        exit;
    }


    public function removalAction ()
    {
        $this->view->achievements = $this->character->getAchievements();
        $html = $this->view->render('achievement/removal.phtml');
        echo json_encode(['html' => $html]);
        exit;
    }


    public function addrequestAction ()
    {
        $achievement = new Story_Model_Achievement(
            $this->character->getCharakterid(),
            $this->episodeId,
            $this->getRequest()->getPost('title'),
            $this->getRequest()->getPost('description'),
            Story_Model_RequestTypes::ADD
        );
        $this->resultService->addRequest($achievement);
        echo json_encode(['success' => true]);
        exit;
    }


    public function addremovalrequestAction ()
    {
        $achievement = new Story_Model_Achievement(
            $this->character->getCharakterid(),
            $this->episodeId,
            null,
            null,
            Story_Model_RequestTypes::REMOVE
        );
        foreach ($this->getRequest()->getPost('achievementIds') as $id) {
            $achievement->setId($id);
            $this->resultService->addRequest($achievement);
        }
        echo json_encode(['success' => true]);
        exit;
    }


    public function removerequestAction ()
    {
        $this->resultService->removeRequest(
            $this->episodeId,
            $this->character->getCharakterid(),
            $this->getRequest()->getPost('requestId')
        );
        echo json_encode(['success' => true]);
        exit;
    }


    public function deleteAction ()
    {
        $this->resultService->removeRequest(
            $this->episodeId,
            $this->character->getCharakterid(),
            $this->getRequest()->getPost('achievementId')
        );
        echo json_encode(['success' => true]);
        exit;
    }

}