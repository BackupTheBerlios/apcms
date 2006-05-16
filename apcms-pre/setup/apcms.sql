-- phpMyAdmin SQL Dump
-- version 2.8.0-beta1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 16. Mai 2006 um 18:29
-- Server Version: 5.0.18
-- PHP-Version: 5.1.4-pl0-gentoo
-- 
-- Datenbank: `apcms`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_global_config`
-- 

DROP TABLE IF EXISTS `apcms_1_global_config`;
CREATE TABLE IF NOT EXISTS `apcms_1_global_config` (
  `title` varchar(128) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sesslifetime` int(6) NOT NULL,
  `emailfrom` varchar(128) NOT NULL,
  `emailadress` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `apcms_1_global_config`
-- 

INSERT INTO `apcms_1_global_config` (`title`, `subtitle`, `description`, `sesslifetime`, `emailfrom`, `emailadress`) VALUES ('My Page', 'My personal page', 'This is my personal page which I\\''ve created to be online.', 3600, 'My Page', 'email@example.com');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_global_groups`
-- 

DROP TABLE IF EXISTS `apcms_1_global_groups`;
CREATE TABLE IF NOT EXISTS `apcms_1_global_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(48) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Daten für Tabelle `apcms_1_global_groups`
-- 

INSERT INTO `apcms_1_global_groups` (`id`, `name`, `desc`) VALUES (1, 'Administrators', 'The group for all administrative users'),
(2, 'Guests', 'The group for all unregistered and not logged in users'),
(3, 'Members', 'The group for all normal registered and logged in users');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_global_leftsidebar`
-- 

DROP TABLE IF EXISTS `apcms_1_global_leftsidebar`;
CREATE TABLE IF NOT EXISTS `apcms_1_global_leftsidebar` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `sort` tinyint(2) NOT NULL default '1',
  `hidden` tinyint(1) NOT NULL default '0',
  `plugin` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `hidden` (`hidden`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `apcms_1_global_leftsidebar`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_global_plugins`
-- 

DROP TABLE IF EXISTS `apcms_1_global_plugins`;
CREATE TABLE IF NOT EXISTS `apcms_1_global_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `md5` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  `config` text NOT NULL,
  `version` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Daten für Tabelle `apcms_1_global_plugins`
-- 

INSERT INTO `apcms_1_global_plugins` (`id`, `name`, `md5`, `active`, `config`, `version`) VALUES (1, 'apcms_plugin_example', 'c79b45c08beb08b57867d0f067d475b8', 1, 'a:3:{s:5:"title";s:14:"Example plugin";s:8:"foofield";s:14:"content of foo";s:8:"barfield";i:1234;}', '0.0.1'),
(2, 'apcms_sidebar_poweredby', 'd2c8e21b62e8f2bb098830ccd4f70c5b', 1, 'a:0:{}', '0.0.2'),
(3, 'apcms_sidebar_adminbox', 'bf97756d30018c1db492f59a07a42870', 1, 'a:0:{}', '0.0.1'),
(4, 'apcms_plugin_newsmanagement', '8373e115bafdced700ef5269fb0e093c', 1, 'a:5:{s:14:"items_per_page";i:15;s:10:"dateformat";s:10:"d.m.Y, H:i";s:11:"show_author";b:1;s:10:"use_bbcode";b:1;s:14:"guest_comments";b:1;}', '0.0.2');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_global_rights`
-- 

DROP TABLE IF EXISTS `apcms_1_global_rights`;
CREATE TABLE IF NOT EXISTS `apcms_1_global_rights` (
  `action` varchar(255) NOT NULL,
  `plugin` varchar(255) NOT NULL,
  `groups` text NOT NULL,
  KEY `action` (`action`),
  KEY `plugin` (`plugin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `apcms_1_global_rights`
-- 

INSERT INTO `apcms_1_global_rights` (`action`, `plugin`, `groups`) VALUES ('global_access', '', 'a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}'),
('admincenter', '', 'a:1:{i:0;i:1;}'),
('admin_main_access', '', 'a:1:{i:0;i:1;}'),
('admin_general_config_access', '', 'a:1:{i:0;i:1;}'),
('admin_plugins_access', '', 'a:1:{i:0;i:1;}'),
('admin_sidebars_access', '', 'a:1:{i:0;i:1;}'),
('admin_user_access', '', 'a:1:{i:0;i:1;}'),
('admin_groups_access', '', 'a:1:{i:0;i:1;}'),
('admin_installplugins_access', '', 'a:1:{i:0;i:1;}'),
('admin_pluginconfigure_access', '', 'a:1:{i:0;i:1;}');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_global_rightsidebar`
-- 

DROP TABLE IF EXISTS `apcms_1_global_rightsidebar`;
CREATE TABLE IF NOT EXISTS `apcms_1_global_rightsidebar` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `sort` tinyint(2) NOT NULL default '1',
  `hidden` tinyint(1) NOT NULL default '0',
  `plugin` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `hidden` (`hidden`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Daten für Tabelle `apcms_1_global_rightsidebar`
-- 

INSERT INTO `apcms_1_global_rightsidebar` (`id`, `title`, `content`, `sort`, `hidden`, `plugin`) VALUES (1, 'Information', '[box=loginform]', 1, 0, ''),
(2, 'Adminbox', '[php]$apcms[''PLUGIN''][''apcms_sidebar_adminbox'']->ShowAdminBox();[/php]', 3, 0, 'apcms_sidebar_adminbox'),
(3, 'Powered by', '[php]$apcms[''PLUGIN''][''apcms_sidebar_poweredby'']->ShowBox();[/php]', 2, 0, 'apcms_sidebar_poweredby');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_global_users`
-- 

DROP TABLE IF EXISTS `apcms_1_global_users`;
CREATE TABLE IF NOT EXISTS `apcms_1_global_users` (
  `id` int(11) NOT NULL auto_increment,
  `nickname` varchar(32) NOT NULL,
  `password` binary(32) NOT NULL,
  `email` varchar(196) NOT NULL,
  `groups` text NOT NULL,
  `theme` varchar(64) NOT NULL default 'default',
  `language` varchar(8) NOT NULL default 'de',
  `active` tinyint(1) NOT NULL default '0',
  `actkey` varchar(32) NOT NULL,
  `regdate` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `nickname` (`nickname`),
  KEY `email` (`email`),
  KEY `active` (`active`),
  KEY `actkey` (`actkey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `apcms_1_global_users`
-- 

INSERT INTO `apcms_1_global_users` (`id`, `nickname`, `password`, `email`, `groups`, `theme`, `language`, `active`, `actkey`, `regdate`, `last_login`) VALUES (1, 'admin', 0x3231323332663239376135376135613734333839346130653461383031666333, 'email@example.com', 'a:1:{i:0;i:1;}', 'default', 'de', 1, 'ckaToGwV', 1147796580, 1147796881);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_plugin_example`
-- 

DROP TABLE IF EXISTS `apcms_1_plugin_example`;
CREATE TABLE IF NOT EXISTS `apcms_1_plugin_example` (
  `id` int(11) NOT NULL auto_increment,
  `foo` int(11) NOT NULL default '0',
  `bar` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `apcms_1_plugin_example`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_plugin_newsmanagement_comments`
-- 

DROP TABLE IF EXISTS `apcms_1_plugin_newsmanagement_comments`;
CREATE TABLE IF NOT EXISTS `apcms_1_plugin_newsmanagement_comments` (
  `id` int(11) NOT NULL auto_increment,
  `nid` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `postdate` int(11) NOT NULL default '0',
  `title` varchar(64) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `nid` (`nid`),
  KEY `uid` (`uid`),
  KEY `postdate` (`postdate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `apcms_1_plugin_newsmanagement_comments`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `apcms_1_plugin_newsmanagement_news`
-- 

DROP TABLE IF EXISTS `apcms_1_plugin_newsmanagement_news`;
CREATE TABLE IF NOT EXISTS `apcms_1_plugin_newsmanagement_news` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `postdate` int(11) NOT NULL default '0',
  `title` varchar(64) NOT NULL,
  `body` text NOT NULL,
  `extbody` text NOT NULL,
  `views` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `postdate` (`postdate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `apcms_1_plugin_newsmanagement_news`
-- 

INSERT INTO `apcms_1_plugin_newsmanagement_news` (`id`, `uid`, `postdate`, `title`, `body`, `extbody`, `views`) VALUES (1, 1, 1147796951, 'Willkommen in Deinem APCms', 'Du hast soeben das APCms erfolgreich installiert!\r\nHerzlichen Glückwunsch für diese Entscheidung.', 'Du kannst diese News in der News-Verwaltung ändern oder löschen.\r\n\r\nViel Spaß mit Deinem APCms!', 0);
