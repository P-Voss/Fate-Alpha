<?php

/**
 * Description of Administration_Service_Items
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Items {
    
    /**
     * @var Administration_Model_Mapper_ItemMapper
     */
    private $mapper;
    /**
     * @var Administration_Service_Requirement
     */
    private $requirementService;
    
    public function __construct() {
        $this->mapper = new Administration_Model_Mapper_ItemMapper();
        $this->requirementService = new Administration_Service_Requirement();
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @throws Exception
     */
    public function createItem(Zend_Controller_Request_Http $request) {
        $item = new Administration_Model_Item();

        $item->setName($request->getPost('name'));
        $item->setBedingung($request->getPost('bedingung'));
        $item->setDescription($request->getPost('beschreibung'));
        $item->setDiscountDays($request->getPost('discountDays', []));
        $item->setCost((int) max($request->getPost('fp', 0), 0));
        $item->setRank($request->getPost('rang'));
        $item->setType($request->getPost('type'));

        $item->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );

        $item->setId($this->mapper->createItem($item));
        $this->mapper->deleteDependencies($item);
        $this->mapper->setDependencies($item);
        $this->mapper->saveDiscountDays($item);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @throws Exception
     */
    public function editItem(Zend_Controller_Request_Http $request) {
        $item = new Administration_Model_Item();

        $item->setId($request->getPost('itemId'));
        $item->setBedingung($request->getPost('bedingung'));
        $item->setName($request->getPost('name'));
        $item->setDescription($request->getPost('beschreibung'));
        $item->setDiscountDays($request->getPost('discountDays', []));
        $item->setCost((int) max($request->getPost('fp', 0), 0));
        $item->setRank($request->getPost('rang'));
        $item->setType($request->getPost('type'));

        $item->setRequirementList(
            $this->requirementService->createRequirementListFromArray(
                $this->requirementService->buildRequirementArray($request)
            )
        );

        $this->mapper->updateItem($item);
        $this->mapper->deleteDependencies($item);
        $this->mapper->setDependencies($item);
        $this->mapper->saveDiscountDays($item);
    }

    /**
     * @return Administration_Model_Item[]
     */
    public function getItemList() {
        return $this->mapper->getAllItems();
    }

    /**
     * @param $itemId
     *
     * @return Administration_Model_Item
     * @throws Exception
     */
    public function getItemById($itemId) {
        $item = $this->mapper->getItemById($itemId);
        $item->setRequirementList($this->mapper->getRequirementsList($itemId));

        return $item;
    }
    
    
    public function deleteItem($itemId) {
        
    }
    
}
