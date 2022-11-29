<?php

namespace WebTechnologyCodes\ZipcodeAvailablity\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
           
        // Get WebTechnologyCodes_zipcode_availablity table
            $tableName = $installer->getTable('WebTechnologyCodes_zipcode_availablity');
            // Check if the table already exists
            if ($installer->getConnection()->isTableExists($tableName) != true) {
                // Create WebTechnologyCodes_zipcode_availablity table
                $table = $installer->getConnection()
                    ->newTable($tableName)
                    ->addColumn(
                        'id',
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'country',
                        Table::TYPE_TEXT,
                        null,
                        ['nullable' => false, 'default' => ''],
                        'Country'
                    )
                    ->addColumn(
                        'state',
                        Table::TYPE_TEXT,
                        null,
                        ['nullable' => false, 'default' => ''],
                        'State'
                    )
                    ->addColumn(
                        'city',
                        Table::TYPE_TEXT,
                        null,
                        ['nullable' => false, 'default' => ''],
                        'City'
                    )
                    ->addColumn(
                        'pincode',
                        Table::TYPE_TEXT,
                        null,
                        ['nullable' => false,'default' =>''],
                        'Pincode'
                    )
					->addColumn(
                        'delivery_days',
                        Table::TYPE_TEXT,
                        null,
                        ['nullable' => false,'default' =>''],
                        'DeliveryDays'
                    )
					
                    ->addColumn(
                        'cash_on_delivery',
                        Table::TYPE_SMALLINT,
                        null,
                        ['nullable' => false, 'default' => '0'],
                        'CashOnDelivery'
                    )
                    ->setComment('News Table')
                    ->setOption('type', 'InnoDB')
                    ->setOption('charset', 'utf8');
                $installer->getConnection()->createTable($table);
            }
     
            $installer->endSetup();
       

    }
}