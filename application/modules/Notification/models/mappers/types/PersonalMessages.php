<?php


namespace Notification\Models\Mappers\Types;


use Notification\Models\Notification;
use Notification\Models\NotificationTypes;
use Notification\Models\Mappers\NotificationMapper;

class PersonalMessages extends NotificationMapper
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
            ['userId = ?' => $userId, 'type = ?' => NotificationTypes::PERSONAL_MESSAGE]
        );
        foreach ($result as $row) {
            $notification = new Notification();
            $notification->setUserId($userId)
                ->setNotificationId($row->notificationId)
                ->setSubjectId($row->subjectId)
                ->setType(NotificationTypes::PERSONAL_MESSAGE);
            $notifications[] = $notification;
        }
        return $notifications;
    }

}