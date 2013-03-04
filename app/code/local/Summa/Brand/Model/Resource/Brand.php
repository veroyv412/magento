<?php
/**
 * Created by JetBrains PhpStorm.
 * User: veritto
 * Date: 3/4/13
 * Time: 2:55 PM
 * To change this template use File | Settings | File Templates.
 */

class Summa_Brand_Model_Mysql4_Brand extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('summa_brand/brand', 'id');
    }
}