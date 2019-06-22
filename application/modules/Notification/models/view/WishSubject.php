<?php


namespace Notification\Models\View;


use Feedback\Models\Wish;
use Notification\Models\NotificationSubject;

class WishSubject implements NotificationSubject
{

    /**
     * @var Wish
     */
    private $wish;

    /**
     * PersonalMessageSubject constructor.
     *
     * @param Wish $wish
     */
    public function __construct (Wish $wish)
    {
        $this->wish = $wish;
    }

    /**
     * @return int
     */
    public function getSubjectId (): int
    {
        return $this->wish->getWishId();
    }

    /**
     * @return string
     */
    public function getSubjectTitle (): string
    {
        return $this->wish->getTitle();
    }

    /**
     * @return string
     */
    public function getSubjectDescription (): string
    {
        return "Neuer Spielerwunsch: ";
    }


}