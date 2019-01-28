<?php

/**
 * Description of Nachteil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Klassen
{

    /**
     * @var Administration_Model_Mapper_KlasseMapper
     */
    private $mapper;

    /**
     * Administration_Service_Klassen constructor.
     */
    public function __construct ()
    {
        $this->mapper = new Administration_Model_Mapper_KlasseMapper();
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @return int
     * @throws Exception
     */
    public function createKlasse (Zend_Controller_Request_Http $request, $userId)
    {
        $klasse = new Administration_Model_Klasse();
        $date = new DateTime();
        $klasse->setCreateDate($date->format('Y-m-d H:i:s'));
        $klasse->setBezeichnung($request->getPost('name'));
        $klasse->setBeschreibung($request->getPost('beschreibung'));
        $klasse->setFamilienname($request->getPost('familienname'));
        $klasse->setKosten($request->getPost('kosten'));
        $klasse->setGruppe($request->getPost('klassengruppe'));
        $klasse->setCreator($userId);
        return $this->mapper->createClass($klasse);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @return int
     * @throws Exception
     */
    public function editKlasse (Zend_Controller_Request_Http $request, $userId)
    {
        $klasse = new Administration_Model_Klasse();
        $date = new DateTime();
        $klasse->setId($request->getPost('klassenId'));
        $klasse->setEditDate($date->format('Y-m-d H:i:s'));
        $klasse->setBezeichnung($request->getPost('name'));
        $klasse->setBeschreibung($request->getPost('beschreibung'));
        $klasse->setFamilienname($request->getPost('familienname'));
        $klasse->setKosten($request->getPost('kosten'));
        $klasse->setGruppe($request->getPost('klassengruppe'));
        $klasse->setEditor($userId);
        return $this->mapper->updateClass($klasse);
    }

    /**
     * @param $subclassId
     *
     * @return Administration_Model_Klasse
     * @throws Exception
     */
    public function getKlasseById ($subclassId)
    {
        return $this->mapper->getClassById($subclassId);
    }

    /**
     * @return mixed
     */
    public function getKlasseList ()
    {
        return $this->mapper->getClasses();
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return mixed
     */
    public function deleteKlasse (Zend_Controller_Request_Http $request)
    {
        return $this->mapper->deleteClass($request->getPost('classId'));
    }

}
