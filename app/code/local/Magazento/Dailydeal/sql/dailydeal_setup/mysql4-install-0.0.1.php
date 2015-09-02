<?php
/*
* Created on Dec 6, 2012
*  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
*  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
*  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
*/
?>
<?php

$installer = $this;
$installer->startSetup();
$installer->run("

CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_dailydeal_item')}` (
  `item_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `qty` tinyint(4) NOT NULL DEFAULT '5',
  `percent` int(11) NOT NULL,
  `order` varchar(25) NOT NULL,
  `layout` varchar(50) NOT NULL,
  `floating_banner` smallint(1) NOT NULL,
  `assign_categories` tinyint(4) NOT NULL DEFAULT '0',
  `assign_pages` tinyint(4) NOT NULL DEFAULT '0',
  `assign_products` tinyint(4) NOT NULL DEFAULT '0',
  `catalog_product_id` int(11) NOT NULL,
  `position` tinyint(10) NOT NULL DEFAULT '0',
  `from_time` datetime DEFAULT NULL,
  `to_time` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `bestseller_type` varchar(25) NOT NULL,
  `on_checkout` tinyint(1) NOT NULL,
  `css` text NOT NULL,
  `bestsellercategory` int(11) NOT NULL,
  `display_type` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_dailydeal_item_category')}` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `category_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_dailydeal_item_page')}` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `page_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_dailydeal_item_product')}` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `product_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_dailydeal_item_store')}` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `store_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();

$newBlock = Mage::getModel('cms/block')
          ->setTitle('daily_deal_top_block')
          ->setContent('<h2><span>Daily Deals - Buy more! Save More!</span></h2> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque, sem ut condimentum mattis, elit dui bibendum risus, sit amet posuere sem sapien vitae enim. Donec lectus elit, malesuada nec ullamcorper a, porta consectetur tellus. Sed ut venenatis tortor. Fusce vehicula purus a turpis aliquam molestie. In est lorem, tristique vitae pharetra sit amet, laoreet non sapien. Maecenas fermentum sapien eu mi viverra pretium non eu leo. Donec elementum enim a massa vulputate vestibulum. Proin sagittis cursus pellentesque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas sed leo augue, vitae consequat enim. Ut a sapien urna, non laoreet sem.</p>')
          ->setIdentifier('daily_deal_top_block')
          ->setIsActive(true)
          ->setStores(array(0))
          ->save();
$newBlock = Mage::getModel('cms/block')
          ->setTitle('daily_deal_bottom_block')
          ->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque, sem ut condimentum mattis, elit dui bibendum risus, sit amet posuere sem sapien vitae enim. Donec lectus elit, malesuada nec ullamcorper a, porta consectetur tellus. Sed ut venenatis tortor. Fusce vehicula purus a turpis aliquam molestie. In est lorem, tristique vitae pharetra sit amet, laoreet non sapien. Maecenas fermentum sapien eu mi viverra pretium non eu leo. Donec elementum enim a massa vulputate vestibulum. Proin sagittis cursus pellentesque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas sed leo augue, vitae consequat enim. Ut a sapien urna, non laoreet sem.</p>')
          ->setIdentifier('daily_deal_bottom_block')
          ->setIsActive(true)
          ->setStores(array(0))
          ->save();

?>