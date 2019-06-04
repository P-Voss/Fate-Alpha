<?php

/**
 * Description of Layout
 *
 * @author Vosser
 */
class Application_Service_Layout {

    /**
     * @param $auth
     *
     * @return Application_Model_Layout
     * @throws Exception
     */
    public function getLayoutData($auth){
        $informationService = new Application_Service_Information();
        $charakterBuilder = new Application_Service_CharakterBuilder();
        $layoutModel = new Application_Model_Layout();
        $userMapper = new Application_Model_Mapper_UserMapper();
        $trainingMapper = new Application_Model_Mapper_TrainingMapper();
        $wetterMapper = new Application_Model_Mapper_WetterMapper();
        
        $layoutModel->setUnreadPmCount($userMapper->countNewPm($auth->userId));
        $layoutModel->setUsergruppe($auth->usergruppe);
        $layoutModel->setLogleser($userMapper->isLogleser($auth->userId));
        $layoutModel->setNotifications($userMapper->getNotifications($auth->userId));
        $layoutModel->setWeather($wetterMapper->getWetterByDate(new DateTime()));

        if($userMapper->hasChara($auth->userId)){
            
            if ($charakterBuilder->initCharakterByUserId($auth->userId)) {
                $charakterBuilder
                    ->setTraits()
                    ->setCircuit()
                    ->setNaturelement()
                    ->setClassData()
                    ->setLuck()
                    ->setMagien()
                    ->setMagieschulen()
                    ->setOdo()
                    ->setProfile()
                    ->setSkills()
                    ->setVermoegen()
                    ->setWerte();
                $charakter = $charakterBuilder->getCharakter();
                $layoutModel->setHasChara(true);
                $layoutModel->setCharakter($charakter);
                try {
                    $layoutModel->setCharakterTraining($trainingMapper->getCurrentTraining($charakter->getCharakterid()));
                } catch (Exception $exception) {
                    // Charakter hat kein Training eingestellt
                }
                $informationService->setCharakter($charakter);
            } else {
                $layoutModel->setHasChara(false);
            }
        }
        $layoutModel->setInformations($informationService->getInformations());

        return $layoutModel;
    }
}
