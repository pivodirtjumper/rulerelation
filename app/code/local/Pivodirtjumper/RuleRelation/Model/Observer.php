<?php

class Pivodirtjumper_RuleRelation_Model_Observer
	extends Mage_Core_Model_Abstract
{

	public function updateRules()
	{
		$ruleCollection = Mage::getModel('pivodirtjumper_rulerelation/rulerelation')
			->getCollection();

		foreach ($ruleCollection as $rule) {
			$rule->save();
		}

		return ;
	} 

}

