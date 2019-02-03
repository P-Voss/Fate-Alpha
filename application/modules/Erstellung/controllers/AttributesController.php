<?php

/**
 * Class Erstellung_AttributesController
 */
class Erstellung_AttributesController extends Zend_Controller_Action
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
        $params = $this->informationService->getCreationParams();
        echo json_encode(
            [
                'success' => true,
                'attributes' => $params
            ]
        );
        exit;
    }
}