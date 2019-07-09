<?php


/**
 * Description of Application_Model_Log
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Log
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $beschreibung;
    /**
     * @var string
     */
    protected $md5;
    /**
     * @var int
     */
    protected $owner;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var string
     */
    protected $plotId;
    /**
     * @var string
     */
    protected $createDate;

    /**
     * @return string
     * @throws Exception
     */
    public function getCreatedate ($format = 'Y-m-d')
    {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    /**
     * @param string $createDate
     *
     * @return Application_Model_Log
     */
    public function setCreatedate ($createDate)
    {
        $this->createDate = $createDate;
        return $this;
    }

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
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMd5 ()
    {
        return $this->md5;
    }

    /**
     * @return int
     */
    public function getOwner ()
    {
        return $this->owner;
    }

    /**
     * @return string
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
     * @param $name
     */
    public function setName ($name)
    {
        $this->name = $name;
    }

    /**
     * @param $md5
     */
    public function setMd5 ($md5)
    {
        $this->md5 = $md5;
    }

    /**
     * @param $owner
     */
    public function setOwner ($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param $status
     */
    public function setStatus ($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getPlotId ()
    {
        return $this->plotId;
    }

    /**
     * @param $plotId
     */
    public function setPlotId ($plotId)
    {
        $this->plotId = $plotId;
    }

    /**
     * @return string
     */
    public function getBeschreibung ()
    {
        return $this->beschreibung;
    }

    /**
     * @param $beschreibung
     */
    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }


}
