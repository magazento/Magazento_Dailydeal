<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Block_Admin_Item_Edit_Tab_Page extends Mage_Adminhtml_Block_Widget_Form {


    protected function _prepareForm() {
        $model = Mage::registry('dailydeal_item');
        
        $form = new Varien_Data_Form(array('id' => 'edit_form_page', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('dailydeal')->__('Assignet Pages'), 'class' => 'fieldset-wide'));
        if ($model->getCategoryId()) {
            $fieldset->addField('category_id', 'hidden', array(
                'name' => 'category_id',
            ));
        }
        $pages = Mage::getModel('dailydeal/data')->getPages4Form();        
        $fieldset->addField('pages', 'multiselect', array(
            'name' => 'pages[]',
            'label' => Mage::helper('dailydeal')->__('Website pages'),
            'title' => Mage::helper('dailydeal')->__('Website pages'),
            'required' => false,
            'values' => $pages,
        'style' => 'height:450px',
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
