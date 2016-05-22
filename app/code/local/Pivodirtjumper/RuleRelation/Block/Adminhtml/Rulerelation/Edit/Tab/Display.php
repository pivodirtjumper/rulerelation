<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pivodirtjumper
 * Date: 7/8/13
 * Time: 4:25 PM
 */
class Pivodirtjumper_RuleRelation_Block_Adminhtml_Rulerelation_Edit_Tab_Display
    extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model = Mage::registry('pivodirtjumper_rulerelation_data');

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('rule_');

        $renderer = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')
            ->setTemplate('promo/fieldset.phtml')
            ->setNewChildUrl($this->getUrl('*/adminhtml_relation/newActionHtml/form/rule_actions_fieldset'));

        $fieldset = $form->addFieldset('actions_fieldset', array(
            'legend'=>Mage::helper('salesrule')->__('Apply the rule only if the following conditions are met (leave blank for all products)')
        ))->setRenderer($renderer);

        $fieldset->addField('actions', 'text', array(
            'name' => 'rule[actions]',
            'label' => Mage::helper('pivodirtjumper_rulerelation')->__('Conditions'),
            'title' => Mage::helper('pivodirtjumper_rulerelation')->__('Conditions'),
            'required' => true,
        ))->setRule($model)->setRenderer(Mage::getBlockSingleton('rule/actions'));

        if ($model) {
            $form->setValues($model->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

}