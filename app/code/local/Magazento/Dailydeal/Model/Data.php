<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2011. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php
Class Magazento_Dailydeal_Model_Data {


    public function getSellDate($days) {
        $product = Mage::getModel('catalog/product');
        $product=array();
        $outputFormat='Y-m-d H:i:s';
        $product['todaydate'] = date($outputFormat, time());
        $product['startdate'] = date($outputFormat, time() - 60 * 60 * 24 * $days);
        return $product;

    }

    public function getCategory ($id){
            $categoryId = $id;
            if (!$categoryId || !is_numeric($categoryId))
                    $category = Mage::registry("current_category");
            else {
                    $category = Mage::getModel("catalog/category")->load($categoryId);
                    if (!$category->getId())
                            $category = Mage::registry("current_category");
            }
            return $category;
    }


    public function getCombineWithManualBestsellers($collection_ids,$product_ids) {
        
        $products = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToFilter('entity_id', array('in' => $product_ids));   
        $merged_ids = array_merge($collection_ids, $products->getAllIds());
        
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addFieldToFilter('entity_id', $merged_ids)
            ->setStoreId($storeId)
            ->addAttributeToSelect('*');    
//        var_dump($merged_ids);
//        var_dump($collection->getAllIds());
        
        return $collection;
    }
    
    public function getDailydealDaysLimit() {
        $count = (int) Mage::getStoreConfig('dailydeal/topsell/days');
        if ($count <=0) $count=5;
        return $count;
    }

    
    //...........
    
    
    public function getProducts4Form() {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSort('name', 'ASC');
        
        $items = array();
        foreach ($collection as $item) {
            $items[$item->getId()] = $item->getName() .' - '.$item->getSku();
        }        
        
        return $items;
    }
    public function getCategories4Grid() {
        $collection = Mage::getModel('catalog/category')->getCollection();
	
        $items = array();
        foreach ($collection as $item) {
            if ($item->getData('parent_id')) {            
                $_category = Mage::getModel('catalog/category')->load($item->getId());
                $items[$item->getId()] = $_category->getName();
            }
            
        }
                
        return $items;
    }    
    
    public function getPages4Grid() {
        $collection = Mage::getResourceModel('cms/page_collection')
                    ->addFieldToFilter('identifier',array(array('nin'=>array('no-route','enable-cookies'))))
                    ->load();
	
        $items = array();
        foreach ($collection as $item) {
            $items[$item->getId()] = $item->getTitle();
        }
                
        return $items;
    }    
    
    public function getPages4Form() {
        $collection = Mage::getResourceModel('cms/page_collection')
                    ->addFieldToFilter('identifier',array(array('nin'=>array('no-route','enable-cookies'))))
                    ->load();
        $items = array();
        foreach ($collection as $item) {
            $v = array( 'label' => $item->getTitle() .' - '.$item->getIdentifier(),
                        'value' => $item->getId()
                        ); 
            array_push($items,$v);
        }
                
        return $items;
    }     
        
    
    

}