<?php

class Flagbit_MageHealth_Model_Resource_Dataflow_Import extends Mage_Dataflow_Model_Resource_Batch_Import
{

    /**
     * clean Dataflow Imports
     *
     * @param $olderThan
     * @return int
     */
    public function clean($olderThan = 1)
    {
        $writeConnection = $this->_getWriteAdapter();

        $sql = sprintf('DELETE FROM %s where batch_id IN(select batch_id from %s where created_at < DATE_SUB(Now(), INTERVAL %s DAY))',
            $writeConnection->quoteIdentifier($this->getMainTable(), true),
            $writeConnection->quoteIdentifier($this->getTable('dataflow/batch'), true),
            intval($olderThan)
        );

        $stmt = $writeConnection->query($sql);
        return $stmt->rowCount();
    }
}
