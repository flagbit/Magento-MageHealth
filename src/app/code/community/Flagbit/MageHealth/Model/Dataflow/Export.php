<?php

class Flagbit_MageHealth_Model_Dataflow_Export extends Mage_Core_Model_Abstract
{

    const XML_PATH_DATAFLOW_CLEAN_OLDER_THAN           = 'magehealth/dataflow/older_than';

    protected function _construct()
    {
        $this->_init('magehealth/dataflow_export');
    }

    /**
     * clean quotes
     *
     * @return Flagbit_MageHealth_Model_Dataflow_Export
     */
    public function clean() {

        $this->getResource()->clean(
            Mage::getStoreConfig(self::XML_PATH_QUOTE_CLEAN_OLDER_THAN),
            Mage::getStoreConfig(self::XML_PATH_QUOTE_CLEAN_LIMIT)
        );
        return $this;
    }

}