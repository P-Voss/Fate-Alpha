<?php

/**
 * Description of Tageswetter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Tageswetter {
    
    /**
     * @var DateTime
     */
    protected $tag;
    /**
     * @var Administration_Model_Wetter
     */
    protected $wetterVormittag;
    /**
     * @var Administration_Model_Wetter
     */
    protected $wetterMittag;
    /**
     * @var Administration_Model_Wetter
     */
    protected $wetterNachmittag;
    /**
     * @var Administration_Model_Wetter
     */
    protected $wetterAbend;
    /**
     * @var Administration_Model_Wetter
     */
    protected $wetterNacht;
    
    /**
     * @return DateTime
     */
    public function getTag() {
        return $this->tag;
    }

    /**
     * Administration_Model_Wetter type
     */
    public function getWetterVormittag() {
        return $this->wetterVormittag;
    }
    
    /**
     * Administration_Model_Wetter type
     */
    public function getWetterMittag() {
        return $this->wetterMittag;
    }
    
    /**
     * Administration_Model_Wetter type
     */
    public function getWetterNachmittag() {
        return $this->wetterNachmittag;
    }
    
    /**
     * Administration_Model_Wetter type
     */
    public function getWetterAbend() {
        return $this->wetterAbend;
    }
    
    /**
     * Administration_Model_Wetter type
     */
    public function getWetterNacht() {
        return $this->wetterNacht;
    }

    /**
     * @param DateTime $tag
     */
    public function setTag($tag) {
        $date = new DateTime($tag);
        $this->tag = $date;
    }

    public function setWetterVormittag(Application_Model_Wetter $wetterVormittag) {
        $this->wetterVormittag = $wetterVormittag;
    }

    public function setWetterMittag(Application_Model_Wetter $wetterMittag) {
        $this->wetterMittag = $wetterMittag;
    }

    public function setWetterNachmittag(Application_Model_Wetter $wetterNachmittag) {
        $this->wetterNachmittag = $wetterNachmittag;
    }

    public function setWetterAbend(Application_Model_Wetter $wetterAbend) {
        $this->wetterAbend = $wetterAbend;
    }

    public function setWetterNacht(Application_Model_Wetter $wetterNacht) {
        $this->wetterNacht = $wetterNacht;
    }


    
}
