<?php
/*
 *  Created on Mar 16, 2011
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2011. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php
class Magazento_Dailydeal_Block_Layoutbanner extends Mage_Core_Block_Template 
{ 

//    protected function _construct() {
//        $this->addData(array(
//            'cache_lifetime' => 86400,
//            'cache_tags' => array("magazento_dailydeal_layoutbanner" .'_'.Mage::app()->getStore()->getId()),
//            'cache_key' => "magazento_dailydeal_layoutbanner".'_'.Mage::app()->getStore()->getId(),
//        ));          
//        Mage::log(http_build_query($this->getData()), null, 'magazento_dailydeal.log');
//    }    
    
    public function getBannerLayoutItems($type,$id,$store = 0) {
        return Mage::getModel('dailydeal/item')->getBannerLayoutItems($type,$id,$store);
    }
    
    
    
}