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
 * $Id: step.4.php,v 1.11 2006/05/18 12:27:49 dma147 Exp $
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



if (isset($_POST['step']) && intval($_POST['step']) == 4) {
	@ob_flush();
	
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
	@ob_flush();
	
	if (!isset($_SESSION['form']['prefix']) || trim($_SESSION['form']['prefix']) == "") {
		$_SESSION['form']['prefix'] = 'apcms';
	}
	if (!isset($_SESSION['form']['uniue']) || trim($_SESSION['form']['uniue']) == "") {
		$_SESSION['form']['uniue'] = 1;
	}
	
	include("./setup/header.".$SUFFIX);
	@ob_flush();
	
	if (!isset($error) || trim($error) == "") {
		@ob_flush();
		echo "<b>".$apcms['LANGUAGE']['STEP4_STARTING_INSTALLATION']."</b><br />\n<br />\n";
		@ob_flush();
		
		
        $MYSQLDATA['HOST']      =       trim($_SESSION['form']['hostname']);
        $MYSQLDATA['USER']      =       trim($_SESSION['form']['username']);
        $MYSQLDATA['PASSWD']    =       trim($_SESSION['form']['password']);
        $MYSQLDATA['DB']        =       trim($_SESSION['form']['database']);
        $MYSQLDATA['PREFIX']    =       trim($_SESSION['form']['prefix']);
        $MYSQLDATA['UNIQUE']    =       intval(trim($_SESSION['form']['uniue']));
		if ((isset($MYSQLDATA['PREFIX']) && trim($MYSQLDATA['PREFIX']) != "") || (isset($MYSQLDATA['UNIQUE']) && trim($MYSQLDATA['UNIQUE']) != "")) {
			$ptrenner = "_";
		} else {
			$ptrenner = "";
		}
        $prefix = $MYSQLDATA['PREFIX'].$ptrenner.$MYSQLDATA['UNIQUE'].$ptrenner;
		
		@ob_flush();
		usleep(100000);;
		@ob_flush();
		
		echo " &nbsp;<span style=\"font-weight:bolder;color:green\">*</span> &nbsp;".$apcms['LANGUAGE']['DEF_CONNECTING_DB']." \"...<br />";
		@ob_flush();
		include("./libs/database.func.".$SUFFIX);
		@ob_flush();
		
		@ob_flush();
		usleep(100000);;
		@ob_flush();
		$fdir = opendir("./setup/sql");
		while ($sql = readdir($fdir)) {
			if (is_file("./setup/sql/".$sql)) {
				include("./setup/sql/".$sql);
				@ob_flush();
				usleep(100000);;
				@ob_flush();
				@ob_flush();
			}
			@ob_flush();
		}
		closedir($fdir);
		@ob_flush();
		
		@ob_flush();
		usleep(100000);;
		@ob_flush();
		
		$cpassword = apcms_CryptPasswd(trim($_SESSION['form']['admin_password']));
		echo " &nbsp;<span style=\"font-weight:bolder;color:green\">*</span> &nbsp;".$apcms['LANGUAGE']['DEF_INSERTING_ADIMIN']." \"...<br />";
		$INSERT = "INSERT INTO `apcms_1_global_users` (
						`nickname`, 
						`password`, 
						`email`, 
						`groups`, 
						`theme`, 
						`language`, 
						`active`, 
						`actkey`, 
						`regdate`, 
						`last_login`
			) VALUES (
						'".apcms_ESC(apcms_Strip($_SESSION['form']['admin_username']))."', 
						'".$cpassword."', 
						'".apcms_ESC(apcms_Strip($_SESSION['form']['admin_email']))."', 
						'a:1:{i:0;i:1;}', 
						'default', 
						'".$_SESSION['lang']."', 
						1, 
						'', 
						'".time()."', 
						0
			)";
		$db->unbuffered_query($INSERT);
		@ob_flush();
		usleep(100000);;
		@ob_flush();
		
		
		
		
		
		
		
		
		
		
		
		
		@ob_flush();
	}
	@ob_flush();
	
	include("./setup/footer.".$SUFFIX);
	@ob_flush();
}




@ob_flush();
?>