<?php

namespace Notification\Services;


use Notification\Models\NotificationTypes;

/**
 * Class EventListener
 * @package Notification\Services
 */
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
     * @param \SplSubject $subject
     *
     * @throws \Exception
     */
    public function update (\SplSubject $subject)
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
                case \Feedback\Services\Wish::NEW_WISH_EVENT:
                    $this->notificationService->handle(
                        $event['wishId'],
                        NotificationTypes::WISH
                    );
                    break;
                case \Gruppen_Service_Gruppen::NEW_MESSAGE_EVENT:
                    $this->notificationService->handle(
                        $event['messageId'],
                        NotificationTypes::GROUP_MESSAGE
                    );
                    break;
                case \Gruppen_Service_Gruppen::JOINED_GROUP_EVENT:
                    $this->notificationService->handle(
                        $event['characterGroupId'],
                        NotificationTypes::JOINED_GROUP
                    );
                    break;
                case \Story_Service_Episode::EPISODE_KICKOFF:
                    $this->notificationService->handle(
                        $event['episodeId'],
                        NotificationTypes::EPISODE_KICKOFF
                    );
                    break;
                case \Story_Service_Episode::EPISODE_STARTED:
                    $this->notificationService->handle(
                        $event['episodeId'],
                        NotificationTypes::EPISODE_STARTED
                    );
                    break;
            }
        }
    }

}