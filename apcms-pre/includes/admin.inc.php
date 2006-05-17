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
 * $Id: admin.inc.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
 */

/*)\
\(*/



/**
 * Exit the script when IN_apcms is not defined
 */
if (!defined('IN_apcms')) {
	exit;
}

/**
 * Defines the admin constant
 */
define('IN_apcms_admin', true);

/**
 * Sets the title of the page
 */
$PAGE_TITLE			= $apcms['LANGUAGE']['ADMINCENTER'];
$smarty->caching = false;
$smarty->cache_lifetime = 1800;


if (!apcms_CheckAccess('admincenter', $_SESSION['groups'])) {
	$error = $apcms['LANGUAGE']['ERROR_ACCESS_DENIED'];
	$apcms['redirect_url'] = $apcms['referer'];
	$apcms['redirect_time'] = 3;
} else {
	
	
	$AdminSideBar  = "<a class=\"adminlinks\" href=\"".$apcms['baseURL']."\">".$apcms['LANGUAGE']['GLOBAL_BACK_TO_APCMS']."</a><br />\n";
	$AdminSideBar .= "<a class=\"adminlinks\" href=\"".$apcms['baseURL']."?c=admin\">".$apcms['LANGUAGE']['ADMIN_MAINPAGE']."</a><br />\n";
	$mainbox_content  = " <a class=\"adminlinks\" href=\"".$apcms['baseURL']."?c=admin&amp;act=general_config\">".$apcms['LANGUAGE']['ADMIN_GENERAL_CONFIG']."</a><br />\n";
	$mainbox_content .= " <a class=\"adminlinks\" href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins\">".$apcms['LANGUAGE']['ADMIN_PLUGINS']."</a><br />\n";
	$mainbox_content .= " <a class=\"adminlinks\" href=\"".$apcms['baseURL']."?c=admin&amp;act=sidebars\">".$apcms['LANGUAGE']['ADMIN_SIDEBARMANAGEMENT']."</a><br />\n";
	$mainbox_content .= " <a class=\"adminlinks\" href=\"".$apcms['baseURL']."?c=admin&amp;act=user\">".$apcms['LANGUAGE']['ADMIN_USERMANAGEMENT']."</a><br />\n";
	$mainbox_content .= " <a class=\"adminlinks\" href=\"".$apcms['baseURL']."?c=admin&amp;act=groups\">".$apcms['LANGUAGE']['ADMIN_GROUPMANAGEMENT']."</a><br />\n";
	$lnav = new APC_Smarty($apcms['themesdir'].'/'.$THEME);
	$lnav->assign('navbox_head', $apcms['LANGUAGE']['ADMIN_NAVBOX_MAIN']);
	$lnav->assign('navbox_content', $mainbox_content);
	$lout = $lnav->fetch('navbox.tpl');
	$AdminSideBar .= "\n<br />\n".$lout;
	
	$smarty->assign('apcms_adminSideBar', $AdminSideBar);
	
	if (isset($_GET['act']) && trim($_GET['act']) != "") {
		$act = htmlspecialchars(urldecode(trim($_GET['act'])));
		$act = str_replace("./", "", $act);
		$act = str_replace("../", "", $act);
		$act = str_replace("..", "", $act);
		$ainclude = $act;
		$aincludefile = $PATH."/includes/".$act.".admin.inc.php";
	} else {
		$act = "main";
		$ainclude = "main";
		$aincludefile = $PATH."/includes/main.admin.inc.php";
	}
	
	$AOUT = "";
	if (!apcms_CheckAccess('admin_'.$act.'_access', $_SESSION['groups'])) {
		$error = $apcms['LANGUAGE']['ERROR_ACCESS_DENIED'];
		$apcms['redirect_url'] = $apcms['referer'];
		$apcms['redirect_time'] = 3;
	} else {
		include($aincludefile);
	}
	
	$COUT .= $AOUT;
}



?>