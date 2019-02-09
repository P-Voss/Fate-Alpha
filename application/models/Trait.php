<?php

/**
 * Description of Application_Model_Trait
 *
 * @author Vosser
 */
class Application_Model_Trait {

    const STORY_TYPE_BIRTH = 1;
    const STORY_TYPE_RAISED = 2;
    const STORY_TYPE_EVENT = 3;
    const STORY_TYPE_GAINED = 4;
    const STORY_TYPE_FOCUS = 5;


    const STORY_TYPES = [
        self::STORY_TYPE_BIRTH,
        self::STORY_TYPE_RAISED,
        self::STORY_TYPE_EVENT,
        self::STORY_TYPE_GAINED,
        self::STORY_TYPE_FOCUS,
    ];

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
     * @var int
     */
    protected $storyType = 0;
    /**
     * @var string
     */
    protected $story = '';

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
     * @return int
     */
    public function getStoryType (): int
    {
        return $this->storyType;
    }

    /**
     * @param int $storyType
     *
     * @return Application_Model_Trait
     */
    public function setStoryType (int $storyType): Application_Model_Trait
    {
        $this->storyType = $storyType;
        return $this;
    }

    /**
     * @return string
     */
    public function getStory (): string
    {
        return $this->story;
    }

    /**
     * @param string $story
     *
     * @return Application_Model_Trait
     */
    public function setStory (string $story): Application_Model_Trait
    {
        $this->story = $story;
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
