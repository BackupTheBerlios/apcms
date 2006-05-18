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
 * $Id: step.3.php,v 1.7 2006/05/18 12:03:25 dma147 Exp $
 */

/*)\
\(*/


@ob_flush();
if (!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = 'de';
}
include("./setup/lang/".$_SESSION['lang'].".lang.".$SUFFIX);
@ob_flush();
$sidebar = '';



if (isset($_POST['step']) && intval($_POST['step']) == 3) {
	@ob_flush();
	
	foreach($_POST['form'] AS $key => $val) {
		$_SESSION['form'][$key] = $val;
	}
	
	if (!isset($_POST['form']['admin_username']) || trim($_POST['form']['admin_username']) == "") {
		$error = $apcms['LANGUAGE']['STEP2_NO_USERNAME'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=2';
		$redirect_time = 3;
	
	} elseif (!isset($_POST['form']['admin_password']) || trim($_POST['form']['admin_password']) == "") {
		$error = $apcms['LANGUAGE']['STEP2_NO_PASSWORD'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=2';
		$redirect_time = 3;
	
	} elseif (!isset($_POST['form']['admin_email']) || trim($_POST['form']['admin_email']) == "") {
		$error = $apcms['LANGUAGE']['STEP2_NO_EMAIL'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=2';
		$redirect_time = 3;
	
	}
	@ob_flush();
	
	
	include("./setup/header.".$SUFFIX);
	@ob_flush();
	
	if (!isset($error) || trim($error) == "") {
		@ob_flush();
		
		echo $apcms['LANGUAGE']['STEP3_FINAL_CHECK']."<br />\n<br />\n";
		@ob_flush();
		
		echo "\n<div id=\"content1\">\n";
		echo "<form name=\"setupform\" action=\"".$_SERVER['PHP_SELF']."?setup[step]=4\" method=\"post\">\n";
		echo "	<input type=\"hidden\" name=\"step\" value=\"4\" />\n";
		echo "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP1_HOSTNAME']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">".(isset($_SESSION['form']['hostname'])&&trim($_SESSION['form']['hostname'])!=""?$_SESSION['form']['hostname']:'localhost')."</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP1_USERNAME']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">".(isset($_SESSION['form']['username'])&&trim($_SESSION['form']['username'])!=""?$_SESSION['form']['username']:'')."</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP1_PASSWORD']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">[".$apcms['LANGUAGE']['hidden']."]</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP1_DATABASE']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">".(isset($_SESSION['form']['database'])&&trim($_SESSION['form']['database'])!=""?$_SESSION['form']['database']:'apcms')."</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP1_PREFIX']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">".(isset($_SESSION['form']['prefix'])&&trim($_SESSION['form']['prefix'])!=""?$_SESSION['form']['prefix']:'apcms')."</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP1_UNIQUE']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">".(isset($_SESSION['form']['unique'])&&trim($_SESSION['form']['unique'])!=""?$_SESSION['form']['unique']:'1')."</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td colspan=\"2\"><hr size=\"1\" noshade=\"noshade\"></td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP2_ADMIN_USERNAME']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">".(isset($_SESSION['form']['admin_username'])&&trim($_SESSION['form']['admin_username'])!=""?$_SESSION['form']['admin_username']:'')."</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP2_ADMIN_PASSWORD']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">[".$apcms['LANGUAGE']['hidden']."]</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td valign=\"top\"><b>".$apcms['LANGUAGE']['STEP2_ADMIN_EMAIL']."</b></td>\n";
		echo "			<td width=\"230\" align=\"right\" valign=\"top\">".(isset($_SESSION['form']['admin_email'])&&trim($_SESSION['form']['admin_email'])!=""?$_SESSION['form']['admin_email']:'')."</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr class=\"content2\">\n";
		echo "			<td colspan=\"2\">".$apcms['LANGUAGE']['STEP3_FINAL_CHECK2']."</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "		<tr>\n";
		echo "			<td colspan=\"2\" align=\"center\">
								<label for=\"submit\" accesskey=\"s\" tabindex=\"4\">
									<input id=\"submit\" type=\"submit\" name=\"submit\" value=\"".$apcms['LANGUAGE']['START_INSTALLATION']."\" />
								</label>
							</td>\n";
		echo "		</tr>\n";
		@ob_flush();
		
		echo "	</table>\n";
		echo "</form>\n";
		echo "</div><br />\n";
		@ob_flush();
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
	
	
	include("./setup/footer.".$SUFFIX);
}

@ob_flush();

?>