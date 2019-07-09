<?php

/**
 * Description of Administration_Service_Trait
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Trait {
    
    /**
     * @var Administration_Model_Mapper_TraitMapper
     */
    private $mapper;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_TraitMapper();
    }

    /**
     * @return Application_Model_Trait[]
     */
    public function getTraits ()
    {
        return $this->mapper->getAllTraits();
    }

    /**
     * @return Application_Model_Trait[]
     */
    public function getFocusTraits ()
    {
        return $this->mapper->getFocusTraits();
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @return int
     * @throws Exception
     */
    public function createTrait(Zend_Controller_Request_Http $request, $userId) {
        $trait = new Administration_Model_Trait();
        $date = new DateTime();
        $trait->setCreateDate($date->format('Y-m-d H:i:s'));
        $trait->setName($request->getPost('name'));
        $trait->setBeschreibung($request->getPost('beschreibung'));
        $trait->setKosten($request->getPost('kosten'));
        $trait->setIsIndividual($request->getPost('isIndividual', false));
        $trait->setIsFocusTrait($request->getPost('isFocusTrait', false));
        $trait->setFocustraitId($request->getPost('focustraitId', 0));

        $traitId = $this->mapper->createTrait($trait);
        foreach ($request->getPost('trait', []) as $incTraitId) {
            $this->mapper->addIncompatibleTrait($traitId, $incTraitId);
        }
        $this->mapper->setTraitsIncompatibilities($traitId);

        return$traitId;
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * @param $userId
     *
     * @return int
     * @throws Exception
     */
    public function editTrait(Zend_Controller_Request_Http $request, $userId) {
        $trait = new Administration_Model_Trait();
        $date = new DateTime();
        $trait->setTraitId($request->getPost('traitId'));
        $trait->setEditDate($date->format('Y-m-d H:i:s'));
        $trait->setName($request->getPost('name'));
        $trait->setBeschreibung($request->getPost('beschreibung'));
        $trait->setKosten($request->getPost('kosten'));
        $trait->setEditor($userId);
        $trait->setIsIndividual($request->getPost('isIndividual', false));
        $trait->setIsFocusTrait($request->getPost('isFocusTrait', false));
        $trait->setFocustraitId($request->getPost('focustraitId', 0));

        $this->mapper->removeTraitIncompatibilites($trait->getTraitId());
        foreach ($request->getPost('trait', []) as $incTraitId) {
            $this->mapper->addIncompatibleTrait($trait->getTraitId(), $incTraitId);
        }
        $this->mapper->setTraitsIncompatibilities($trait->getTraitId());

        return $this->mapper->updateTrait($trait);
    }

    /**
     * @param $traitId
     *
     * @return Administration_Model_Trait
     * @throws Exception
     */
    public function getTraitById($traitId) {
        $trait = $this->mapper->getTraitById($traitId);
        $trait->setIncompatibleTraits($this->mapper->getIncompatibleTraits($traitId));
        return $trait;
    }

    /**
     * @param int $traitId
     *
     * @throws Exception
     */
    public function delete(int $traitId) {
        $this->mapper->delete($traitId);
    }
    
}
