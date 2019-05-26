<?php

/**
 * Description of Application_Model_CharakterResult
 *
 * @author Voß
 */
class Application_Model_CharakterResult implements Application_Model_Interfaces_CharakterResult
{

    /**
     * @var Story_Model_Skill[]
     */
    protected $requestedSkills = [];
    /**
     * @var Story_Model_Magie[]
     */
    protected $requestedMagien = [];
    /**
     * @var Application_Model_Item[]
     */
    protected $requestedItems = [];
    /**
     * @var array
     */
    protected $requestedEigenschaften = [];
    /**
     * @var Application_Model_Charakter[]
     */
    protected $charaktersKilled = [];
    /**
     * @var Application_Model_Achievement[]
     */
    protected $achievements = [];
    /**
     * @var bool
     */
    protected $died;
    /**
     * @var int
     */
    protected $killNpcs = 0;
    /**
     * @var string
     */
    protected $comment;

    /**
     * @return Story_Model_Skill[]
     */
    public function getRequestedSkills ()
    {
        return $this->requestedSkills;
    }


    /**
     * @return Story_Model_Magie[]
     */
    public function getRequestedMagien ()
    {
        return $this->requestedMagien;
    }

    /**
     * @return Application_Model_Item[]
     */
    public function getRequestedItems ()
    {
        return $this->requestedItems;
    }

    /**
     * @return array
     */
    public function getRequestedEigenschaften ()
    {
        return $this->requestedEigenschaften;
    }

    /**
     * @return array
     */
    public function getCharaktersKilled ()
    {
        return $this->charaktersKilled;
    }

    /**
     * @return boolean
     */
    public function getDied ()
    {
        return $this->died;
    }

    /**
     * @return int
     */
    public function getKillNpcs ()
    {
        return $this->killNpcs;
    }

    /**
     * @param Application_Model_Skill[] $requestedSkills
     */
    public function setRequestedSkills ($requestedSkills)
    {
        foreach ($requestedSkills as $skill) {
            if ($skill instanceof Application_Model_Skill) {
                $this->requestedSkills[] = $skill;
            }
        }
    }

    /**
     * @param Application_Model_Magie[] $requestedMagien
     */
    public function setRequestedMagien ($requestedMagien)
    {
        foreach ($requestedMagien as $magie) {
            if ($magie instanceof Application_Model_Magie) {
                $this->requestedMagien[] = $magie;
            }
        }
    }

    /**
     * @param Application_Model_Item[] $requestedItems
     */
    public function setRequestedItems ($requestedItems = [])
    {
        foreach ($requestedItems as $item) {
            if ($item instanceof Application_Model_Item) {
                $this->requestedItems[] = $item;
            }
        }
    }

    /**
     * @param $requestedEigenschaften
     */
    public function setRequestedEigenschaften ($requestedEigenschaften)
    {
        $this->requestedEigenschaften = $requestedEigenschaften;
    }

    /**
     * @param $charaktersKilled
     */
    public function setCharaktersKilled ($charaktersKilled)
    {
        $this->charaktersKilled = $charaktersKilled;
    }

    /**
     * @param boolean $died
     */
    public function setDied ($died)
    {
        $this->died = $died;
    }

    /**
     * @param int $killNpcs
     */
    public function setKillNpcs ($killNpcs)
    {
        $this->killNpcs = $killNpcs;
    }

    /**
     * @return string
     */
    public function getComment ()
    {
        return $this->comment !== null ? $this->comment : '';
    }

    /**
     * @param string $comment
     */
    public function setComment ($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return Application_Model_Achievement[]
     */
    public function getAchievements (): array
    {
        return $this->achievements;
    }

    /**
     * @return Application_Model_Achievement[]
     */
    public function getAchievementsToAdd ()
    {
        return array_filter($this->achievements, function (Story_Model_Achievement $achievement) {
            return $achievement->getRequestType() === Story_Model_RequestTypes::ADD;
        });
    }

    /**
     * @return Application_Model_Achievement[]
     */
    public function getAchievementsToRemove ()
    {
        return array_filter($this->achievements, function (Story_Model_Achievement $achievement) {
            return $achievement->getRequestType() === Story_Model_RequestTypes::REMOVE;
        });
    }

    /**
     * @param Application_Model_Achievement[] $achievements
     *
     * @return Application_Model_CharakterResult
     */
    public function setAchievements (array $achievements): Application_Model_CharakterResult
    {
        $this->achievements = $achievements;
        return $this;
    }

    /**
     * @return Story_Model_Skill[]
     */
    public function getSkillsToAdd ()
    {
        return array_filter($this->requestedSkills, function (Story_Model_Skill $skill) {
            return $skill->getRequestType() === Story_Model_RequestTypes::ADD;
        });
    }

    /**
     * @return Story_Model_Skill[]
     */
    public function getSkillsToRemove ()
    {
        return array_filter($this->requestedSkills, function (Story_Model_Skill $skill) {
            return $skill->getRequestType() === Story_Model_RequestTypes::REMOVE;
        });
    }

    /**
     * @return Story_Model_Magie[]
     */
    public function getMagicToAdd ()
    {
        return array_filter($this->requestedMagien, function (Story_Model_Magie $magic) {
            return $magic->getRequestType() === Story_Model_RequestTypes::ADD;
        });
    }

    /**
     * @return Story_Model_Magie[]
     */
    public function getMagicToRemove ()
    {
        return array_filter($this->requestedMagien, function (Story_Model_Magie $magic) {
            return $magic->getRequestType() === Story_Model_RequestTypes::REMOVE;
        });
    }

}
