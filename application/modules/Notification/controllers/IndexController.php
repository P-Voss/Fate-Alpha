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
            $id = $this->getRequest()->getParam('id', 0);
            $mapper = new General();
            $notification = $mapper->load($id);
            if ($notification->getUserId() !== Zend_Auth::getInstance()->getIdentity()->userId) {
                $this->redirect('index');
            }
            $mapper->remove($notification->getNotificationId());
            switch ($notification->getType()) {
                case NotificationTypes::GROUP_MESSAGE:
                    $groupMapper = new Gruppen_Model_Mapper_GruppenMapper();
                    $group = $groupMapper->getGroupByMessageId($notification->getSubjectId());

                    $this->redirect('Gruppen/index/show/id/' . $group->getId());
                    break;
                case NotificationTypes::PERSONAL_MESSAGE:
                    $this->redirect('Nachrichten/index/show/id/' . $notification->getSubjectId() . '/read/true');
                    break;
                case NotificationTypes::WISH:
                    $this->redirect('Feedback/wishes/show/id/' . $notification->getSubjectId());
                    break;
                case NotificationTypes::JOINED_GROUP:
                    $groupMapper = new Gruppen_Model_Mapper_GruppenMapper();
                    $group = $groupMapper->getGroupByCharacterZuo($notification->getSubjectId());

                    $this->redirect('Gruppen/index/show/id/' . $group->getId());
                    break;
            }
        } catch (\Exception $exception) {
            $this->redirect('index');
        }
    }


    public function removeAction ()
    {
        try {
            $id = $this->getRequest()->getPost('id', 0);
            $mapper = new General();
            $notification = $mapper->load($id);
            if ($notification->getUserId() !== Zend_Auth::getInstance()->getIdentity()->userId) {
                echo json_encode(
                    [
                        'success' => false,
                        'message' => 'not your notification'
                    ]
                );
                exit;
            }
            $mapper->remove($notification->getNotificationId());
            echo json_encode(
                [
                    'success' => true
                ]
            );
            exit;
        } catch (\Exception $exception) {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'error on server'
                ]
            );
            exit;
        }

    }

}