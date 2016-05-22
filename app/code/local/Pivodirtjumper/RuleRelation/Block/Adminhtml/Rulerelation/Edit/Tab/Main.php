<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pivodirtjumper
 * Date: 7/4/13
 * Time: 7:18 PM
 */
class Pivodirtjumper_RuleRelation_Block_Adminhtml_Rulerelation_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('pivodirtjumper_rulerelation_main', array('legend'=>Mage::helper('pivodirtjumper_rulerelation')->__('Main')));

        $fieldset->addField('label', 'text', array(
            'label'     => Mage::helper('pivodirtjumper_rulerelation')->__('Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'rule[name]',
        ));
        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('pivodirtjumper_rulerelation')->__('Status'),
            'name'      => 'rule[is_active]',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('pivodirtjumper_rulerelation')->__('Active'),
                ),

                array(
                    'value'     => 2,
                    'label'     => Mage::helper('pivodirtjumper_rulerelation')->__('Inactive'),
                ),
            ),
        ));
        $fieldset->addField('from_date','date', array(
                'label'     => 'From date',
                'format'    => 'M/d/yyyy',
                'time'      => false,
                'image'     => $this->getSkinUrl('images/grid-cal.gif'),
                'required'  => true,
                'name'      => 'rule[from_date]'
            )
        );
        $fieldset->addField('to_date','date', array(
                'label'     => 'To date',
                'format'    => 'M/d/yyyy',
                'time'      => false,
                'image'     => $this->getSkinUrl('images/grid-cal.gif'),
                'required'  => true,
                'name'      => 'rule[to_date]'
            )
        );

        $fieldset->addField('relation_type', 'select', array(
            'label'     => Mage::helper('pivodirtjumper_rulerelation')->__('Relation type'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'rule[relation_type]',
            'values'    => array(
                array(
                    'value' => 1,
                    'label' => 'Related product'
                ),
                array(
                    'value' => 2,
                    'label' => 'Cross-sell'
                ),
                array(
                    'value' => 3,
                    'label' => 'Upsell'
                )
            )
        ));

        if ( Mage::getSingleton('adminhtml/session')->getRuleRelationData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getRuleRelationData());
            Mage::getSingleton('adminhtml/session')->setRuleRleationData(null);
        } elseif ( Mage::registry('pivodirtjumper_rulerelation_data') ) {
            $form->setValues(Mage::registry('pivodirtjumper_rulerelation_data')->getData());
            $form->getElement('label')->setValue(Mage::registry('pivodirtjumper_rulerelation_data')->getData('name'));
        }
        return parent::_prepareForm();
    }

}