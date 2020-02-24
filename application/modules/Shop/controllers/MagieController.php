<?php

use Shop\Services\Character;
use Shop\Services\Magie;

/**
 * Description of MagieController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_MagieController extends Zend_Controller_Action
{

    /**
     * @var Application_Model_Charakter;
     */
    private $charakter;
    /**
     * @var Character;
     */
    private $characterService;

    public function init ()
    {
        if (!$this->_helper->logincheck()) {
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->characterService = new Character();

        $auth = Zend_Auth::getInstance()->getIdentity();
        try {
            $this->charakter = $this->characterService->getCharakterByUserid($auth->userId);
            $this->view->charakter = $this->charakter;
        } catch (Exception $exception) {
            $this->redirect('index/index');
        }
    }


    public function indexAction ()
    {
        $service = new Magie();
        $this->view->schools = $service->getSchoolsWithoutOrganization($this->charakter);
        $this->view->organizationSchools = $service->getSchoolsFromOrganization($this->charakter);
        $this->view->organization = $this->charakter->getMagiOrganization();
    }

    public function unlockschoolAction ()
    {
        $service = new Magie();
        $service->unlockSchool($this->charakter, $this->getRequest()->getPost('magieschuleId'));
        $this->redirect('Shop/magie/index');
    }

    public function showAction ()
    {
        $schoolId = (int) $this->getRequest()->getParam('id');
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $service = new Magie();
        $this->charakter->setMagieStufe(
            $this->charakterService->getMagieStufe(
                $this->charakter->getCharakterid(),
                $schoolId
            )
        );

        $organizationSchools = $service->getSchoolsFromOrganization($this->charakter);
        foreach ($organizationSchools as $school)
        {
            if ($school->getId() === $schoolId)
            {
                if (!$school->getLearned())
                {
                    echo json_encode(['html' => '']);
                    exit;
                }
                $this->view->magien = $service->getUnlearnedMagienBySchulId(
                    $this->charakter,
                    $schoolId
                );
                $html = $this->view->render('magie/show.phtml');
                echo json_encode(['html' => $html]);
                exit;
            }
        }
        $this->view->magien = $service->getUnlearnedMagienBySchulId(
            $this->charakter,
            $schoolId
        );
        $html = $this->view->render('magie/show.phtml');
        echo json_encode(['html' => $html]);
        exit;
    }

    public function unlockAction ()
    {
        $this->charakter->setMagieStufe(
            $this->charakterService->getMagieStufe(
                $this->charakter->getCharakterid(),
                $this->getRequest()->getParam('id')
            )
        );
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $service = new Magie();
        echo json_encode($service->unlockMagie($this->charakter, $this->getRequest()->getParam('id')));
    }

    public function previewAction ()
    {
        $service = new Magie();
        $magie = $service->getMagieById($this->charakter, $this->getRequest()->getParam('id'));
        if ($this->getRequest()->getParam('tooltip') !== null)
        {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            echo json_encode($magie);
        } else
        {
            $layout = $this->_helper->layout();
            $layout->setLayout('partials');
            $this->view->magie = $magie;
        }
    }

    public function organizationAction ()
    {
        if ($this->charakter->getMagiOrganization() === 0)
        {
            $this->charakterService->updateOrganization(
                $this->getRequest()->getPost('organization', 1),
                $this->charakter->getCharakterid()
            );
        }
        $this->redirect('Shop/magie/index');
    }

}
