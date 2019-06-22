<?php

use Feedback\Models\Wish;
use Feedback\Services\Wish as WishService;

/**
 * Class Feedback_WishesController
 */
class Feedback_WishesController extends Zend_Controller_Action
{

    /**
     * @var WishService
     */
    private $wishService;
    /**
     * @var Application_Service_User
     */
    private $userService;

    public function init ()
    {
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $this->wishService = new WishService();
        $this->userService = new Application_Service_User();
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->wishService->attach(
            new \Notification\Services\EventListener(
                new \Notification\Services\NotificationFacade()
            )
        );
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
        $this->view->wishes = array_map(function (Wish $wish) {
            return new \Feedback\Models\View\Wish($wish, $this->userService->getUserById($wish->getUserId()));
        }, $this->wishService->loadAll());
    }


    public function showAction ()
    {
        if (!$this->_helper->admincheck()) {
            $this->redirect('Feedback/wishes/index');
        }
        try {
            $wish = $this->wishService->load($this->getRequest()->getParam('id'));
            $this->view->wish = new \Feedback\Models\View\Wish(
                $wish,
                $this->userService->getUserById($wish->getUserId())
            );
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
        $wishId = $this->wishService->create($wish);
        $this->wishService->notify();

        $this->redirect('Feedback/wishes/index');
    }


    public function editAction ()
    {

    }

}