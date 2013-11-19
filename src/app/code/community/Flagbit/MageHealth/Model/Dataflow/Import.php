<?php

class Flagbit_MageHealth_Model_Dataflow_Import extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('magehealth/dataflow_import');
    }

    /**
     * clean quotes
     *
     * @return Flagbit_MageHealth_Model_Dataflow_Import
     */
    public function clean() {

        $this->getResource()->clean();
        return $this;
    }

}