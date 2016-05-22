<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pivodirtjumper
 * Date: 9/23/13
 * Time: 8:45 AM
 */
class Pivodirtjumper_RuleRelation_Model_Rulerelation_Match_Condition_Combine
    extends Mage_Rule_Model_Condition_Combine
{

    public function __construct()
    {
        parent::__construct();

        $this->setType('pivodirtjumper_rulerelation/rulerelation_match_condition_combine');
    }


    public function getNewChildSelectOptions()
    {
        $productCondition = Mage::getModel('pivodirtjumper_rulerelation/rulerelation_condition_product');
        $productAttributes = $productCondition->loadAttributeOptions()->getAttributeOption();
        $pAttributes = array();
        $iAttributes = array();
        foreach ($productAttributes as $code=>$label) {
            if (strpos($code, 'quote_item_')===0) {
                $iAttributes[] = array('value'=>'pivodirtjumper_rulerelation/rulerelation_condition_product|'.$code, 'label'=>$label);
            } else {
                $pAttributes[] = array('value'=>'pivodirtjumper_rulerelation/rulerelation_condition_product|'.$code, 'label'=>$label);
            }
        }

        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive($conditions, array(
            array('value'=>'pivodirtjumper_rulerelation/rulerelation_match_condition_combine', 'label'=>Mage::helper('catalog')->__('Conditions Combination')),
            array('label'=>Mage::helper('catalog')->__('Product Attribute'), 'value'=>$pAttributes),
        ));
        return $conditions;
    }

    public function collectValidatedAttributes($productCollection)
    {
        foreach ($this->getConditions() as $condition) {
            $condition->collectValidatedAttributes($productCollection);
        }
        return $this;
    }


    /*public function getNewChildSelectOptions()
    {
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive($conditions, array(
            array(
                'value' => 'pivodirtjumper_rulerelation/rulerelation_match_condition_combine',
                'label' => Mage::helper('salesrule')->__('Conditions combination')
            ),

        ));

        $additional = new Varien_Object();

        Mage::dispatchEvent('pivodirtjumper_rulerelation_rule_match_condition_combine', array('additional' => $additional));

        if ($additionalConditions = $additional->getConditions()) {
            $conditions = array_merge_recursive($conditions, $additionalConditions);
        }

        return $conditions;
    }

    protected function _getConditionAttributes($conditionModel)
    {
        $attributes = Mage::getModel($conditionModel)->loadAttributeOptions()
            ->getAttributeOption();
        $attributesFormatted = array();
        foreach ($attributes as $code=>$label) {
            $attributesFormatted[] = array(
                'value' => $conditionModel.'|'.$code,
                'label' => $label
            );
        }
        return $attributesFormatted;
    }*/

}