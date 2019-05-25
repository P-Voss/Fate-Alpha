<?php


class Story_Service_Result_Magic
{

    /**
     * @var Story_Model_Mapper_Result_MagicMapper
     */
    protected $resultMapper;

    /**
     * Story_Service_Shop constructor.
     */
    public function __construct ()
    {
        $this->resultMapper = new Story_Model_Mapper_Result_MagicMapper();
    }

    /**
     * @param $charakterId
     *
     * @return Story_Model_Magie[]
     */
    public function getLearnableMagien ($charakterId)
    {
        try {
            return $this->resultMapper->getMagienToLearnByRpg($charakterId);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param $charakterId
     *
     * @return Application_Model_Magie[]
     * @throws Exception
     */
    public function getLearnedMagien ($charakterId)
    {
        return $this->resultMapper->getCharakterMagien($charakterId);
    }

    /**
     * @param $episodeId
     * @param $characterId
     * @param array $magicIds
     *
     * @return bool
     * @throws Exception
     */
    public function addRequests ($episodeId, $characterId, $magicIds = [])
    {
        $this->resultMapper->removeSkillrequest($episodeId, $characterId, 'magie', 'add');
        if (count($magicIds) > 0) {
            $this->addMagicrequest($episodeId, $magicIds, $characterId);
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
        $this->resultMapper->addSkillrequest($episodenId, $charakterId, 'magie', 'add', $ids);
    }

    /**
     * @param $episodeId
     * @param $characterId
     * @param array $magicIds
     *
     * @return bool
     * @throws Exception
     */
    public function removalRequests ($episodeId, $characterId, $magicIds = [])
    {
        $this->addMagicRemovalrequest($episodeId, $magicIds, $characterId);
        return true;
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
        $this->resultMapper->removeSkillrequest($episodenId, $charakterId, 'magie', 'remove');
        $this->resultMapper->addSkillrequest($episodenId, $charakterId, 'magie', 'remove', $ids);
    }

}