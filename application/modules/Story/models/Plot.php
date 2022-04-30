<?php

/**
 * Description of Story_Model_Plot
 *
 * @author Voß
 */
class Story_Model_Plot extends Application_Model_Plot {
    
    
    /**
     * @var DateTime
     */
    protected $creationdate;
    /**
     * @var DateTime
     */
    protected $editDate;
    protected $status;
    /**
     * @var Application_Model_Charakter[]
     */
    protected $characters = [];
    
    
    public function getCreateDate($format = 'd.m.Y H:i:s') {
        if ($this->creationdate instanceof DateTime) {
            return $this->creationdate->format($format);
        }
        $date = new DateTime($this->creationdate);
        return $date->format($format);
    }

    public function getEditDate() {
        return $this->editDate;
    }

    public function setCreateDate(DateTime $creationdate) {
        $this->creationdate = $creationdate;
    }

    public function setEditDate($editDate) {
        $this->editDate = $editDate;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return Application_Model_Charakter[]
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param Application_Model_Charakter[] $characters
     * @return Story_Model_Plot
     */
    public function setCharacters(array $characters)
    {
        $this->characters = $characters;
        return $this;
    }

    /**
     * @param Application_Model_Charakter $character
     * @return $this
     */
    public function addCharacter(Application_Model_Charakter $character)
    {
        $this->characters[] = $character;
        return $this;
    }
    
}
