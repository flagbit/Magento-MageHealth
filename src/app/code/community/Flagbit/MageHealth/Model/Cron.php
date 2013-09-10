<?php

class Flagbit_MageHealth_Model_Cron extends Mage_Core_Model_Abstract
{
    const XML_PATH_LOG_ROTATE_ENABLED           = 'magehealth/log/enabled';
    const XML_PATH_QUOTE_CLEAN_ENABLED          = 'magehealth/quote/enabled';


    /**
     * Clean logs
     *
     * @return Mage_Log_Model_Cron
     */
    public function logClean()
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_LOG_ROTATE_ENABLED)) {
            try {
                Mage::getModel('magehealth/log')->rotate();
            }
            catch (Exception $e) {
                Mage::logException($e);
            }
        }
        return $this;
    }

    /**
     * Clean logs
     *
     * @return Mage_Log_Model_Cron
     */
    public function quoteClean()
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_QUOTE_CLEAN_ENABLED)) {
            try {
                Mage::getModel('magehealth/quote')->clean();
            }
            catch (Exception $e) {
                Mage::logException($e);
            }
        }
        return $this;
    }

    /**
     * Clean logs
     *
     * @return Mage_Log_Model_Cron
     */
    public function dataflowClean()
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_QUOTE_CLEAN_ENABLED)) {
            try {
                Mage::getModel('magehealth/dataflow')->clean();
            }
            catch (Exception $e) {
                Mage::logException($e);
            }
        }
        return $this;
    }

}
