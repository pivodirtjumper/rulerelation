<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 3:28 PM
 */
class Pivodirtjumper_RuleRelation_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $_inStock = null;

    public function getInStockList($stockId = 1)
    {
        Varien_Profiler::start('helper in stock');
        if (is_null($this->_inStock)) {
            $stockCollection = Mage::getModel('cataloginventory/stock_item')->getCollection()
                ->addFieldToFilter('is_in_stock', 1)
                ->addFieldToFilter('stock_id', $stockId);

            $this->_inStock = array_values($stockCollection->getColumnValues('product_id'));

            unset($stockCollection);
        }
        Varien_Profiler::stop('helper in stock');

        return $this->_inStock;
    }
    
}