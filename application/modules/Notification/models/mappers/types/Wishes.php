<?php


namespace Notification\Models\Mappers\Types;


use Notification\Models\Notification;
use Notification\Models\NotificationTypes;
use Notification\Models\Mappers\NotificationMapper;

class Wishes extends NotificationMapper
{

    /**
     * @param int $userId
     *
     * @return Notification[]
     * @throws \Exception
     */
    public function loadByUserId (int $userId): array
    {
        return $this->load($userId, NotificationTypes::WISH);
    }

    /**
     * @param Notification $notification
     *
     * @return int
     * @throws \Exception
     */
    public function create(Notification $notification): int
    {
        $sql = <<<SQL
INSERT INTO notifications (userId, subjectId, type)
SELECT admins.userId, ?, ?
FROM admins
SQL;
        $stmt = $this->getDbTable('Notification')->getAdapter()->prepare($sql);
        return $stmt->execute([$notification->getSubjectId(), $notification->getType()]);
    }

}