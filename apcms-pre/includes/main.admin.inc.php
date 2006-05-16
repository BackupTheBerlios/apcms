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
$PAGE_SUBTITLE 		= '';

$AOUT .= "<h3>.: ".$apcms['LANGUAGE']['ADMINCENTER']." :.</h3><br />\n";


$AOUT .= "\n<div id=\"adminmain1\">\n";
$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td>\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_WELCOMEMSG1']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";
$AOUT .= "	</table>\n";
$AOUT .= "</div><br />\n";


$AOUT .= "\n<div id=\"adminmain1\">\n";
$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td colspan=\"2\">\n";
$AOUT .= "				<b>".$apcms['LANGUAGE']['ADMIN_SYSINFO']."</b>\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$return = apcms_GetHTML('http://www.php-programs.de/versions_backend.php?what=apcms');
$available_version = ereg_replace(".*\<version\>([^\<]+)\<\/version\>.*", "\\1", apcms_Strip($return['html'], 1));
$available_version = apcms_Strip($available_version);

if (version_compare($apcms['version'], $available_version, "<")) {
	// update available!
	$class_local = "red";
	$class_official = "green";
} elseif (version_compare($apcms['version'], $available_version, ">")) {
	// local version is newer than official available version
	$class_local = "green";
	$class_official = "";
} else {
	// Local version is the most actual version
	$class_local = "green";
	$class_official = "green";
}

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['SYSINFO_ACTVERSION']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\" class=".$class_local.">\n";
$AOUT .= "				".$apcms['version']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['SYSINFO_AVAILVERSION']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\" class=".$class_official.">\n";
$AOUT .= "				".$available_version."\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "	</table>\n";
$AOUT .= "</div><br />\n";



$AOUT .= "\n<div id=\"adminmain1\">\n";
$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td colspan=\"2\">\n";
$AOUT .= "				<b>".$apcms['LANGUAGE']['ADMIN_USERINFO']."</b>\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$retnumuser = $db->unbuffered_query_first("SELECT COUNT(*) FROM `".$apcms['table']['global']['users']."`");
if (isset($retnumuser[0]) && intval($retnumuser[0]) >= 1) {
	$num_regusers = intval($retnumuser[0]);
} else {
	$num_regusers = 0;
}
$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['SYSINFO_REGUSER']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				".$num_regusers."\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$retactnumuser = $db->unbuffered_query_first("SELECT COUNT(*) FROM `".$apcms['table']['global']['users']."` WHERE `active`='1'");
if (isset($retactnumuser[0]) && intval($retactnumuser[0]) >= 1) {
	$num_actregusers = intval($retactnumuser[0]);
} else {
	$num_actregusers = 0;
}
$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['SYSINFO_REGUSER_ACTIVE']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				".$num_actregusers."\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				".$apcms['LANGUAGE']['SYSINFO_REGUSER_INACTIVE']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				".($num_regusers - $num_actregusers)."\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";







/*
$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				&nbsp;\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				&nbsp;\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				&nbsp;\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				&nbsp;\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				&nbsp;\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				&nbsp;\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

$AOUT .= "		<tr class=\"adminmain2\">\n";
$AOUT .= "			<td valign=\"top\">\n";
$AOUT .= "				&nbsp;\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"170\" align=\"right\" valign=\"top\">\n";
$AOUT .= "				&nbsp;\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";
*/

$AOUT .= "	</table>\n";
$AOUT .= "</div><br />\n";























































?>