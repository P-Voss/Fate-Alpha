<?php

/**
 * Description of Application_Model_EpisodenStatus
 *
 * @author Voß
 */
class Application_Model_EpisodenStatus implements Application_Model_Interfaces_EpisodenStatus
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $status;
    /**
     * @var string
     */
    protected $colorCode;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * @param $status
     */
    public function setStatus ($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getColorCode ()
    {
        return $this->colorCode;
    }

    /**
     * @param $colorCode
     */
    public function setColorCode ($colorCode)
    {
        $this->colorCode = $colorCode;
    }

}
