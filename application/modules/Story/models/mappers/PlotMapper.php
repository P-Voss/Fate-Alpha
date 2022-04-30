<?php

/**
 * Description of Story_Model_Mapper_PlotMapper
 *
 * @author Voß
 */
class Story_Model_Mapper_PlotMapper extends Application_Model_Mapper_PlotMapper
{

    /**
     * @param int $plotId
     * @param int $gruppenId
     *
     * @return int
     * @throws Exception
     */
    public function connectGroupToPlot ($plotId, $gruppenId)
    {
        $data = [
            'plotId' => $plotId,
            'gruppenId' => $gruppenId,
        ];
        return parent::getDbTable('PlotToGruppe')->insert($data);
    }

    /**
     * @param int $plotId
     *
     * @return Story_Model_Plot
     * @throws Exception
     */
    public function getPlotById ($plotId)
    {
        $plot = new Story_Model_Plot();
        $db = $this->getDbTable('Plots')->getDefaultAdapter();
        $sql = 'SELECT 
                    plots.plotId, 
                    plots.userId, 
                    plots.name, 
                    plots.creationdate, 
                    description.description,
                    outcome.outcome
                FROM plots
                LEFT JOIN (
                    SELECT pd.plotId, MAX(pd.creationdate) AS date
                    FROM plotDescriptions AS pd
                    GROUP BY pd.plotId 
                ) AS plotDesc 
                    ON plotDesc.plotId = plots.plotId
                LEFT JOIN plotDescriptions AS description 
                    ON description.plotId = plots.plotId AND description.creationdate = plotDesc.date
                LEFT JOIN (
                    SELECT po.plotId, MAX(po.creationdate) AS date
                    FROM plotOutcomes AS po
                    GROUP BY po.plotId 
                ) AS plotRes 
                    ON plotRes.plotId = plots.plotId
                LEFT JOIN plotOutcomes AS outcome 
                    ON outcome.plotId = plots.plotId AND outcome.creationdate = plotRes.date
                WHERE plots.plotId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$plotId]);
        $result = $stmt->fetch();
        if ($result !== false) {
            $plot->setId($result['plotId']);
            $plot->setName($result['name']);
            $plot->setBeschreibung($result['description']);
            $plot->setSlId($result['userId']);
            $plot->setCreateDate(new DateTime($result['creationdate']));
            $plot->setZusammenfassung($result['outcome']);
        }
        return $plot;
    }

    /**
     * @param Application_Model_Plot $plot
     *
     * @return int
     * @throws Exception
     */
    public function createPlot (Application_Model_Plot $plot)
    {
        $data = [
            'userId' => $plot->getSlId(),
            'name' => $plot->getName(),
            'isSecret' => (int) $plot->getIsSecret(),
            'creationdate' => $plot->getCreateDate('Y-m-d H:i:s'),
            'genres' => json_encode($plot->getGenres())
        ];
        return $this->getDbTable('Plots')->insert($data);
    }

    /**
     * @param Application_Model_Plot $plot
     *
     * @return int
     * @throws Exception
     */
    public function renamePlot (Application_Model_Plot $plot)
    {
        $data = [
            'name' => $plot->getName(),
        ];
        return $this->getDbTable('Plots')->update($data, ['plotId = ?' => $plot->getId()]);
    }

    /**
     * @param int $plotId
     *
     * @return int
     * @throws Exception
     */
    public function deactivatePlot ($plotId)
    {
        $data = [
            'isActive' => 0,
        ];
        return $this->getDbTable('Plots')->update($data, ['plotId = ?' => $plotId]);
    }

    /**
     * @param int $plotId
     * @param array $genres
     *
     * @throws Exception
     */
    public function setGenres ($plotId, $genres = [])
    {
        $data = ['plotId' => $plotId];
        foreach ($genres as $genre) {
            $data['genre'] = $genre;
            $this->getDbTable('PlotGenres')->insert($data);
        }
    }


    /**
     * @param Story_Model_Plot $plot
     *
     * @throws Exception
     */
    public function setPlotDescription (Story_Model_Plot $plot)
    {
        $db = $this->getDbTable('Plots')->getDefaultAdapter();
        $stmt = $db->prepare(
            'INSERT INTO plotDescriptions (plotId, description) 
                                VALUES (?, ?)'
        );
        $stmt->execute([$plot->getId(), $plot->getBeschreibung()]);
    }

    /**
     * @param int $gruppenId
     *
     * @return Gruppen_Model_Plot[]
     * @throws Exception
     */
    public function getPlotsByGruppe ($gruppenId)
    {
        $returnArray = [];
        $db = $this->getDbTable('PlotToGruppe')->getDefaultAdapter();
        $sql = 'SELECT plots.plotId, plots.name, plotDesc.description
                FROM plots
                LEFT JOIN (
                    SELECT pd.plotId, pd.description 
                    FROM plotDescriptions AS pd
                    GROUP BY pd.plotId 
                    HAVING MAX(pd.creationdate)
                ) AS plotDesc USING(plotId)
                INNER JOIN plotToGruppe USING (plotId)
                WHERE plotToGruppe.gruppenId = ?';
        $result = $db->query($sql, [$gruppenId])->fetchAll();
        foreach ($result as $row) {
            $plot = new Gruppen_Model_Plot();
            $plot->setId($row['plotId']);
            $plot->setName($row['name']);
            $plot->setBeschreibung($row['description']);
            $returnArray[] = $plot;
        }
        return $returnArray;
    }

    /**
     * @param int $plotId
     * @param int $userId
     *
     * @return boolean
     * @throws Exception
     */
    public function verifySl ($plotId, $userId)
    {
        $select = $this->getDbTable('Plots')->select();
        $select->setIntegrityCheck(false);
        $select->from('plots');
        $select->where('plots.plotId = ?', $plotId);
        $select->where('plots.userId = ? AND plots.isActive = 1', $userId);
        return $this->getDbTable('Spielergruppen')->fetchAll($select)->count() > 0;
    }

    /**
     * @param int $plotId
     * @param int $userId
     *
     * @return boolean
     * @throws Exception
     */
    public function verifyPlayer ($plotId, $userId)
    {
        $select = $this->getDbTable('Plots')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterPlots');
        $select->joinInner('charakter', 'charakter.charakterId = charakterPlots.charakterId AND charakter.active = 1', []);
        $select->joinInner('plots', 'plots.plotId = charakterPlots.plotId AND plots.isActive = 1', []);
        $select->where('charakter.userId = ?', $userId);
        $select->where('charakterPlots.plotId = ?', $plotId);
        return $this->getDbTable('Plots')->fetchAll($select)->count() > 0;
    }

    /**
     * @param int $plotId
     *
     * @return Application_Model_Charakter[]
     * @throws Exception
     */
    public function getParticipantsByPlotId ($plotId)
    {
        $returnArray = [];
        $db = $this->getDbTable('Charakter')->getDefaultAdapter();
        $sql = <<<SQL
SELECT
    charakter.charakterId,
    charakter.vorname,
    charakter.nachname,
    charakterPlots.freigabe,
    involvedInEpisodes.charakterId IS NOT NULL AS isInvolved
FROM 
    charakter
INNER JOIN charakterPlots 
    USING (charakterId)
LEFT JOIN 
(
    SELECT charakterId, plotId FROM episodenToCharakter
    INNER JOIN episoden USING (episodenId)
    WHERE episoden.statusId > 2
    GROUP BY charakterId, plotId
) AS involvedInEpisodes 
    ON charakterPlots.plotId = involvedInEpisodes.plotId 
    AND charakterPlots.charakterId = involvedInEpisodes.charakterId
WHERE 
    charakterPlots.plotId = ? AND charakter.active = 1
ORDER BY charakter.vorname ASC
SQL;
        $stmt = $db->prepare($sql);
        $stmt->execute([$plotId]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $row) {
            $charakter = new Story_Model_Charakter();
            $charakter->setCharakterid($row->charakterId);
            $charakter->setVorname($row->vorname);
            $charakter->setNachname($row->nachname);
            $charakter->setDatenFreigabe((bool) $row->freigabe);
            $charakter->setInvolved((bool) $row->isInvolved);
            $returnArray[] = $charakter;
        }
        return $returnArray;
    }

    /**
     * @param int $plotId
     *
     * @return Application_Model_Charakter[]
     * @throws Exception
     */
    public function getParticipantsNotInPlot ($plotId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('plotToGruppe');
        $select->joinInner('charakterGruppen', 'charakterGruppen.gruppenId = plotToGruppe.gruppenId');
        $select->joinLeft('charakterPlots', 'charakterPlots.plotId = plotToGruppe.plotId AND charakterPlots.charakterId = charakterGruppen.charakterId');
        $select->joinInner('charakter', 'charakterGruppen.charakterId = charakter.charakterId AND charakter.active = 1');
        $select->where('plotToGruppe.plotId = ? AND charakterPlots.charakterId IS NULL', $plotId);
        $select->order('charakter.vorname ASC');

        $result = $this->getDbTable('Charakter')->fetchAll($select);
        foreach ($result as $row) {
            $charakter = new Story_Model_Charakter();
            $charakter->setCharakterid($row->charakterId);
            $charakter->setVorname($row->vorname);
            $charakter->setNachname($row->nachname);
            $returnArray[] = $charakter;
        }
        return $returnArray;
    }

    /**
     * @param int $slId
     *
     * @return Story_Model_Plot[]
     * @throws Exception
     */
    public function getPlotsBySLId ($slId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Plots')->select();
        $select->setIntegrityCheck(false);
        $select->from('plots');
        $select->joinInner(
            'plotDescriptions',
            'plotDescriptions.plotId = plots.plotId',
            ['description']
        );
        $select->where('userId = ? AND plots.isActive = 1', $slId);
        $result = $this->getDbTable('Plots')->fetchAll($select);
        foreach ($result as $row) {
            $plot = new Story_Model_Plot();
            $plot->setId($row->plotId);
            $plot->setSlId($slId);
            $plot->setName($row->name);
            $plot->setBeschreibung($row->description);
            $plot->setCreateDate(new DateTime($row->creationdate));
            if (json_decode($row->genres)) {
                $plot->setGenres(json_decode($row->genres));
            }
            $returnArray[] = $plot;
        }
        return $returnArray;
    }

    /**
     * @param int $playerId
     *
     * @return Story_Model_Plot[]
     * @throws Exception
     */
    public function getPlotsByPlayerId ($playerId)
    {
        $returnArray = [];
        $select = $this->getDbTable('Plots')->select();
        $select->setIntegrityCheck(false);
        $select->from('plots');
        $select->joinInner('charakterPlots', 'charakterPlots.plotId = plots.plotId', []);
        $select->joinInner('charakter', 'charakter.charakterId = charakterPlots.charakterId AND charakter.active = 1', []);
        $select->joinInner(
            'plotDescriptions',
            'plotDescriptions.plotId = plots.plotId',
            ['description']
        );
        $select->where('charakter.userId = ? AND plots.isActive = 1', $playerId);
        $result = $this->getDbTable('Plots')->fetchAll($select);
        foreach ($result as $row) {
            $plot = new Story_Model_Plot();
            $plot->setId($row->plotId);
            $plot->setSlId($row->userId);
            $plot->setName($row->name);
            $plot->setBeschreibung($row->description);
            $plot->setCreateDate(new DateTime($row->creationdate));
            if (json_decode($row->genres)) {
                $plot->setGenres(json_decode($row->genres));
            }
            $returnArray[] = $plot;
        }
        return $returnArray;
    }

    /**
     * @param int $plotId
     * @param int $charakterId
     *
     * @throws Exception
     */
    public function addParticipant ($plotId, $charakterId)
    {
        $data = [
            'charakterId' => $charakterId,
            'plotId' => $plotId,
        ];
        $this->getDbTable('CharakterPlots')->insert($data);
    }

    /**
     * @param int $charakterId
     * @param int $plotId
     *
     * @throws Exception
     */
    public function removeParticipant ($charakterId, $plotId)
    {
        $db = $this->getDbTable('CharakterPlots')->getDefaultAdapter();
        $sql = 'DELETE episodenToCharakter.* 
            FROM episodenToCharakter 
            INNER JOIN episoden USING (episodenId)
            WHERE plotId = ? AND charakterId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$plotId, $charakterId]);
        $this->getDbTable('CharakterPlots')->delete(
            [
                'charakterId = ?' => $charakterId,
                'plotId = ?' => $plotId,
            ]
        );
    }

    /**
     * @param int $plotId
     * @param int $userId
     *
     * @return boolean
     * @throws Exception
     */
    public function datenFreigegeben ($plotId, $userId)
    {
        $select = $this->getDbTable('Plots')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterPlots');
        $select->joinInner('charakter', 'charakter.charakterId = charakterPlots.charakterId AND charakter.active = 1', []);
        $select->where('charakter.userId = ?', $userId);
        $select->where('charakterPlots.plotId = ?', $plotId);
        $select->where('charakterPlots.freigabe = 1');
        return $this->getDbTable('Plots')->fetchAll($select)->count() > 0;
    }

    /**
     * @param int $plotId
     * @param int $charakterId
     *
     * @return boolean
     * @throws Exception
     */
    public function datenFreigebenCharakter ($plotId, $charakterId)
    {
        $select = $this->getDbTable('Plots')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakterPlots');
        $select->where('charakterPlots.charakterId = ?', $charakterId);
        $select->where('charakterPlots.plotId = ?', $plotId);
        $select->where('charakterPlots.freigabe = 1');
        return $this->getDbTable('Plots')->fetchAll($select)->count() > 0;
    }


    /**
     * @param $status
     * @param $userId
     * @param $plotId
     *
     * @throws Exception
     */
    public function updateFreigabe ($status, $userId, $plotId)
    {
        $db = $this->getDbTable('Plots')->getDefaultAdapter();
        $sql = 'UPDATE charakterPlots 
                INNER JOIN charakter 
                    USING (charakterId)
                SET freigabe = ?
                WHERE 
                    charakterPlots.plotId = ?
                    AND charakter.userId = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$status, $plotId, $userId]);
    }

    /**
     * @todo ?
     *
     * @param $plotId
     */
    public function getLogsByPlotId ($plotId)
    {

    }

}
