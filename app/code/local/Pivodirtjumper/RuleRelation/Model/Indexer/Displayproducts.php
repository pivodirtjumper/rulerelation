<?php
/**
 * Created by PhpStorm.
 * @author: pivodirtjumper
 * @date: 14.01.15
 * @time: 17:24
 */

class Pivodirtjumper_RuleRelation_Model_Indexer_DisplayProducts
    extends Mage_Core_Model_Abstract
{

    public function updateRuleRelation($ruleRelationId = null)
    {
        $relationModel = Mage::getModel('pivodirtjumper_rulerelation/rulerelation')
            ->load($ruleRelationId);

        $productCollection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes());


        $displayProducts = array();
        foreach ($productCollection as $product) {
            if ($relationModel->getActions()->validate($product)) {
                $displayProducts[] = $product->getId();
            }
        }

        $indexModel = Mage::getModel('pivodirtjumper_rulerelation/index')->loadByRuleId($ruleRelationId);

        if (! $indexModel->getId()) {
            $indexModel->setData('rule_id', $ruleRelationId);
        }

        $indexModel->setData('display_products', serialize($displayProducts));
        $indexModel->save();

        //$this->setDisplayProducts(serialize($displayProducts));
    }

    public function updateAllRuleRelation()
    {
        $ruleCollection = Mage::getModel('pivodirtjumper_rulerelation/rulerelation')
            ->getCollection();

        foreach ($ruleCollection as $rule) {
            $this->updateRuleRelation($rule->getId());
        }
    }

}