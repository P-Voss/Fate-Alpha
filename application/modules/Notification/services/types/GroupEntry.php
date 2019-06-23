<?php


namespace Notification\Services\Types;


use Notification\Models\Notification;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Models\NotificationSubject;
use Notification\Models\NotificationTypes;
use Notification\Models\View\GroupEntrySubject;
use Notification\Models\View\GroupMessageSubject;
use Notification\Services\NotificationService;

/**
 * Class GroupEntry
 * @package Notification\Services\Types
 */
class GroupEntry extends NotificationService
{

    /**
     * @var NotificationMapper
     */
    private $notificationMapper;
    /**
     * @var \Gruppen_Model_Mapper_GruppenMapper
     */
    private $groupMapper;

    /**
     * GroupEntry constructor.
     */
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
        $this->handle($notification->getSubjectId(), NotificationTypes::JOINED_GROUP);
    }

    /**
     * @param int $subjectId
     * @param int $notificationType
     *
     * @throws \Exception
     */
    public function handle (int $subjectId, int $notificationType)
    {
        $characterToGroup = $this->groupMapper->getCharacterToGroup($subjectId);
        $group = $this->groupMapper->getGruppeByGruppenId($characterToGroup->groupId);

        if ($group->getGruender() !== $characterToGroup->characterId) {
            $notification = new Notification();
            $notification->setSubjectId($subjectId)
                ->setType(NotificationTypes::JOINED_GROUP)
                ->setUserId($characterToGroup->characterId);
            $this->getMapper()->create($notification);
        }
    }

    /**
     * @return NotificationMapper
     */
    protected function getMapper (): NotificationMapper
    {
        if ($this->notificationMapper === null) {
            $this->notificationMapper = new \Notification\Models\Mappers\Types\GroupEntry();
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
        return new GroupEntrySubject($this->groupMapper->getGroupByCharacterZuo($id));
    }


}