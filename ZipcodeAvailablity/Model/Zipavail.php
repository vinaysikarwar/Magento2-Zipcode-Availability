<?php
namespace WebTechnologyCodes\ZipcodeAvailablity\Model;

class Zipavail extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WebTechnologyCodes\ZipcodeAvailablity\Model\ResourceModel\Zipavail');
    }
}
