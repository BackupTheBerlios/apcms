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
 * @subpackage includes
 * 
 * $Id: activate.inc.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
 */

/*)\
\(*/



/**
 * Exit the script when IN_apcms is not defined
 */
if (!defined('IN_apcms')) {
	exit;
}

$PAGE_TITLE			= $apcms['LANGUAGE']['ACTIVATE_TITLE'];
$PAGE_SUBTITLE 		= $apcms['LANGUAGE']['ACTIVATE_SUBTITLE'];
$smarty->caching = false;
$smarty->cache_lifetime = 1800;

$template = "main";

if (isset($_GET['key']) && trim($_GET['key']) != "" && strlen($_GET['key']) <= 32) {
	$key = apcms_Strip($_GET['key']);
	$ret = $db->unbuffered_query_first("SELECT `id`, `active` FROM `".$apcms['table']['global']['users']."` WHERE `actkey`='".apcms_ESC($key)."'");
	if (isset($ret[0]) && intval($ret[0]) >= 1) {
		If (intval(intval($ret[1])) <= 0) {
			$query = "UPDATE `".$apcms['table']['global']['users']."` SET `active`='1' WHERE `id`='".intval($ret[0])."'";
			$db->unbuffered_query($query);
			$success = $apcms['LANGUAGE']['SUCCESS_ACCOUNT_ACTIVATED'];
			$apcms['redirect_url'] = $apcms['baseURL'];
			$apcms['redirect_time'] = 3;
		} else {
			$error = $apcms['LANGUAGE']['ERROR_ACTIVATE_ALREADY_ACTIVATED'];
			$apcms['redirect_url'] = $apcms['baseURL'];
			$apcms['redirect_time'] = 3;
		}
	} else {
		$error = $apcms['LANGUAGE']['ERROR_ACTIVATE_NOT_EXIST'];
		$apcms['redirect_url'] = $apcms['baseURL'];
		$apcms['redirect_time'] = 3;
	}
} else {
	$error = $apcms['LANGUAGE']['ERROR_ACTIVATE_WRONG_KEY'];
	$apcms['redirect_url'] = $apcms['baseURL'];
	$apcms['redirect_time'] = 3;
}


?>