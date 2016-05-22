<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pivodirtjumper
 * Date: 9/23/13
 * Time: 9:48 AM
 */
class Pivodirtjumper_RuleRelation_Model_Resource_Rulerelation_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('pivodirtjumper_rulerelation/rulerelation');
    }

    public function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->joinLeft(
            array('display_idx' => 'pivodirtjumper_rulerelation_index'),
            'main_table.rule_id = display_idx.rule_id',
            array('display_products')
        );

        return $this;
    }
}