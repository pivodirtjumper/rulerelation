<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 3:30 PM
 */
class Pivodirtjumper_RuleRelation_Block_Adminhtml_Rulerelation extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_rulerelation';
        $this->_blockGroup = 'pivodirtjumper_rulerelation';
        $this->_headerText = Mage::helper('pivodirtjumper_rulerelation')->__('Manage rules');
        $this->_addButtonLabel = Mage::helper('pivodirtjumper_rulerelation')->__('New rule');

        parent::__construct();
    }

}