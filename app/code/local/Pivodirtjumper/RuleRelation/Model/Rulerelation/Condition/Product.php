<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pivodirtjumper
 * Date: 9/24/13
 * Time: 10:37 AM
 */
class Pivodirtjumper_RuleRelation_Model_Rulerelation_Condition_Product
    extends Mage_Rule_Model_Condition_Product_Abstract
{
    /**
     * Add special attributes
     *
     * @param array $attributes
     */
    protected function _addSpecialAttributes(array &$attributes)
    {
        parent::_addSpecialAttributes($attributes);
        $attributes['quote_item_qty'] = Mage::helper('salesrule')->__('Quantity in cart');
        $attributes['quote_item_price'] = Mage::helper('salesrule')->__('Price in cart');
        $attributes['quote_item_row_total'] = Mage::helper('salesrule')->__('Row total in cart');
    }

    /**
     * Validate Product Rule Condition
     *
     * @param Varien_Object $object
     *
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        //echo get_class($object); die;

        if (! $object instanceof Mage_Catalog_Model_Product) {
            if ($object->getProduct() instanceof Mage_Catalog_Model_Product) {
                $product = $object->getProduct();
            } else {
                $product = Mage::getModel('catalog/product')
                    ->load($object->getProductId());
            }
        }
        else $product = $object;

        return parent::validate($product);
    }
}