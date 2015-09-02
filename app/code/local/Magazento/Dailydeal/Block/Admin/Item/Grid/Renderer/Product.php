<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Block_Admin_Item_Grid_Renderer_Product extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row) {
        $_product = Mage::getModel('catalog/product')->load($row->getData('catalog_product_id'));
        $html = '<div style="margin-bottom:5px;border-bottom:1px solid #DADFE0;width: 200px;">'. $row->getData('catalog_product_id') . ' </div>';
        $html.= '<img style="margin-right:5px;float:left; display: block; border:1px solid #ddd " src="'.$this->helper('catalog/image')->init($_product, 'small_image')->resize(50, 50).'">';
        $html.= '<p style="float:left; display:block;">'.$_product->setStoreId($row->getData('store_id'))->getName().'</p>';
        $html.= '<p>'.$row->getData('percent').'% '.Mage::helper('dailydeal')->__('off').'</p>';
        $html.= '<p>'.$_product->getTypeId().'</p>';
        return $html;
    }    
}
