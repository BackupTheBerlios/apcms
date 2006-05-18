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
 * $Id: step.3.php,v 1.3 2006/05/18 10:20:31 dma147 Exp $
 */

/*)\
\(*/


if (!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = 'de';
}
include("./setup/lang/".$_SESSION['lang'].".lang.".$SUFFIX);
$sidebar = '';



if (isset($_POST['step']) && intval($_POST['step']) == 3) {
	
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
	
	
	
	include("./setup/header.".$SUFFIX);
	
	
	if (!isset($error) || trim($error) == "") {
		
		echo $apcms['LANGUAGE']['STEP3_FINAL_CHECK']."<br />\n<br />\n";
		
		
		
		
		
		
		
		
	}
	
	
	include("./setup/footer.".$SUFFIX);
}


?>