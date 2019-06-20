<?php

use Feedback\Models\Wish;
use Feedback\Services\WishService;

/**
 * Class Feedback_WishesController
 */
class Feedback_WishesController extends Zend_Controller_Action
{

    /**
     * @var WishService
     */
    private $wishService;

    public function init ()
    {
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->wishService = new WishService();
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
    }


    public function indexAction ()
    {
        if ($this->_helper->admincheck()) {
            $this->forward('list');
        }

    }


    public function listAction ()
    {
        if (!$this->_helper->admincheck()) {
            $this->redirect('Feedback/wishes/index');
        }
        $this->view->wishes = $this->wishService->loadAll();
    }


    public function showAction ()
    {
        if (!$this->_helper->admincheck()) {
            $this->redirect('Feedback/wishes/index');
        }
        try {
            $this->view->wish = $this->wishService->load($this->getRequest()->getParam('id'));
        } catch (Exception $exception) {
            $this->redirect('Feedback/wishes/list');
        }
    }


    public function createAction ()
    {
        $wish = new Wish();
        $wish->setTitle($this->getRequest()->getPost('title', ''))
            ->setDescription($this->getRequest()->getPost('description', ''))
            ->setUserId(\Zend_Auth::getInstance()->getIdentity()->userId);
        $this->wishService->create($wish);

        $this->redirect('Feedback/wishes/index');
    }


    public function editAction ()
    {

    }

}