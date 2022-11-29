<?php
/**
 * Copyright © WebTechnologyCodes. All rights reserved.
 */
namespace WebTechnologyCodes\ZipcodeAvailablity\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {

    public function __construct(
	\Magento\Catalog\Block\Product\Context $context, 
	\WebTechnologyCodes\ZipcodeAvailablity\Helper\Data $helper,
	array $data = []
	){
    parent::__construct($context, $data);
	$this->helper = $helper;
    }


    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
	
	
	public function modulesysvalue($variable)
	{
	 return $status = $this->helper->getGeneralConfig($variable);	 
	}

}