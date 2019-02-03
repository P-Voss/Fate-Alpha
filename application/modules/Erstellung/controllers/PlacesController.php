<?php

/**
 * Class Erstellung_PlacesController
 */
class Erstellung_PlacesController extends Zend_Controller_Action
{

    /**
     * @var Erstellung_Service_Information
     */
    private $informationService;

    public function init ()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }
        $this->layoutService = new Application_Service_Layout();
        $layoutData = $this->layoutService->getLayoutData($auth);
        if ($layoutData->getHasChara()) {
            $this->redirect('index');
        }
        $this->informationService = new Erstellung_Service_Information();
    }


    public function indexAction ()
    {
        echo json_encode(
            [
                'success' => true,
                'districts' => $this->informationService->getDistricts(),
                'attractions' => $this->informationService->getAttractions()
            ]
        );
        exit;
    }
}