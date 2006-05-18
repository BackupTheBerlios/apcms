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
 * $Id: step.4.php,v 1.3 2006/05/18 10:48:44 dma147 Exp $
 */

/*)\
\(*/


if (!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = 'de';
}
include("./setup/lang/".$_SESSION['lang'].".lang.".$SUFFIX);
$sidebar = '';



if (isset($_POST['step']) && intval($_POST['step']) == 4) {
	
	if (!isset($_SESSION['form']['hostname']) || trim($_SESSION['form']['hostname']) == "") {
		$error = $apcms['LANGUAGE']['STEP1_NO_HOSTNAME'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=1';
		$redirect_time = 3;
	
	} elseif (!isset($_SESSION['form']['username']) || trim($_SESSION['form']['username']) == "") {
		$error = $apcms['LANGUAGE']['STEP1_NO_USERNAME'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=1';
		$redirect_time = 3;
	
	} elseif (!isset($_SESSION['form']['password']) || trim($_SESSION['form']['password']) == "") {
		$error = $apcms['LANGUAGE']['STEP1_NO_PASSWORD'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=1';
		$redirect_time = 3;
	
	} elseif (!isset($_SESSION['form']['database']) || trim($_SESSION['form']['database']) == "") {
		$error = $apcms['LANGUAGE']['STEP1_NO_DATABASE'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=1';
		$redirect_time = 3;
	
	} elseif (!isset($_SESSION['form']['admin_username']) || trim($_SESSION['form']['admin_username']) == "") {
		$error = $apcms['LANGUAGE']['STEP2_NO_USERNAME'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=2';
		$redirect_time = 3;
	
	} elseif (!isset($_SESSION['form']['admin_password']) || trim($_SESSION['form']['admin_password']) == "") {
		$error = $apcms['LANGUAGE']['STEP2_NO_PASSWORD'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=2';
		$redirect_time = 3;
	
	} elseif (!isset($_SESSION['form']['admin_email']) || trim($_SESSION['form']['admin_email']) == "") {
		$error = $apcms['LANGUAGE']['STEP2_NO_EMAIL'];
		$redirect_url = $apcms['baseURL'].'apcms_installer.'.$SUFFIX.'?setup[step]=2';
		$redirect_time = 3;
	
	}
	
	
	
	include("./setup/header.".$SUFFIX);
	
	
	if (!isset($error) || trim($error) == "") {
		
		echo "Starte Installation...";
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
	
	
	include("./setup/footer.".$SUFFIX);
}





?>