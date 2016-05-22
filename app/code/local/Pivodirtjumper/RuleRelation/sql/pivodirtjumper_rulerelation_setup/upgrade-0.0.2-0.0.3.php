<?php
/**
 * Created by PhpStorm.
 * @author: pivodirtjumper
 * @date: 14.01.15
 * @time: 18:43
 */

$installer = $this;
$installer->startSetup();

$installer->getConnection()->dropColumn($installer->getTable('pivodirtjumper_rulerelation/rulerelation'), 'display_products');

$installer->endSetup();