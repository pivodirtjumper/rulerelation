<?php
/**
 * Created by PhpStorm.
 * @author: pivodirtjumper
 * @date: 14.01.15
 * @time: 17:11
 */

class Pivodirtjumper_RuleRelation_Model_Index
    extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        parent::_construct();
        $this->_init('pivodirtjumper_rulerelation/index', 'index_id');
        $this->setIdFieldName('index_id');
    }

    public function loadByRuleId($ruleId)
    {
        $this->setData($this->getResource()->loadByAttributes(array('rule_id' => $ruleId)));

        return $this;
    }

}