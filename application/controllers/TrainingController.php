<?php

/**
 * Description of TrainingController
 *
 * @author Vosser
 */
class TrainingController extends Zend_Controller_Action
{

    /**
     * @var Application_Service_Layout
     */
    protected $layoutService;
    /**
     * @var Application_Service_Training
     */
    protected $trainingService;
    /**
     * @var Application_Service_Charakter
     */
    protected $charakterService;
    private $auth;
    /**
     *
     * @var Application_Model_Charakter
     */
    private $charakter;

    /**
     * @throws Exception
     */
    public function init ()
    {
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->layoutService = new Application_Service_Layout();
        $this->charakterService = new Application_Service_Charakter();
        $this->trainingService = new Application_Service_Training();

        $layout = $this->_helper->layout();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        if ($this->auth === null) {
            $layout->setLayout('offline');
        } else {
            try {
                $this->charakter = $this->charakterService->getCharakterByUserid($this->auth->userId);
                $this->view->layoutData = $this->layoutService->getLayoutData($this->auth);
                $layout->setLayout('training');
            } catch (Throwable $exception) {
                $this->redirect('Erstellung/creation');
            }
        }
    }


    public function indexAction ()
    {
        try {
            $this->view->trainingsprograms = $this->trainingService->getTrainingPrograms($this->charakter);
        } catch (Throwable $exception) {
            $this->view->trainingsprograms = [];
        }
    }


    public function programsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();

        try {
            $charakter = $this->charakter;
            echo json_encode(
                [
                'success' => true,
                'programs' => array_map(
                    function(Application_Model_Training_Program $program) {
                        return $program->toArray();
                    },
                    $this->trainingService->getTrainingPrograms($charakter))
                ]
            );
        } catch (Throwable $exception) {
            echo json_encode([]);
        }
        exit;
    }

    public function attributesAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();

        try {
            $charakter = $this->charakter;
            echo json_encode(
                [
                    'success' => true,
                    'attributes' => [
                        'strength' => [
                            'value' => $charakter->getCharakterwerte()->getStaerke(),
                            'category' => $charakter->getCharakterwerte()->getCategory('str')->getCategory()
                        ],
                        'agility' => [
                            'value' => $charakter->getCharakterwerte()->getAgilitaet(),
                            'category' => $charakter->getCharakterwerte()->getCategory('agi')->getCategory()
                        ],
                        'endurance' => [
                            'value' => $charakter->getCharakterwerte()->getAusdauer(),
                            'category' => $charakter->getCharakterwerte()->getCategory('aus')->getCategory()
                        ],
                        'practice' => [
                            'value' => $charakter->getCharakterwerte()->getUebung(),
                            'category' => 'F'
                        ],
                        'controle' => [
                            'value' => $charakter->getCharakterwerte()->getKontrolle(),
                            'category' => $charakter->getCharakterwerte()->getCategory('kon')->getCategory()
                        ],
                        'discipline' => [
                            'value' => $charakter->getCharakterwerte()->getDisziplin(),
                            'category' => $charakter->getCharakterwerte()->getCategory('dis')->getCategory()
                        ],
                        'remainingDays' => $charakter->getCharakterwerte()->getStartpunkte()
                    ]
                ]
            );
        } catch (Throwable $exception) {
            echo json_encode([]);
        }
        exit;
    }


    public function previewAction ()
    {

    }

    /**
     * @todo FlashMessage wenn das speichern fehlschlägt
     */
    public function setAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        if (!$this->getRequest()->isPost()) {
            $this->redirect('training');
        }
        try {
            $program = $this->trainingService->getCharakterTrainingProgramById(
                $this->charakter,
                $this->getRequest()->getPost('program', 0)
            );
            $program->setRemainingDuration($this->getRequest()->getPost('days', 0));
            $this->trainingService->startTraining($this->charakter, $program);
        } catch (Exception $exception) {
            $this->redirect('training');
        } catch (Throwable $exception) {
            $this->redirect('training');
        }
        $this->redirect('training');
    }

    public function logAction ()
    {
        $this->view->trainingLogs = $this->trainingService->fetchTraininglog($this->charakter->getCharakterid());
    }

    public function executeAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $layout->disableLayout();

        try {
            $charakter = $this->charakter;
        } catch (Exception $exception) {
            echo json_encode([]);
            exit;
        }

        if ($this->getRequest()->getPost('program', 0) < 1 || $this->getRequest()->getPost('days', 0) < 1) {
            echo json_encode([]);
            exit;
        }
        $programId = $this->getRequest()->getPost('program', 0);
        $days = min($charakter->getCharakterwerte()->getStartpunkte(), $this->getRequest()->getPost('days', 0));
        try {
            $trainingDays = 0;
            while ($days > 0) {
                $this->trainingService->executeBonusTraining($charakter, $programId);
                $days--;
                $trainingDays++;
            }

            echo json_encode(
                [
                    'success' => true,
                    'days' => $trainingDays
                ]
            );
            exit;
        } catch (Exception $exception) {
            echo json_encode([]);
            exit;
        }
    }

}
