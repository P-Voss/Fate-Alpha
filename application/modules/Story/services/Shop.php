<?php

/**
 * Description of Story_Service_Shop
 *
 * @author Voß
 */
class Story_Service_Shop {
    
    protected $shopMapper;


    public function __construct() {
        $this->shopMapper = new Story_Model_Mapper_ShopMapper();
    }
    
    
    public function getLearnableMagien($charakterId) {
        return $this->shopMapper->getMagienToLearnByRpg($charakterId);
    }
    
    public function getLearnedMagien($charakterId) {
        return $this->shopMapper->getCharakterMagien($charakterId);
    }
    
    
    public function getLearnableSkills($charakterId) {
        return $this->shopMapper->getSkillsToLearnByRpg($charakterId);
    }
    
    public function getLearnedSkills($charakterId) {
        return $this->shopMapper->getCharakterSkills($charakterId);
    }
    
    
    public function addRequests(Zend_Controller_Request_Http $request) {
        switch ($request->getPost('art', 'none')) {
            case 'magie':
                $this->addMagicrequest($request->getPost('episode'), $request->getPost('ids'), $request->getPost('charakterId'));
                break;
            case 'skill':
                $this->addSkillrequest($request->getPost('episode'), $request->getPost('ids'), $request->getPost('charakterId'));
                break;
            case 'none':
                return false;
        }
    }
    
    
    public function removalRequests(Zend_Controller_Request_Http $request) {
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
    }
    
    
    public function addMagicrequest($episodenId, $ids, $charakterId) {
        $this->shopMapper->removeSkillrequest($episodenId, $charakterId, 'magie', 'add');
        $this->shopMapper->addSkillrequest($episodenId, $charakterId, 'magie', 'add', $ids);
    }
    
    public function addMagicRemovalrequest($episodenId, $ids, $charakterId) {
        $this->shopMapper->removeSkillrequest($episodenId, $charakterId, 'magie', 'remove');
        $this->shopMapper->addSkillrequest($episodenId, $charakterId, 'magie', 'remove', $ids);
    }
    
    
    public function addSkillrequest($episodenId, $ids, $charakterId) {
        $this->shopMapper->removeSkillrequest($episodenId, $charakterId, 'skill', 'add');
        $this->shopMapper->addSkillrequest($episodenId, $charakterId, 'skill', 'add', $ids);
    }
    
    public function addSkillRemovalrequest($episodenId, $ids, $charakterId) {
        $this->shopMapper->removeSkillrequest($episodenId, $charakterId, 'skill', 'remove');
        $this->shopMapper->addSkillrequest($episodenId, $charakterId, 'skill', 'remove', $ids);
    }
    
}
