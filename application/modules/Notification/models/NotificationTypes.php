<?php


namespace Notification\Models;

/**
 * Class NotificationTypes
 * @package Notification\Models
 */
class NotificationTypes
{

    const GROUP_MESSAGE = 1;
    const PERSONAL_MESSAGE = 2;
    const WISH = 3;
    const JOINED_GROUP = 4;
    const EPISODE_KICKOFF = 5;
    const EPISODE_STARTED = 6;

    /**
     * @return array
     */
    public static function getNotificationTypes(): array {
        return [
            static::GROUP_MESSAGE,
            static::PERSONAL_MESSAGE,
            static::WISH,
            static::JOINED_GROUP,
            static::EPISODE_KICKOFF,
            static::EPISODE_STARTED,
        ];
    }

}