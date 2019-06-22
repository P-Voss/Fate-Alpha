<?php


namespace Notification\Models\Mappers\Types;


use Notification\Models\Notification;
use Notification\Models\NotificationTypes;
use Notification\Models\Mappers\NotificationMapper;

class GroupMessages extends NotificationMapper
{

    /**
     * @param int $userId
     *
     * @return Notification[]
     * @throws \Exception
     */
    public function loadByUserId (int $userId): array
    {
        $notifications = [];
        $result = $this->getDbTable('Notification')->fetchAll(
            ['userId = ?' => $userId, 'type = ?' => NotificationTypes::GROUP_MESSAGE]
        );
        foreach ($result as $row) {
            $notification = new Notification();
            $notification->setUserId($userId)
                ->setNotificationId($row->notificationId)
                ->setSubjectId($row->subjectId)
                ->setType(NotificationTypes::GROUP_MESSAGE);
            $notifications[] = $notification;
        }
        return $notifications;
    }

    /**
     * @param Notification $notification
     *
     * @throws \Exception
     */
    public function create(Notification $notification)
    {
        if ($this->hasNotification($notification->getUserId(), $notification->getSubjectId())) {
            return;
        }
        $this->getDbTable('Notification')->insert($notification->toArray());
    }

    /**
     * @param int $userId
     * @param int $subjectId
     *
     * @return bool
     * @throws \Exception
     */
    public function hasNotification (int $userId, int $subjectId): bool
    {
        $row = $this->getDbTable('Notification')->fetchRow(
            ['userId = ?' => $userId, 'subjectId = ?' => $subjectId]
        );
        return $row !== null;
    }

}