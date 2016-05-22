<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 3:35 PM
 */
class Pivodirtjumper_RuleRelation_Block_Adminhtml_Rulerelation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'pivodirtjumper_rulerelation';
        $this->_controller = 'adminhtml_rulerelation';

        $this->_updateButton('save', 'label', Mage::helper('pivodirtjumper_rulerelation')->__('Save Rule'));
        $this->_updateButton('delete', 'label', Mage::helper('pivodirtjumper_rulerelation')->__('Delete Rule'));
    }

    /**
     *
     * @return string
     */
    public function getHeaderText()
    {
        if( Mage::registry('pivodirtjumper_rulerelation_data') && Mage::registry('pivodirtjumper_rulerelation_data')->getId() ) {
            return Mage::helper('pivodirtjumper_rulerelation')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('pivodirtjumper_rulerelation_data')->getName()));
        } else {
            return Mage::helper('pivodirtjumper_rulerelation')->__('Add Item');
        }
    }
}