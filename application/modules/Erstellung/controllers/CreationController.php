<?php

/**
 * Class Erstellung_CreationController
 */
class Erstellung_CreationController extends Zend_Controller_Action
{

    /**
     * @var Erstellung_Service_Validation
     */
    private $validationService;
    /**
     * @var Erstellung_Service_Creation
     */
    private $creationService;

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
        $layout = $this->_helper->layout();
        $layout->setLayout('erstellung');
        $this->view->layoutData = $layoutData;
        $this->validationService = new Erstellung_Service_Validation();
        $this->creationService = new Erstellung_Service_Creation();
    }


    public function indexAction ()
    {

    }


    public function saveAction ()
    {
        $character = $this->getCharacterFromRequest($this->getRequest());
        try {
            if ($this->validationService->validateCharacter($character)) {
                $characterId = $this->creationService->saveCharacter($character);
                echo json_encode(
                    [
                        'success' => true,
                        'characterId' => $characterId
                    ]
                );
                exit;
            } else {
                Zend_Debug::dump($character);
                exit;
            }
        } catch (Throwable $exception) {
            echo json_encode(
                [
                    'success' => false,
                    'error' => $exception->getMessage()
                ]
            );
            exit;
        }
    }

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return Erstellung_Model_Character
     */
    private function getCharacterFromRequest(Zend_Controller_Request_Http $request) {
        $character = new Erstellung_Model_Character();
        $character->setVorname($request->getPost('firstname'));
        $character->setNachname($request->getPost('surname'));
        $character->setGeschlecht($request->getPost('gender'));
        $character->setGeburtsdatum($request->getPost('dateOfBirth'));
        $character->setAugenfarbe($request->getPost('eyeColor'));
        $character->setSize($request->getPost('size'));
        $character->setSexualitaet($request->getPost('preference'));
        $character->setWohnort($request->getPost('residence'));

        $traits = array_map(function($traitId) {
            $trait= new Erstellung_Model_Trait();
            $trait->setTraitId($traitId);
            return $trait;
        }, explode(',', $request->getPost('traits')));

        $character->setTraits($traits);

        $element = new Erstellung_Model_Element();
        $element->setId($request->getPost('element'));
        $character->setNaturElement($element);

        $class = new Erstellung_Model_Klasse();
        $class->setId($request->getPost('class'));
        $character->setKlassengruppe($class);

        $subclass = new Erstellung_Model_Unterklasse();
        $subclass->setId($request->getPost('subclass'));
        $character->setKlasse($subclass);

        $odo = new Erstellung_Model_Odo();
        $odo->setId($request->getPost('odo'));
        $character->setOdo($odo);

        $circuit = new Erstellung_Model_Circuit();
        $circuit->setId($request->getPost('circuit'));
        $character->setMagiccircuit($circuit);

        $luck = new Erstellung_Model_Luck();
        $luck->setId($request->getPost('luck'));
        $character->setLuck($luck);

        return $character;
    }
}