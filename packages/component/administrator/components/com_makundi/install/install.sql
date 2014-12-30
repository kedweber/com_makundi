CREATE TABLE IF NOT EXISTS `#__makundi_categories` (
  `makundi_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `cck_fieldset_id` int(11) NOT NULL DEFAULT '800',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `simple_title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'category',
  `layout` varchar(255) NOT NULL DEFAULT 'default',
  `fields` text,
  `order_by` varchar(512) NOT NULL DEFAULT 'publish_up',
  `direction` varchar(512) NOT NULL DEFAULT 'DESC',
  `featured` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `show_date` tinyint(1) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` bigint(20) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`makundi_category_id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `slug` (`slug`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__makundi_category_relations` (
  `ancestor_id` int(11) unsigned NOT NULL DEFAULT '0',
  `descendant_id` int(11) unsigned NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ancestor_id`, `descendant_id`, `level`),
  KEY `path_index` (`descendant_id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__makundi_category_orderings` (
  `makundi_category_id` int(11) unsigned NOT NULL,
  `title` int(11) NOT NULL DEFAULT '0',
  `custom` int(11) NOT NULL DEFAULT '0',
  `created_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`makundi_category_id`)
) DEFAULT CHARSET=utf8;