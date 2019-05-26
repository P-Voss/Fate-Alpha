<?php

/**
 * Description of Story_Model_CharakterResult
 *
 * @author Voß
 */
class Story_Model_CharakterResult extends Application_Model_CharakterResult implements Application_Model_Interfaces_CharakterResult {


    /**
     * @return Story_Model_Achievement[]
     */
    public function getAchievements (): array
    {
        return $this->achievements;
    }

    /**
     * @return Story_Model_Achievement[]
     */
    public function getAchievementsToAdd ()
    {
        return array_filter($this->achievements, function (Story_Model_Achievement $achievement) {
            return $achievement->getRequestType() === Story_Model_RequestTypes::ADD;
        });
    }

    /**
     * @return Story_Model_Achievement[]
     */
    public function getAchievementsToRemove ()
    {
        return array_filter($this->achievements, function (Story_Model_Achievement $achievement) {
            return $achievement->getRequestType() === Story_Model_RequestTypes::REMOVE;
        });
    }
    
}
