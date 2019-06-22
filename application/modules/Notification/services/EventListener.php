<?php


namespace Notification\Services;


use Feedback\Models\NotificationTypes;
use SplSubject;

class EventListener implements \Application_Model_Events_Observer
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
        if (!$subject instanceof \Application_Model_Events_Subject) {
            return;
        }

        foreach ($subject->getEvents() as $event) {
            switch ($event['event']) {
                case \Nachrichten_Service_Nachrichten::NEW_MESSAGE_EVENT:
                    $this->notificationService->handle(
                        $event['messageId'],
                        NotificationTypes::PERSONAL_MESSAGE
                    );
                    break;
            }
        }
    }


}