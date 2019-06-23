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
        return $this->load($userId, NotificationTypes::GROUP_MESSAGE);
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