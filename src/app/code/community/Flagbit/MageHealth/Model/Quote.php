<?php

class Flagbit_MageHealth_Model_Quote extends Mage_Core_Model_Abstract
{

    const XML_PATH_QUOTE_CLEAN_OLDER_THAN           = 'magehealth/quote/older_than';
    const XML_PATH_QUOTE_CLEAN_LIMIT                = 'magehealth/quote/limit';

    protected function _construct()
    {
        $this->_init('magehealth/quote');
    }

    /**
     * clean quotes
     *
     * @return Flagbit_MageHealth_Model_Quote
     */
    public function clean() {

       $this->getResource()->clean(
           Mage::getStoreConfig(self::XML_PATH_QUOTE_CLEAN_OLDER_THAN),
           Mage::getStoreConfig(self::XML_PATH_QUOTE_CLEAN_LIMIT)
       );
       return $this;
   }

}