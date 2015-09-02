<?php

class Magazento_Dailydeal_Block_Links extends Mage_Customer_Block_Account_Navigation
{

    public function addTopLink()
    {
        if (Mage::getStoreConfig('dailydeal/toplinks/link')) {
            $storeId = Mage::app()->getStore()->getId();
            $storeUrl = Mage::getModel('core/store')->load($storeId)->getUrl();
            $route = Mage::getBaseUrl().'dailydeal' ;
            $title = Mage::getStoreConfig('dailydeal/toplinks/link_title');
            $this->getParentBlock()->addLink($title, $route, $title, false, array(), 15, null, 'class="magazento-dailydeal"');
        }
   }

}
