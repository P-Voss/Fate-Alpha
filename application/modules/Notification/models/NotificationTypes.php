<?php


namespace Feedback\Models;

/**
 * Class NotificationTypes
 * @package Feedback\models
 */
class NotificationTypes
{

    const GROUP_MESSAGE = 1;
    const PERSONAL_MESSAGE = 2;
    const WISH = 3;

    /**
     * @return array
     */
    public static function getNotificationTypes(): array {
        return [
            static::GROUP_MESSAGE,
            static::PERSONAL_MESSAGE,
            static::WISH,
        ];
    }

}