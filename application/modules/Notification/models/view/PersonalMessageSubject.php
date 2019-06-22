<?php


namespace Notification\Models\View;


use Notification\Models\NotificationSubject;

class PersonalMessageSubject implements NotificationSubject
{

    /**
     * @var \Nachrichten_Model_Nachricht
     */
    private $message;

    /**
     * PersonalMessageSubject constructor.
     *
     * @param \Nachrichten_Model_Nachricht $message
     */
    public function __construct (\Nachrichten_Model_Nachricht $message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getId (): int
    {
        return $this->message->getId();
    }

    /**
     * @return string
     */
    public function getTitle (): string
    {
        return $this->message->getBetreff();
    }

    /**
     * @return string
     */
    public function getDescription (): string
    {
        return sprintf(
            "Neue Nachricht von: %s",
            $this->message->getAdmin() ? 'Administration' : $this->message->getVerfasser()->getProfilname()
        );
    }


}