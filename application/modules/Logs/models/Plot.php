<?php

namespace Logs\Models;

/**
 * Description of Plot
 *
 * @author Voß
 */
class Plot extends \Application_Model_Plot
{

    /**
     * @var Episode[]
     */
    protected $episoden = [];

    /**
     * @return Episode[]
     */
    public function getEpisoden ()
    {
        return $this->episoden;
    }

    /**
     * @param array $episoden
     */
    public function setEpisoden (array $episoden = [])
    {
        foreach ($episoden as $episode) {
            if ($episode instanceof Episode) {
                $this->episoden[] = $episode;
            }
        }
    }

    /**
     * @param Episode $episode
     */
    public function addEpisode (Episode $episode)
    {
        $this->episoden[] = $episode;
    }

}
