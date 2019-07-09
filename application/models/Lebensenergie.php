<?php

/**
 * Description of Application_Model_Lebensenergie
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Lebensenergie
{


    /**
     * @return array
     */
    private function getKategorienNormal ()
    {
        return [
            'F-' => 17,
            'F' => 17,
            'F+' => 17,
            'E-' => 20,
            'E' => 25,
            'E+' => 27,
            'D-' => 30,
            'D' => 32,
            'D+' => 34,
            'C-' => 37,
            'C' => 40,
            'C+' => 42,
            'B-' => 45,
            'B' => 47,
            'B+' => 48,
            'A-' => 52,
            'A' => 55,
            'A+' => 58,
        ];
    }

    /**
     * @return array
     */
    private function getKategorienUeber ()
    {
        return [
            'F-' => 62,
            'F' => 62,
            'F+' => 62,
            'E-' => 65,
            'E' => 70,
            'E+' => 72,
            'D-' => 75,
            'D' => 77,
            'D+' => 79,
            'C-' => 82,
            'C' => 85,
            'C+' => 87,
            'B-' => 90,
            'B' => 92,
            'B+' => 94,
            'A-' => 97,
            'A' => 100,
            'A+' => 105,
        ];
    }

    /**
     * @param string $ausdauerKategorie
     * @param bool $ueber
     *
     * @return int
     */
    public function getEnergiewert ($ausdauerKategorie, $ueber = false)
    {
        if ($ueber) {
            return $this->getKategorienUeber()[$ausdauerKategorie];
        } else {
            return $this->getKategorienNormal()[$ausdauerKategorie];
        }
    }

}
