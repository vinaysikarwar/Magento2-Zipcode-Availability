<?php
namespace WebTechnologyCodes\ZipcodeAvailablity\Controller\Adminhtml\zipavail;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;


class Getcsv extends \Magento\Backend\App\Action
{

    public function __construct(Action\Context $context,\Magento\Framework\App\Request\Http $request)
    {
		
        parent::__construct($context);
		$this->request = $request;
    }
	
	
    public function execute()
    {
		
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($data){
			$files = $this->getRequest()->getFiles();
		    $filename=$files["zipcsv"]["tmp_name"];		
 
 
		 if($files["zipcsv"]["size"] > 0)
		 {
			$model = $this->_objectManager->create('WebTechnologyCodes\ZipcodeAvailablity\Model\Zipavail');
		  	$file = fopen($filename, "r");
			fgetcsv($file);
			while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	        {
				//echo '<pre>';print_r($getData);die;
				 $csvdata = array();
				 $csvdata['form_key'] = $data['form_key'];
				 $csvdata['country'] = "INDIA";
				 $csvdata['state'] = $getData[3];
				 $csvdata['city'] = $getData[1];
				 $csvdata['pincode'] = $getData[2];
				 $csvdata['delivery_days'] = "Same Day Delivery Available";
				 $csvdata['cash_on_delivery'] = "";
				 
				 
				 $id = $getData[0];
                 if ($id) {
                $model->load($id);
                $model->setCreatedAt(date('Y-m-d H:i:s'));
                } 
				 
				$model->setData($csvdata);
				$model->save();
			}
			
			try {
               
                $this->messageManager->addSuccess(__('The Zipavail has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Zipavail.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
			fclose($file);	
		 }
	   	 
        }
        return $resultRedirect->setPath('*/*/');
    }
}

