<?php

namespace Nachrichten\Models;

/**
 * Description of Message
 *
 * @author Voß
 */
class Message
{

    /**
     * @var
     */
    protected $id;
    /**
     * @var
     */
    protected $betreff;
    /**
     * @var
     */
    protected $nachricht;
    /**
     * @var
     */
    protected $verfasserId;
    /**
     * @var
     */
    protected $empfaengerId;
    /**
     * @var string
     */
    protected $creationDate;
    /**
     * @var
     */
    protected $status;
    /**
     * @var
     */
    protected $admin;
    /**
     * @var User
     */
    protected $verfasser;
    /**
     * @var User
     */
    protected $empfaenger;


    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBetreff ()
    {
        return $this->betreff;
    }

    /**
     * @return mixed
     */
    public function getNachricht ()
    {
        return $this->nachricht;
    }

    /**
     * @return mixed
     */
    public function getVerfasserId ()
    {
        return $this->verfasserId;
    }

    /**
     * @return mixed
     */
    public function getEmpfaengerId ()
    {
        return $this->empfaengerId;
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws \Exception
     */
    public function getCreationDate ($format = 'd.m.Y H:i')
    {
        $date = new \DateTime($this->creationDate);
        return $date->format($format);
    }

    /**
     * @return mixed
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * @param $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @param $betreff
     */
    public function setBetreff ($betreff)
    {
        $this->betreff = $betreff;
    }

    /**
     * @param $nachricht
     */
    public function setNachricht ($nachricht)
    {
        $this->nachricht = $nachricht;
    }

    /**
     * @param $verfasserId
     */
    public function setVerfasserId ($verfasserId)
    {
        $this->verfasserId = $verfasserId;
    }

    /**
     * @param $empfaengerId
     */
    public function setEmpfaengerId ($empfaengerId)
    {
        $this->empfaengerId = $empfaengerId;
    }

    /**
     * @param $creationDate
     */
    public function setCreationDate ($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @param $status
     */
    public function setStatus ($status)
    {
        $this->status = $status;
    }

    /**
     * @return User
     */
    public function getVerfasser ()
    {
        return $this->verfasser;
    }

    /**
     * @return User
     */
    public function getEmpfaenger ()
    {
        return $this->empfaenger;
    }

    /**
     * @param \Application_Model_User $verfasser
     */
    public function setVerfasser (\Application_Model_User $verfasser)
    {
        $this->verfasser = $verfasser;
    }

    /**
     * @param \Application_Model_User $empfaenger
     */
    public function setEmpfaenger (\Application_Model_User $empfaenger)
    {
        $this->empfaenger = $empfaenger;
    }

    /**
     * @return mixed
     */
    public function getAdmin ()
    {
        return $this->admin;
    }

    /**
     * @param $admin
     */
    public function setAdmin ($admin)
    {
        $this->admin = $admin;
    }

}
