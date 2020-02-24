<?php


namespace Shop\Services;


use Application_Model_Charakter;
use Application_Service_CharakterBuilder;
use Exception;

class Character extends \Application_Service_Charakter
{



    /**
     * @param int $userId
     *
     * @return Application_Model_Charakter
     * @throws Exception
     */
    public function getCharakterByUserid($userId) {
        $charakterId = $this->charakterMapper->getCharakterIdByUserId($userId);
        return $this->buildCharakter($charakterId);
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Charakter
     * @throws Exception
     */
    protected function buildCharakter($charakterId) {
        $charakterBuilder = new Application_Service_CharakterBuilder();
        if ($charakterBuilder->initCharakterByCharakterId($charakterId)) {
            $charakterBuilder
                ->setTraits()
                ->setCircuit()
                ->setNaturelement()
                ->setClassData()
                ->setLuck()
                ->setMagien()
                ->setOdo()
                ->setProfile()
                ->setCompleteSkills()
                ->setItems()
                ->setAchievements()
                ->setVermoegen()
                ->setWerte();
            return $charakterBuilder->getCharakter();
        } else {
            throw new Exception('Character could not be loaded');
        }
    }


}