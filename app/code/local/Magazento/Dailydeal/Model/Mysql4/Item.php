<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Model_Mysql4_Item extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {
        $this->_init('dailydeal/item', 'item_id');
    }

   protected function _beforeSave(Mage_Core_Model_Abstract $object) {
        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        if (!$object->getFromTime()) {
            $object->setFromTime(Mage::getSingleton('core/date')->gmtDate());
        } else {
            $object->setFromTime(Mage::app()->getLocale()->date($object->getFromTime(), $dateFormatIso));
            $object->setFromTime($object->getFromTime()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
            $object->setFromTime(Mage::getSingleton('core/date')->gmtDate(null, $object->getFromTime()));
        }
        $object->setData('from_time', Mage::getSingleton('core/date')->gmtDate());

        return $this;
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        $condition = $this->_getWriteAdapter()->quoteInto('item_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('dailydeal/item_page'), $condition);
        $this->_getWriteAdapter()->delete($this->getTable('dailydeal/item_store'), $condition);
        $this->_getWriteAdapter()->delete($this->getTable('dailydeal/item_category'), $condition);
        if ($object->getData('in_products')) $this->_getWriteAdapter()->delete($this->getTable('dailydeal/item_product'), $condition);
//        var_dump($object->getData('in_products') );
//        exit();        
        
        $products = $object->getData('products');
        
        foreach ((array) $products as $product) {
            if ($product == 0) continue;
            $productArray = array();
            $productArray['item_id'] = $object->getId();
            $productArray['product_id'] = $product;
            $this->_getWriteAdapter()->insert($this->getTable('dailydeal/item_product'), $productArray);
        }        
        
        // ASSIGNED PRODUCT 
        $products = $object->getData('assignedproducts');   
        foreach ((array) $products as $product) {
            if ($product == 0) continue;
            $productArray = array();
            $productArray['item_id'] = $object->getId();
            $productArray['assignedproduct_id'] = $product;
            $this->_getWriteAdapter()->insert($this->getTable('dailydeal/item_assignedproduct'), $productArray);
        }        
        
        // ASSIGNED REVIEWS 
        $reviews = $object->getData('assignedreviews');   
//        var_dump($reviews);
//        exit();
        foreach ((array) $reviews as $review) {
            if ($review == 0) continue;
            $reviewArray = array();
            $reviewArray['item_id'] = $object->getId();
            $reviewArray['review_id'] = $review;
            $this->_getWriteAdapter()->insert($this->getTable('dailydeal/item_review'), $reviewArray);
        }        
        
        
        //STORE
        if (!$object->getData('stores')) {
            $object->setData('stores', $object->getData('store_id'));
        }
        if (in_array(0, $object->getData('stores'))) {
            $object->setData('stores', array(0));
        }
        foreach ((array) $object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['item_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('dailydeal/item_store'), $storeArray);
        }
        
        // CATEGORY 
        $category = explode(',',$object->getData('category_ids'));
        $category = array_filter($category);
        $category = array_unique($category);
        
        if (!$object->getData('categories')) {
            $object->setData('categories', $category);
        }
        if (in_array(0, $object->getData('categories'))) {
            $object->setData('categories', array(0));
        }
        foreach ((array) $object->getData('categories') as $category) {
            $categoryArray = array();
            $categoryArray['item_id'] = $object->getId();
            $categoryArray['category_id'] = $category;
            $this->_getWriteAdapter()->insert($this->getTable('dailydeal/item_category'), $categoryArray);
        }
        
        
        // PAGE 
        $page = $object->getData('pages');
        foreach ((array) $page as $page) {
            $pageArray = array();
            $pageArray['item_id'] = $object->getId();
            $pageArray['page_id'] = $page;
            $this->_getWriteAdapter()->insert($this->getTable('dailydeal/item_page'), $pageArray);
        }
        
        
        return parent::_afterSave($object);
    }
    
    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        
        //STORE
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getTable('dailydeal/item_store'))
                        ->where('item_id = ?', $object->getId());
        
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }
        
        
        
        //CATEGORY 
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getTable('dailydeal/item_category'))
                        ->where('item_id = ?', $object->getId());
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $categoryArray = array();
            foreach ($data as $row) {
                $categoryArray[] = $row['category_id'];
            }
            $object->setData('category_id', $categoryArray);
            $object->setData('category_ids', implode(',',$categoryArray));
        }
       
        
        //PRODUCT 
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getTable('dailydeal/item_product'))
                        ->where('item_id = ?', $object->getId());
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $productArray = array();
            foreach ($data as $row) {
                $productArray[] = $row['product_id'];
            }
            $object->setData('product_id', $productArray);
        }
       
        //PAGE
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getTable('dailydeal/item_page'))
                        ->where('item_id = ?', $object->getId());
        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $pageArray = array();
            foreach ($data as $row) {
                $pageArray[] = $row['page_id'];
            }
            $object->setData('pages', $pageArray);
        }        
        
        return parent::_afterLoad($object);
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {
        $adapter = $this->_getReadAdapter();
        $adapter->delete($this->getTable('dailydeal/item_store'), 'item_id=' . $object->getId());
        $adapter->delete($this->getTable('dailydeal/item_category'), 'item_id=' . $object->getId());
        $adapter->delete($this->getTable('dailydeal/item_product'), 'item_id=' . $object->getId());
        $adapter->delete($this->getTable('dailydeal/item_page'), 'item_id=' . $object->getId());
    }

}