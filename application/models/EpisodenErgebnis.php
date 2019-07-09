<?php

/**
 * Description of Application_Model_EpisodenErgebnis
 *
 * @author Voß
 */
class Application_Model_EpisodenErgebnis
{

    /**
     * @var string
     */
    protected $result;
    /**
     * @var string
     */
    protected $creationdate;

    /**
     * @return string
     */
    public function getResult ()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getCreationdate ()
    {
        return $this->creationdate;
    }

    /**
     * @param $result
     */
    public function setResult ($result)
    {
        $this->result = $result;
    }

    /**
     * @param $creationdate
     */
    public function setCreationdate ($creationdate)
    {
        $this->creationdate = $creationdate;
    }

}
