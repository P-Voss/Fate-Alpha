<?php

/**
 * Class Erstellung_SubclassController
 */
class Erstellung_SubclassController extends Zend_Controller_Action
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
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();

        $character = new Erstellung_Model_Character();
        $character->setTraits(
            array_map(function($traitId) {
                $trait = new Application_Model_Trait();
                $trait->setTraitId($traitId);
                return $trait;
            }, explode(',', $this->getRequest()->getPost('traits')))
        );
        $element = new Application_Model_Element();
        $element->setId($this->getRequest()->getPost('element'));
        $character->setNaturElement($element);
        $luck = new Application_Model_Luck();
        $luck->setId($this->getRequest()->getPost('luck'));
        $character->setLuck($luck);
        $odo = new Application_Model_Odo();
        $odo->setId($this->getRequest()->getPost('odo'));
        $character->setOdo($odo);
        $circuit = new Administration_Model_Circuit();
        $circuit->setId($this->getRequest()->getPost('circuit'));
        $character->setMagiccircuit($circuit);
        $klassengruppe = new Application_Model_Klassengruppe();
        $klassengruppe->setId($this->getRequest()->getPost('class'));
        $character->setKlassengruppe($klassengruppe);

        echo json_encode(
            [
                'success' => true,
                'subclasses' => $this->informationService->getSubclassesByCharacter($character)
            ]
        );
        exit;
    }
}