<?php
/**
 * Project:		APCms: (Another PHP) Complex module system
 *
 * This source file is subject to version 2 of the GPL,
 * that is bundled with this package in the file LICENSE, and is
 * available through the world-wide-web at the following url:
 * http://www.gnu.org/copyleft/gpl.html.
 * If you did not receive a copy of the GPL license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * <dma147@php-programs.de> so we can mail you a copy immediately.
 *
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-general-subscribe@lists.php.net
 *
 * @link http://apcms.php-programs.de
 * @version 0.0.1-pre1
 * @copyright Copyright: 2000-2006 Alexander 'dma147' Mieland
 * @author Alexander 'dma147' Mieland <dma147@php-programs.de>
 * @access public
 * @package apcms
 * @subpackage setup
 * 
 * $Id: global_plugins.php,v 1.4 2006/05/18 12:18:52 dma147 Exp $
 */

/*)\
\(*/


@ob_flush();

$table = $prefix.(str_replace(".".$SUFFIX, "", basename(__FILE__)));

echo " &nbsp;<span style=\"font-weight:bolder;color:green\">*</span> &nbsp;".$apcms['LANGUAGE']['DEF_DROP_TABLE']." \"".$table."\"...<br />";
@ob_flush();
$query1 = "DROP TABLE IF EXISTS `".$table."`";
$db->unbuffered_query($query1);
@ob_flush();
usleep(50000);;
@ob_flush();


echo " &nbsp;<span style=\"font-weight:bolder;color:green\">*</span> &nbsp;".$apcms['LANGUAGE']['DEF_CREATE_TABLE']." \"".$table."\"...<br />";
@ob_flush();
$query2 = "CREATE TABLE IF NOT EXISTS `".$table."` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `md5` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  `config` text NOT NULL,
  `version` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`)
) CHARSET=utf8 AUTO_INCREMENT=4";
$db->unbuffered_query($query2);
@ob_flush();
usleep(50000);;
@ob_flush();


echo " &nbsp;<span style=\"font-weight:bolder;color:green\">*</span> &nbsp;".$apcms['LANGUAGE']['DEF_INSERT_DATA']." \"".$table."\"...<br />";
@ob_flush();
$query3 = "INSERT INTO `".$table."` (`id`, `name`, `md5`, `active`, `config`, `version`) VALUES (1, 'apcms_plugin_example', 'c79b45c08beb08b57867d0f067d475b8', 1, 'a:3:{s:5:\"title\";s:14:\"Example plugin\";s:8:\"foofield\";s:14:\"content of foo\";s:8:\"barfield\";i:1234;}', '0.0.1'),
(2, 'apcms_sidebar_poweredby', 'd2c8e21b62e8f2bb098830ccd4f70c5b', 1, 'a:0:{}', '0.0.2'),
(3, 'apcms_sidebar_adminbox', 'bf97756d30018c1db492f59a07a42870', 1, 'a:0:{}', '0.0.1')";
$db->unbuffered_query($query3);
@ob_flush();
usleep(50000);;
@ob_flush();




















@ob_flush();
?>