<?php

/**
 * Description of Administration_Service_Logs
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Logs extends Logs_Service_Log {
    
    const EPISODE_ACCEPTED_STATUS = 6;
    const EPISODE_REJECTED_STATUS = 7;
    
    const SCND_LIFE_NONE = 1;
    const SCND_LIFE_SCHICKSAL = 17;
    const SCND_LIFE_UNDEAD = 41;
    
    
    /**
     * @var Administration_Model_Mapper_LogsMapper
     */
    private $mapper;
    
    private $charakterMapper;
    
    
    public function __construct() {
        parent::__construct();
        $this->mapper = new Administration_Model_Mapper_LogsMapper();
        $this->charakterMapper = new Application_Model_Mapper_CharakterMapper();
    }
    
    
    public function getEpisodesToReview() {
        return $this->mapper->getEpisodesToReview();
    }
    
    
    public function getEpisode($episodeId) {
        $episode = $this->mapper->getEpisodeToReview($episodeId);
        $episode->setAuswertungen($this->mapper->getLogreaderResults($episodeId));
        return $episode;
    }
    
    
    public function rejectEpisode($episodeId, Zend_Controller_Request_Http $request) {
        $auswertung = new Administration_Model_Auswertung();
        $auswertung->setUserId(Zend_Auth::getInstance()->getIdentity()->userId);
        $auswertung->setDescription($request->getPost('feedback', ''));
        $this->mapper->insertRejection($episodeId, $auswertung);
        $this->mapper->updateStatus($episodeId, self::EPISODE_REJECTED_STATUS);
    }
    
    
    public function acceptEpisode($episodeId) {
        $mapper = new Story_Model_Mapper_EpisodeMapper();
        $skillMapper = new Shop_Model_Mapper_SkillMapper();
        $magieMapper = new Shop_Model_Mapper_MagieMapper();
        
        $participants = $mapper->getParticipantsByEpisode($episodeId);
        foreach ($participants as $charakter) {
            $charakterId = $charakter->getCharakterid();
            $result = $mapper->getCharakterResult($episodeId, $charakterId);
            foreach ($result->getRequestedSkills() as $skill) {
                if (!$skillMapper->checkIfLearned($charakterId, $skill->getId())) {
                    $skillMapper->unlockSkillByRPG($charakterId, $skill->getId());
                }
            }
            foreach ($result->getRequestedMagien() as $magie) {
                if (!$magieMapper->checkIfLearned($charakterId, $magie->getId())) {
                    $magieMapper->unlockMagieByRPG($charakterId, $magie->getId());
                }
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
        switch ($this->getActionOnDeath($charakter->getVorteile())) {
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
     * @param Application_Model_Vorteil[] $vorteile
     *
     * @return int
     */
    private function getActionOnDeath(array $vorteile) {
        foreach ($vorteile as $vorteil) {
            if ($vorteil->getId() === self::SCND_LIFE_UNDEAD) {
                return self::SCND_LIFE_UNDEAD;
            }
        }
        foreach ($vorteile as $vorteil) {
            if ($vorteil->getId() === self::SCND_LIFE_SCHICKSAL) {
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
        $this->charakterMapper->removeVorteil($charakter->getCharakterid(), self::SCND_LIFE_UNDEAD);
        $this->charakterMapper->setUndead($charakter->getCharakterid());
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @throws Exception
     */
    private function setCharakterSecondChance(Application_Model_Charakter $charakter) {
        $this->charakterMapper->removeVorteil($charakter->getCharakterid(), self::SCND_LIFE_SCHICKSAL);
    }
    
}
