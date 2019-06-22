<?php


namespace Notification\Services\Types;


use Notification\Models\Notification;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Models\NotificationSubject;
use Notification\Services\NotificationService;

class GroupMessages extends NotificationService
{
    /**
     * @var NotificationMapper
     */
    private $notificationMapper;


    public function create (Notification $notification)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param int $subjectId
     * @param int $notificationType
     */
    public function handle (int $subjectId, int $notificationType)
    {
        // TODO: Implement handle() method.
    }

    /**
     * @return NotificationMapper
     */
    protected function getMapper (): NotificationMapper
    {
        if ($this->notificationMapper === null) {
            $this->notificationMapper = new \Notification\Models\Mappers\Types\GroupMessages();
        }
        return $this->notificationMapper;
    }

    /**
     * @param int $id
     *
     * @return NotificationSubject
     */
    protected function getSubject (int $id): NotificationSubject
    {
        // TODO: Implement getSubject() method.
    }


}