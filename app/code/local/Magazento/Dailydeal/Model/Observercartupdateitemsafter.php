<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php
class Magazento_Dailydeal_Model_Observercartupdateitemsafter
{
	public function __construct()
	{
	}

	public function check_is_dailydeal($observer)
	{
		$items = Mage::getSingleton('checkout/cart')->getItems();
		foreach($items as $item)
		{
			$product_id = $item->getProductId();
                        
                        $collection = Mage::getModel('dailydeal/item')->getCollection();
                        $collection ->addFilter('is_active', 1);
                        $collection ->addNowFilter();
				
                        foreach($collection as $deal)
                        {
                                if($product_id == $deal->getData('catalog_product_id'))
                                {
                                        $qty = $deal->getData('qty') - $item->getQty();
                                        if($qty < 0)
                                        {
                                                $item->setQty($deal->getData('qty'));
                                                $session = Mage::getSingleton('checkout/session');
                                                $message = Mage::getSingleton('core/message')->notice('The product "'.$item->getName().'" quantity has been readjusted to max available stock');
                                                $session->getMessages()->add($message);
                                        }


                                }
                        }

		}
		return $this;
	}
}
?>
