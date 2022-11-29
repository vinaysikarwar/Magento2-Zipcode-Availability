<?php

namespace WebTechnologyCodes\ZipcodeAvailablity\Controller\Index;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\Result\ForwardFactory;


class Zipcheck extends \Magento\Framework\App\Action\Action
{
	
const COOKIE_NAME = 'apnakirana_zipcode';
const COOKIE_DURATION = 86400; // lifetime in seconds
/**
* @var \Magento\Framework\Stdlib\CookieManagerInterface
*/
protected $_cookieManager;
   
   public $helper;
  
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    public $actionFactory;
    public $trafficFactory;

    protected $_request;

   

 
    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \WebTechnologyCodes\ZipcodeAvailablity\Helper\Data $helper
     */
    public function __construct(
    	Context $context,
        \Magento\Framework\App\ActionFactory $actionFactory,
		\WebTechnologyCodes\ZipcodeAvailablity\Helper\Data $helper,
		ForwardFactory $resultForwardFactory,
		\Magento\Framework\Registry $coreRegistry,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
     	\Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
		\Magento\Framework\Controller\Result\JsonFactory    $resultJsonFactory
    ) {
    
		parent::__construct($context);
        $this->actionFactory = $actionFactory;
		$this->_coreRegistry = $coreRegistry;
        $this->helper = $helper;
		$this->_resultPageFactory = $pageFactory;
		$this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
		$this->resultForwardFactory = $resultForwardFactory;
		$this->resultJsonFactory = $resultJsonFactory;
    }
  



   public function execute()
   {  


   	 $metadata = $this->_cookieMetadataFactory
         ->createPublicCookieMetadata()
         ->setDuration(self::COOKIE_DURATION);
     
       $zipcode = $this->getRequest()->getPostValue('zipcode');
      
    	 $list = $this->helper->getZipcode($zipcode);
    	 $dlist =  $list->getData();
       
            $html = "";
            if(count($dlist) > 0){
				foreach($dlist as $pc){
					$city = $pc['city'];
					$state = $pc['state'];
				}
               // Set cookie
               $this->_cookieManager->setPublicCookie('zipcode',$zipcode ,$metadata);
			   $delivery_days = $dlist[0]['delivery_days'];
			   
			   $successmsg = $this->helper->getGeneralConfig('success_message');
			    if($successmsg){
				  $html .= '<h4>Delivery Available in '.$city.', '.$state.'</h4>';
			    }else{
				 $html .= '<h4>Delivery Available In Your Area</h4>';	
				}
               /* if($delivery_days){
				 $html .= '<p style="color:green;">'.$delivery_days.'<p>';  
			   } */
			   // Get cookie
               $value = $this->_cookieManager->getCookie('zipcode');
			  // $html .= '<p style="color:green;">'.$value.'<p>';


			}else{
             $this->_cookieManager->deleteCookie('zipcode');
			 $failuremsg = $this->helper->getGeneralConfig('failure_message');
			    if($failuremsg){
				   $html = "<p style='color:red;'>".$failuremsg."</p>";
			    }else{
				   $html = "<p style='color:red;'>Delivery is not Available In Your Area</p>";
				}
			}
			
			/** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultJsonFactory->create();
		$result->setData(['data' => $html]);
        return $result;
    }
}