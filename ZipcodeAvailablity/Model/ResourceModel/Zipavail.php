<?php
namespace WebTechnologyCodes\ZipcodeAvailablity\Model\ResourceModel;

class Zipavail extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WebTechnologyCodes_zipcode_availablity', 'id');
    }
}
