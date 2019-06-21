<?php


namespace Notification\Services;


use SplSubject;

class EventListener implements \SplObserver
{

    const NEW_GROUP_MESSAGE = 1;
    const NEW_PERSONAL_MESSAGE = 2;
    const NEW_WISH = 3;

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * EventListener constructor.
     *
     * @param NotificationService $notificationService
     */
    public function __construct (NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @param SplSubject $subject
     */
    public function update (SplSubject $subject)
    {

        // TODO: Implement update() method.
    }


}