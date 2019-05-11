<?php

/**
 * Description of Application_Model_Item
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Item {

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $type;
    /**
     * @var string
     */
    protected $rank;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var int
     */
    protected $cost;

    /**
     * @return int
     */
    public function getId (): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Application_Model_Item
     */
    public function setId (int $id): Application_Model_Item
    {
        $this->id = $id;
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
     * @return Application_Model_Item
     */
    public function setName (string $name): Application_Model_Item
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getType (): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return Application_Model_Item
     */
    public function setType (int $type): Application_Model_Item
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getRank (): string
    {
        return $this->rank;
    }

    /**
     * @param string $rank
     *
     * @return Application_Model_Item
     */
    public function setRank (string $rank): Application_Model_Item
    {
        $this->rank = $rank;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription (): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Application_Model_Item
     */
    public function setDescription (string $description): Application_Model_Item
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getCost (): int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     *
     * @return Application_Model_Item
     */
    public function setCost (int $cost): Application_Model_Item
    {
        $this->cost = $cost;
        return $this;
    }
    
}
