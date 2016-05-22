<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: pivodirtjumper
 * @date: 7/1/13
 * @time: 3:35 PM
 */
class Pivodirtjumper_RuleRelation_Block_Adminhtml_Rulerelation_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();

        $this->setId('rulerelationGrid');
        $this->setDefaultSort('rule_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('pivodirtjumper_rulerelation/rulerelation')
            ->getResourceCollection();

        /*    ->addFieldToSelect('rule_id')
            ->addFieldToSelect('name')
            ->addFieldToSelect('is_active')
            ->addFieldToSelect('relation_type');*/


        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('rule_id',
            array(
                'header'=> Mage::helper('pivodirtjumper_rulerelation')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'rule_id',
            ));
        $this->addColumn('name',
            array(
                'header'=> Mage::helper('pivodirtjumper_rulerelation')->__('Name'),
                'index' => 'name',
            ));
        $this->addColumn('relation_type',
            array(
                'header'=> Mage::helper('pivodirtjumper_rulerelation')->__('Relation type'),
                'index' => 'relation_type',
                'type'  => 'options',
                'options'=> array(
                    '1' => 'Related product',
                    '2' => 'Cross-sell',
                    '3' => 'Upsell'
                ),

            ));
        $this->addColumn('from_date',
            array(
                'header' => Mage::helper('pivodirtjumper_rulerelation')->__('From date'),
                'index'  => 'from_date',
                'type'   => 'date'
            ));
        $this->addColumn('to_date',
            array(
                'header' => Mage::helper('pivodirtjumper_rulerelation')->__('To date'),
                'index'  => 'to_date',
                'type'   => 'date'
            ));
        $this->addColumn('is_active',
            array(
            'header'=> Mage::helper('pivodirtjumper_rulerelation')->__('Active'),
            'index' => 'is_active',
            'type'  => 'options',
            'options'=> Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

}
