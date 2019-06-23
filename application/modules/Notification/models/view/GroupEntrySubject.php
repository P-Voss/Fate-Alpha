<?php


namespace Notification\Models\View;


use Notification\Models\NotificationSubject;

class GroupEntrySubject implements NotificationSubject
{

    /**
     * @var \Gruppen_Model_Gruppe
     */
    private $group;

    /**
     * PersonalMessageSubject constructor.
     *
     * @param \Gruppen_Model_Gruppe $group
     */
    public function __construct (\Gruppen_Model_Gruppe $group)
    {
        $this->group = $group;
    }

    /**
     * @return int
     */
    public function getSubjectId (): int
    {
        return $this->group->getId();
    }

    /**
     * @return string
     */
    public function getSubjectTitle (): string
    {
        return $this->group->getName();
    }

    /**
     * @return string
     */
    public function getSubjectDescription (): string
    {
        return "Du wurdest in eine Gruppe eingeladen: ";
    }


}