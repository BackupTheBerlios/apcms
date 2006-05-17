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
 * $Id: password.inc.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
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
 * Sets the title of the page
 */
$PAGE_TITLE			= $apcms['LANGUAGE']['PASSWORD_TITLE'];
/**
 * Sets the Subtitle of the page
 */
$PAGE_SUBTITLE 		= $apcms['LANGUAGE']['PASSWORD_SUBTITLE'];
$smarty->caching = false;
$smarty->cache_lifetime = 1800;


if (!isset($_SESSION['regref'])) {
	$_SESSION['regref'] = $apcms['referer'];
}

$COUT .= "\n<div id=\"content1\">\n";
$COUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
$COUT .= "		<tr class=\"content2\">\n";
$COUT .= "			<td>\n";
$COUT .= "				".$apcms['LANGUAGE']['PASSWORD_DESCRIPTION']."\n";
$COUT .= "			</td>\n";
$COUT .= "		</tr>\n";
$COUT .= "	</table>\n";
$COUT .= "</div><br />\n";


$COUT .= "\n<div id=\"content1\">\n";
$COUT .= "<form name=\"registerform\" action=\"".$apcms['baseURL']."?c=password\" method=\"post\">\n";
$COUT .= "<input type=\"hidden\" name=\"apcms[referer]\" value=\"".$_SESSION['regref']."\" />\n";
$COUT .= "<input type=\"hidden\" name=\"apcms[what]\" value=\"sendpassword\" />\n";
$COUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";

$COUT .= "		<tr class=\"content2\">\n";
$COUT .= "			<td valign=\"top\">\n";
$COUT .= "				".$apcms['LANGUAGE']['GLOBAL_USERNAME']."\n";
$COUT .= "			</td>\n";
$COUT .= "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
$COUT .= "				<input type=\"text\" name=\"apcms[username]\" value=\"".(isset($apcms['POST']['username'])?$apcms['POST']['username']:'')."\" style=\"width:100%\" />\n";
$COUT .= "			</td>\n";
$COUT .= "		</tr>\n";

$COUT .= "		<tr>\n";
$COUT .= "			<td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"apcms[submit]\" value=\"".$apcms['LANGUAGE']['GLOBAL_SEND_PASSWORD']."\" /></td>\n";
$COUT .= "		</tr>\n";

$COUT .= "	</table>\n";
$COUT .= "</form>\n";
$COUT .= "</div><br />\n";






























?>