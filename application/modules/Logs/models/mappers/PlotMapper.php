<?php

/**
 * Description of Logs_Model_Mapper_PlotMapper
 *
 * @author Voß
 */
class Logs_Model_Mapper_PlotMapper extends Application_Model_Mapper_PlotMapper {
    
    
    public function getPlotsOpenToReviewByUser($userId) {
        $returnArray = [];
        $db = $this->getDbTable('Plots')->getDefaultAdapter();
        $sql = 'SELECT plots.plotId, plotData.name 
                FROM plots
                INNER JOIN episoden 
                    ON plots.plotId = episoden.plotId 
                    AND episoden.statusId = 4
                LEFT JOIN episodenAuswertung AS auswertung
                    ON auswertung.episodenId = episoden.episodenId 
                    AND auswertung.userId = ? AND auswertung.isActive = 1
                INNER JOIN plots AS plotData
                    ON plotData.plotId = plots.plotId
                WHERE auswertung.episodenId IS NULL AND plots.isSecret = 0
                GROUP BY plots.plotId';
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId]);
        foreach ($stmt->fetchAll() as $row) {
            $plot = new Logs_Model_Plot();
            $plot->setName($row['name']);
            $plot->setId($row['plotId']);
            $returnArray[] = $plot;
        }
        return $returnArray;
    }
    
    /**
     * @param int $plotId
     * @return \Logs_Model_Plot
     */
    public function getPlotById($plotId) {
        $plot = new Logs_Model_Plot();
        $db = $this->getDbTable('Plots')->getDefaultAdapter();
        $sql ='SELECT 
                    plots.plotId, 
                    plots.userId, 
                    plots.name, 
                    plots.creationdate, 
                    plotDesc.description,
                    plotRes.outcome
                FROM plots
                LEFT JOIN (
                    SELECT pd.plotId, pd.description 
                    FROM plotDescriptions AS pd
                    GROUP BY pd.plotId 
                    HAVING MAX(pd.creationdate)
                ) AS plotDesc USING(plotId)
                LEFT JOIN (
                    SELECT po.plotId, po.outcome 
                    FROM plotOutcomes AS po
                    GROUP BY po.plotId 
                    HAVING MAX(po.creationdate)
                ) AS plotRes USING(plotId)
                WHERE plots.plotId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($plotId));
        $result = $stmt->fetch();
        if($result !== false){
            $plot->setId($result['plotId']);
            $plot->setName($result['name']);
            $plot->setBeschreibung($result['description']);
            $plot->setSlId($result['userId']);
            $plot->setCreateDate($result['creationdate']);
            $plot->setZusammenfassung($result['outcome']);
        }
        return $plot;
    }
    
    /**
     * @param int $plotId
     * @param Application_Model_Interfaces_Auswertung $auswertung
     */
    public function setPlotFeedback($plotId, Application_Model_Interfaces_Auswertung $auswertung) {
        $db = $this->getDbTable('Plots')->getDefaultAdapter();
        $stmt = $db->prepare('INSERT INTO plotAuswertung (plotId, userId, feedback, isAccepted) 
                                VALUES (?, ?)');
        $stmt->execute([
            $plotId, $auswertung->getUserId(), $auswertung->getDescription(), $auswertung->getIsAccepted(),
        ]);
    }
    
}
