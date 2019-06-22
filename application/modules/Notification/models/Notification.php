<?php


namespace Notification\Models;


class Notification implements NotificationSubject
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
    private $subjectId;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var NotificationSubject
     */
    private $subject;

    /**
     * @return int
     */
    public function getNotificationId (): int
    {
        return $this->notificationId;
    }

    /**
     * @param int $notificationId
     *
     * @return Notification
     */
    public function setNotificationId (int $notificationId): Notification
    {
        $this->notificationId = $notificationId;
        return $this;
    }

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
    public function getSubjectId (): int
    {
        return $this->subjectId;
    }

    /**
     * @param int $subjectId
     *
     * @return Notification
     */
    public function setSubjectId (int $subjectId): Notification
    {
        $this->subjectId = $subjectId;
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
     * @return string
     */
    public function getSubjectTitle (): string
    {
        return $this->subject->getSubjectTitle();
    }

    /**
     * @return string
     */
    public function getSubjectDescription (): string
    {
        return $this->subject->getSubjectDescription();
    }

    /**
     * @param NotificationSubject $notificationSubject
     *
     * @return $this
     */
    public function setSubject (NotificationSubject $notificationSubject)
    {
        $this->subject = $notificationSubject;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        $data = [
            'subjectId' => $this->subjectId,
            'type' => $this->type,
            'userId' => $this->userId
        ];
        if ($this->notificationId !== null) {
            $data['notificationId'] = $this->notificationId;
        }
        return $data;
    }

}