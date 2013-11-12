<?php

class Flagbit_MageHealth_Model_Resource_Dataflow_Import extends Mage_Dataflow_Model_Resource_Batch_Import
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('dataflow/batch_import');
    }

    /**
     * clean Dataflow Imports
     *
     * @param $olderThan
     * @param int $limit
     * @return int
     */
    public function clean($olderThan = 1, $limit = 5000)
    {
        $writeConnection = $this->_getWriteAdapter();

        $sql = sprintf('DELETE FROM %s WHERE updated_at < DATE_SUB(Now(), INTERVAL %s DAY) LIMIT %s',
            $writeConnection->quoteIdentifier($this->getMainTable(), true),
            max(intval($olderThan), 7),
            min(intval($limit), 50000)
        );

        $stmt = $writeConnection->query($sql);
        return $stmt->rowCount();
    }
}
