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
        
        $layoutModel->setUnreadPmCount($userMapper->countNewPm($auth->userId));
        $layoutModel->setUsergruppe($auth->usergruppe);
        if($userMapper->hasChara($auth->userId)){
            $layoutModel->setHasChara(true);
            $layoutModel->setCharakter($charakterMapper->getCharakterByUserId($auth->userId));
            $layoutModel->setCharakterTraining($charakterMapper->getCurrentTraining($layoutModel->getCharakter()->getCharakterid()));
        }
        return $layoutModel;
    }
}
