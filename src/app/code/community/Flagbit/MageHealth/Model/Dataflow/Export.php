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
     * @return Flagbit_MageHealth_Model_Dataflow_Export
     */
    public function clean() {

        $this->getResource()->clean();
        return $this;
    }

}