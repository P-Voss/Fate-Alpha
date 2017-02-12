<?php

/**
 * Description of Application_Model_Notification
 *
 * @author Voß
 */
class Application_Model_Notification {
    
    private $type;
    private $typeName;
    private $parentName;
    private $parentId;
    private $notificationElementId;


    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
    
    public function getTypeName() {
        return $this->typeName;
    }

    public function setTypeName($typeName) {
        $this->typeName = $typeName;
    }
    
    public function getParentName() {
        return $this->parentName;
    }

    public function getParentId() {
        return $this->parentId;
    }

    public function setParentName($parentName) {
        $this->parentName = $parentName;
    }

    public function setParentId($parentId) {
        $this->parentId = $parentId;
    }
    
    public function getNotificationElementId() {
        return $this->notificationElementId;
    }

    public function setNotificationElementId($notificationElementId) {
        $this->notificationElementId = $notificationElementId;
    }
    
}
