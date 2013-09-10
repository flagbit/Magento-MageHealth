<?php

class Flagbit_MageHealth_Model_Resource_Dataflow_Export extends Mage_Dataflow_Model_Resource_Batch_Export
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('dataflow/batch_export');
    }

    /**
     * clean Dataflow Export Tables
     *
     * @return int
     */
    public function clean()
    {
        $writeConnection = $this->_getWriteAdapter();

        $sql = 'TRUNCATE TABLE '.$this->getMainTable();
        $stmt = $writeConnection->query($sql);

        return $stmt->rowCount();
    }
}
