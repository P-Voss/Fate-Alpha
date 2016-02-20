<?php

class Gruppen_Model_Mapper_PlotMapper extends Application_Model_Mapper_PlotMapper {
    
    /**
     * @param int $plotId
     * @param int $gruppenId
     * @return int
     */
    public function connectGroupToPlot($plotId, $gruppenId) {
        $data = array(
            'plotId' => $plotId,
            'gruppenId' => $gruppenId,
        );
        return parent::getDbTable('PlotToGruppe')->insert($data);
    }
    
    
    public function getPlotsByGruppe($gruppenId) {
        $returnArray = array();
        $select = $this->getDbTable('PlotToGruppe')->select();
        $select->setIntegrityCheck(false);
        $select->from('plotToGruppe');
        $select->join('plots', 'plots.plotId = plotToGruppe.plotId');
        $select->where('plotToGruppe.gruppenId = ?', $gruppenId);
        $result = $this->getDbTable('PlotToGruppe')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row) {
                $plot = new Gruppen_Model_Plot();
                $plot->setId($row->plotId);
                $plot->setName($row->name);
                $plot->setBeschreibung($row->beschreibung);
                $plot->setCreateDate($row->createDate);
                $returnArray[] = $plot;
            }
        }
        return $returnArray;
    }
    
}
