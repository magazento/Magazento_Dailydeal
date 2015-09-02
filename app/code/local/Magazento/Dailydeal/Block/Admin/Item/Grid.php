<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Block_Admin_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('DailydealGrid');
        $this->setDefaultSort('item_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('dailydeal/item')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $baseUrl = $this->getUrl();
        
        $this->addColumn('catalog_product_id', array(
            'header' => Mage::helper('dailydeal')->__('Product Id'),
            'index' => 'catalog_product_id',
            'renderer' => 'dailydeal/admin_item_grid_renderer_product'
        ));      
        $this->addColumn('percent', array(
            'header' => Mage::helper('dailydeal')->__('Percent off'),
            'index' => 'percent',
        ));      
        $this->addColumn('qty', array(
            'header' => Mage::helper('dailydeal')->__('Qty'),
            'index' => 'qty',
        ));      
        
        $this->addColumn('floating_banner', array(
            'header' => Mage::helper('dailydeal')->__('Banner'),
            'index' => 'floating_banner',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('dailydeal')->__('No'),
                1 => Mage::helper('dailydeal')->__('Yes'),
            ),
        ));
        $this->addColumn('on_checkout', array(
            'header' => Mage::helper('dailydeal')->__('On Checkout page'),
            'index' => 'on_checkout',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('dailydeal')->__('No'),
                1 => Mage::helper('dailydeal')->__('Yes'),
            ),
        ));
                
        
        $this->addColumn('products', array(
            'header' => Mage::helper('dailydeal')->__('Show on products'),
            'align' => 'left',
            'type' => 'options',     
            'sortable' => false,
            'options' => Mage::getModel('dailydeal/data')->getProducts4Form(),            
            'index' => 'products',
            'filter_condition_callback'  => array($this, '_filterProductCondition'),             
            'renderer' => 'dailydeal/admin_item_grid_renderer_products'
        ));
        
        $this->addColumn('categories', array(
            'header' => Mage::helper('dailydeal')->__('Show on categories'),
            'align' => 'left',
            'type' => 'options',
            'sortable' => false,
            'options' => Mage::getModel('dailydeal/data')->getCategories4Grid(),            
            'index' => 'categories',
            'filter_condition_callback'  => array($this, '_filterCategoryCondition'),
            'renderer' => 'dailydeal/admin_item_grid_renderer_categories'
        ));        
        
        $this->addColumn('pages', array(
            'header' => Mage::helper('dailydeal')->__('Show on pages'),
            'align' => 'left',
            'type' => 'options',     
            'sortable' => false,
            'options' => Mage::getModel('dailydeal/data')->getPages4Grid(),                
            'index' => 'products',
            'filter_condition_callback'  => array($this, '_filterPageCondition'),            
            'renderer' => 'dailydeal/admin_item_grid_renderer_pages'
        ));   
        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('dailydeal')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'width'         => '120px',
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'  => array($this, '_filterStoreCondition'),
            ));
        }        

        $this->addColumn('from_time', array(
            'header' => Mage::helper('dailydeal')->__('From Time'),
            'index' => 'from_time',
            'type' => 'datetime',
        ));

        $this->addColumn('to_time', array(
            'header' => Mage::helper('dailydeal')->__('To Time'),
            'index' => 'to_time',
            'type' => 'datetime',
        ));
        $this->addColumn('is_active', array(
            'header' => Mage::helper('dailydeal')->__('Status'),
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('dailydeal')->__('Disabled'),
                1 => Mage::helper('dailydeal')->__('Enabled'),
            ),
        ));


        $this->addColumn('action',
                array(
                    'header' => Mage::helper('dailydeal')->__('Action'),
                    'index' => 'item_id',
                    'sortable' => false,
                    'filter' => false,
                    'no_link' => true,
                    'width' => '100px',
                    'renderer' => 'dailydeal/admin_item_grid_renderer_action'
        ));
//        $this->addExportType('*/*/exportCsv', Mage::helper('dailydeal')->__('CSV'));
//        $this->addExportType('*/*/exportXml', Mage::helper('dailydeal')->__('XML'));
        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection() {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

    protected function _filterCategoryCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addCategoryFilter($value);
    }
    protected function _filterProductCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addProductFilter($value);
    }
    protected function _filterPageCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addPageFilter($value);
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('item_id');
        $this->getMassactionBlock()->setFormFieldName('massaction');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('dailydeal')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('dailydeal')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('dailydeal')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('dailydeal')->__('Status'),
                    'values' => array(
                        0 => Mage::helper('dailydeal')->__('Disabled'),
                        1 => Mage::helper('dailydeal')->__('Enabled'),
                    ),
                )
            )
        ));
        
        $this->getMassactionBlock()->addItem('chekout', array(
            'label' => Mage::helper('dailydeal')->__('Display on checkout page'),
            'url' => $this->getUrl('*/*/massCheckout', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'checkout',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('dailydeal')->__('Display'),
                    'values' => array(
                        0 => Mage::helper('dailydeal')->__('No'),
                        1 => Mage::helper('dailydeal')->__('Yes'),
                    ),
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit',  array('item_id' => $row->getId(), 'type' => $row->getData('item_type')));
    }

}
