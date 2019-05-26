<?php

/**
 * Description of Story_Service_Shop
 *
 * @author Voß
 */
class Story_Service_Shop
{

    /**
     * @var Story_Model_Mapper_ShopMapper
     */
    protected $shopMapper;

    /**
     * Story_Service_Shop constructor.
     */
    public function __construct ()
    {
        $this->shopMapper = new Story_Model_Mapper_ShopMapper();
    }

    /**
     * @param $characterId
     *
     * @return Application_Model_Item[]
     */
    public function getItemsToAcquire ($characterId)
    {
        try {
            return $this->shopMapper->getItemsToAcquire($characterId);
        } catch (Exception $exception) {
            return [];
        }
    }

}
