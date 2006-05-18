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
 * $Id: global_config.php,v 1.3 2006/05/18 12:13:01 dma147 Exp $
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
usleep(400);;
@ob_flush();


echo " &nbsp;<span style=\"font-weight:bolder;color:green\">*</span> &nbsp;".$apcms['LANGUAGE']['DEF_CREATE_TABLE']." \"".$table."\"...<br />";
@ob_flush();
$query2 = "CREATE TABLE IF NOT EXISTS `".$table."` (
  `title` varchar(128) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sesslifetime` int(6) NOT NULL,
  `emailfrom` varchar(128) NOT NULL,
  `emailadress` varchar(128) NOT NULL
) DEFAULT CHARSET=utf8";
$db->unbuffered_query($query2);
@ob_flush();
usleep(400);;
@ob_flush();


echo " &nbsp;<span style=\"font-weight:bolder;color:green\">*</span> &nbsp;".$apcms['LANGUAGE']['DEF_INSERT_DATA']." \"".$table."\"...<br />";
@ob_flush();
$query3 = "INSERT INTO `".$table."` (`title`, `subtitle`, `description`, `sesslifetime`, `emailfrom`, `emailadress`) VALUES ('My Page', 'My personal page', 'This is my personal page which I\'ve created to be online.', 3600, 'My Page', 'email@example.com')";
$db->unbuffered_query($query3);
@ob_flush();
usleep(400);;
@ob_flush();




















@ob_flush();
?>