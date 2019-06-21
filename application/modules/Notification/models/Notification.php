<?php


namespace Feedback\Models;


class Notification
{

    /**
     * @var int
     */
    private $notificationId;
    /**
     * @var int
     */
    private $type;
    /**
     * @var int
     */
    private $notificationElementId;
    /**
     * @var int
     */
    private $userId;

    /**
     * @return int
     */
    public function getType (): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return Notification
     * @throws \Exception
     */
    public function setType (int $type): Notification
    {
        if (!in_array($type, NotificationTypes::getNotificationTypes())) {
            throw new \Exception('Invalid NotificationType');
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getNotificationElementId (): int
    {
        return $this->notificationElementId;
    }

    /**
     * @param int $notificationElementId
     *
     * @return Notification
     */
    public function setNotificationElementId (int $notificationElementId): Notification
    {
        $this->notificationElementId = $notificationElementId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId (): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return Notification
     */
    public function setUserId (int $userId): Notification
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        $data = [
            'subjectId' => $this->notificationElementId,
            'type' => $this->type,
            'userId' => $this->userId
        ];
        if ($this->notificationId !== null) {
            $data['notificationId'] = $this->notificationId;
        }
        return $data;
    }

}