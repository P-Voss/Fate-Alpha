<?php

/**
 * Class Story_SkillController
 */
class Story_SkillController extends Zend_Controller_Action
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
     * @var Story_Service_Result_Skill
     */
    private $resultService;


    public function init(){
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->characterService = new Application_Service_Charakter();
        $this->episodeService = new Story_Service_Episode();
        $this->resultService = new Story_Service_Result_Skill();
        $userId = Zend_Auth::getInstance()->getIdentity()->userId;
        if(
            !$this->_helper->logincheck()
            || (!$this->episodeService->isSl($this->getRequest()->getPost('episodeId'), $userId)
            && !$this->episodeService->isPlayer(
                (int)$this->getRequest()->getParam('episodeId'),
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
        $this->view->skills = $this->resultService->getLearnableSkills($this->character->getCharakterid());
        $html = $this->view->render('skill/show.phtml');
        echo json_encode(['html' => $html]);
        exit;
    }


    public function removalAction() {
        $this->view->skills = $this->resultService->getLearnedSkills($this->character->getCharakterid());
        $html = $this->view->render('skill/removal.phtml');
        echo json_encode(['html' => $html]);
        exit;
    }


    public function requestAction()
    {
        if($this->getRequest()->getParam('requesttype') === 'add'){
            $this->resultService->addRequests(
                $this->episodeId,
                $this->character->getCharakterid(),
                $this->getRequest()->getPost('skillIds', [])
            );
        } else {
            $this->resultService->addSkillRemovalrequest(
                $this->episodeId,
                $this->character->getCharakterid(),
                $this->getRequest()->getPost('skillIds')
            );
        }
        echo json_encode([]);
        exit;
    }



}