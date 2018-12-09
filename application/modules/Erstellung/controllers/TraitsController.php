<?php

/**
 * Class Erstellung_TraitsController
 */
class Erstellung_TraitsController extends Zend_Controller_Action
{

    /**
     * @var Erstellung_Service_Information
     */
    private $informationService;

    public function init ()
    {
        header('Access-Control-Allow-Origin: *');
        header('X-Frame-Options ALLOW-FROM uri');
//        $auth = Zend_Auth::getInstance()->getIdentity();
//        if($auth === null){
//            $this->redirect('index');
//        }
        $this->informationService = new Erstellung_Service_Information();
    }


    public function indexAction ()
    {
        $traits = $this->informationService->getTraits();
        echo json_encode(
            [
                'success' => true,
                'traits' => $traits
            ]
        );
        exit;
    }
}