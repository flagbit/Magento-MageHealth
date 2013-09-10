<?php

class Flagbit_MageHealth_Model_Dataflow_Import extends Mage_Core_Model_Abstract
{
    /**
     * clean dataflow logs
     *
     * @return Flagbit_MageHealth_Model_Dataflow
     */
    public function clean() {

        $this->_init('magehealth/dataflow_export');
        $this->getResource()->clean();
        $this->clearInstance();

        $this->_init('magehealth/dataflow_import');
        $this->getResource()->clean();
        $this->clearInstance();

        return $this;
    }

}