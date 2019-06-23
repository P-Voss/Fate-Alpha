<?php


namespace Notification\Models\View;


use Notification\Models\NotificationSubject;

class EpisodeStartSubject implements NotificationSubject
{

    /**
     * @var \Story_Model_Episode
     */
    private $episode;

    /**
     * PersonalMessageSubject constructor.
     *
     * @param \Story_Model_Episode $episode
     */
    public function __construct (\Story_Model_Episode $episode)
    {
        $this->episode = $episode;
    }

    /**
     * @return int
     */
    public function getSubjectId (): int
    {
        return $this->episode->getId();
    }

    /**
     * @return string
     */
    public function getSubjectTitle (): string
    {
        return 'Episode: ' . $this->episode->getName();
    }

    /**
     * @return string
     */
    public function getSubjectDescription (): string
    {
        return "Alle Spieler sind bereit zum Start!";
    }

}