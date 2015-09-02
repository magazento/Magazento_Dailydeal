<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php
class Magazento_Dailydeal_Model_Observergetprice
{
	public function __construct()
	{
	}

	public function get_price($observer)
	{
		$event = $observer->getEvent();
		$product = $event->getProduct();  
                $collection = Mage::getModel('dailydeal/item')->getCollection();
                $collection ->addFilter('is_active', 1);
                $collection ->addNowFilter();
                
                foreach($collection as $item)
                {
                        if($item->getData('catalog_product_id') == $product->getId())
                        {
                                $final_price = $product->getFinalPrice();
                                $percent = $item->getPercent();
                                $special_price = $final_price-$final_price*$percent/100;

                                if($special_price < 0) $special_price = $final_price;

                                $product->setFinalPrice($special_price);
                        }
                }
		return $this;
	}
}
