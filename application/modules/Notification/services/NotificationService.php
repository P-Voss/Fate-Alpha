<?php

namespace Notification\Services;


use Notification\Models\Notification;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Models\NotificationSubject;

/**
 * Class NotificationService
 * @package Notification\services
 */
abstract class NotificationService
{

    /**
     * @param Notification $notification
     *
     * @return int
     */
    abstract public function create (Notification $notification): int;

    /**
     * creates Notifications based on type and subject
     *
     * @param int $subjectId
     * @param int $notificationType
     */
    abstract public function handle (int $subjectId, int $notificationType);

    /**
     * @return NotificationMapper
     */
    abstract protected function getMapper(): NotificationMapper;

    /**
     * @param int $id
     *
     * @return NotificationSubject
     */
    abstract protected function getSubject(int $id): NotificationSubject;

    /**
     * @param int $userId
     *
     * @return Notification[]
     */
    public function loadByUserId (int $userId): array
    {
        $notifications = [];
        foreach ($this->getMapper()->loadByUserId($userId) as $notification) {
            $notification->setSubject($this->getSubject($notification->getSubjectId()));
            $notifications[] = $notification;
        }
        return $notifications;
    }

}