<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 3:48 PM
 */
class Pivodirtjumper_RuleRelation_Model_Rulerelation extends Mage_Rule_Model_Abstract
{
    const ENTITY = 'pivodirtjumper_rulerelation';
    const IS_INACTIVE = 0;
    const IS_ACTIVE = 1;

    const RELATION_TYPE_RELATED = 1;
    const RELATION_TYPE_CROSSELL = 2;
    const RELATION_TYPE_UPSELL = 3;

    protected function _construct()
    {
        parent::_construct();
        $this->_init('pivodirtjumper_rulerelation/rulerelation', 'rule_id');
        $this->setIdFieldName('rule_id');
    }

    public function getConditionsInstance()
    {
        return Mage::getModel('pivodirtjumper_rulerelation/rulerelation_match_condition_combine');
    }

    public function getActionsInstance()
    {
        return Mage::getModel('pivodirtjumper_rulerelation/rulerelation_display_condition_combine');
    }

    /**
     * Deprecated after 0.0.2 / Indexer added
     * @return Mage_Core_Model_Abstract|void
     */
    /*protected function _beforeSave()
    {
        $productCollection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('code_cip')
            ->addAttributeToSelect('code_ean');

        $displayProducts = array();
        foreach ($productCollection as $product) {
            if ($this->getActions()->validate($product)) {
                $displayProducts[] = $product->getId();
            }
        }

        $this->setDisplayProducts(serialize($displayProducts));

        parent::_beforeSave();
    }*/

    protected function _afterSave()
    {
        Mage::getSingleton('index/indexer')->processEntityAction(
            $this, self::ENTITY, Mage_Index_Model_Event::TYPE_SAVE
        );
    }

    protected function _afterSaveCommit()
    {
        Mage::getSingleton('index/indexer')->indexEvents(
            self::ENTITY, Mage_Index_Model_Event::TYPE_SAVE
        );
    }

}