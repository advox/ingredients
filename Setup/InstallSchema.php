<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    
    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $setup->startSetup();
    
        $connection = $setup->getConnection();
        $tableName = $setup->getTable('ingredient_label');
    
        if (false === $connection->isTableExists($tableName)) {
            $table = $connection
                ->newTable($tableName)
                ->addColumn(
                    'label_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ]
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ]
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'default' => Table::TIMESTAMP_INIT,
                        'nullable' => false,
                    ]
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'default' => Table::TIMESTAMP_UPDATE,
                    ]
                )
                ->addIndex(
                    $setup->getIdxName($tableName, 'product_id', AdapterInterface::INDEX_TYPE_UNIQUE),
                    'product_id',
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addForeignKey(
                    $setup->getIdxName($tableName, 'product_id'),
                    'product_id',
                    $setup->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                );
        
            $connection->createTable($table);
        }
    
        $setup->endSetup();
    }
    
}
