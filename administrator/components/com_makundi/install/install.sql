CREATE TABLE IF NOT EXISTS `#__makundi_categories` (
    `makundi_category_id` int(11) NOT NULL AUTO_INCREMENT,
  	`uuid` char(36) NOT NULL UNIQUE,
    `title` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL UNIQUE,
    `description` text,
    `order_by` varchar(512) NOT NULL default '',
    `direction` varchar(512) NOT NULL default '',
    `enabled` tinyint(1) NOT NULL default 1,
    `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL default 0, 
    `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
    `created_by` bigint(20) NOT NULL default 0,
    `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL default 0,
    PRIMARY KEY (`makundi_category_id`)
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