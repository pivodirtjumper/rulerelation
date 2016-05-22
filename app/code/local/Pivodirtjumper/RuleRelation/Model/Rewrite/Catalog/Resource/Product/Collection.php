<?php
/**
 * Created by PhpStorm.
 * User: pivodirtjumper
 * Date: 22.05.2016
 * Time: 7:23
 */
class Pivodirtjumper_RuleRelation_Model_Rewrite_Catalog_Resource_Product_Collection
    extends Mage_Catalog_Model_Resource_Product_Collection
{

    /**
     * Simple dummy for compatibility with Link Product collection
     * @todo find a way to rework this
     * @return $this
     */
    public function setPositionOrder()
    {
        return $this;
    }

}