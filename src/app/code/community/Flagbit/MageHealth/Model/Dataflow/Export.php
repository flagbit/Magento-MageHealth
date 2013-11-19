<?php

class Flagbit_MageHealth_Model_Dataflow_Export extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('magehealth/dataflow_export');
    }

    /**
     * clean quotes
     *
     * @return int
     */
    public function clean() {

        return $this->getResource()->clean();
    }

}