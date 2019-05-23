<?php


class Story_Model_Achievement extends Application_Model_Achievement
{

    /**
     * @var int
     */
    private $characterId;

    /**
     * Story_Model_Achievement constructor.
     *
     * @param $characterId
     * @param $title
     * @param $description
     * @param $episodeId
     * @param null $id
     */
    public function __construct ($characterId, $title, $description, $episodeId, $id = null)
    {
        $this->characterId = $characterId;
        $this->title = $title;
        $this->description = $description;
        $this->episodeId = $episodeId;
        $this->id = $id;
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

}