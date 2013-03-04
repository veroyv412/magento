<?php
/**
 * Created by JetBrains PhpStorm.
 * User: veritto
 * Date: 3/1/13
 * Time: 1:53 PM
 * To change this template use File | Settings | File Templates.
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'foo_bar_baz'
 */
$table = $installer->getConnection()
// The following call to getTable('foo_bar/baz') will lookup the resource for foo_bar (foo_bar_mysql4), and look
// for a corresponding entity called baz. The table name in the XML is foo_bar_baz, so ths is what is created.
    ->newTable($installer->getTable('summa_brand/brand'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 15, array(
    'nullable'  => false,
    ), 'Code')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
    'nullable'  => false,
    ), 'Description');

$installer->getConnection()->createTable($table);
$installer->endSetup();