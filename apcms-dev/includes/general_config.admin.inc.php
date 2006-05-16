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
 * Exit the script when IN_apcms_admin is not defined
 */
if (!defined('IN_apcms_admin')) {
	exit;
}

/**
 * Sets the Subtitle of the page
 */
$PAGE_SUBTITLE 		= $apcms['LANGUAGE']['ADMIN_GENERAL_CONFIG'];

$AOUT .= "<h3>.: ".$apcms['LANGUAGE']['ADMIN_GENERAL_CONFIG']." :.</h3><br />\n";

if (isset($_POST['save']) && intval($_POST['save']) >= 1) {
	$KEYS = "";
	foreach($apcms['POST'] AS $key => $val) {
		if ($KEYS != "") { $KEYS .= ", "; }
		$KEYS .= "`".apcms_ESC(apcms_Strip($key))."`='".apcms_ESC(apcms_Strip($val))."'";
	}
	$UPDATE = "UPDATE `".$apcms['table']['global']['config']."` SET ".$KEYS;
	$db->unbuffered_query($UPDATE);
	$success = $apcms['LANGUAGE']['SUCCESS_SAVED'];
	$apcms['redirect_url'] = $apcms['baseURL']."?c=admin";
	$apcms['redirect_time'] = 4;
	$retconf = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['config']."`");
	$apcms['title'] = htmlspecialchars(stripslashes(trim($retconf[0])));
	$apcms['subtitle'] = htmlspecialchars(stripslashes(trim($retconf[1])));
	$apcms['description'] = htmlspecialchars(stripslashes(trim($retconf[2])));
	$apcms['sesslifetime'] = intval($retconf[3]);
	$apcms['emailfrom'] = stripslashes(trim($retconf[4]));
	$apcms['emailadress'] = stripslashes(trim($retconf[5]));
}



$AOUT .= "\n<div id=\"adminmain1\">\n";
$AOUT .= "<form name=\"gcform\" action=\"".$apcms['baseURL']."?c=admin&amp;act=general_config\" method=\"post\">\n";
$AOUT .= "<input type=\"hidden\" name=\"save\" value=\"1\" />\n";
$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_GC_TITLE']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"300\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				<input type=\"text\" name=\"apcms[title]\" value=\"".$apcms['title']."\" style=\"width:100%\" />\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_GC_SUBTITLE']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"300\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				<input type=\"text\" name=\"apcms[subtitle]\" value=\"".$apcms['subtitle']."\" style=\"width:100%\" />\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_GC_DESCRIPTION']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"300\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				<textarea rows=\"4\" name=\"apcms[description]\" style=\"width:100%\">".$apcms['description']."</textarea>\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_GC_EMAILFROM']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"300\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				<input type=\"text\" name=\"apcms[emailfrom]\" value=\"".$apcms['emailfrom']."\" style=\"width:100%\" />\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_GC_EMAILMAIL']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"300\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				<input type=\"text\" name=\"apcms[emailadress]\" value=\"".$apcms['emailadress']."\" style=\"width:100%\" />\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_GC_SESSLIFETIME']."<br /><span class=\"small_desc\">".$apcms['LANGUAGE']['ADMIN_GC_SESSLIFETIME_EXT']."</span>\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"300\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				<input type=\"text\" name=\"apcms[sesslifetime]\" value=\"".$apcms['sesslifetime']."\" style=\"width:100%\" />\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";


$AOUT .= "		<tr>\n";
$AOUT .= "			<td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"submit\" value=\"".$apcms['LANGUAGE']['ADMIN_SAVE']."\" /></td>\n";
$AOUT .= "		</tr>\n";



$AOUT .= "	</table>\n";
$AOUT .= "</form>\n";
$AOUT .= "</div><br />\n";























































?>