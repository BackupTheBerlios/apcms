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
$PAGE_TITLE			= $apcms['LANGUAGE']['REGISTER_TITLE'];
/**
 * Sets the Subtitle of the page
 */
$PAGE_SUBTITLE 		= $apcms['LANGUAGE']['REGISTER_SUBTITLE'];
$smarty->caching = false;
$smarty->cache_lifetime = 1800;

if (!isset($_SESSION['regref'])) {
	$_SESSION['regref'] = $apcms['referer'];
}

$COUT .= "\n<div id=\"content1\">\n";
$COUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
$COUT .= "		<tr class=\"content2\">\n";
$COUT .= "			<td>\n";
$COUT .= "				".$apcms['LANGUAGE']['REGISTER_DESCRIPTION']."\n";
$COUT .= "			</td>\n";
$COUT .= "		</tr>\n";
$COUT .= "	</table>\n";
$COUT .= "</div><br />\n";


$COUT .= "\n<div id=\"content1\">\n";
$COUT .= "<form name=\"registerform\" action=\"".$apcms['baseURL']."?c=register\" method=\"post\">\n";
$COUT .= "<input type=\"hidden\" name=\"apcms[referer]\" value=\"".$_SESSION['regref']."\" />\n";
$COUT .= "<input type=\"hidden\" name=\"apcms[what]\" value=\"register\" />\n";
$COUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";

/** This sets the focus into the field with the given id */
$smarty->assign('fieldid', 'username');

$COUT .= "		<tr class=\"content2\">\n";
$COUT .= "			<td valign=\"top\">\n";
$COUT .= "				<label for=\"username\" accesskey=\"u\" tabindex=\"1\">".$apcms['LANGUAGE']['GLOBAL_USERNAME']."</label> <b>*</b>\n";
$COUT .= "			</td>\n";
$COUT .= "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
$COUT .= "				<input id=\"username\" onfocus=\"formInUse=true;\" type=\"text\" name=\"apcms[username]\" value=\"".(isset($apcms['POST']['username'])?$apcms['POST']['username']:'')."\" style=\"width:100%\" />\n";
$COUT .= "			</td>\n";
$COUT .= "		</tr>\n";

$COUT .= "		<tr class=\"content2\">\n";
$COUT .= "			<td valign=\"top\">\n";
$COUT .= "				<label for=\"password1\" accesskey=\"1\" tabindex=\"2\">".$apcms['LANGUAGE']['GLOBAL_PASSWORD']."</label> <b>*</b>\n";
$COUT .= "			</td>\n";
$COUT .= "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
$COUT .= "				<input id=\"password1\" onfocus=\"formInUse=true;\" type=\"password\" name=\"apcms[password1]\" value=\"".(isset($apcms['POST']['password1'])?$apcms['POST']['password1']:'')."\" style=\"width:100%\" />\n";
$COUT .= "			</td>\n";
$COUT .= "		</tr>\n";

$COUT .= "		<tr class=\"content2\">\n";
$COUT .= "			<td valign=\"top\">\n";
$COUT .= "				<label for=\"password2\" accesskey=\"2\" tabindex=\"3\">".$apcms['LANGUAGE']['GLOBAL_PASSWORD']."</label> <b>*</b><br /><span class=\"small_desc\">".$apcms['LANGUAGE']['REGISTER_PASSWORD_TWICE']."</span>\n";
$COUT .= "			</td>\n";
$COUT .= "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
$COUT .= "				<input id=\"password2\" onfocus=\"formInUse=true;\" type=\"password\" name=\"apcms[password2]\" value=\"".(isset($apcms['POST']['password2'])?$apcms['POST']['password2']:'')."\" style=\"width:100%\" />\n";
$COUT .= "			</td>\n";
$COUT .= "		</tr>\n";

$COUT .= "		<tr class=\"content2\">\n";
$COUT .= "			<td valign=\"top\">\n";
$COUT .= "				<label for=\"email\" accesskey=\"e\" tabindex=\"4\">".$apcms['LANGUAGE']['REGISTER_EMAIL']."</label> <b>*</b>\n";
$COUT .= "			</td>\n";
$COUT .= "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
$COUT .= "				<input id=\"email\" onfocus=\"formInUse=true;\" type=\"text\" name=\"apcms[email]\" value=\"".(isset($apcms['POST']['email'])?$apcms['POST']['email']:'')."\" style=\"width:100%\" />\n";
$COUT .= "			</td>\n";
$COUT .= "		</tr>\n";

$COUT .= "		<tr>\n";
$COUT .= "			<td colspan=\"2\" align=\"center\">
						<label for=\"submit\" accesskey=\"s\" tabindex=\"5\">
							<input id=\"submit\" onfocus=\"formInUse=true;\" type=\"submit\" name=\"apcms[submit]\" value=\"".$apcms['LANGUAGE']['REGISTER_SUBMIT']."\" />
						</label>
					</td>\n";
$COUT .= "		</tr>\n";

$COUT .= "	</table>\n";
$COUT .= "</form>\n";
$COUT .= "</div><br />\n";






























?>