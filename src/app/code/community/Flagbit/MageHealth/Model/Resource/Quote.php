<?php

class Flagbit_MageHealth_Model_Resource_Quote extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     *
     */
    public function _construct()
    {
        $this->_init('sales/quote', 'entity_id');
    }

    /**
     * clean Quotes
     *
     * @param $olderThan
     * @return int
     */
     public function clean($olderThan)
     {
        $writeConnection = $this->_getWriteAdapter();

        $sql = sprintf('DELETE FROM %s WHERE updated_at < DATE_SUB(Now(), INTERVAL %s DAY)',
           $writeConnection->quoteIdentifier($this->getMainTable(), true),
            max(intval($olderThan), 7)
        );

        $stmt = $writeConnection->query($sql);
        return $stmt->rowCount();
    }
}