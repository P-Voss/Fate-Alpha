<?php

/**
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Skill
{

    /**
     * @var Administration_Model_Mapper_SkillMapper
     */
    private $mapper;
    /**
     * @var Administration_Service_Requirement
     */
    private $requirementService;


    /**
     * Administration_Service_Skill constructor.
     */
    public function __construct ()
    {
        $this->mapper = new Administration_Model_Mapper_SkillMapper();
        $this->requirementService = new Administration_Service_Requirement();
    }


    /**
     * @return array
     * @throws Exception
     */
    public function getMagieList ()
    {
        return $this->mapper->getMagien();
    }


    /**
     * @return array
     * @throws Exception
     */
    public function getRpgMagieList ()
    {
        return $this->mapper->getRpgMagien();
    }


    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return array
     * @throws Exception
     */
    public function getFilteredMagieList (Zend_Controller_Request_Http $request)
    {
        $filter = false;
        $magieschulen = [];
        $gruppen = [];
        $klassen = [];
        if ($request->getPost('magieschulen') !== null) {
            $magieschulen = $request->getPost('magieschulen');
            $filter = true;
        }
        if ($request->getPost('gruppen') !== null) {
            $gruppen = $request->getPost('gruppen');
            $filter = true;
        }
        if ($request->getPost('klassen') !== null) {
            $klassen = $request->getPost('klassen');
            $filter = true;
        }
        if ($filter) {
            return $this->mapper->searchMagien($magieschulen, $gruppen, $klassen);
        } else {
            return $this->mapper->getMagien();
        }
    }


    /**
     * @return array
     * @throws Exception
     */
    public function getSkillList ()
    {
        return $this->mapper->getSkills();
    }


    /**
     * @return array
     * @throws Exception
     */
    public function getRpgSkillList ()
    {
        return $this->mapper->getRpgSkills();
    }


    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return array
     * @throws Exception
     */
    public function getFilteredSkillList (Zend_Controller_Request_Http $request)
    {
        $filter = false;
        $skillarten = [];
        $gruppen = [];
        $klassen = [];
        if ($request->getPost('skillarten') !== null) {
            $skillarten = $request->getPost('skillarten');
            $filter = true;
        }
        if ($request->getPost('gruppen') !== null) {
            $gruppen = $request->getPost('gruppen');
            $filter = true;
        }
        if ($request->getPost('klassen') !== null) {
            $klassen = $request->getPost('klassen');
            $filter = true;
        }
        if ($filter) {
            return $this->mapper->searchSkills($skillarten, $gruppen, $klassen);
        } else {
            return $this->mapper->getSkills();
        }
    }

    /**
     * @param $magieId
     *
     * @return Administration_Model_Magie
     * @throws Exception
     */
    public function getMagieById ($magieId)
    {
        $magie = $this->mapper->getMagieById($magieId);
        $magie->setRequirementList($this->mapper->getRequirementsMagie($magieId));
        return $magie;
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @throws Exception
     */
    public function editMagie (Zend_Controller_Request_Http $request, $userId)
    {
        $magie = new Administration_Model_Magie();
        $date = new DateTime();
        $element = new Administration_Model_Element();
        $element->setId($request->getPost('element'));
        $schule = new Administration_Model_Schule();
        $schule->setId($request->getPost('magieschule'));

        $magie->setId($request->getPost('magieId'));
        $magie->setEditDate($date->format('Y-m-d H:i:s'));
        $magie->setEditor($userId);
        $magie->setBezeichnung($request->getPost('name'));
        $magie->setBeschreibung($request->getPost('beschreibung'));
        $magie->setFp($request->getPost('fp', 0) !== 0 ? (int)$request->getPost('fp', 0) : 0);
        $magie->setElement($element);
        $magie->setSchule($schule);
        $magie->setPrana($request->getPost('prana', 0) !== 0 ? (int)$request->getPost('prana', 0) : 0);
        $magie->setStufe($request->getPost('stufe'));
        $magie->setRang($request->getPost('rang'));
        $magie->setProvenance($request->getPost('provenance', ''));
        $magie->setLernbedingung($request->getPost('lernbedingung'));

        $magie->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );
        $this->mapper->updateMagie($magie);
        $this->mapper->deleteDependencies($magie);
        $this->mapper->setDependencies($magie);
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @throws Exception
     */
    public function createMagie (Zend_Controller_Request_Http $request, $userId)
    {
        $magie = new Administration_Model_Magie();
        $date = new DateTime();
        $element = new Administration_Model_Element();
        $element->setId($request->getPost('element'));
        $schule = new Administration_Model_Schule();
        $schule->setId($request->getPost('magieschule'));

        $magie->setCreateDate($date->format('Y-m-d H:i:s'));
        $magie->setCreator($userId);
        $magie->setBezeichnung($request->getPost('name'));
        $magie->setBeschreibung($request->getPost('beschreibung'));
        $magie->setFp($request->getPost('fp', 0) !== 0 ? (int)$request->getPost('fp', 0) : 0);
        $magie->setElement($element);
        $magie->setSchule($schule);
        $magie->setPrana($request->getPost('prana', 0) !== 0 ? (int)$request->getPost('prana', 0) : 0);
        $magie->setStufe($request->getPost('stufe'));
        $magie->setRang($request->getPost('rang'));
        $magie->setProvenance($request->getPost('provenance', ''));
        $magie->setLernbedingung($request->getPost('lernbedingung'));

        $magie->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );
        $magie->setId($this->mapper->createMagie($magie));
        $this->mapper->deleteDependencies($magie);
        $this->mapper->setDependencies($magie);
    }


    /**
     * @param $skillId
     *
     * @return Administration_Model_Skill
     * @throws Exception
     */
    public function getSkillById ($skillId)
    {
        $skill = $this->mapper->getSkillById($skillId);
        $skill->setRequirementList($this->requirementService->getRequirementListSkill($skillId));
        return $skill;
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @throws Exception
     */
    public function editSkill (Zend_Controller_Request_Http $request, $userId)
    {
        $skill = new Administration_Model_Skill();
        $date = new DateTime();
        $skill->setEditDate($date->format('Y-m-d H:i:s'));
        $skill->setEditor($userId);
        $skill->setId($request->getPost('skillId'));
        $skill->setBezeichnung($request->getPost('name'));
        $skill->setBeschreibung($request->getPost('beschreibung'));
        $skill->setFp($request->getPost('fp', 0) !== 0 ? (int)$request->getPost('fp') : 0);
        $skill->setSkillArt($request->getPost('skillart'));
        $skill->setRang($request->getPost('rang'));
        $skill->setProvenance($request->getPost('provenance', ''));
        $skill->setUebung($request->getPost('uebung', 0) !== 0 ? (int)$request->getPost('uebung', 0) : 0);
        $skill->setDisziplin($request->getPost('disziplin', 0) !== 0 ? (int)$request->getPost('disziplin', 0) : 0);
        $skill->setLernbedingung($request->get('lernbedingung'));
        $skill->setReplacesSkillId((int)$request->getPost('replaces') !== 0 ? $request->getPost('replaces') : null);

        $skill->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );
        $this->mapper->updateSkill($skill);
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @throws Exception
     */
    public function createSkill (Zend_Controller_Request_Http $request, $userId)
    {
        $skill = new Administration_Model_Skill();
        $date = new DateTime();
        $skill->setCreateDate($date->format('Y-m-d H:i:s'));
        $skill->setCreator($userId);
        $skill->setBezeichnung($request->getPost('name'));
        $skill->setBeschreibung($request->getPost('beschreibung'));
        $skill->setFp($request->getPost('fp', 0) !== 0 ? (int)$request->getPost('fp') : 0);
        $skill->setSkillArt($request->getPost('skillart'));
        $skill->setRang($request->getPost('rang'));
        $skill->setProvenance($request->getPost('provenance', ''));
        $skill->setUebung($request->getPost('uebung', 0) !== 0 ? (int)$request->getPost('uebung', 0) : 0);
        $skill->setDisziplin($request->getPost('disziplin', 0) !== 0 ? (int)$request->getPost('disziplin', 0) : 0);
        $skill->setLernbedingung($request->get('lernbedingung'));
        $skill->setReplacesSkillId((int)$request->getPost('replaces') !== 0 ? $request->getPost('replaces') : null);

        $skill->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );
        $this->mapper->createSkill($skill);
    }

}
