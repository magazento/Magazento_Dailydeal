<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Block_Admin_Item_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
    	$this->_objectId = 'item_id';
        $this->_controller = 'admin_item';
        $this->_blockGroup = 'dailydeal';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('dailydeal')->__('Save'));
//        $this->_removeButton('reset');
//        $this->_removeButton('delete');
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
//        

        $this->_formScripts[] = "
           function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }
            
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('dailydeal_item')->getId()) {
            return Mage::helper('dailydeal')->__("Edit item: #%s", Mage::registry('dailydeal_item')->getId());
        } else {
            return Mage::helper('dailydeal')->__("New item");
        }
    }

}
