<?php

namespace Logs\Models;


/**
 * Description of Log
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Log extends \Application_Model_Log
{

    /**
     * @var int
     */
    protected $episodenId;

    /**
     * @return int
     */
    public function getEpisodenId ()
    {
        return $this->episodenId;
    }

    /**
     * @param $episodenId
     */
    public function setEpisodenId ($episodenId)
    {
        $this->episodenId = $episodenId;
    }

}
