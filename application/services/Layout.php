<?php

/**
 * Description of Layout
 *
 * @author Vosser
 */
class Application_Service_Layout {

    public function getLayoutData($auth){
        $informationService = new Application_Service_Information();
        $charakterService = new Application_Service_Charakter();
        $layoutModel = new Application_Model_Layout();
        $userMapper = new Application_Model_Mapper_UserMapper();
        $charakterMapper = new Application_Model_Mapper_CharakterMapper();
        
        $layoutModel->setUnreadPmCount($userMapper->countNewPm($auth->userId));
        $layoutModel->setUsergruppe($auth->usergruppe);
        $layoutModel->setLogleser($userMapper->isLogleser($auth->userId));
        if($userMapper->hasChara($auth->userId)){
            $charakter = $charakterService->getCharakterByUserid($auth->userId);
            $layoutModel->setHasChara(true);
            $layoutModel->setCharakter($charakter);
            $layoutModel->setCharakterTraining($charakterMapper->getCurrentTraining($charakter->getCharakterid()));
            $informationService->setCharakter($charakter);
        }
        $layoutModel->setInformations($informationService->getInformations());
        return $layoutModel;
    }
}
