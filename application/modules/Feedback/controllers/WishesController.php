<?php

use Feedback\Models\Wish;
use Feedback\Services\WishService;

/**
 * Class Feedback_WishesController
 */
class Feedback_WishesController extends Zend_Controller_Action
{


    public function init ()
    {
        if($this->_helper->logincheck() === false){
            $this->redirect('index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
    }


    public function indexAction ()
    {

    }


    public function createAction ()
    {
        $service = new WishService();
        $wish = new Wish();
        $wish->setTitle($this->getRequest()->getPost('title', ''))
            ->setDescription($this->getRequest()->getPost('description', ''))
            ->setUserId(\Zend_Auth::getInstance()->getIdentity()->userId);
        $service->create($wish);

        $this->redirect('Feedback/wishes/index');
    }


    public function showAction ()
    {

    }


    public function editAction ()
    {

    }

}