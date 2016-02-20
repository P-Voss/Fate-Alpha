<?php


/**
 * Description of Application_Model_Log
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Log {
   
    protected $id;
    protected $name;
    protected $md5;
    protected $owner;
    protected $status;
    protected $plotId;
    protected $createDate;
    
    /**
     * @return string
     */
    public function getCreatedate($format = 'Y-m-d') {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    /**
     * @param string $createDate
     * @return \Application_Model_Charakter
     */
    public function setCreatedate($createDate) {
        $this->createDate = $createDate;
        return $this;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getMd5() {
        return $this->md5;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setMd5($md5) {
        $this->md5 = $md5;
    }

    public function setOwner($owner) {
        $this->owner = $owner;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function getPlotId() {
        return $this->plotId;
    }

    public function setPlotId($plotId) {
        $this->plotId = $plotId;
    }

}
