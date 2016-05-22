<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 3:36 PM
 */
class Pivodirtjumper_RuleRelation_Block_Adminhtml_Rulerelation_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('pivodirtjumper_rulerelation_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('pivodirtjumper_rulerelation')->__('Product relation rule'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main_section', array(
            'label'     => Mage::helper('pivodirtjumper_rulerelation')->__('Rule Information'),
            'title'     => Mage::helper('pivodirtjumper_rulerelation')->__('Rule Information'),
            'content'   => $this->getLayout()->createBlock('pivodirtjumper_rulerelation/adminhtml_rulerelation_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $this->addTab('match_section', array(
            'label'     => Mage::helper('pivodirtjumper_rulerelation')->__('Items to match'),
            'title'     => Mage::helper('pivodirtjumper_rulerelation')->__('Items to match'),
            'content'   => $this->getLayout()->createBlock('pivodirtjumper_rulerelation/adminhtml_rulerelation_edit_tab_match')->toHtml(),
        ));

        $this->addTab('display_section', array(
            'label'     => Mage::helper('pivodirtjumper_rulerelation')->__('Items to display'),
            'title'     => Mage::helper('pivodirtjumper_rulerelation')->__('Items to display'),
            'content'   => $this->getLayout()->createBlock('pivodirtjumper_rulerelation/adminhtml_rulerelation_edit_tab_display')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}