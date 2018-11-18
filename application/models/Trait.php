<?php

/**
 * Description of Application_Model_Trait
 *
 * @author Vosser
 */
class Application_Model_Trait {

    /**
     * @var int
     */
    protected $traitId;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var int
     */
    protected $kosten;

    /**
     * @var Application_Model_Trait[]
     */
    protected $incompatibleTraits = [];

    /**
     * @return int
     */
    public function getTraitId (): int
    {
        return $this->traitId;
    }

    /**
     * @param int $traitId
     *
     * @return Application_Model_Trait
     */
    public function setTraitId (int $traitId): Application_Model_Trait
    {
        $this->traitId = $traitId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName (): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Application_Model_Trait
     */
    public function setName (string $name): Application_Model_Trait
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getBeschreibung (): string
    {
        return $this->beschreibung;
    }

    /**
     * @param string $beschreibung
     *
     * @return Application_Model_Trait
     */
    public function setBeschreibung (string $beschreibung): Application_Model_Trait
    {
        $this->beschreibung = $beschreibung;
        return $this;
    }

    /**
     * @return int
     */
    public function getKosten (): int
    {
        return $this->kosten;
    }

    /**
     * @param int $kosten
     *
     * @return Application_Model_Trait
     */
    public function setKosten (int $kosten): Application_Model_Trait
    {
        $this->kosten = $kosten;
        return $this;
    }

    /**
     * @return Application_Model_Trait[]
     */
    public function getIncompatibleTraits (): array
    {
        return $this->incompatibleTraits;
    }

    /**
     * @param Application_Model_Trait[] $incompatibleTraits
     *
     * @return Application_Model_Trait
     */
    public function setIncompatibleTraits (array $incompatibleTraits): Application_Model_Trait
    {
        foreach ($incompatibleTraits as $trait) {
            $this->addIncompatibleTrait($trait);
        }
        return $this;
    }

    public function addIncompatibleTrait (Application_Model_Trait $trait): Application_Model_Trait
    {
        $this->incompatibleTraits[] = $trait;
        return $this;
    }
    
}
