<?php

namespace WebTechnologyCodes\ZipcodeAvailablity\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
		$ob = \Magento\Framework\App\ObjectManager::getInstance();
		$collection = $ob->create('WebTechnologyCodes\ZipcodeAvailablity\Model\Zipavail')->getCollection();
		echo '<pre>';print_r($collection->getData());die;
		die('test..');
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    } 
}