<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 3:49 PM
 */
class Pivodirtjumper_RuleRelation_Model_Resource_Rulerelation
    extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('pivodirtjumper_rulerelation/rulerelation', 'rule_id');
    }

    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        $select->joinLeft(
            array('display_idx' => 'pivodirtjumper_rulerelation_index'),
            $this->getMainTable() . '.rule_id = display_idx.rule_id',
            array('display_products')
        );


        return $select;
    }


}