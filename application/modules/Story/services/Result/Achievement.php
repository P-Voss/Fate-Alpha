<?php


class Story_Service_Result_Achievement
{

    /**
     * @var Story_Model_Mapper_Result_AchievementMapper
     */
    private $resultMapper;


    public function __construct ()
    {
        $this->resultMapper = new Story_Model_Mapper_Result_AchievementMapper();
    }

    /**
     * @param $episodeId
     * @param $characterId
     *
     * @return Story_Model_Achievement[]
     * @throws Exception
     */
    public function getAchievmentRequests ($episodeId, $characterId)
    {
        return $this->resultMapper->getRequestedAchievements($episodeId, $characterId);
    }

    /**
     * @param Story_Model_Achievement $achievement
     *
     * @throws Exception
     */
    public function addRequest (Story_Model_Achievement $achievement)
    {
        $this->resultMapper->addAchievementRequest($achievement);
    }

    /**
     * @param $episodeId
     * @param $charakterId
     * @param $requestId
     *
     * @throws Exception
     */
    public function removeRequest ($episodeId, $charakterId, $requestId)
    {
        $this->resultMapper->removeAchievement($episodeId, $charakterId, $requestId);
    }

}