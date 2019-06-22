<?php


namespace Notification\Services\Types;

use Feedback\Models\Mappers\WishMapper;
use Notification\Models\Notification;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Models\NotificationSubject;
use Notification\Models\NotificationTypes;
use Notification\Models\View\WishSubject;
use Notification\Services\NotificationService;

/**
 * Class Wishes
 * @package Notification\Services\Types
 */
class Wishes extends NotificationService
{

    /**
     * @var WishMapper
     */
    private $wishesMapper;
    /**
     * @var NotificationMapper
     */
    private $notificationMapper;


    public function __construct ()
    {
        $this->wishesMapper = new WishMapper();
    }

    /**
     * @param Notification $notification
     *
     * @throws \Exception
     */
    public function create (Notification $notification)
    {
        $this->getMapper()->create($notification);
    }

    /**
     * @param int $subjectId
     * @param int $notificationType
     *
     * @throws \Exception
     */
    public function handle (int $subjectId, int $notificationType)
    {
        $notification = new Notification();
        $notification->setType(NotificationTypes::WISH)
            ->setSubjectId($subjectId);
        $this->getMapper()->create($notification);
    }

    /**
     * @return NotificationMapper
     */
    protected function getMapper (): NotificationMapper
    {
        if ($this->notificationMapper === null) {
            $this->notificationMapper = new \Notification\Models\Mappers\Types\Wishes();
        }
        return $this->notificationMapper;
    }

    /**
     * @param int $id
     *
     * @return NotificationSubject
     * @throws \Exception
     */
    protected function getSubject (int $id): NotificationSubject
    {
        return new WishSubject($this->wishesMapper->load($id));
    }


}