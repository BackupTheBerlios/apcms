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
 * $Id: profile.inc.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
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
$PAGE_TITLE			= $apcms['LANGUAGE']['USER_PROFILE_TITLE'];
/**
 * Sets the Subtitle of the page
 */
$PAGE_SUBTITLE 		= $apcms['LANGUAGE']['USER_PROFILE_SUBTITLE'];
$smarty->caching = false;
$smarty->cache_lifetime = 1800;

if (!isset($_SESSION['isloggedin']) || $_SESSION['isloggedin'] === false) {
	$error = $apcms['LANGUAGE']['ERROR_NOT_LOGGEDIN'];
	$_SESSION['groups'] = array(2);
	$apcms['redirect_url'] = $apcms['baseURL'];
	$apcms['redirect_time'] = 3;
} else {
	
	
	
	$COUT .= "\n<div id=\"content1\">\n";
	$COUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
	$COUT .= "		<tr class=\"content2\">\n";
	$COUT .= "			<td>\n";
	$COUT .= "				".$apcms['LANGUAGE']['USER_PROFILE_DESCRIPTION']."\n";
	$COUT .= "			</td>\n";
	$COUT .= "		</tr>\n";
	$COUT .= "	</table>\n";
	$COUT .= "</div><br />\n";
	
	
	$COUT .= "\n<div id=\"content1\">\n";
	$COUT .= "<form name=\"profileform\" action=\"".$apcms['baseURL']."?c=profile\" method=\"post\">\n";
	$COUT .= "<input type=\"hidden\" name=\"apcms[what]\" value=\"profile\" />\n";
	$COUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
	
	$COUT .= "		<tr class=\"content2\">\n";
	$COUT .= "			<td valign=\"top\">\n";
	$COUT .= "				<label for=\"username\" tabindex=\"-1\">".$apcms['LANGUAGE']['GLOBAL_USERNAME']."</label>\n";
	$COUT .= "			</td>\n";
	$COUT .= "			<td width=\"270\" align=\"right\" valign=\"top\">\n";
	$COUT .= "				<input id=\"username\" type=\"text\" name=\"apcms[username]\" value=\"".$_SESSION['nickname']."\" disabled=\"disabled\" readonly=\"readonly\" style=\"width:100%\" />\n";
	$COUT .= "			</td>\n";
	$COUT .= "		</tr>\n";
	
	$COUT .= "		<tr class=\"content2\">\n";
	$COUT .= "			<td valign=\"top\">\n";
	$COUT .= "				<label for=\"email\" tabindex=\"-1\">".$apcms['LANGUAGE']['GLOBAL_EMAIL']."</label>\n";
	$COUT .= "			</td>\n";
	$COUT .= "			<td width=\"270\" align=\"right\" valign=\"top\">\n";
	$COUT .= "				<input id=\"email\" type=\"text\" name=\"apcms[email]\" value=\"".$_SESSION['email']."\" disabled=\"disabled\" readonly=\"readonly\" style=\"width:100%\" />\n";
	$COUT .= "			</td>\n";
	$COUT .= "		</tr>\n";
	
	/** This sets the focus into the field with the given id */
	$smarty->assign('fieldid', 'password1');
	
	$COUT .= "		<tr class=\"content2\">\n";
	$COUT .= "			<td valign=\"top\">\n";
	$COUT .= "				<label for=\"password1\" accesskey=\"1\" tabindex=\"1\">".$apcms['LANGUAGE']['GLOBAL_PASSWORD']."</label>\n";
	$COUT .= "			</td>\n";
	$COUT .= "			<td width=\"270\" align=\"right\" valign=\"top\">\n";
	$COUT .= "				<input id=\"password1\" onfocus=\"formInUse=true;\" type=\"password\" name=\"apcms[password1]\" value=\"\" style=\"width:100%\" /><br /><span class=\"small_desc\">".$apcms['LANGUAGE']['USER_PROFILE_CHANGE_PASSWORD_DESC']."</span>\n";
	$COUT .= "			</td>\n";
	$COUT .= "		</tr>\n";
	
	$COUT .= "		<tr class=\"content2\">\n";
	$COUT .= "			<td valign=\"top\">\n";
	$COUT .= "				<label for=\"password2\" accesskey=\"2\" tabindex=\"2\">".$apcms['LANGUAGE']['GLOBAL_PASSWORD']."</label><br /><span class=\"small_desc\">".$apcms['LANGUAGE']['REGISTER_PASSWORD_TWICE']."</span>\n";
	$COUT .= "			</td>\n";
	$COUT .= "			<td width=\"270\" align=\"right\" valign=\"top\">\n";
	$COUT .= "				<input id=\"password2\" onfocus=\"formInUse=true;\" type=\"password\" name=\"apcms[password2]\" value=\"\" style=\"width:100%\" /><br /><span class=\"small_desc\">".$apcms['LANGUAGE']['USER_PROFILE_CHANGE_PASSWORD_DESC']."</span>\n";
	$COUT .= "			</td>\n";
	$COUT .= "		</tr>\n";
	
	$COUT .= "		<tr class=\"content2\">\n";
	$COUT .= "			<td valign=\"top\">\n";
	$COUT .= "				<label for=\"theme\" accesskey=\"t\" tabindex=\"3\">".$apcms['LANGUAGE']['USER_PROFILE_THEME']."</label>\n";
	$COUT .= "			</td>\n";
	$COUT .= "			<td width=\"270\" align=\"right\" valign=\"top\">\n";
	$COUT .= "				<select id=\"theme\" onfocus=\"formInUse=true;\" name=\"apcms[theme]\" style=\"width:100%\">\n";
	$fd = opendir($apcms['path']."/themes");
	while ($thistheme = readdir($fd)) {
		if (is_dir($apcms['path']."/themes/".$thistheme) && $thistheme != "." && $thistheme != "..") {
			if (apcms_Strip($thistheme) == apcms_Strip($_SESSION['theme'])) {
				$COUT .= "					<option value=\"".$thistheme."\" selected=\"selected\">".apcms_Strip($thistheme)."</option>\n";
			} else {
				$COUT .= "					<option value=\"".$thistheme."\">".apcms_Strip($thistheme)."</option>\n";
			}
		}
	}
	closedir($fd);
	$COUT .= "				</select>\n";
	$COUT .= "			</td>\n";
	$COUT .= "		</tr>\n";
	
	$COUT .= "		<tr class=\"content2\">\n";
	$COUT .= "			<td valign=\"top\">\n";
	$COUT .= "				<label for=\"lang\" accesskey=\"l\" tabindex=\"3\">".$apcms['LANGUAGE']['USER_PROFILE_LANGUAGE']."</label>\n";
	$COUT .= "			</td>\n";
	$COUT .= "			<td width=\"270\" align=\"right\" valign=\"top\">\n";
	$COUT .= "				<select id=\"lang\" onfocus=\"formInUse=true;\" name=\"apcms[lang]\" style=\"width:100%\">\n";
	$fd = opendir($apcms['path']."/lang");
	while ($thislang = readdir($fd)) {
		if (!is_dir($apcms['path']."/lang/".$thislang) && $thislang != "." && $thislang != "..") {
			$thislang = preg_replace("`^([^\.]+)\..*`", "\\1", $thislang);
			if (apcms_Strip($thislang) == apcms_Strip($_SESSION['language'])) {
				$COUT .= "					<option value=\"".$thislang."\" selected=\"selected\">".apcms_Strip($thislang)."</option>\n";
			} else {
				$COUT .= "					<option value=\"".$thislang."\">".apcms_Strip($thislang)."</option>\n";
			}
		}
	}
	closedir($fd);
	$COUT .= "				</select>\n";
	$COUT .= "			</td>\n";
	$COUT .= "		</tr>\n";
	
	$COUT .= "		<tr>\n";
	$COUT .= "			<td colspan=\"2\" align=\"center\">
							<label for=\"submit\" accesskey=\"s\" tabindex=\"4\">
								<input id=\"submit\" onfocus=\"formInUse=true;\" type=\"submit\" name=\"apcms[submit]\" value=\"".$apcms['LANGUAGE']['USER_PROFILE_SAVE']."\" />
							</label>
						</td>\n";
	$COUT .= "		</tr>\n";
	
	$COUT .= "	</table>\n";
	$COUT .= "</form>\n";
	$COUT .= "</div><br />\n";
	
	
	
	
	
}


?>