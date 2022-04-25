<?php

/**
 * Description of Information
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Information
{

    /**
     * @var Administration_Model_Mapper_InformationMapper
     */
    private $mapper;
    /**
     * @var Administration_Model_Mapper_ErstellungMapper
     */
    private $erstellungMapper;
    /**
     * @var Administration_Service_Requirement
     */
    private $requirementService;

    /**
     * Administration_Service_Information constructor.
     */
    public function __construct ()
    {
        $this->mapper = new Administration_Model_Mapper_InformationMapper();
        $this->erstellungMapper = new Administration_Model_Mapper_ErstellungMapper();
        $this->requirementService = new Administration_Service_Requirement();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getInformationList ()
    {
        return $this->mapper->getAllInformations();
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @throws Exception
     */
    public function createInformation (Zend_Controller_Request_Http $request, $userId)
    {
        $information = new Administration_Model_Information();
        $date = new DateTime();
        $information->setCreateDate($date->format('Y-m-d H:i:s'));
        $information->setName($request->getPost('name'));
        $information->setKategorie($request->getPost('kategorie'));
        $information->setInhalt($request->getPost('beschreibung'));
        $information->setCreator($userId);

        $information->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );
        $information->setInformationId($this->mapper->createInformation($information));
        $this->mapper->setDependencies($information);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $userId
     *
     * @return int
     * @throws Exception
     */
    public function editInformation (Zend_Controller_Request_Http $request, $userId)
    {
        $information = new Administration_Model_Information();
        $date = new DateTime();
        $information->setInformationId($request->getPost('informationId'));
        $information->setEditDate($date->format('Y-m-d H:i:s'));
        $information->setName($request->getPost('name'));
        $information->setKategorie($request->getPost('kategorie'));
        $information->setInhalt($request->getPost('beschreibung'));
        $information->setEditor($userId);

        $information->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );
        $this->mapper->deleteDependencies($information);
        $this->mapper->setDependencies($information);
        return $this->mapper->updateInformation($information);
    }


    /**
     * @param $informationId
     *
     * @return Administration_Model_Information
     * @throws Exception
     */
    public function getInformationById ($informationId)
    {
        $information = $this->mapper->getInformationById($informationId);
        $information->setRequirementList($this->requirementService->getRequirementListInformation($informationId));
        return $information;
    }


    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return mixed
     */
    public function deleteInformation (Zend_Controller_Request_Http $request)
    {
        return $this->mapper->deleteNews($request->getPost('schulId'));
    }

}
