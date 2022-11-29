<?php

namespace WebTechnologyCodes\ZipcodeAvailablity\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use WebTechnologyCodes\ZipcodeAvailablity\Model\ZipavailFactory as ZipavailFactory;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\ObjectManagerInterface;


class Data extends AbstractHelper
{

    const XML_PATH_ZIPCODEAVAILABLITY = 'zipcodeAvailablity/';

	public $zipCollectionFactory;
	public $zipcodefactory;
    public function __construct(
        
        \Magento\Framework\App\Helper\Context $context,
        ZipavailFactory $zipcodefactory,
        TemplateContext $templateContext,
		ObjectManagerInterface $objectManager,
        \WebTechnologyCodes\ZipcodeAvailablity\Model\ResourceModel\Zipavail\CollectionFactory $zipCollectionFactory

       
    ){
        $this->zipcodefactory     = $zipcodefactory;
        $this->zipCollectionFactory = $zipCollectionFactory;
        parent::__construct($context, $objectManager, $templateContext->getStoreManager());
    }
   

    public function getRemoteAddress()
    {
        return $this->_remoteAddressInstance->getRemoteAddress();
    }
    



	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}

	public function getGeneralConfig($code, $storeId = null)
	{
    return $this->getConfigValue(self::XML_PATH_ZIPCODEAVAILABLITY .'general/'. $code, $storeId);
	}




   
    public function getZipcode($zipcode = null)
    {
        $zipcodes = $this->zipcodefactory->create();
		$list = $zipcodes->getCollection();
		$list->addFieldToFilter('pincode', $zipcode);
		 return $list;
    }

}
