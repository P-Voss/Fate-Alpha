<?php


namespace Notification\Models\Mappers\Types;


use Notification\Models\Notification;
use Notification\Models\NotificationTypes;
use Notification\Models\Mappers\NotificationMapper;

class GroupMessages extends NotificationMapper
{

    /**
     * @param int $userId
     *
     * @return Notification[]
     * @throws \Exception
     */
    public function loadByUserId (int $userId): array
    {
        return $this->load($userId, NotificationTypes::GROUP_MESSAGE);
    }

    /**
     * @param Notification $notification
     *
     * @throws \Exception
     */
    public function create(Notification $notification)
    {
        if ($this->hasNotification($notification->getUserId(), $notification->getSubjectId())) {
            return;
        }
        $this->getDbTable('Notification')->insert($notification->toArray());
    }

    /**
     * @param int $userId
     * @param int $subjectId
     *
     * @return bool
     * @throws \Exception
     */
    private function hasNotification (int $userId, int $subjectId): bool
    {
        $select = $this->getDbTable('Notification')
            ->select()
            ->setIntegrityCheck(false)
            ->from('gruppenchat', ['nachrichtenId'])
            ->joinInner(['oldMessages' => 'gruppenchat'], 'oldMessages.gruppenId = gruppenchat.gruppenId', [])
            ->joinInner(
                'notifications',
                'notifications.subjectId = oldMessages.nachrichtenId AND notifications.type = 1',
                []
            )
            ->where('gruppenchat.nachrichtenId = ?', $subjectId)
            ->where('notifications.userId = ?', $userId);
        $result = $this->getDbTable('Notification')->fetchAll(
            $select
        );
        return $result->count() > 0;
    }

}