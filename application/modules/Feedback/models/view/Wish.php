<?php


namespace Feedback\Models\View;


/**
 * Class Wish
 * @package Feedback\Models\View
 */
class Wish
{

    /**
     * @var \Feedback\Models\Wish
     */
    private $wish;
    /**
     * @var \Application_Model_User
     */
    private $user;

    /**
     * Wish constructor.
     *
     * @param \Feedback\Models\Wish $wish
     * @param \Application_Model_User $user
     */
    public function __construct (\Feedback\Models\Wish $wish, \Application_Model_User $user)
    {
        $this->wish = $wish;
        $this->user = $user;
    }


    /**
     * @return int
     */
    public function getId ()
    {
        return $this->wish->getWishId();
    }

    /**
     * @return string
     */
    public function getTitle ()
    {
        return $this->wish->getTitle();
    }


    /**
     * @return string
     */
    public function getDescription ()
    {
        return $this->wish->getDescription();
    }


    /**
     * @return string
     */
    public function getDate ()
    {
        return $this->wish->getCreationDatetime();
    }


    /**
     * @return string
     */
    public function getSender ()
    {
        return $this->user->getProfilname();
    }

}