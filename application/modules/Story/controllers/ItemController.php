<?php

/**
 * Description of Story_ItemController
 *
 * @author Voß
 */
class Story_ItemController extends Zend_Controller_Action
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
     * @var Story_Service_Shop
     */
    protected $shopService;

    public function init ()
    {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->characterService = new Application_Service_Charakter();
        $this->episodeService = new Story_Service_Episode();
        $this->resultService = new Story_Service_Result_Magic();
        $userId = Zend_Auth::getInstance()->getIdentity()->userId;
        if (
            !$this->_helper->logincheck()
            || (!$this->episodeService->isSl($this->getRequest()->getPost('episodeId'), $userId)
                && !$this->episodeService->isPlayer(
                    (int)$this->getRequest()->getParam('episodeId'),
                    $this->getRequest()->getPost('characterId')
                ))
        ) {
            $this->redirect('index');
        }
        $this->episodeId = (int)$this->getRequest()->getParam('episodeId');
        $this->character = $this->characterService->getCharakterById($this->getRequest()->getPost('characterId'));

        $this->shopService = new Story_Service_Result_Item();

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }


    public function indexAction() {
        $this->redirect('index');
    }


    public function showAction() {
        $this->view->items = $this->shopService->getItemsToAcquire($this->character->getCharakterid());
        $html = $this->view->render('item/show.phtml');
        echo json_encode(['html' => $html]);
        exit;
    }


    public function removalAction() {
        $this->view->items = $this->shopService->getItemsToRemove($this->character->getCharakterid());
        $html = $this->view->render('item/removal.phtml');
        echo json_encode(['html' => $html]);
        exit;
    }


    public function requestAction()
    {
        if($this->getRequest()->getParam('requesttype') === 'add'){
            $this->shopService->addRequests(
                $this->episodeId,
                $this->character->getCharakterid(),
                $this->getRequest()->getPost('itemIds', [])
            );
        } else {
            $this->shopService->addItemRemovalrequest(
                $this->episodeId,
                $this->character->getCharakterid(),
                $this->getRequest()->getPost('itemIds', [])
            );
        }
        echo json_encode([]);
        exit;
    }


}
