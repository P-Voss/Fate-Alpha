<?php

/**
 * Description of Skill
 *
 * @author Vosser
 */
class Administration_Model_Skill extends Application_Model_Skill implements Administration_Model_CrudObject
{


    /**
     * @var
     */
    private $replacesSkillId;
    /**
     * @var
     */
    private $creator;
    /**
     * @var
     */
    private $editor;
    /**
     * @var DateTime
     */
    private $createDate;
    /**
     * @var DateTime
     */
    private $editDate;
    /**
     * @var Administration_Model_Requirementlist
     */
    private $requirementList;

    /**
     * @return mixed
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @return mixed
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @param string $format
     * @return string
     * @throws Exception
     */
    public function getCreateDate($format = 'd.m.Y H:i')
    {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    /**
     * @param string $format
     * @return string
     * @throws Exception
     */
    public function getEditDate($format = 'd.m.Y H:i')
    {
        $date = new DateTime($this->editDate);
        return $date->format($format);
    }

    /**
     * @param $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @param $editor
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;
    }

    /**
     * @param $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @param $editDate
     */
    public function setEditDate($editDate)
    {
        $this->editDate = $editDate;
    }

    /**
     * @return Administration_Model_Requirementlist
     */
    public function getRequirementList()
    {
        return $this->requirementList;
    }

    /**
     * @param Administration_Model_Requirementlist $requirementList
     */
    public function setRequirementList(Administration_Model_Requirementlist $requirementList)
    {
        $this->requirementList = $requirementList;
    }

    /**
     * @return mixed
     */
    public function getReplacesSkillId()
    {
        return $this->replacesSkillId;
    }

    /**
     * @param $replacesSkillId
     */
    public function setReplacesSkillId($replacesSkillId)
    {
        $this->replacesSkillId = $replacesSkillId;
    }

}
