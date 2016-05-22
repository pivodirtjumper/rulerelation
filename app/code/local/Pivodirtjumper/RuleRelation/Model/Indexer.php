<?php
/**
 * Created by PhpStorm.
 * @author: pivodirtjumper
 * @date: 14.01.15
 * @time: 15:02
 */
class Pivodirtjumper_RuleRelation_Model_Indexer extends Mage_Index_Model_Indexer_Abstract
{

    const EVENT_MATCH_RESULT_KEY = 'pivodirtjumper_rulerelation_match_result';

    protected $_matchedEntities = array(
        Pivodirtjumper_RuleRelation_Model_Rulerelation::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE
        )
    );

    public function getName()
    {
        return 'Rule Relation index';
    }

    public function getDescription()
    {
        return 'Indexes all the matching products per each rule';
    }

    protected function _registerEvent(Mage_Index_Model_Event $event)
    {
        // Seems to be a Pivodirtjumper_RuleRelation_Model_RuleRelation
        $dataObj = $event->getDataObject();

        if ($event->getType() == Mage_Index_Model_Event::TYPE_SAVE) {
            $event->addNewData('pivodirtjumper_rulerelation_update_relation_id', $dataObj->getId());
        }
    }

    protected function _processEvent(Mage_Index_Model_Event $event)
    {
        $data = $event->getNewData();
        if(!empty($data['pivodirtjumper_rulerelation_update_relation_id'])){
            $processor = Mage::getModel('pivodirtjumper_rulerelation/indexer_displayproducts');
            $processor->updateRuleRelation(($data['pivodirtjumper_rulerelation_update_relation_id']));
        }
    }

    public function matchEvent(Mage_Index_Model_Event $event)
    {
        $data = $event->getNewData();
        if (isset($data[self::EVENT_MATCH_RESULT_KEY])) {
            return $data[self::EVENT_MATCH_RESULT_KEY];
        }
        $entity = $event->getEntity();
        $result = true;
        if($entity != Pivodirtjumper_RuleRelation_Model_Rulerelation::ENTITY){
            return;
        }
        $event->addNewData(self::EVENT_MATCH_RESULT_KEY, $result);
        return $result;
    }

    public function reindexAll()
    {
        $processor = Mage::getModel('pivodirtjumper_rulerelation/indexer_displayproducts');
        $processor->updateAllRuleRelation();
    }

}