<?php

/**
 * Description of Story
 *
 * @author Voß
 */
class Gruppen_Service_Story extends Application_Service_Story {
    
    
    public function createStoryline(Zend_Controller_Request_Http $request) {
        $mapper = new Gruppen_Model_Mapper_PlotMapper();
        $plotId = parent::createStoryline($request);
        return $mapper->connectGroupToPlot($plotId, $request->getPost('gruppenId'));
    }
    
    
    public function getPlotsByGruppe($gruppenId) {
        $mapper = new Gruppen_Model_Mapper_PlotMapper();
        return $mapper->getPlotsByGruppe($gruppenId);
    }
    
}
