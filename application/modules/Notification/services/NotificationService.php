<?php


namespace Notification\Services;


use Feedback\Models\Notification;
use Notification\Models\Mappers\NotificationMapper;

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
     * @param int $userId
     *
     * @return Notification[]
     */
    abstract public function loadByUserId (int $userId): array;

    /**
     * @return NotificationMapper
     */
    abstract protected function getMapper(): NotificationMapper;

    /**
     * @param int $notificationId
     *
     * @throws \Exception
     */
    final public function remove (int $notificationId) {
        $this->getMapper()->remove($notificationId);
    }

}