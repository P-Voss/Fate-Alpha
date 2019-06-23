<?php

namespace Notification\Services\Types;


use Notification\Models\Notification;
use Notification\Models\Mappers\NotificationMapper;
use Notification\Models\NotificationSubject;
use Notification\Models\NotificationTypes;
use Notification\Models\View\EpisodeStartSubject;
use Notification\Services\NotificationService;

/**
 * Class EpisodeStart
 * @package Notification\Services\Types
 */
class EpisodeStart extends NotificationService
{

    /**
     * @var NotificationMapper
     */
    private $notificationMapper;
    /**
     * @var \Story_Model_Mapper_EpisodeMapper
     */
    private $episodeMapper;

    /**
     * GroupEntry constructor.
     */
    public function __construct ()
    {
        $this->episodeMapper = new \Story_Model_Mapper_EpisodeMapper();
    }

    /**
     * @param Notification $notification
     *
     * @throws \Exception
     */
    public function create (Notification $notification)
    {
        $this->handle($notification->getSubjectId(), NotificationTypes::EPISODE_STARTED);
    }

    /**
     * @param int $subjectId
     * @param int $notificationType
     *
     * @throws \Exception
     */
    public function handle (int $subjectId, int $notificationType)
    {
        $plotmapper = new \Story_Model_Mapper_PlotMapper();
        $episode = $this->episodeMapper->getEpisodeById($subjectId);

        $plot = $plotmapper->getPlotById($episode->getPlotId());
        $notification = new Notification();
        $notification->setSubjectId($subjectId)
            ->setType($notificationType)
            ->setUserId($plot->getSlId());
        $this->getMapper()->create($notification);
    }

    /**
     * @return NotificationMapper
     */
    protected function getMapper (): NotificationMapper
    {
        if ($this->notificationMapper === null) {
            $this->notificationMapper = new \Notification\Models\Mappers\Types\EpisodeStart();
        }
        return $this->notificationMapper;
    }

    /**
     * @param int $id
     *
     * @return NotificationSubject
     * @throws \Exception
     */
    protected function getSubject (int $id): NotificationSubject
    {
        return new EpisodeStartSubject($this->episodeMapper->getEpisodeById($id));
    }


}