<?php

/**
 * Description of Gruppe
 *
 * @author Voß
 */
class Gruppen_Model_Gruppe
{

    /**
     * @var
     */
    protected $id;
    /**
     * @var
     */
    protected $name;
    /**
     * @var
     */
    protected $beschreibung;
    /**
     * @var
     */
    protected $passwort;
    /**
     * @var Application_Model_Charakter[]
     */
    protected $mitglieder = [];
    /**
     * @var
     */
    protected $gruender;
    /**
     * @var
     */
    protected $createDate;


    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getBeschreibung ()
    {
        return $this->beschreibung;
    }

    /**
     * @return mixed
     */
    public function getPasswort ()
    {
        return $this->passwort;
    }

    /**
     * @return Application_Model_Charakter[]
     */
    public function getMitglieder ()
    {
        return $this->mitglieder;
    }

    /**
     * @return mixed
     */
    public function getGruender ()
    {
        return $this->gruender;
    }

    /**
     * @return mixed
     */
    public function getCreateDate ()
    {
        return $this->createDate;
    }

    /**
     * @param $name
     */
    public function setName ($name)
    {
        $this->name = $name;
    }

    /**
     * @param $beschreibung
     */
    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @param $passwort
     */
    public function setPasswort ($passwort)
    {
        $this->passwort = $passwort;
    }

    /**
     * @param Application_Model_Charakter[] $mitglieder
     */
    public function setMitglieder ($mitglieder = [])
    {
        foreach ($mitglieder as $mitglied) {
            if ($mitglied instanceof Application_Model_Charakter) {
                $this->addMitglied($mitglied);
            }
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function addMitglied (Application_Model_Charakter $charakter)
    {
        $this->mitglieder[] = $charakter;
    }

    /**
     * @param $gruender
     */
    public function setGruender ($gruender)
    {
        $this->gruender = $gruender;
    }

    /**
     * @param $createDate
     */
    public function setCreateDate ($createDate)
    {
        $this->createDate = $createDate;
    }

}
