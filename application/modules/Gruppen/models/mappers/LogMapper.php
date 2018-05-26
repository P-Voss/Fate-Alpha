<?php

/**
 * Class Gruppen_Model_Mapper_LogMapper
 */
class Gruppen_Model_Mapper_LogMapper extends Application_Model_Mapper_LogMapper {

    /**
     * @param int $logId
     * @param int $gruppenId
     *
     * @return int
     * @throws Exception
     */
    public function connectGroupToLog($logId, $gruppenId) {
        $data = array(
            'logId' => $logId,
            'gruppenId' => $gruppenId,
        );
        return parent::getDbTable('LogToGruppe')->insert($data);
    }


    /**
     * @param $gruppenId
     *
     * @return array
     * @throws Exception
     */
    public function getLogsByGruppe($gruppenId) {
        $returnArray = array();
        $select = $this->getDbTable('LogToGruppe')->select();
        $select->setIntegrityCheck(false);
        $select->from('logsToGruppe');
        $select->join('logs', 'logs.logId = logsToGruppe.logId');
        $select->where('logsToGruppe.gruppenId = ?', $gruppenId);
        $select->order('plotId DESC');
        $result = $this->getDbTable('LogToGruppe')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row) {
                $log = new Application_Model_Log();
                $log->setId($row->logId);
                $log->setName($row->name);
                $log->setMd5($row->md5);
                $log->setOwner($row->owner);
                $log->setStatus($row->status);
                $log->setPlotId($row->plotId);
                $log->setCreateDate($row->createDate);
                $returnArray[] = $log;
            }
        }
        return $returnArray;
    }


    /**
     * @param $gruppenId
     * @param $logId
     *
     * @return Application_Model_Log|bool
     * @throws Exception
     */
    public function getGruppenLogById($gruppenId, $logId) {
        $select = $this->getDbTable('LogToGruppe')->select();
        $select->setIntegrityCheck(false);
        $select->from('logsToGruppe');
        $select->join('logs', 'logs.logId = logsToGruppe.logId');
        $select->where('logsToGruppe.gruppenId = ?', $gruppenId);
        $select->where('logs.logId = ?', $logId);
        $row = $this->getDbTable('LogToGruppe')->fetchRow($select);
        if($row !== null){
            $log = new Application_Model_Log();
            $log->setId($row->logId);
            $log->setName($row->name);
            $log->setMd5($row->md5);
            $log->setOwner($row->owner);
            $log->setStatus($row->status);
            $log->setPlotId($row->plotId);
            $log->setCreateDate($row->createDate);
            return $log;
        }
        return false;
    }

    /**
     * @todo ?
     * @param $log
     */
    public function saveLog ($log)
    {

    }


}
