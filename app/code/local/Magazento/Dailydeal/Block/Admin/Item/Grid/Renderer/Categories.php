<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Block_Admin_Item_Grid_Renderer_Categories extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{


  public function render(Varien_Object $row)
    {
        $html = '';
        if ($row->getData('assign_categories')) {
            $html.=Mage::helper('dailydeal')->__('All categories');
        } else {   
            if ($row->getData('category_id')) {
                foreach ($row->getData('category_id') as $id) {
                    $_category = Mage::getModel('catalog/category')->load($id);
                    $html.= $_category->getName()."<br/>";
                } 
            }
        }
        return $html;
    } 
    
}