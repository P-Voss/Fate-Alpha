<?php


namespace Notification\Models\View;


use Nachrichten\Model\Message;
use Notification\Models\NotificationSubject;

class PersonalMessageSubject implements NotificationSubject
{

    /**
     * @var Message
     */
    private $message;

    /**
     * PersonalMessageSubject constructor.
     *
     * @param Message $message
     */
    public function __construct (Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getSubjectId (): int
    {
        return $this->message->getId();
    }

    /**
     * @return string
     */
    public function getSubjectTitle (): string
    {
        return '(' . $this->message->getBetreff() . ')';
    }

    /**
     * @return string
     */
    public function getSubjectDescription (): string
    {
        return sprintf(
            "Neue Nachricht von: %s",
            $this->message->getAdmin() ? 'Administration' : $this->message->getVerfasser()->getProfilname()
        );
    }


}