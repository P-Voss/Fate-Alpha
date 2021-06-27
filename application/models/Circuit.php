<?php

/**
 * Description of Circuit
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Circuit
{

    const MANA_KONTROLLE = 22;
    const MANA_BAENDIGER = 104;

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $kategorie;
    /**
     * @var string
     */
    protected $menge;
    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var string
     */
    protected $kosten;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getKategorie ()
    {
        return $this->kategorie;
    }

    /**
     * @return int
     */
    public function getMenge ()
    {
        return $this->menge;
    }

    /**
     * @param Application_Model_Charakter $character
     * @return int
     */
    public function getMana(Application_Model_Charakter $character)
    {
        foreach ($character->getTraits() as $trait) {
            if (in_array($trait->getTraitId(), [self::MANA_KONTROLLE, self::MANA_BAENDIGER])) {
                return $this->getMenge() + $character->getCharakterwerte()->getCategory('pra')->getNumericValue() * 25;
            }
        }
        return $this->getMenge();
    }

    /**
     * @return string
     */
    public function getBeschreibung ()
    {
        return $this->beschreibung;
    }

    /**
     * @return string
     */
    public function getKosten ()
    {
        return $this->kosten;
    }

    /**
     * @param $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @param $kategorie
     */
    public function setKategorie ($kategorie)
    {
        $this->kategorie = $kategorie;
    }

    /**
     * @param $menge
     */
    public function setMenge ($menge)
    {
        $this->menge = $menge;
    }

    /**
     * @param $beschreibung
     */
    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @param $kosten
     */
    public function setKosten ($kosten)
    {
        $this->kosten = $kosten;
    }

}
