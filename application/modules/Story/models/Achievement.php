<?php


class Story_Model_Achievement extends Application_Model_Achievement
{

    /**
     * @var int
     */
    private $characterId;
    /**
     * @var string
     */
    private $requestType;
    /**
     * @var int
     */
    private $achievementId;

    /**
     * Story_Model_Achievement constructor.
     *
     * @param $characterId
     * @param $episodeId
     * @param $title
     * @param $description
     * @param null $requestType
     */
    public function __construct ($characterId = null, $episodeId = null, $title = null, $description = null, $requestType = null)
    {
        $this->characterId = $characterId;
        $this->title = $title;
        $this->description = $description;
        $this->episodeId = $episodeId;
        $this->requestType = $requestType;
    }

    /**
     * @return int
     */
    public function getCharacterId (): int
    {
        return $this->characterId;
    }

    /**
     * @param int $characterId
     *
     * @return Story_Model_Achievement
     */
    public function setCharacterId (int $characterId): Story_Model_Achievement
    {
        $this->characterId = $characterId;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestType (): string
    {
        return $this->requestType;
    }

    /**
     * @param string $requestType
     *
     * @return Story_Model_Achievement
     */
    public function setRequestType (string $requestType): Story_Model_Achievement
    {
        $this->requestType = $requestType;
        return $this;
    }

    /**
     * @return int
     */
    public function getAchievementId (): int
    {
        return $this->achievementId;
    }

    /**
     * @param int $achievementId
     *
     * @return Story_Model_Achievement
     */
    public function setAchievementId (int $achievementId = null): Story_Model_Achievement
    {
        $this->achievementId = $achievementId;
        return $this;
    }

}