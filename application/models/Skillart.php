<?php

/**
 * Description of Skillart
 *
 * @author Voß
 */
class Application_Model_Skillart
{

    protected $id;
    protected $bezeichnung;
    protected $beschreibung;
    protected $skills = [];

    public function getId ()
    {
        return $this->id;
    }

    public function setId ($id)
    {
        $this->id = $id;
    }

    public function getBezeichnung ()
    {
        return $this->bezeichnung;
    }

    public function getBeschreibung ()
    {
        return $this->beschreibung;
    }

    /**
     * @return Application_Model_Skill[]
     */
    public function getSkills ()
    {
        return $this->skills;
    }

    public function setBezeichnung ($bezeichnung)
    {
        $this->bezeichnung = $bezeichnung;
    }

    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    public function setSkills ($skills)
    {
        foreach ($skills as $skill) {
            if ($skill instanceof Application_Model_Skill) {
                $this->addSkill($skill);
            }
        }
    }

    public function addSkill (Application_Model_Skill $skill)
    {
        $this->skills[] = $skill;
    }

}
