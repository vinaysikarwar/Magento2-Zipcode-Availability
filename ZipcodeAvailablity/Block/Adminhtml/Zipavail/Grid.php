<?php
namespace WebTechnologyCodes\ZipcodeAvailablity\Block\Adminhtml\Zipavail;
ini_set('display_errors',1);
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \WebTechnologyCodes\ZipcodeAvailablity\Model\zipavailFactory
     */
    protected $_zipavailFactory;
    protected $_countryCollectionFactory;
    /**
     * @var \WebTechnologyCodes\ZipcodeAvailablity\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \WebTechnologyCodes\ZipcodeAvailablity\Model\zipavailFactory $zipavailFactory
     * @param \WebTechnologyCodes\ZipcodeAvailablity\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \WebTechnologyCodes\ZipcodeAvailablity\Model\ZipavailFactory $ZipavailFactory,
        \WebTechnologyCodes\ZipcodeAvailablity\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
		\Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
        array $data = []
    ) {
        $this->_zipavailFactory = $ZipavailFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
		$this->_countryCollectionFactory = $countryCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_zipavailFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }
   
   
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
						//return $options;
			$opcount = count($options);		
			$option_array=array();
			for($i=0;$i<$opcount;$i++){
			 $option_array[$options[$i]['value']]=$options[$i]['label'];
			}
			//echo '<pre>';print_r($option_array);die;
			return $option_array;
		}
   
   
   
    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
		
		$countryoptions = $this->getCountryOptionArray();
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        
		
			
				
				
				  $this->addColumn(
							'country',
							[
								'header' => __('Country'),
								'index' => 'country',
								'type' => 'options',
								//'options' => \WebTechnologyCodes\ZipcodeAvailablity\Block\Adminhtml\Zipavail\Grid::getOptionArray5()
								'options' => $countryoptions ,
							]
						);  
						
				$this->addColumn(
					'state',
					[
						'header' => __('State'),
						'index' => 'state',
					]
				);
				
				$this->addColumn(
					'city',
					[
						'header' => __('City'),
						'index' => 'city',
					]
				);
				
				$this->addColumn(
					'pincode',
					[
						'header' => __('Zip code'),
						'index' => 'pincode',
					]
				);
				
				$this->addColumn(
					'delivery_days',
					[
						'header' => __(' Delivery Days'),
						'index' => 'delivery_days',
					]
				);
				
						
						 $this->addColumn(
							'cash_on_delivery',
							[
								'header' => __('Cash On Delivery'),
								'index' => 'cash_on_delivery',
								'type' => 'options',
								'options' => \WebTechnologyCodes\ZipcodeAvailablity\Block\Adminhtml\Zipavail\Grid::getOptionArray5()
							]
						); 
						
						


		
        //$this->addColumn(
            //'edit',
            //[
                //'header' => __('Edit'),
                //'type' => 'action',
                //'getter' => 'getId',
                //'actions' => [
                    //[
                        //'caption' => __('Edit'),
                        //'url' => [
                            //'base' => '*/*/edit'
                        //],
                        //'field' => 'id'
                    //]
                //],
                //'filter' => false,
                //'sortable' => false,
                //'index' => 'stores',
                //'header_css_class' => 'col-action',
                //'column_css_class' => 'col-action'
            //]
        //);
		

		
		   $this->addExportType($this->getUrl('zipcodeavailablity/*/exportCsv', ['_current' => true]),__('CSV'));
		   $this->addExportType($this->getUrl('zipcodeavailablity/*/exportExcel', ['_current' => true]),__('Excel XML'));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

	
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('id');
        //$this->getMassactionBlock()->setTemplate('WebTechnologyCodes_ZipcodeAvailablity::zipavail/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('zipavail');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('zipcodeavailablity/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('zipcodeavailablity/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );


        return $this;
    }
		

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('zipcodeavailablity/*/index', ['_current' => true]);
    }

    /**
     * @param \WebTechnologyCodes\ZipcodeAvailablity\Model\zipavail|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		
        return $this->getUrl(
            'zipcodeavailablity/*/edit',
            ['id' => $row->getId()]
        );
		
    }

	
		static public function getOptionArray5()
		{
            $data_array=array(); 
			$data_array[0]='Available';
			$data_array[1]='Not Available';
            return($data_array);
		}
		static public function getValueArray5()
		{
            $data_array=array();
			foreach(\WebTechnologyCodes\ZipcodeAvailablity\Block\Adminhtml\Zipavail\Grid::getOptionArray5() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
 public function getMainButtonsHtml()
    {
        $html = parent::getMainButtonsHtml();//get the parent class buttons
        $addButton = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')
            ->setData(array(
            'label'     => 'Bulk Import',
            'onclick'   => 'setLocation(\'' . $this->getUrl(
                        'zipcodeavailablity/*/importcsv',
                        ['store' => $this->getRequest()->getParam('store', 0)]
                    ) . '\')',
            'class'   => 'action-default primary add'
        ))->toHtml();
        return $addButton.$html;
    }
}