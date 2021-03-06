<?php

use Shop\Services\Character;

/**
 * Description of ItemController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_ItemController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_Charakter;
     */
    private $character;
    /**
     * @var Character;
     */
    private $characterService;

    public function init ()
    {
        if (!$this->_helper->logincheck()) {
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->characterService = new Character();

        $auth = Zend_Auth::getInstance()->getIdentity();
        try {
            $this->character = $this->characterService->getCharakterByUserid($auth->userId);
            $this->view->character = $this->character;
        } catch (Exception $exception) {
            $this->redirect('index/index');
        }
    }


    public function indexAction ()
    {
        $requirementService = new \Shop\Services\Requirement($this->character);
        $service = new \Shop\Services\Item($requirementService);
        try {
            $this->view->items = $service->getItems($this->character);
        } catch (Exception $exception) {
            $this->view->items = [];
        }
    }


    public function buyAction ()
    {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $requirementService = new \Shop\Services\Requirement($this->character);
        $service = new \Shop\Services\Item($requirementService);
        try {
            $service->buy(
                $this->getRequest()->getPost('id', 0),
                $this->character
            );
            echo json_encode(['success' => true]);
            exit;
        } catch (Exception $exception) {
            echo json_encode(
                [
                    'success' => false,
                    'message' => $exception->getMessage()
                ]
            );
            exit;
        }
    }

}
