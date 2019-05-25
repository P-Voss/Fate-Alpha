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
     * @param $charakterId
     *
     * @return Story_Model_Magie[]
     * @throws Exception
     */
    public function getLearnableMagien ($charakterId)
    {
        return $this->shopMapper->getMagienToLearnByRpg($charakterId);
    }

    /**
     * @param $charakterId
     *
     * @return Application_Model_Magie[]
     * @throws Exception
     */
    public function getLearnedMagien ($charakterId)
    {
        return $this->shopMapper->getCharakterMagien($charakterId);
    }

    /**
     * @param $charakterId
     *
     * @return Story_Model_Skill[]
     * @throws Exception
     */
    public function getLearnableSkills ($charakterId)
    {
        return $this->shopMapper->getSkillsToLearnByRpg($charakterId);
    }

    /**
     * @param $charakterId
     *
     * @return Application_Model_Skill[]
     * @throws Exception
     */
    public function getLearnedSkills ($charakterId)
    {
        return $this->shopMapper->getCharakterSkills($charakterId);
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return bool
     * @throws Exception
     */
    public function addRequests (Zend_Controller_Request_Http $request)
    {
        switch ($request->getPost('art', 'none')) {
            case 'magie':
                $this->shopMapper->removeSkillrequest($request->getPost('episode'), $request->getPost('charakterId'), 'magie', 'add');
                if (count($request->getPost('ids')) > 0) {
                    $this->addMagicrequest($request->getPost('episode'), $request->getPost('ids'), $request->getPost('charakterId'));
                }
                break;
            case 'skill':
                $this->shopMapper->removeSkillrequest($request->getPost('episode'), $request->getPost('charakterId'), 'skill', 'add');
                if (count($request->getPost('ids')) > 0) {
                    $this->addSkillrequest($request->getPost('episode'), $request->getPost('ids'), $request->getPost('charakterId'));
                }
                break;
            case 'none':
                return false;
        }
        return true;
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return bool
     * @throws Exception
     */
    public function removalRequests (Zend_Controller_Request_Http $request)
    {
        switch ($request->getPost('art', 'none')) {
            case 'magie':
                $this->addMagicRemovalrequest($request->getPost('episode'), $request->getPost('ids'), $request->getPost('charakterId'));
                break;
            case 'skill':
                $this->addSkillRemovalrequest($request->getPost('episode'), $request->getPost('ids'), $request->getPost('charakterId'));
                break;
            case 'none':
                return false;

        }
        return true;
    }

    /**
     * @param $episodenId
     * @param $ids
     * @param $charakterId
     *
     * @throws Exception
     */
    public function addMagicrequest ($episodenId, $ids, $charakterId)
    {
        $this->shopMapper->addSkillrequest($episodenId, $charakterId, 'magie', 'add', $ids);
    }

    /**
     * @param $episodenId
     * @param $ids
     * @param $charakterId
     *
     * @throws Exception
     */
    public function addMagicRemovalrequest ($episodenId, $ids, $charakterId)
    {
        $this->shopMapper->removeSkillrequest($episodenId, $charakterId, 'magie', 'remove');
        $this->shopMapper->addSkillrequest($episodenId, $charakterId, 'magie', 'remove', $ids);
    }

    /**
     * @param $episodenId
     * @param $ids
     * @param $charakterId
     *
     * @throws Exception
     */
    public function addSkillrequest ($episodenId, $ids, $charakterId)
    {
        $this->shopMapper->addSkillrequest($episodenId, $charakterId, 'skill', 'add', $ids);
    }

    /**
     * @param $episodenId
     * @param $ids
     * @param $charakterId
     *
     * @throws Exception
     */
    public function addSkillRemovalrequest ($episodenId, $ids, $charakterId)
    {
        $this->shopMapper->removeSkillrequest($episodenId, $charakterId, 'skill', 'remove');
        $this->shopMapper->addSkillrequest($episodenId, $charakterId, 'skill', 'remove', $ids);
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
