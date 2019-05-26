<?php

/**
 * Description of Story_Service_Episode
 *
 * @author Voß
 */
class Story_Service_Episode
{

    /**
     * @var Story_Model_Mapper_PlotMapper
     */
    protected $plotMapper;
    /**
     * @var Story_Model_Mapper_EpisodeMapper
     */
    protected $episodeMapper;

    public function __construct ()
    {
        $this->plotMapper = new Story_Model_Mapper_PlotMapper();
        $this->episodeMapper = new Story_Model_Mapper_EpisodeMapper();
    }

    /**
     * @param int $episodeId
     * @param int $userId
     *
     * @return boolean
     */
    public function isSL ($episodeId, $userId)
    {
        return $this->episodeMapper->verifySl($episodeId, $userId);
    }

    /**
     * @param int $episodeId
     * @param int $charakterId
     *
     * @return boolean
     */
    public function isPlayer ($episodeId, $charakterId)
    {
        return $this->episodeMapper->verifyPlayer($episodeId, $charakterId);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return int
     * @throws Exception
     */
    public function createEpisode (Zend_Controller_Request_Http $request)
    {
        $episode = new Story_Model_Episode();
        $episode->setName($request->getPost('episodename'));
        $episode->setBeschreibung($request->getPost('beschreibung'));
        $episode->setPlotId($request->getPost('plotId'));
        $episodenId = $this->episodeMapper->createEpisode($episode);
        if (count($request->getPost('participants')) > 0) {
            $this->episodeMapper->addParticipants($episodenId, $request->getPost('participants'));
        }
        $episode->setId($episodenId);
        $this->episodeMapper->setBeschreibung($episode);
        return $episodenId;
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @throws Exception
     */
    public function editEpisode (Zend_Controller_Request_Http $request)
    {
        $episode = new Story_Model_Episode();
        $episode->setId($request->getPost('episodeId'));
        $episode->setName($request->getPost('episodename'));
        $episode->setBeschreibung($request->getPost('beschreibung'));
        $this->episodeMapper->removeParticipants($episode->getId());
        $this->episodeMapper->updateEpisode($episode);
        if (count($request->getPost('participants')) > 0) {
            $this->episodeMapper->addParticipants($episode->getId(), $request->getPost('participants'));
        }
        $this->episodeMapper->setBeschreibung($episode);
        $status = new Story_Model_EpisodenStatus();
        $status->setId(1);
        $this->episodeMapper->updateStatus($status, $episode->getId());
    }

    /**
     * @param Story_Model_Episode $episode
     *
     * @throws Exception
     */
    public function deleteEpisode (Story_Model_Episode $episode)
    {
        $this->episodeMapper->deleteEpisode($episode->getId());
    }

    /**
     * @param int $episodeId
     *
     * @throws Exception
     */
    public function startEpisode ($episodeId)
    {
        $status = new Story_Model_EpisodenStatus();
        $status->setId(2);
        $this->episodeMapper->updateStatus($status, $episodeId);
    }

    /**
     * @param int $episodeId
     * @param int $zusammenfassung
     *
     * @throws Exception
     */
    public function finishEpisode ($episodeId, $zusammenfassung)
    {
        $episode = new Story_Model_Episode();
        $episode->setId($episodeId);
        $episode->setZusammenfassung($zusammenfassung);
        $status = new Story_Model_EpisodenStatus();
        $status->setId(4);
        $this->episodeMapper->updateStatus($status, $episodeId);
        $this->episodeMapper->setZusammenfassung($episode);
        $this->episodeMapper->resetEvaluations($episodeId);
        $this->episodeMapper->resetRejection($episodeId);
    }

    /**
     * @param int $plotId
     *
     * @return array
     * @throws Exception
     */
    public function getEpisodesByPlotId ($plotId)
    {
        return $this->episodeMapper->getEpisodesByPlotId($plotId);
    }

    /**
     * @param int $plotId
     *
     * @return array
     * @throws Exception
     */
    public function getActiveEpisodesByPlotId ($plotId)
    {
        return $this->episodeMapper->getActiveEpisodesByPlotId($plotId);
    }

    /**
     * @param int $plotId
     * @param int $userId
     *
     * @return array
     * @throws Exception
     */
    public function getEpisodesByPlotIdForUser ($plotId, $userId)
    {
        return $this->episodeMapper->getEpisodesByPlotIdForUser($plotId, $userId);
    }

    /**
     * @param int $episodeId
     *
     * @return Story_Model_Episode
     * @throws Exception
     */
    public function getEpisode ($episodeId)
    {
        return $this->episodeMapper->getEpisodeById($episodeId);
    }

    /**
     * @param int $episodeId
     *
     * @return array
     * @throws Exception
     */
    public function getParticipantsByEpisodeId ($episodeId)
    {
        return $this->episodeMapper->getParticipants($episodeId);
    }

    /**
     * @param int $episodeId
     *
     * @return array
     * @throws Exception
     */
    public function getParticipantsReady ($episodeId)
    {
        return $this->episodeMapper->getParticipantsByEpisodeAndStatus($episodeId, 1);
    }

    /**
     * @param $episodeId
     * @param $characterId
     *
     * @return Story_Model_Charakter
     * @throws Exception
     */
    public function getParticipant ($episodeId, $characterId)
    {
        $participant = $this->episodeMapper->getParticipant($episodeId, $characterId);
        $participant->setResult($this->getResult($episodeId, $characterId));

        return $participant;
    }

    /**
     * @param int $episodeId
     *
     * @return array
     * @throws Exception
     */
    public function getParticipantsByEpisode ($episodeId)
    {
        $participants = $this->episodeMapper->getParticipantsByEpisode($episodeId);
        foreach ($participants as $participant) {
            $participant->setResult($this->getResult($episodeId, $participant->getCharakterid()));
        }
        return $participants;
    }

    /**
     * @param $episodeId
     * @param $characterId
     *
     * @return Story_Model_CharakterResult
     * @throws Exception
     */
    private function getResult ($episodeId, $characterId)
    {
        $achievementMapper = new Story_Model_Mapper_Result_AchievementMapper();
        $magicMapper = new Story_Model_Mapper_Result_MagicMapper();
        $skillMapper = new Story_Model_Mapper_Result_SkillMapper();
        $itemMapper = new Story_Model_Mapper_Result_ItemMapper();

        $result = $this->episodeMapper->getCharakterResult($episodeId, $characterId);
        $result->setRequestedMagien($magicMapper->getRequestedMagic($episodeId, $characterId));
        $result->setRequestedSkills($skillMapper->getRequestedSkills($episodeId, $characterId));
        $result->setCharaktersKilled($this->episodeMapper->getRequestedCharakterKills($episodeId, $characterId));
        $result->setAchievements($achievementMapper->getRequestedAchievements($episodeId, $characterId));
        $result->setRequestedItems($itemMapper->getRequestedItems($episodeId, $characterId));

        return $result;
    }

    /**
     * @param int $episodeId
     *
     * @return array
     * @throws Exception
     */
    public function getParticipantsPending ($episodeId)
    {
        return $this->episodeMapper->getParticipantsByEpisodeAndStatus($episodeId, 0);
    }

    /**
     * @param $status
     * @param $episodeId
     * @param $charakterId
     *
     * @throws Exception
     */
    public function updateReadyStatus ($status, $episodeId, $charakterId)
    {
        if (!$this->episodeMapper->allReady($episodeId)) {
            $this->episodeMapper->updateCharakterStatus($status, $episodeId, $charakterId);
        }
        if ($this->episodeMapper->allReady($episodeId)) {
            $status = new Story_Model_EpisodenStatus();
            $status->setId(3);
            $this->episodeMapper->updateStatus($status, $episodeId);
            $this->episodeMapper->initCharakterResult($episodeId);
        }
    }

    /**
     * @param $episodenId
     * @param $charakterId
     * @param $killcount
     *
     * @throws Exception
     */
    public function updateCharakterNpckills ($episodenId, $charakterId, $killcount)
    {
        $this->episodeMapper->updateCharakterNpckills($episodenId, $charakterId, $killcount);
    }

    /**
     * @param $episodenId
     * @param $charakterId
     * @param $comment
     *
     * @throws Exception
     */
    public function updateCharakterComment ($episodenId, $charakterId, $comment)
    {
        $this->episodeMapper->updateCharakterComment($episodenId, $charakterId, $comment);
    }

    /**
     * @param $episodenId
     * @param $charakterId
     * @param $gotKilled
     *
     * @throws Exception
     */
    public function updateCharakterGotKilled ($episodenId, $charakterId, $gotKilled)
    {
        $this->episodeMapper->updateCharakterGotKilled($episodenId, $charakterId, $gotKilled);
    }

    /**
     * @param $episodenId
     * @param $charakterId
     * @param Zend_Controller_Request_Http $request
     *
     * @throws Exception
     */
    public function updateCharakterKills ($episodenId, $charakterId, Zend_Controller_Request_Http $request)
    {
        if ($request->getPost('ids') === null) {
            $ids = [];
        } else {
            $ids = is_array($request->getPost('ids')) ? $request->getPost('ids') : [$request->getPost('ids')];
        }
        $this->episodeMapper->removeCharakterKillRequests($episodenId, $charakterId);
        $this->episodeMapper->addCharakterKillRequests($episodenId, $charakterId, $ids);
    }

    /**
     * @param $episodeId
     *
     * @return Story_Model_Auswertung
     * @throws Exception
     */
    public function getRejection ($episodeId)
    {
        return $this->episodeMapper->getRejection($episodeId);
    }

    /**
     * @param Story_Model_Achievement $achievement
     *
     * @throws Exception
     */
    public function addAchievement (Story_Model_Achievement $achievement)
    {
        $this->episodeMapper->addAchievementRequest($achievement);
    }

    /**
     * @param $episodeId
     * @param $charakterId
     * @param int $achievementId
     *
     * @throws Exception
     */
    public function removeAchievement ($episodeId, $charakterId, $achievementId)
    {
        $this->episodeMapper->removeAchievement($episodeId, $charakterId, $achievementId);
    }

}
