<?php

use Logs\Services\Log;

/**
 * Description of Administration_Service_Logs
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Logs extends Log {
    
    const EPISODE_ACCEPTED_STATUS = 6;
    const EPISODE_REJECTED_STATUS = 7;
    
    const SCND_LIFE_NONE = 1;
    const SCND_LIFE_SCHICKSAL = 17;
    const SCND_LIFE_UNDEAD = 41;
    
    
    /**
     * @var Administration_Model_Mapper_LogsMapper
     */
    private $mapper;

    /**
     * @var Application_Model_Mapper_CharakterMapper
     */
    private $charakterMapper;


    /**
     * Administration_Service_Logs constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->mapper = new Administration_Model_Mapper_LogsMapper();
        $this->charakterMapper = new Application_Model_Mapper_CharakterMapper();
    }

    /**
     * @param int $episodeId
     *
     * @return bool
     * @throws Exception
     */
    public function alreadyJudged ($episodeId)
    {
        $episode = $this->mapper->getEpisode($episodeId);
        return in_array($episode->getStatus()->getId(), [self::EPISODE_ACCEPTED_STATUS, self::EPISODE_REJECTED_STATUS]);
    }


    /**
     * @return array
     * @throws Exception
     */
    public function getEpisodesToReview() {
        return $this->mapper->getEpisodesToReview();
    }


    /**
     * @param $episodeId
     *
     * @return Administration_Model_Episode
     * @throws Exception
     */
    public function getEpisode($episodeId) {
        $episode = $this->mapper->getEpisodeToReview($episodeId);
        $episode->setAuswertungen($this->mapper->getLogreaderResults($episodeId));
        return $episode;
    }


    /**
     * @param $episodeId
     * @param Zend_Controller_Request_Http $request
     */
    public function rejectEpisode($episodeId, Zend_Controller_Request_Http $request) {
        $auswertung = new Administration_Model_Auswertung();
        $auswertung->setUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        $auswertung->setDescription($request->getPost('feedback', ''));
        $this->mapper->insertRejection($episodeId, $auswertung);
        $this->mapper->updateStatus($episodeId, self::EPISODE_REJECTED_STATUS);
    }


    /**
     * @param $episodeId
     *
     * @throws Exception
     */
    public function acceptEpisode($episodeId) {
        $storyEpisodeService = new Story_Service_Episode();
        $skillMapper = new \Shop\Models\Mappers\SkillMapper();
        $magieMapper = new \Shop\Models\Mappers\MagieMapper();
        $itemMapper = new \Shop\Models\Mappers\ItemMapper();
        $achievementMapper = new Application_Model_Mapper_CharakterMapper();

        $participants = $storyEpisodeService->getParticipantsByEpisode($episodeId);
        foreach ($participants as $charakter) {
            $charakterId = $charakter->getCharakterid();
            $result = $charakter->getResult();

            foreach ($result->getSkillsToAdd() as $skill) {
                if (!$skillMapper->checkIfLearned($charakterId, $skill->getId())) {
                    $skillMapper->unlockSkillByRPG($charakterId, $skill->getId());
                }
            }
            foreach ($result->getSkillsToRemove() as $skill) {
                $skillMapper->removeSkill($charakterId, $skill->getId());
            }
            foreach ($result->getMagicToAdd() as $magie) {
                if (!$magieMapper->checkIfLearned($charakterId, $magie->getId())) {
                    $magieMapper->unlockMagieByRPG($charakterId, $magie->getId());
                }
            }
            foreach ($result->getMagicToRemove() as $magie) {
                $magieMapper->unlockMagieByRPG($charakterId, $magie->getId());
            }
            foreach ($result->getItemsToAdd() as $item) {
                if (!$itemMapper->checkIfLearned($charakterId, $item->getId())) {
                    $itemMapper->unlockByRpg($charakterId, $item->getId());
                }
            }
            foreach ($result->getItemsToRemove() as $item) {
                $itemMapper->removeItem($charakterId, $item->getId());
            }
            foreach ($result->getItemsToAdd() as $item) {
                if (!$itemMapper->checkIfLearned($charakterId, $item->getId())) {
                    $itemMapper->unlockByRpg($charakterId, $item->getId());
                }
            }
            foreach ($result->getItemsToRemove() as $item) {
                $itemMapper->removeItem($charakterId, $item->getId());
            }
            foreach ($result->getAchievementsToAdd() as $achievement) {
                $achievementMapper->addAchievement($achievement, $charakterId);
            }
            foreach ($result->getAchievementsToRemove() as $achievement) {
                $achievementMapper->deleteAchievement($achievement->getAchievementId());
            }

            foreach ($result->getCharaktersKilled() as $kill) {
                $this->charakterMapper->setCharakterKill($charakterId, $kill->getCharakterId(), $episodeId);
                $this->killCharakter($kill->getCharakterid());
            }
            if ($result->getKillNpcs() > 0) {
                $this->charakterMapper->updateNpcKills($charakterId, $result->getKillNpcs());
            }
            if ($result->getDied() === 1) {
                $this->killCharakter($charakterId);
            }
        }
        $this->mapper->updateStatus($episodeId, self::EPISODE_ACCEPTED_STATUS);
    }

    /**
     * @param int $charakterId
     *
     * @throws Exception
     */
    private function killCharakter($charakterId) {
        $charakterService = new Application_Service_Charakter();
        $charakter = $charakterService->getCharakterById($charakterId);
        switch ($this->getActionOnDeath($charakter->getTraits())) {
            case self::SCND_LIFE_NONE:
                $this->charakterMapper->deactivateCharakter($charakterId);
                break;
            case self::SCND_LIFE_UNDEAD:
                $this->setCharakterUndead($charakter);
                break;
            case self::SCND_LIFE_SCHICKSAL:
                $this->setCharakterSecondChance($charakter);
                break;
            default:
                $this->charakterMapper->deactivateCharakter($charakterId);
                break;
        }
    }

    /**
     * @param Application_Model_Trait[] $traits
     *
     * @return int
     */
    private function getActionOnDeath(array $traits) {
        foreach ($traits as $trait) {
            if ($trait->getTraitId() === self::SCND_LIFE_UNDEAD) {
                return self::SCND_LIFE_UNDEAD;
            }
        }
        foreach ($traits as $trait) {
            if ($trait->getTraitId() === self::SCND_LIFE_SCHICKSAL) {
                return self::SCND_LIFE_SCHICKSAL;
            }
        }
        return self::SCND_LIFE_NONE;
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @throws Exception
     */
    private function setCharakterUndead(Application_Model_Charakter $charakter) {
        $this->charakterMapper->removeTrait($charakter->getCharakterid(), self::SCND_LIFE_UNDEAD);
        $this->charakterMapper->setUndead($charakter->getCharakterid());
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @throws Exception
     */
    private function setCharakterSecondChance(Application_Model_Charakter $charakter) {
        $this->charakterMapper->removeTrait($charakter->getCharakterid(), self::SCND_LIFE_SCHICKSAL);
    }
    
}
