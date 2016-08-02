<?php

class Flagbit_MageHealth_Model_Cron extends Mage_Core_Model_Abstract
{
    const XML_PATH_LOG_ROTATE_ENABLED           = 'magehealth/log/enabled';
    const XML_PATH_QUOTE_CLEAN_ENABLED          = 'magehealth/quote/enabled';
    const XML_PATH_DATAFLOW_CLEAN_ENABLED       = 'magehealth/dataflow/enabled';


    /**
     * clean logs
     *
     * @param Mage_Cron_Model_Schedule $schedule
     * @return $this
     */
    public function logClean(Mage_Cron_Model_Schedule $schedule)
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_LOG_ROTATE_ENABLED)) {
            $result = 0;
            try {
                $result = Mage::getModel('magehealth/log')->rotate();
            }
            catch (Exception $e) {
                Mage::logException($e);
                throw $e;
            }
            return Mage::helper('magehealth')->__('rotated %s Logfiles', $result);
        }
    }

    /**
     * Clean quotes
     *
     * @param Mage_Cron_Model_Schedule $schedule
     * @return Mage_Log_Model_Cron
     */
    public function quoteClean(Mage_Cron_Model_Schedule $schedule)
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_QUOTE_CLEAN_ENABLED)) {;
            try {
                $result = Mage::getModel('magehealth/quote')->clean();
            }
            catch (Exception $e) {
                Mage::logException($e);
                throw $e;
            }
            return Mage::helper('magehealth')->__('deleted %s Quotes', $result);
        }
    }

    /**
     * Clean dataflow tables
     *
     * @param Mage_Cron_Model_Schedule $schedule
     * @return Mage_Log_Model_Cron
     */
    public function dataflowClean(Mage_Cron_Model_Schedule $schedule)
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_DATAFLOW_CLEAN_ENABLED)) {
            $result = 0;
            try {
                $result += Mage::getModel('magehealth/dataflow_import')->clean();
                $result += Mage::getModel('magehealth/dataflow_export')->clean();
            }
            catch (Exception $e) {
                Mage::logException($e);
                throw $e;
            }
            return Mage::helper('magehealth')->__('deleted %s dataflow rows ', $result);
        }
    }

}
