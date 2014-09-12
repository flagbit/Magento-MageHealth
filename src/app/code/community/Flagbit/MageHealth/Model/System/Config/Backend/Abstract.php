<?php

abstract class Flagbit_MageHealth_Model_System_Config_Backend_Abstract extends Mage_Core_Model_Config_Data
{
    /**
     * get status
     *
     * @return boolean
     */
    abstract protected function _getIsEnabled();

    /**
     * get Time
     *
     * @return array
     */
    abstract protected function _getTime();

    /**
     * get frequency
     *
     * @return string
     */
    abstract protected function _getFrequency();

    /**
     * get config xpath to cron string
     *
     * @return string
     */
    abstract protected function _getCronStringPath();

    /**
     * get config xpath to cron model
     *
     * @return string
     */
    abstract protected function _getCronModelPath();

    /**
     * Cron settings after save
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Dataflow_Cron
     */
    protected function _afterSave()
    {
        $time       = $this->_getTime();
        $frequency   = $this->_getFrequency();

        $frequencyDaily     = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_DAILY;
        $frequencyWeekly    = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_WEEKLY;
        $frequencyMonthly   = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_MONTHLY;

        if ($this->_getIsEnabled()) {
            $cronDayOfWeek = date('N');
            $cronExprArray = array(
                intval($time[1]),                                   # Minute
                intval($time[0]),                                   # Hour
                ($frequency == $frequencyMonthly) ? '1' : '*',       # Day of the Month
                '*',                                                # Month of the Year
                ($frequency == $frequencyWeekly) ? '1' : '*',        # Day of the Week
            );
            $cronExprString = join(' ', $cronExprArray);
        }
        else {
            $cronExprString = '';
        }

        try {
            Mage::getModel('core/config_data')
                ->load($this->_getCronStringPath(), 'path')
                ->setValue($cronExprString)
                ->setPath($this->_getCronStringPath())
                ->save();

            Mage::getModel('core/config_data')
                ->load($this->_getCronModelPath(), 'path')
                ->setValue((string) Mage::getConfig()->getNode($this->_getCronModelPath()))
                ->setPath($this->_getCronModelPath())
                ->save();
        }
        catch (Exception $e) {
            Mage::throwException(Mage::helper('adminhtml')->__('Unable to save the cron expression.'));
        }
    }

}