<?php

use Notification\Models\Mappers\General;
use Notification\Models\NotificationTypes;

/**
 * Class Notification_IndexController
 */
class Notification_IndexController extends \Zend_Controller_Action
{


    public function init ()
    {
        if (!$this->_helper->logincheck()) {
            $this->redirect('index');
        }
        $config = \HTMLPurifier_Config::createDefault();
        $this->view->purifier = new \HTMLPurifier($config);
    }


    public function showAction ()
    {
        try {
            $mapper = new General();
            $id = $this->getRequest()->getParam('id', 0);
            $notification = $mapper->load($id);
            if ($notification->getUserId() !== Zend_Auth::getInstance()->getIdentity()->userId) {
                $this->redirect('index');
            }
            $mapper->remove($notification->getNotificationId());
            switch ($notification->getType()) {
                case NotificationTypes::GROUP_MESSAGE:
                    $this->forward('group');
                    break;
                case NotificationTypes::PERSONAL_MESSAGE:
                    $this->redirect('Nachrichten/index/show/id/' . $notification->getSubjectId() . '/read/true');
                    break;
                case NotificationTypes::WISH:
                    $this->redirect('Feedback/wishes/show/id/' . $notification->getSubjectId());
                    break;
            }
        } catch (\Exception $exception) {
            $this->redirect('index');
        }
    }

    public function groupAction ()
    {

//        $this->redirect('Gruppen/index/show/id/' . $notification->getSubjectId());
        \Zend_Debug::dump('dsfsdf');
        exit;
    }

}