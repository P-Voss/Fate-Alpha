<?php

/**
 * Description of Application_Model_Charakterprofil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterprofil
{

    /**
     * @var string
     */
    protected $charaktergeschichte;
    /**
     * @var string
     */
    protected $privatdaten;
    /**
     * @var string
     */
    protected $sldaten;
    /**
     * @var string
     */
    protected $profilpic;
    /**
     * @var string
     */
    protected $charpic;
    /**
     * @var string
     */
    protected $kennenlerncode;
    /**
     * @var string
     */
    protected $privatcode;

    /**
     * @return string
     */
    public function getCharaktergeschichte ()
    {
        return $this->charaktergeschichte;
    }

    /**
     * @return string
     */
    public function outputCharaktergeschichte ()
    {
        return $this->charaktergeschichte;
    }

    /**
     * @return string
     */
    public function getPrivatdaten ()
    {
        return $this->privatdaten;
    }

    /**
     * @return string
     */
    public function outputPrivatdaten ()
    {
        return $this->privatdaten;
    }

    /**
     * @return string
     */
    public function getProfilpic ()
    {
        return $this->profilpic;
    }

    /**
     * @return string
     */
    public function getCharpic ()
    {
        return $this->charpic;
    }

    /**
     * @return string
     */
    public function getKennenlerncode ()
    {
        return $this->kennenlerncode;
    }

    /**
     * @return string
     */
    public function getPrivatcode ()
    {
        return $this->privatcode;
    }

    /**
     * @param $charaktergeschichte
     */
    public function setCharaktergeschichte ($charaktergeschichte)
    {
        $this->charaktergeschichte = $charaktergeschichte;
    }

    /**
     * @param $privatdaten
     */
    public function setPrivatdaten ($privatdaten)
    {
        $this->privatdaten = $privatdaten;
    }

    /**
     * @param $profilpic
     */
    public function setProfilpic ($profilpic)
    {
        $this->profilpic = $profilpic;
    }

    /**
     * @param $charpic
     */
    public function setCharpic ($charpic)
    {
        $this->charpic = $charpic;
    }

    /**
     * @param $kennenlerncode
     */
    public function setKennenlerncode ($kennenlerncode)
    {
        $this->kennenlerncode = $kennenlerncode;
    }

    /**
     * @param $privatcode
     */
    public function setPrivatcode ($privatcode)
    {
        $this->privatcode = $privatcode;
    }

    /**
     * @return string
     */
    public function getSldaten ()
    {
        return $this->sldaten;
    }

    /**
     * @return string
     */
    public function outputSldaten ()
    {
        return $this->sldaten;
    }

    /**
     * @param $sldaten
     */
    public function setSldaten ($sldaten)
    {
        $this->sldaten = $sldaten;
    }

}
