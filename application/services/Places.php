<?php

/**
 * Description of Application_Service_Places
 *
 * @author Vosser
 */
class Application_Service_Places
{

    /**
     * @var Application_Model_Mapper_OrteMapper
     */
    protected $placesMapper;

    public function __construct ()
    {
        $this->placesMapper = new Application_Model_Mapper_OrteMapper();
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function getOrtePreview ($name)
    {
        return $this->placesMapper->getOrtePreview($name);
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function getStadtteilePreview ($name)
    {
        return $this->placesMapper->getStadtteilPreview($name);
    }

}
