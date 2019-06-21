<?php


namespace Notification\Services\Types;


use Feedback\Models\Notification;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Services\NotificationService;

class GroupMessages extends NotificationService
{

    public function create (Notification $notification): int
    {
        // TODO: Implement create() method.
    }

    public function handle (int $subjectId, int $notificationType)
    {
        // TODO: Implement handle() method.
    }

    public function loadByUserId (int $userId): array
    {
        // TODO: Implement loadByUserId() method.
    }

    /**
     * @return NotificationMapper
     */
    protected function getMapper (): NotificationMapper
    {
        // TODO: Implement getMapper() method.
    }

}