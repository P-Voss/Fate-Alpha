<?php

/**
 * Interface Application_Model_Events_Subject
 */
interface Application_Model_Events_Subject extends SplSubject
{

    /**
     * @return array
     */
    public function getEvents(): array;

}