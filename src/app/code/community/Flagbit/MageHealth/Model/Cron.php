<?php

class Flagbit_MageHealth_Model_Cron extends Mage_Core_Model_Abstract
{
    const XML_PATH_LOG_ROTATE_ENABLED            = 'magehealth/log/enabled';


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
}
