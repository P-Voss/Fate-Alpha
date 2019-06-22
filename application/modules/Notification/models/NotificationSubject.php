<?php


namespace Notification\Models;


/**
 * Interface NotificationSubject
 * @package Notification\Models
 */
interface NotificationSubject
{

    /**
     * @return int
     */
    public function getId (): int;

    /**
     * @return string
     */
    public function getTitle (): string;

    /**
     * @return string
     */
    public function getDescription (): string;

}