<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Block_Admin_Item_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('dailydeal_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('dailydeal')->__('Daily Deal'));
    }
    
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
         

    protected function _beforeToHtml() {
        $this->addTab('form_section_item', array(
            'label' => Mage::helper('dailydeal')->__('General information'),
            'title' => Mage::helper('dailydeal')->__('General information'),
            'content' => $this->getLayout()->createBlock('dailydeal/admin_item_edit_tab_tabhoriz')->toHtml(),
        ));
        
        $this->addTab('related', array(
            'label' => Mage::helper('catalog')->__('Display on products'),
            'url' => $this->getUrl('*/*/related', array('_current' => true)),
            'class' => 'ajax',
        ));        
        
        $this->addTab('form_section_categories', array(
            'label'     => Mage::helper('dailydeal')->__('Display on categories'),
            'title'     => Mage::helper('dailydeal')->__('Display on categories'),
            'content'   => $this->getLayout()->createBlock('dailydeal/admin_item_edit_tab_categories')->toHtml(),
        ));               
        
        $this->addTab('form_section_page', array(
            'label'     => Mage::helper('dailydeal')->__('Display on pages'),
            'title'     => Mage::helper('dailydeal')->__('Display on pages'),
            'content'   => $this->getLayout()->createBlock('dailydeal/admin_item_edit_tab_page')->toHtml(),
        ));   
        
        return parent::_beforeToHtml();
    }
    
    
    protected function _toHtml()
    {
        $sContent = parent::_toHtml();
        
        $sContent .= '
        <style>
        #general_tab_form_content .input-text {
            width: 272px !important;
        }
        #page_pages {
            width: 100% !important;
        }
        </style>
        ';
        return $sContent;        
     }   

}