<?php


class Story_Service_Result_Skill
{

    /**
     * @var Story_Model_Mapper_Result_SkillMapper
     */
    protected $resultMapper;

    /**
     * Story_Service_Shop constructor.
     */
    public function __construct ()
    {
        $this->resultMapper = new Story_Model_Mapper_Result_SkillMapper();
    }

    /**
     * @param $charakterId
     *
     * @return Story_Model_Skill[]
     * @throws Exception
     */
    public function getLearnableSkills ($charakterId)
    {
        return $this->resultMapper->getSkillsToLearnByRpg($charakterId);
    }

    /**
     * @param $charakterId
     *
     * @return Application_Model_Skill[]
     * @throws Exception
     */
    public function getLearnedSkills ($charakterId)
    {
        return $this->resultMapper->getCharakterSkills($charakterId);
    }

    /**
     * @param $episodeId
     * @param $characterId
     * @param $skillIds
     *
     * @return bool
     * @throws Exception
     */
    public function addRequests ($episodeId, $characterId, $skillIds = [])
    {
        $this->resultMapper->removeSkillrequest(
            $episodeId,
            $characterId,
            'skill',
            'add'
        );
        if (count($skillIds) > 0) {
            $this->resultMapper->addSkillrequest(
                $episodeId,
                $characterId,
                'skill',
                'add',
                $skillIds
            );
        }
        return true;
    }

    /**
     * @param $episodenId
     * @param $charakterId
     * @param $skillIds
     *
     * @throws Exception
     */
    public function addSkillRemovalrequest ($episodenId, $charakterId, $skillIds = [])
    {
        $this->resultMapper->removeSkillrequest($episodenId, $charakterId, 'skill', 'remove');
        $this->resultMapper->addSkillrequest($episodenId, $charakterId, 'skill', 'remove', $skillIds);
    }

}