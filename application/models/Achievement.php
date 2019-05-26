<?php

/**
 * Description of Application_Model_Achievement
 *
 * @author Voß
 */
class Application_Model_Achievement
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $title = '';
    /**
     * @var string
     */
    protected $description = '';
    /**
     * @var int
     */
    protected $episodeId;
    /**
     * @var string
     */
    protected $creationDate;

    /**
     * Application_Model_Achievement constructor.
     *
     * @param $id
     * @param $title
     * @param $description
     */
    public function __construct ($id = null, $title = null, $description = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Application_Model_Achievement
     */
    public function setId ($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle ()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return Application_Model_Achievement
     */
    public function setTitle ($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription ()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return Application_Model_Achievement
     */
    public function setDescription ($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getEpisodeId (): int
    {
        return $this->episodeId;
    }

    /**
     * @param int $episodeId
     *
     * @return Application_Model_Achievement
     */
    public function setEpisodeId (int $episodeId): Application_Model_Achievement
    {
        $this->episodeId = $episodeId;
        return $this;
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws Exception
     */
    public function getCreationDate ($format = 'd.m.Y H:i')
    {
        if ($this->creationDate === null) {
            $date = new DateTime();
        } else {
            $date = new DateTime($this->creationDate);
        }
        return $date->format($format);
    }

    /**
     * @param $creationDate
     */
    public function setCreationDate ($creationDate)
    {
        $this->creationDate = $creationDate;
    }

}
