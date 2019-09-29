<?php

/**
 * Description of Information
 *
 * @author Vosser
 */
class Application_Service_Information
{

    /**
     * @var Application_Model_Charakter
     */
    private $charakter;
    /**
     * @var Application_Model_Mapper_InformationMapper
     */
    private $informationMapper;

    public function __construct ()
    {
        $this->informationMapper = new Application_Model_Mapper_InformationMapper();
    }

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter (Application_Model_Charakter $charakter)
    {
        $this->charakter = $charakter;
    }

    /**
     * @param int $informationId
     * @param int $userId
     *
     * @return Application_Model_Information
     * @throws Exception
     */
    public function getInformation ($informationId, $userId)
    {
        return $this->informationMapper->getInformation($userId, $informationId);
    }

    /**
     * @return Application_Model_Information[]
     * @throws Exception
     */
    public function getInformations ()
    {
        return $this->informationMapper->getInformationsByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
    }

    /**
     *
     * @throws Exception
     */
    public function refreshInformation ()
    {
        $charakterService = new Application_Service_Charakter();
        $informations = $this->initInformations();
        $users = $this->initUsers();
        $informationZuo = [];
        foreach ($users as $user) {
            try {
                $charakter = $charakterService->getCharakterByUserid($user->getId());
            } catch (Exception $exception) {
                continue;
            }
            $this->charakter = $charakter === false ? null : $charakter;
            if ($charakter !== false) {
                $informationIds = array_unique(
                    array_merge(
                        $this->buildInformationZuo($informations),
                        array_map(
                            function (Application_Model_Information $information) {
                                return $information->getInformationId();
                            },
                            $this->informationMapper->getCharacterInformations($charakter->getCharakterid())
                        )
                    )
                );
            } else {
                $informationIds = $this->buildInformationZuo($informations);
            }
            $informationZuo[] = [
                'userId' => $user->getId(),
                'informationIds' => $informationIds,
            ];
        }
        $this->informationMapper->truncateBenutzerinformationen();
        $this->informationMapper->saveBenutzerinformationen($informationZuo);
        $this->informationMapper->insertAdminInformationZuo();
    }

    /**
     * @param Application_Model_Information[] $informations
     *
     * @return array
     */
    private function buildInformationZuo ($informations)
    {
        $returnArray = [];
        foreach ($informations as $information) {
            if (count($information->getRequirementList()->getRequirements()) === 0) {
                $returnArray[] = $information->getInformationId();
                continue;
            }
            if ($this->charakter === null) {
                continue;
            }
            if ($this->checkValidation($information) === true) {
                $returnArray[] = $information->getInformationId();
            }
        }
        return $returnArray;
    }

    /**
     * @param Application_Model_Information $information
     *
     * @return boolean
     */
    private function checkValidation (Application_Model_Information $information)
    {
        $validatorFactory = new Application_Model_Requirements_Factory();
        try {
            foreach ($information->getRequirementList()->getRequirements() as $requirement) {
                $validator = $validatorFactory->getValidator($requirement->getArt());
                if ($validator->check($this->charakter, $requirement->getRequiredValue()) !== true) {
                    return false;
                }
            }
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @return Application_Model_User[]
     */
    private function initUsers ()
    {
        $userService = new Application_Service_User();
        return $userService->getActiveUsers();
    }

    /**
     * @return Application_Model_Information[]
     */
    private function initInformations ()
    {
        $informations = $this->informationMapper->getInformations();
        foreach ($informations as $information) {
            $information->setRequirementList($this->informationMapper->getRequirements($information->getInformationId()));
        }
        return $informations;
    }

}
