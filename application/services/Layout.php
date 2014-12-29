<?php

/**
 * Description of Layout
 *
 * @author Vosser
 */
class Application_Service_Layout {

    public function getLayoutData($auth){
        $layoutModel = new Application_Model_Layout();
        $userMapper = new Application_Model_Mapper_UserMapper();
        $charakterMapper = new Application_Model_Mapper_CharakterMapper();
        
        $layoutModel->setHasChara($userMapper->hasChara($auth->ID));
        $layoutModel->setCharakter($charakterMapper->getCharakterById($auth->ID));
        $layoutModel->setUnreadPmCount($userMapper->countNewPm($auth->ID));
        $layoutModel->setUsergruppe($auth->Usergruppe);
        $layoutModel->setCharakterTraining($charakterMapper->getCurrentTraining($layoutModel->getCharakter()->getCharakterid()));
        return $layoutModel;
    }
}
