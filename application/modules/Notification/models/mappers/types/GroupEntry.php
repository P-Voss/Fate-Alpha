<?php


namespace Notification\Models\Mappers\Types;


use Notification\Models\Notification;
use Notification\Models\NotificationTypes;
use Notification\Models\Mappers\NotificationMapper;

/**
 * Class GroupEntry
 * @package Notification\Models\Mappers\Types
 */
class GroupEntry extends NotificationMapper
{

    /**
     * @param int $userId
     *
     * @return Notification[]
     * @throws \Exception
     */
    public function loadByUserId (int $userId): array
    {
        return $this->load($userId, NotificationTypes::JOINED_GROUP);
    }

}