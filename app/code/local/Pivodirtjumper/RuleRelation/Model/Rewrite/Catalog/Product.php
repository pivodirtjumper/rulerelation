<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pivodirtjumper
 * Date: 9/24/13
 * Time: 6:05 PM
 */
class Pivodirtjumper_RuleRelation_Model_Rewrite_Catalog_Product
    extends Mage_Catalog_Model_Product
{

    protected function _getRulesCollection($relationType)
    {
        $ruleCollection = Mage::getModel('pivodirtjumper_rulerelation/rulerelation')->getCollection()
            ->addFieldToFilter('is_active', Pivodirtjumper_RuleRelation_Model_Rulerelation::IS_ACTIVE)
            ->addFieldToFilter('from_date', array('lteq' => date('Y-m-d')))
            ->addFieldToFilter('to_date', array('gteq' => date('Y-m-d')))
            ->addFieldToFilter('relation_type', $relationType);

        return $ruleCollection;
    }

    /**
     * @param $ruleType
     * @return array
     */
    protected function _getRuleTypeProductIds($ruleType)
    {
        $productIds = array();

        $ruleCollection = $this->_getRulesCollection($ruleType);

        foreach ($ruleCollection as $rule) {
            if ($rule->getConditions()->validate($this)) {

                //print_r(array_values(unserialize($rule->getDisplayProducts())));
                /**
                 * Stacking all matching results in one array.
                 */
                $productIds = array_merge(
                    array_values(unserialize($rule->getDisplayProducts())),
                    $productIds
                );

            }
        }

        return $productIds;
    }

    /**
     * @param $ruleType
     * @param Mage_Catalog_Model_Resource_Product_Collection $parentCollection
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    protected function _getRuleTypeProductCollection($ruleType, Mage_Catalog_Model_Resource_Product_Collection $parentCollection)
    {
        if ($parentCollection->count()) {
            return $parentCollection;
        }

        if ($productIds = $this->_getRuleTypeProductIds($ruleType)) {
            return Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter('entity_id', array('in' => $productIds));
        }

        return $parentCollection;
    }

    /**
     * @return bool
     */
    public function hasCrossSellRules()
    {
        /**
         * Getting list of rules
         */
        $ruleCollection = $this->_getRulesCollection(Pivodirtjumper_RuleRelation_Model_Rulerelation::RELATION_TYPE_CROSSELL);

        /**
         * That may be quite slow, so probably we can not validate rules.
         */
        foreach ($ruleCollection as $rule) {
            if ($rule->getConditions()->validate($this)) {
                return true;
            }
        }

        return false;
    }


    //  REPLACER METHODS

    public function getRelatedProductCollection()
    {
        return $this->_getRuleTypeProductCollection(Pivodirtjumper_RuleRelation_Model_Rulerelation::RELATION_TYPE_RELATED, parent::getRelatedProductCollection());
    }

    public function getUpSellProductCollection()
    {
        return $this->_getRuleTypeProductCollection(Pivodirtjumper_RuleRelation_Model_Rulerelation::RELATION_TYPE_UPSELL, parent::getUpSellProductCollection());
    }

    public function getCrossSellProductCollection()
    {
        return $this->_getRuleTypeProductCollection(Pivodirtjumper_RuleRelation_Model_Rulerelation::RELATION_TYPE_CROSSELL, parent::getCrossSellProductCollection());
    }
}
