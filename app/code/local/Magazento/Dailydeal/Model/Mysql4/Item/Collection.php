<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Model_Mysql4_Item_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected function _construct() {
        $this->_init('dailydeal/item');
    }

    public function toOptionArray() {
        return $this->_toOptionArray('item_id', 'name');
    }
    
    public function addStoreFilter($store, $withAdmin = true) {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        $this->getSelect()->join(
                        array('item_store' => $this->getTable('dailydeal/item_store')),
                        'main_table.item_id = item_store.item_id',
                        array()
                )
                ->where('item_store.store_id in (?)', ($withAdmin ? array(0, $store) : $store));
        
        return $this;
    }
    
    public function addCategoryFilter($category) {

        $this->getSelect()->joinleft(
                        array('item_category' => $this->getTable('dailydeal/item_category')),
                        'main_table.item_id = item_category.item_id',
                        array()
                )
                ->distinct()
                ->where('item_category.category_id in (?) OR main_table.assign_categories = 1', $category);
        return $this;
    }
    
    public function addProductFilter($product) {

        $this->getSelect()->joinleft(
                        array('item_product' => $this->getTable('dailydeal/item_product')),
                        'main_table.item_id = item_product.item_id',
                        array()
                )
                ->distinct()                      
                ->where('item_product.product_id in (?) OR main_table.assign_products = 1', $product);

        return $this;
    }
    
    public function addPageFilter($page) {
        $this->getSelect()->joinleft(
                    array('item_page' => $this->getTable('dailydeal/item_page')),
                    'main_table.item_id = item_page.item_id',
                    array()
                )
            ->distinct()                         
            ->where('item_page.page_id in (?) OR main_table.assign_pages = 1 ', $page);
        return $this;
    }
    
    public function addLayoutFilter($layout,$order) {
        $where = "`layout` = '".$layout."' AND `order` = '".$order."'";
        $this->getSelect()->where($where);
    }
    public function addNowFilter() {
        $now = Mage::getSingleton('core/date')->gmtDate();
        $where = "from_time < '" . $now . "' AND ((to_time > '" . $now . "'))";
        $this->getSelect()->where($where);
    }

}