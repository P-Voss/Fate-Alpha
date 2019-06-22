<?php


namespace Notification\Services\Types;


use Notification\Models\Notification;
use Notification\Models\NotificationTypes;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Models\NotificationSubject;
use Notification\Models\View\PersonalMessageSubject;
use Notification\Services\NotificationService;

/**
 * Class PersonalMessages
 * @package Notification\Services\Types
 */
class PersonalMessages extends NotificationService
{

    /**
     * @var \Nachrichten_Model_Mapper_NachrichtenMapper
     */
    private $messagesMapper;
    /**
     * @var NotificationMapper
     */
    private $notificationMapper;


    public function __construct ()
    {
        $this->messagesMapper = new \Nachrichten_Model_Mapper_NachrichtenMapper();
    }


    /**
     * @param Notification $notification
     *
     * @throws \Exception
     */
    public function create (Notification $notification)
    {
        $this->getMapper()->create($notification);
    }

    /**
     * @param int $subjectId
     * @param int $notificationType
     *
     * @throws \Exception
     */
    public function handle (int $subjectId, int $notificationType)
    {
        $message = $this->messagesMapper->getNachrichtById($subjectId);
        $notification = new Notification();
        $notification->setUserId($message->getEmpfaengerId())
            ->setType(NotificationTypes::PERSONAL_MESSAGE)
            ->setSubjectId($message->getId());
        $this->getMapper()->create($notification);
    }

    /**
     * @param int $id
     *
     * @return NotificationSubject
     * @throws \Exception
     */
    protected function getSubject (int $id): NotificationSubject
    {
        $userMapper = new \Application_Model_Mapper_UserMapper();
        $message = $this->messagesMapper->getNachrichtById($id);
        $message->setVerfasser($userMapper->getUserById($message->getVerfasserId()));
        return new PersonalMessageSubject($message);
    }

    /**
     * @return NotificationMapper
     */
    protected function getMapper (): NotificationMapper
    {
        if ($this->notificationMapper === null) {
            $this->notificationMapper = new \Notification\Models\Mappers\Types\PersonalMessages();
        }
        return $this->notificationMapper;
    }

}