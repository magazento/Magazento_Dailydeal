<?php

class Magazento_Dailydeal_IndexController extends Mage_Core_Controller_Front_Action {

   public function indexAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::getStoreConfig('dailydeal/options/metatitle'));
        $this->renderLayout();
   }
   
}
?>
