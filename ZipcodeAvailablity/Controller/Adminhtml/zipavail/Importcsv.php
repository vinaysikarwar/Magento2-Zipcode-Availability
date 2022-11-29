<?php

namespace WebTechnologyCodes\ZipcodeAvailablity\Controller\Adminhtml\zipavail;

class Importcsv extends \Magento\Backend\App\Action
{
	
	
    public function execute()
    {
	$this->_view->loadLayout();
    $this->_view->getLayout()->initMessages();
    $this->_view->renderLayout();	
	}

   
}