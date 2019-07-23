<?php

namespace Shop\Models;

/**
 * Description of Requirement
 *
 * @author Voß
 */
class Requirement
{

    /**
     * @var string
     */
    private $art;
    /**
     * @var int
     */
    private $requiredValue;

    /**
     * @return string
     */
    public function getArt ()
    {
        return $this->art;
    }

    /**
     * @return int
     */
    public function getRequiredValue ()
    {
        return $this->requiredValue;
    }

    /**
     * @param $art
     *
     * @return $this
     */
    public function setArt ($art)
    {
        $this->art = $art;
        return $this;
    }

    /**
     * @param $requiredValue
     *
     * @return $this
     */
    public function setRequiredValue ($requiredValue)
    {
        $this->requiredValue = $requiredValue;
        return $this;
    }

}
