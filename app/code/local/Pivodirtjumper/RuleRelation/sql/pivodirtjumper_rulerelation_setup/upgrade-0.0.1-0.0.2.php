<?php
/**
 * Created by PhpStorm.
 * @author: pivodirtjumper
 * @date: 14.01.15
 * @time: 16:24
 */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('pivodirtjumper_rulerelation/index'))
    ->addColumn('index_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Index id')
    ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'Matching rule id')
    ->addColumn('display_products', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
    ), 'Serialized list of products, that are matching the rule')
    ->addIndex($installer->getIdxName('pivodirtjumper_rulerelation/index', array('rule_id')),
        array('rule_id'))
    ->setComment('Relation rule');
$installer->getConnection()->createTable($table);


$installer->endSetup();
