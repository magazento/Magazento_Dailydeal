<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Block_Admin_Item_Edit_Tab_Tabhoriz_Form extends Mage_Adminhtml_Block_Widget_Form {


    protected function _prepareForm() {
        $model = Mage::registry('dailydeal_item');
        
        $form = new Varien_Data_Form(array('id' => 'edit_form_item', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setHtmlIdPrefix('item_');
        
        $fieldset = $form->addFieldset('base_fieldset_automation', array('legend' => Mage::helper('dailydeal')->__('Product settings'), 'class' => 'fieldset-wide'));
        
        $note = '';
        if (!$model->getData('catalog_product_id'))  {
            $note = '';
        } else {
            $product = Mage::getModel('catalog/product')->load($model->getData('catalog_product_id'));
            $note = $product->getName();
        }
        
        $fieldset->addField('catalog_product_id', 'text', array( 
           'name' => 'catalog_product_id',
            'label' => Mage::helper('dailydeal')->__('Product Id'),
            'title' => Mage::helper('dailydeal')->__('Product Id'),
            'required' => true,
            'note' => $note,
        ));  
        $fieldset->addField('qty', 'text', array(
            'name' => 'qty',
            'label' => Mage::helper('dailydeal')->__('Quantity'),
            'title' => Mage::helper('dailydeal')->__('Quantity'),
            'required' => true,
        ));        
        
        $fieldset->addField('percent', 'text', array(
            'name' => 'percent',
            'label' => Mage::helper('dailydeal')->__('Percent off'),
            'title' => Mage::helper('dailydeal')->__('Percent off'),
            'required' => true,
        ));        
        
        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $fieldset->addField('from_time', 'date', array(
            'name' => 'from_time',
            'time' => true,
            'label' => Mage::helper('dailydeal')->__('From Time'),
            'title' => Mage::helper('dailydeal')->__('From Time'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'style' => 'width:272px',
            'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format' => $dateFormatIso,
            'required' => true,
        ));

        $fieldset->addField('to_time', 'date', array(
            'name' => 'to_time',
            'time' => true,
            'label' => Mage::helper('dailydeal')->__('To Time'),
            'title' => Mage::helper('dailydeal')->__('To Time'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'style' => 'width:272px',
            'format' => $dateFormatIso,
            'required' => true,
            
        ));
        
        
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('dailydeal')->__('Display settings'), 'class' => 'fieldset-wide'));
        if ($model->getItemId()) {
            $fieldset->addField('item_id', 'hidden', array(
                'name' => 'item_id',
            ));
        }
        
        $fieldset->addField('floating_banner', 'select', array(
            'label' => Mage::helper('dailydeal')->__('Floating banner'),
            'title' => Mage::helper('dailydeal')->__('Floating banner'),
            'name' => 'floating_banner',
            'required' => true,
            'options' => array(
                '0' => Mage::helper('dailydeal')->__('No'),
                '1' => Mage::helper('dailydeal')->__('Yes'),                
            ),
        ));        
        
        $fieldset->addField('layout', 'select', array(
            'name' => 'layout',
            'label' => Mage::helper('dailydeal')->__('Layout block'),
            'title' => Mage::helper('dailydeal')->__('Layout block'),
            'required' => true,
            'options' => Mage::helper('dailydeal/data')->getLayoutTypes(),
        ));    
        $fieldset->addField('order', 'select', array(
            'name' => 'order',
            'label' => Mage::helper('dailydeal')->__('Block order'),
            'title' => Mage::helper('dailydeal')->__('Block order'),
            'required' => true,
            'options' => Mage::helper('dailydeal/data')->getLayoutOrder(),
        ));    
        
        $fieldset->addField('position', 'select', array(
            'name' => 'position',
            'label' => Mage::helper('dailydeal')->__('Position(Sorting)'),
            'title' => Mage::helper('dailydeal')->__('Position(Sorting)'),
            'required' => true,
            'options' => Mage::helper('dailydeal')->numberArray(20,Mage::helper('dailydeal')->__('')),
        ));
        
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('dailydeal')->__('Store View'),
                'title' => Mage::helper('dailydeal')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            'style' => 'height:150px',
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('is_active', 'select', array(
            'label' => Mage::helper('dailydeal')->__('Status'),
            'title' => Mage::helper('dailydeal')->__('Status'),
            'name' => 'is_active',
            'required' => true,
            'options' => array(
                '0' => Mage::helper('dailydeal')->__('Disabled'),
                '1' => Mage::helper('dailydeal')->__('Enabled'),                
            ),
        ));

        $fieldset->addField('on_checkout', 'select', array(
            'label' => Mage::helper('dailydeal')->__('Display on checkout page'),
            'title' => Mage::helper('dailydeal')->__('Display on checkout page'),
            'name' => 'on_checkout',
            'required' => true,
            'options' => array(
                '0' => Mage::helper('dailydeal')->__('No'),
                '1' => Mage::helper('dailydeal')->__('Yes'),                
            ),
        ));
        
        
        $fieldset->addField('assign_products', 'select', array(
            'label' => Mage::helper('dailydeal')->__('Display on product pages'),
            'title' => Mage::helper('dailydeal')->__('Display on product pages'),
            'name' => 'assign_products',
            'required' => true,
            'options' => array(
                '0' => Mage::helper('dailydeal')->__('Dispaly on selected products'),
                '1' => Mage::helper('dailydeal')->__('All products'),
            ),
        ));
        $fieldset->addField('assign_categories', 'select', array(
            'label' => Mage::helper('dailydeal')->__('Display on category pages'),
            'title' => Mage::helper('dailydeal')->__('Display on category pages'),
            'name' => 'assign_categories',
            'required' => true,
            'options' => array(
                '0' => Mage::helper('dailydeal')->__('Dispaly on selected categories'),
                '1' => Mage::helper('dailydeal')->__('All categories'),
            ),
        ));
        $fieldset->addField('assign_pages', 'select', array(
            'label' => Mage::helper('dailydeal')->__('Display on CMS pages'),
            'title' => Mage::helper('dailydeal')->__('Display on CMS pages'),
            'name' => 'assign_pages',
            'required' => true,
            'options' => array(
                '0' => Mage::helper('dailydeal')->__('Dispaly on selected pages'),
                '1' => Mage::helper('dailydeal')->__('All pages'),
            ),
        ));

        $fieldset->addField('script_java', 'note', array(
            'text' => '<script type="text/javascript">
				            var inputDateFrom = document.getElementById(\'item_from_time\');
				            var inputDateTo = document.getElementById(\'item_to_time\');
            				inputDateTo.onchange=function(){dateTestAnterior(this)};
				            inputDateFrom.onchange=function(){dateTestAnterior(this)};


				            function dateTestAnterior(inputChanged){
				            	dateFromStr=inputDateFrom.value;
				            	dateToStr=inputDateTo.value;

				            	if(dateFromStr.indexOf(\'.\')==-1)
				            		dateFromStr=dateFromStr.replace(/(\d{1,2} [a-zA-Zâêûîôùàçèé]{3})[^ \.]+/,"$1.");
				            	if(dateToStr.indexOf(\'.\')==-1)
				            		dateToStr=dateToStr.replace(/(\d{1,2} [a-zA-Zâêûîôùàçèé]{3})[^ \.]+/,"$1.");

				            	fromDate= Date.parseDate(dateFromStr,"%e %b %Y %H:%M:%S");
				            	toDate= Date.parseDate(dateToStr,"%e %b %Y %H:%M:%S");

				            	if(dateToStr!=\'\'){
					            	if(fromDate>toDate){
	            						inputChanged.value=\'\';
	            						alert(\'' . Mage::helper('dailydeal')->__('You must set a date to value greater than the date from value') . '\');
					            	}
				            	}
            				}
            			</script>',
            'disabled' => true
        ));
        

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
