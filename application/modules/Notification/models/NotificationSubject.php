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
    public function getSubjectId (): int;

    /**
     * @return string
     */
    public function getSubjectTitle (): string;

    /**
     * @return string
     */
    public function getSubjectDescription (): string;

}