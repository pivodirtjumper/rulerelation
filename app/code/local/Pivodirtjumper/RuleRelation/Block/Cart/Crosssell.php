<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pivodirtjumper
 * Date: 10/1/13
 * Time: 1:56 AM
 */
class Pivodirtjumper_RuleRelation_Block_Cart_Crosssell
    extends Mage_Checkout_Block_Cart_Crosssell
{

    protected $_crossCollection = null;

    public function getItems()
    {
        if (is_null($this->_crossCollection)) {
            Varien_Profiler::start('Get crosssell items from block');

            $productIds = Mage::getModel('checkout/cart')->getProductIds();

            $crossSellIds = array();

            $productCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', array('in' => $productIds));

            foreach ($productCollection as $product) {
                if ($product->hasCrossSellRules()) {
                    $crossSellIds = array_merge($crossSellIds, $product->getCrossSellProductIds());
                }
            }

            if (count($crossSellIds) < 1) {
                return parent::getItems();
            }

            $crossCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addAttributeToFilter('entity_id', array('in' => $crossSellIds));

            Varien_Profiler::stop('Get crosssell items from block');

            $this->_crossCollection = $crossCollection;
        }

        return $this->_crossCollection;
     }

    public function getItemCount()
    {
        $items = $this->getItems();
        if (is_array($items))
        {
            return count($items);
        }
        return $items->count();
    }

}
