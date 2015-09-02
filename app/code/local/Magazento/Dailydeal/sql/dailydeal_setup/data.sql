
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `magazento_dailydeal_item`
--

CREATE TABLE IF NOT EXISTS `magazento_dailydeal_item` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `magazento_dailydeal_item`
--

INSERT INTO `magazento_dailydeal_item` (`item_id`, `qty`, `percent`, `order`, `layout`, `floating_banner`, `assign_categories`, `assign_pages`, `assign_products`, `catalog_product_id`, `position`, `from_time`, `to_time`, `is_active`, `bestseller_type`, `on_checkout`, `css`, `bestsellercategory`, `display_type`) VALUES
(48, 3, 35, 'before', 'content', 0, 0, 0, 0, 54, 1, '2012-12-29 11:26:42', '2013-06-20 10:43:57', 1, 'bestseller', 1, '', 0, 0),
(49, 5, 15, 'before', 'content', 0, 1, 0, 0, 113, 1, '2012-12-30 10:26:28', '2013-01-29 22:43:00', 1, 'toprated', 1, '', 0, 1),
(50, 5, 50, 'before', 'content', 0, 1, 0, 0, 54, 1, '2012-12-29 11:26:42', '2013-12-18 06:28:00', 1, 'new', 1, '', 0, 1),
(51, 5, 90, 'before', 'left', 0, 1, 0, 0, 120, 1, '2012-12-29 11:26:42', '2013-12-29 11:17:00', 1, 'review', 1, '', 0, 1),
(52, 5, 23, 'before', 'left', 0, 0, 0, 0, 165, 20, '2012-12-29 11:26:42', '2013-12-05 01:39:05', 1, 'popular', 1, '', 0, 1),
(53, 3, 12, 'before', 'content', 0, 0, 0, 0, 150, 1, '2012-12-29 11:26:42', '2012-12-29 01:31:25', 1, 'new', 1, '', 0, 0),
(54, 22, 2, 'before', 'content', 0, 0, 0, 0, 54, 1, '2012-12-29 11:26:42', '2012-12-27 00:49:20', 1, 'bestseller', 1, '', 0, 1),
(55, 40, 40, 'before', 'right', 0, 1, 1, 1, 153, 1, '2012-12-29 11:26:42', '2013-12-19 22:43:19', 1, '', 1, '', 0, 1),
(56, 4, 50, 'before', 'right', 0, 1, 1, 1, 135, 1, '2012-12-29 11:26:42', '2013-12-19 22:43:19', 1, '', 1, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `magazento_dailydeal_item_category`
--

CREATE TABLE IF NOT EXISTS `magazento_dailydeal_item_category` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `category_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `magazento_dailydeal_item_category`
--

INSERT INTO `magazento_dailydeal_item_category` (`item_id`, `category_id`) VALUES
(52, 10),
(52, 13),
(52, 18),
(53, 10),
(53, 13),
(53, 18);

-- --------------------------------------------------------

--
-- Table structure for table `magazento_dailydeal_item_page`
--

CREATE TABLE IF NOT EXISTS `magazento_dailydeal_item_page` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `page_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `magazento_dailydeal_item_page`
--

INSERT INTO `magazento_dailydeal_item_page` (`item_id`, `page_id`) VALUES
(48, 2),
(48, 3),
(48, 5),
(50, 3),
(51, 3),
(52, 3),
(54, 2),
(49, 2),
(49, 3),
(49, 4),
(49, 5);

-- --------------------------------------------------------

--
-- Table structure for table `magazento_dailydeal_item_product`
--

CREATE TABLE IF NOT EXISTS `magazento_dailydeal_item_product` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `product_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `magazento_dailydeal_item_product`
--

INSERT INTO `magazento_dailydeal_item_product` (`item_id`, `product_id`) VALUES
(48, 16),
(48, 17),
(48, 18),
(48, 20),
(49, 16),
(49, 17),
(49, 18);

-- --------------------------------------------------------

--
-- Table structure for table `magazento_dailydeal_item_store`
--

CREATE TABLE IF NOT EXISTS `magazento_dailydeal_item_store` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `store_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `magazento_dailydeal_item_store`
--

INSERT INTO `magazento_dailydeal_item_store` (`item_id`, `store_id`) VALUES
(48, 0),
(50, 0),
(51, 0),
(52, 0),
(53, 0),
(54, 0),
(55, 0),
(56, 0),
(49, 0);
