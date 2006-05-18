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
 * $Id: step.2.php,v 1.6 2006/05/18 10:20:31 dma147 Exp $
 */

/*)\
\(*/



if (!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = 'de';
}
include("./setup/lang/".$_SESSION['lang'].".lang.".$SUFFIX);
$sidebar = '';



if (isset($_POST['step']) && intval($_POST['step']) == 2) {
	
	foreach($_POST['form'] AS $key => $val) {
		$_SESSION['form'][$key] = $val;
	}
	
	if (!isset($_POST['form']['hostname']) || trim($_POST['form']['hostname']) == "") {
		$error = $apcms['LANGUAGE']['STEP1_NO_HOSTNAME'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=1';
		$redirect_time = 3;
	
	} elseif (!isset($_POST['form']['username']) || trim($_POST['form']['username']) == "") {
		$error = $apcms['LANGUAGE']['STEP1_NO_USERNAME'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=1';
		$redirect_time = 3;
	
	} elseif (!isset($_POST['form']['password']) || trim($_POST['form']['password']) == "") {
		$error = $apcms['LANGUAGE']['STEP1_NO_PASSWORD'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=1';
		$redirect_time = 3;
	
	} elseif (!isset($_POST['form']['database']) || trim($_POST['form']['database']) == "") {
		$error = $apcms['LANGUAGE']['STEP1_NO_DATABASE'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=1';
		$redirect_time = 3;
	
	}
	
	
	
	include("./setup/header.".$SUFFIX);
	
	
	if (!isset($error) || trim($error) == "") {
		$sidebar = $apcms['LANGUAGE']['STEP2_HINT1'];
		
		echo "\n<div id=\"content1\">\n";
		echo "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
		echo "		<tr class=\"content2\">\n";
		echo "			<td>\n";
		echo "				".$apcms['LANGUAGE']['STEP2_DESCRIPTION']."\n";
		echo "			</td>\n";
		echo "		</tr>\n";
		echo "	</table>\n";
		echo "</div><br />\n";
		
		
		echo "\n<div id=\"content1\">\n";
		echo "<form name=\"setupform\" action=\"".$_SERVER['PHP_SELF']."?setup[step]=3\" method=\"post\">\n";
		echo "	<input type=\"hidden\" name=\"step\" value=\"3\" />\n";
		echo "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\">\n";
		echo "				<label for=\"admin_username\" accesskey=\"u\" tabindex=\"1\">".$apcms['LANGUAGE']['STEP2_ADMIN_USERNAME']."</label>\n";
		echo "			</td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
		echo "				<input id=\"admin_username\" type=\"text\" name=\"form[admin_username]\" value=\"".(isset($_SESSION['form']['admin_username'])&&trim($_SESSION['form']['admin_username'])!=""?$_SESSION['form']['admin_username']:'')."\" style=\"width:100%\" />\n";
		echo "			</td>\n";
		echo "		</tr>\n";
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\">\n";
		echo "				<label for=\"admin_password\" accesskey=\"p\" tabindex=\"2\">".$apcms['LANGUAGE']['STEP2_ADMIN_PASSWORD']."</label>\n";
		echo "			</td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
		echo "				<input id=\"admin_password\" type=\"password\" name=\"form[admin_password]\" value=\"".(isset($_SESSION['form']['admin_password'])&&trim($_SESSION['form']['admin_password'])!=""?$_SESSION['form']['admin_password']:'')."\" style=\"width:100%\" />\n";
		echo "			</td>\n";
		echo "		</tr>\n";
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\">\n";
		echo "				<label for=\"admin_email\" accesskey=\"e\" tabindex=\"3\">".$apcms['LANGUAGE']['STEP2_ADMIN_EMAIL']."</label>\n";
		echo "			</td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
		echo "				<input id=\"admin_email\" type=\"text\" name=\"form[admin_email]\" value=\"".(isset($_SESSION['form']['admin_email'])&&trim($_SESSION['form']['admin_email'])!=""?$_SESSION['form']['admin_email']:'')."\" style=\"width:100%\" />\n";
		echo "			</td>\n";
		echo "		</tr>\n";
		
		
		
		echo "		<tr>\n";
		echo "			<td colspan=\"2\" align=\"center\">
								<label for=\"submit\" accesskey=\"s\" tabindex=\"4\">
									<input id=\"submit\" type=\"submit\" name=\"submit\" value=\"".$apcms['LANGUAGE']['CONTINUE']."\" />
								</label>
							</td>\n";
		echo "		</tr>\n";
		
		
		echo "	</table>\n";
		echo "</form>\n";
		echo "</div><br />\n";
		
	}
	
	
	include("./setup/footer.".$SUFFIX);
}



?>