<?php


namespace Notification\Services;


use Notification\Models\Notification;
use Notification\Models\NotificationTypes;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Models\NotificationSubject;
use Notification\Services\Types\GroupEntry;
use Notification\Services\Types\GroupMessages;
use Notification\Services\Types\PersonalMessages;
use Notification\Services\Types\Wishes;

class NotificationFacade extends NotificationService
{

    /**
     * @var GroupMessages
     */
    private $groupmessagesService;
    /**
     * @var PersonalMessages
     */
    private $personalmessagesService;
    /**
     * @var Wishes
     */
    private $wishesService;
    /**
     * @var GroupEntry
     */
    private $groupEntryService;

    /**
     * NotificationFacade constructor.
     */
    public function __construct ()
    {
        $this->groupmessagesService = new GroupMessages();
        $this->personalmessagesService = new PersonalMessages();
        $this->wishesService = new Wishes();
        $this->groupEntryService = new GroupEntry();
    }

    /**
     * @param int $notificationType
     *
     * @return NotificationService
     * @throws \Exception
     */
    public function getService (int $notificationType): NotificationService
    {
        switch ($notificationType) {
            case NotificationTypes::GROUP_MESSAGE:
                return $this->groupmessagesService;
                break;
            case NotificationTypes::PERSONAL_MESSAGE:
                return $this->personalmessagesService;
                break;
            case NotificationTypes::WISH:
                return $this->wishesService;
                break;
            case NotificationTypes::JOINED_GROUP:
                return $this->groupEntryService;
                break;
            default:
                throw new \Exception('Invalid NotificationType');
        }
    }

    /**
     * @param Notification $notification
     *
     * @throws \Exception
     */
    public function create (Notification $notification)
    {
        return $this->getService($notification->getType())->create($notification);
    }

    /**
     * @param int $subjectId
     * @param int $notificationType
     *
     * @throws \Exception
     */
    public function handle (int $subjectId, int $notificationType)
    {
        return $this->getService($notificationType)->handle($subjectId, $notificationType);
    }

    /**
     * @param int $userId
     *
     * @return Notification[]
     */
    public function loadByUserId (int $userId): array
    {
        $notifications = [];
        foreach (NotificationTypes::getNotificationTypes() as $type) {
            try {
                $notifications = array_merge(
                    $this->getService($type)->loadByUserId($userId),
                    $notifications
                );
            } catch (\Exception $exception) {
                \Zend_Debug::dump($exception);
                exit;
            }
        }
        return $notifications;
    }

    /**
     * @return NotificationMapper
     * @throws \Exception
     */
    protected function getMapper (): NotificationMapper
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @param int $id
     *
     * @return NotificationSubject
     * @throws \Exception
     */
    protected function getSubject (int $id): NotificationSubject
    {
        throw new \Exception('Not implemented');
    }

}