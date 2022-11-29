<?php

namespace WebTechnologyCodes\ZipcodeAvailablity\Block\Adminhtml\Zipavail\Edit\Tab;

/**
 * Zipavail edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    protected $_countryCollectionFactory;
    /**
     * @var \WebTechnologyCodes\ZipcodeAvailablity\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \WebTechnologyCodes\ZipcodeAvailablity\Model\Status $status,
		\Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
         //\Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
		$this->_countryCollectionFactory = $countryCollectionFactory;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
	 
	 
	  public function getCountryCollection()
        {
            $collection = $this->_countryCollectionFactory->create()->loadByStore();
            return $collection;
        }
 
        /**
         * Retrieve list of top destinations countries
         *
         * @return array
         */
        protected function getTopDestinations()
        {
            $destinations = (string)$this->_scopeConfig->getValue(
                'general/country/destinations',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            return !empty($destinations) ? explode(',', $destinations) : [];
        }
 
        /**
         * Retrieve list of countries in array option
         *
         * @return array
         */
        public function getCountries()
        {
			
            return $options = $this->getCountryCollection()
                    ->setForegroundCountries($this->getTopDestinations())
                        ->toOptionArray();
				
        } 
		
		
		public function getCountryOptionArray(){
			$options = $this->getCountryCollection()
                    ->setForegroundCountries($this->getTopDestinations())
                        ->toOptionArray();
						
			$opcount = count($options);		
			$option_array=array();
			for($i=0;$i<$opcount;$i++){
			 $option_array[$options[$i]['value']]=$options[$i]['label'];
			}
			
			return $option_array;
		}
		
    protected function _prepareForm()
    {
		
		$countryoptions = $this->getCountryOptionArray();			
		
       /* @var $model \WebTechnologyCodes\ZipcodeAvailablity\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('zipavail');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

		
        $fieldset->addField(
            'country',
            'select',
            [
                'label' => __('Country'),
                'title' => __('Country'),
                'name' => 'country',
				
                'options' =>  $countryoptions,
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'state',
            'text',
            [
                'name' => 'state',
                'label' => __('State'),
                'title' => __('State'),
				
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'city',
            'text',
            [
                'name' => 'city',
                'label' => __('City'),
                'title' => __('City'),
				
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'pincode',
            'text',
            [
                'name' => 'pincode',
                'label' => __('Zip code'),
                'title' => __('Zip code'),
				
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'delivery_days',
            'text',
            [
                'name' => 'delivery_days',
                'label' => __(' Delivery Days'),
                'title' => __(' Delivery Days'),
				
                'disabled' => $isElementDisabled
            ]
        );
									
						
        $fieldset->addField(
            'cash_on_delivery',
            'select',
            [
                'label' => __('Cash On Delivery'),
                'title' => __('Cash On Delivery'),
                'name' => 'cash_on_delivery',
				
                'options' => \WebTechnologyCodes\ZipcodeAvailablity\Block\Adminhtml\Zipavail\Grid::getOptionArray5(),
                'disabled' => $isElementDisabled
            ]
        );
						
						
      
					

        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);
		
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Item Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Item Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    
    public function getTargetOptionArray(){
    	return array(
    				'_self' => "Self",
					'_blank' => "New Page",
    				);
    }
}
