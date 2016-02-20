<?php

/**
 * Description of Application_Service_Story
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Story {
    
    
    public function createStoryline(Zend_Controller_Request_Http $request) {
        $mapper = new Application_Model_Mapper_PlotMapper();
        $plot = new Application_Model_Plot();
        $plot->setName($request->getPost('plotname'));
        $plot->setBeschreibung($request->getPost('beschreibung'));
        $plotId = $mapper->createPlot($plot);
        if(!is_null($request->getPost('genre'))){
            $mapper->setGenres($plotId, $request->getPost('genre'));
        }
        return $plotId;
    }
    
}
