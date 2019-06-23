<?php


namespace Notification\Models\Mappers\Types;


use Notification\Models\Notification;
use Notification\Models\NotificationTypes;
use Notification\Models\Mappers\NotificationMapper;

/**
 * Class EpisodeStart
 * @package Notification\Models\Mappers\Types
 */
class EpisodeStart extends NotificationMapper
{

    /**
     * @param int $userId
     *
     * @return Notification[]
     * @throws \Exception
     */
    public function loadByUserId (int $userId): array
    {
        return $this->load($userId, NotificationTypes::EPISODE_STARTED);
    }

}