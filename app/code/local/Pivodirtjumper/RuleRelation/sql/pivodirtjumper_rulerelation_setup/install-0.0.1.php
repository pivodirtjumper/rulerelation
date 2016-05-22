<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 4:57 PM
 */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('pivodirtjumper_rulerelation/rulerelation'))
    ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    'identity'  => true,
    'unsigned'  => true,
    'nullable'  => false,
    'primary'   => true,
), 'Rule Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
), 'Name')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
    'nullable'  => false,
    'default'   => '0',
), 'Is Active')
    ->addColumn('from_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
), 'From Date')
    ->addColumn('to_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
), 'To Date')
    ->addColumn('relation_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
), 'Type of relation (related, cross, upsell)')
    ->addColumn('limit', Varien_Db_Ddl_Table::TYPE_INTEGER, 255, array(
), 'Max products to associate')
    ->addColumn('conditions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
), 'Conditions Serialized')
    ->addColumn('actions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
), 'Actions Serialized')
    ->addColumn('display_products', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
    ), 'Display products serialized')
    ->addIndex($installer->getIdxName('pivodirtjumper_rulerelation/rulerelation', array('is_active', 'to_date', 'from_date')),
    array('is_active', 'to_date', 'from_date'))

    ->setComment('Relation rule');
$installer->getConnection()->createTable($table);

$installer->endSetup();