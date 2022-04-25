<?php

/**
 * Description of Element
 *
 * @author Vosser
 */
class Application_Model_Magie implements JsonSerializable
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $bezeichnung;
    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var int
     */
    protected $fp;
    /**
     * @var int
     */
    protected $prana;
    /**
     * @var Application_Model_Element
     */
    protected $element;
    /**
     * @var string
     */
    protected $rang;
    /**
     * @var Application_Model_Klasse
     */
    protected $klasse;
    /**
     * @var int
     */
    protected $gruppe;
    /**
     * @var int
     */
    protected $stufe;
    /**
     * @var Application_Model_Schule
     */
    protected $schule;
    /**
     * @var string
     */
    protected $lernbedingung;
    /**
     * @var string
     */
    protected $provenance;

    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBezeichnung ()
    {
        return $this->bezeichnung;
    }

    /**
     * @return string
     */
    public function getBeschreibung ()
    {
        return $this->beschreibung;
    }

    /**
     * @return mixed
     */
    public function getFp ()
    {
        return $this->fp;
    }

    /**
     * @return mixed
     */
    public function getPrana ()
    {
        return $this->prana;
    }

    /**
     * @return Application_Model_Element
     */
    public function getElement ()
    {
        return $this->element;
    }

    /**
     * @return mixed
     */
    public function getRang ()
    {
        return $this->rang;
    }

    /**
     * @return Application_Model_Klasse
     */
    public function getKlasse ()
    {
        return $this->klasse;
    }

    /**
     * @return mixed
     */
    public function getGruppe ()
    {
        return $this->gruppe;
    }

    /**
     * @return mixed
     */
    public function getStufe ()
    {
        return $this->stufe;
    }

    /**
     * @return Application_Model_Schule
     */
    public function getSchule ()
    {
        return $this->schule;
    }

    /**
     * @return string
     */
    public function getLernbedingung ()
    {
        return $this->lernbedingung;
    }

    /**
     * @param $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @param $bezeichnung
     */
    public function setBezeichnung ($bezeichnung)
    {
        $this->bezeichnung = $bezeichnung;
    }

    /**
     * @param $beschreibung
     */
    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @param $fp
     */
    public function setFp ($fp)
    {
        $this->fp = $fp;
    }

    /**
     * @param $prana
     */
    public function setPrana ($prana)
    {
        $this->prana = $prana;
    }

    /**
     * @param Application_Model_Element $element
     */
    public function setElement (Application_Model_Element $element)
    {
        $this->element = $element;
    }

    /**
     * @param $rang
     */
    public function setRang ($rang)
    {
        $this->rang = $rang;
    }

    /**
     * @param Application_Model_Klasse $klasse
     */
    public function setKlasse (Application_Model_Klasse $klasse)
    {
        $this->klasse = $klasse;
    }

    /**
     * @param $gruppe
     */
    public function setGruppe ($gruppe)
    {
        $this->gruppe = $gruppe;
    }

    /**
     * @param $stufe
     */
    public function setStufe ($stufe)
    {
        $this->stufe = $stufe;
    }

    /**
     * @param Application_Model_Schule $schule
     */
    public function setSchule (Application_Model_Schule $schule)
    {
        $this->schule = $schule;
    }

    /**
     * @param $lernbedingung
     */
    public function setLernbedingung ($lernbedingung)
    {
        $this->lernbedingung = $lernbedingung;
    }

    /**
     * @return string
     */
    public function getProvenance()
    {
        return $this->provenance;
    }

    /**
     * @param string $provenance
     * @return Application_Model_Magie
     */
    public function setProvenance($provenance)
    {
        $this->provenance = $provenance;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize ()
    {
        $return = [];
        foreach (get_object_vars($this) as $key => $property) {
            $return[$key] = $property;
        }
        return $return;
    }

}
