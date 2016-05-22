<?php
/**
 * Created by PhpStorm.
 * @author: pivodirtjumper
 * @date: 14.01.15
 * @time: 17:17
 */

class Pivodirtjumper_RuleRelation_Model_Resource_Index
    extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('pivodirtjumper_rulerelation/index', 'index_id');
    }

    public function loadByAttributes($attributes)
    {
        $adapter = $this->_getReadAdapter();
        $where   = array();
        foreach ($attributes as $attributeCode=> $value) {
            $where[] = sprintf('%s=:%s', $attributeCode, $attributeCode);
        }
        $select = $adapter->select()
            ->from($this->getMainTable())
            ->where(implode(' AND ', $where));

        $binds = $attributes;

        return $adapter->fetchRow($select, $binds);
    }

}