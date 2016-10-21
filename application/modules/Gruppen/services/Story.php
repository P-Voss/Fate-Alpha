<?php

/**
 * Description of Story
 *
 * @author Voß
 */
class Gruppen_Service_Story extends Application_Service_Story {
    
    
    public function getPlotsByGruppe($gruppenId) {
        $mapper = new Gruppen_Model_Mapper_PlotMapper();
        return $mapper->getPlotsByGruppe($gruppenId);
    }
    
}
