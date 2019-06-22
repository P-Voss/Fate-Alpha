<?php


namespace Notification\Services\Types;


use Notification\Models\Notification;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Models\NotificationSubject;
use Notification\Models\NotificationTypes;
use Notification\Models\View\GroupMessageSubject;
use Notification\Services\NotificationService;

class GroupMessages extends NotificationService
{
    /**
     * @var NotificationMapper
     */
    private $notificationMapper;
    /**
     * @var \Gruppen_Model_Mapper_GruppenMapper
     */
    private $groupMapper;


    public function __construct ()
    {
        $this->groupMapper = new \Gruppen_Model_Mapper_GruppenMapper();
    }

    /**
     * @param Notification $notification
     *
     * @throws \Exception
     */
    public function create (Notification $notification)
    {
        $this->handle($notification->getSubjectId(), NotificationTypes::GROUP_MESSAGE);
    }

    /**
     * @param int $subjectId
     * @param int $notificationType
     *
     * @throws \Exception
     */
    public function handle (int $subjectId, int $notificationType)
    {
        $message = $this->groupMapper->getMessage($subjectId);
        $group = $this->groupMapper->getGroupByMessageId($subjectId);
        $userIds = array_map(function(\Application_Model_Charakter $character) {
            return $character->getUserid();
        }, $this->groupMapper->getGruppenmitglieder($group->getId()));
        $userIds[] = $group->getGruender();

        $notification = new Notification();
        $notification->setSubjectId($subjectId)
            ->setType(NotificationTypes::GROUP_MESSAGE);
        foreach ($userIds as $userId) {
            if ($userId === $message->getUserId()) {
                continue;
            }
            $notification->setUserId($userId);
            $this->getMapper()->create($notification);
        }
    }

    /**
     * @return NotificationMapper
     */
    protected function getMapper (): NotificationMapper
    {
        if ($this->notificationMapper === null) {
            $this->notificationMapper = new \Notification\Models\Mappers\Types\GroupMessages();
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
        return new GroupMessageSubject($this->groupMapper->getGroupByMessageId($id));
    }


}