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
 * @subpackage libraries
 */

/*)\
\(*/



/**
 * Exit the script when IN_apcms_admin is not defined
 */
if (!defined('IN_apcms')) {
	exit;
}

if (isset($apcms['POST']['what'])) {
	switch ($apcms['POST']['what']) {
		
		case 'login':
			if(!isset($apcms['POST']['username']) || trim($apcms['POST']['username']) == "") {
				$error = $apcms['LANGUAGE']['ERROR_MISSING_USERNAME'];
				$_SESSION['groups'] = array(2);
			} elseif(!isset($apcms['POST']['password']) || trim($apcms['POST']['password']) == "") {
				$error = $apcms['LANGUAGE']['ERROR_MISSING_PASSWORD'];
				$_SESSION['groups'] = array(2);
			} else {
				$cpassword = apcms_CryptPasswd(trim($apcms['POST']['password']));
				$seluser = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['users']."` WHERE `nickname`='".apcms_ESC($apcms['POST']['username'])."' AND `password`='".apcms_ESC($cpassword)."'");
				if (isset($seluser[0]) && intval($seluser[0]) >= 1) {
					if (intval($seluser[7]) <= 0) {
						$error = $apcms['LANGUAGE']['ERROR_ACCOUNT_NOT_ACTIVATED'];
						$_SESSION['groups'] = array(2);
					} else {
						$userid = intval($seluser[0]);
						$nickname = stripslashes(trim($seluser[1]));
						$password = trim($apcms['POST']['password']);
						
						$db->unbuffered_query("UPDATE `".$apcms['table']['global']['users']."` SET `last_login`='".time()."' WHERE `id`='".$userid."'");
						
						$apcms['user']['id'] = $userid;
						$apcms['user']['nickname'] = $nickname;
						$apcms['user']['password'] = stripslashes(trim($seluser[2]));
						$apcms['user']['email'] = stripslashes(trim($seluser[3]));
						$apcms['user']['groups'] = unserialize(stripslashes(trim($seluser[4])));
						$apcms['user']['theme'] = stripslashes(trim($seluser[5]));
						$apcms['user']['language'] = stripslashes(trim($seluser[6]));
						
						$_SESSION['isloggedin'] = true;
						$_SESSION['userid'] = $userid;
						$_SESSION['nickname'] = $nickname;
						$_SESSION['email'] = $apcms['user']['email'];
						$_SESSION['groups'] = $apcms['user']['groups'];
						$_SESSION['theme'] = $apcms['user']['theme'];
						$_SESSION['language'] = $apcms['user']['language'];
						
						setcookie("apcms[userid]", "$userid", time()+intval($apcms['sesslifetime']));
						setcookie("apcms[nickname]", "$nickname", time()+intval($apcms['sesslifetime']));
						setcookie("apcms[password]", "$cpassword", time()+intval($apcms['sesslifetime']));
						
						$apcms['redirect_url'] = $apcms['referer'];
						$apcms['redirect_time'] = 3;
						$success = $apcms['LANGUAGE']['SUCCESS_LOGGED_IN'];
					}
				} else {
					$error = $apcms['LANGUAGE']['ERROR_USER_UNKNOWN'];
					$_SESSION['groups'] = array(2);
					$apcms['redirect_url'] = $apcms['referer'];
					$apcms['redirect_time'] = 3;
				}
			}
			break;
		
		
		
		
		case 'logout':
			unset($apcms['user']);
			session_unset();
			session_destroy();
			setcookie("apcms[userid]", "", time()-999);
			setcookie("apcms[nickname]", "", time()-999);
			$_SESSION['groups'] = array(2);
			$apcms['redirect_url'] = $apcms['referer'];
			$apcms['redirect_time'] = 3;
			$success = $apcms['LANGUAGE']['SUCCESS_LOGGED_OUT'];
			break;
		
		
		
		
		case 'sendpassword':
			if(!isset($apcms['POST']['username']) || trim($apcms['POST']['username']) == "") {
				$error = $apcms['LANGUAGE']['ERROR_MISSING_USERNAME'];
				$c = "password";
				$include = "password";
				$includefile = $PATH."/includes/password.inc.php";
			} else {
				$seluser = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['users']."` WHERE `nickname`='".apcms_ESC($apcms['POST']['username'])."'");
				if (isset($seluser[0]) && intval($seluser[0]) >= 1) {
					$password = apcms_GenRandomString(6);
					$cpassword = apcms_CryptPasswd($password);
					$db->unbuffered_query("UPDATE `".$apcms['table']['global']['users']."` SET `password`='".apcms_ESC($cpassword)."' WHERE `id`='".intval($seluser[0])."'");
					
					
					$fromname = apcms_Strip($apcms['emailfrom']);
					$frommail = apcms_Strip($apcms['emailadress']);
					
					$toname = apcms_Strip($seluser[1]);
					$tomail = apcms_Strip($seluser[3]);
					
					$subject = str_replace("{username}", apcms_Strip($apcms['POST']['username']), $apcms['LANGUAGE']['PASSWORD_EMAIL_SUBJECT']);
					$subject = str_replace("{baseurl}", $apcms['baseURL'], $subject);
					$subject = str_replace("{title}", $apcms['title'], $subject);
					
					$body = $apcms['LANGUAGE']['PASSWORD_EMAIL_BODY'];
				
					$body = str_replace("{username}", apcms_Strip($apcms['POST']['username']), $body);
					$body = str_replace("{password}", $password, $body);
					$body = str_replace("{baseurl}", $apcms['baseURL'], $body);
					$body = str_replace("{title}", $apcms['title'], $body);
					
					$from    = "$fromname <$frommail>";
					$to      = "$toname <$tomail>";
					$headers  = "From: $from\r\n";
					$headers .= "Reply-To: $frommail\r\n";
					$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n\r\n";
					mail("$to", "$subject", "$body", "$headers");
					
					$apcms['redirect_url'] = $apcms['POST']['referer'];
					$apcms['redirect_time'] = 4;
					$success = $apcms['LANGUAGE']['SUCCESS_PASSWORD_SENT'];
					unset($_SESSION['regref']);
					
					
				} else {
					$error = $apcms['LANGUAGE']['ERROR_USER_UNKNOWN'];
					$_SESSION['groups'] = array(2);
					$apcms['redirect_url'] = $apcms['POST']['referer'];
					$apcms['redirect_time'] = 3;
				}
			}
			break;
		
		
		
		case 'profile':
			$newpassword = 0;
			if ((isset($apcms['POST']['password1']) && trim($apcms['POST']['password1']) != "") || (isset($apcms['POST']['password2']) && trim($apcms['POST']['password1']) != "")) {
				if((isset($apcms['POST']['password1']) && trim($apcms['POST']['password1']) != "") && (!isset($apcms['POST']['password2']) || trim($apcms['POST']['password1']) == "")) {
					$error = $apcms['LANGUAGE']['ERROR_MISSING_SECOND_PASSWORD'];
				} elseif((isset($apcms['POST']['password2']) && trim($apcms['POST']['password2']) != "") && (!isset($apcms['POST']['password1']) || trim($apcms['POST']['password1']) == "")) {
					$error = $apcms['LANGUAGE']['ERROR_MISSING_FIRST_PASSWORD'];
				} else {
					if(trim($apcms['POST']['password2']) != trim($apcms['POST']['password1'])) {
						$error = $apcms['LANGUAGE']['ERROR_PASSWORDS_DOESNT_MATCH'];
					} else {
						$password = trim($apcms['POST']['password2']);
						$cpassword = apcms_CryptPasswd($password);
						$newpassword = 1;
					}
				}
			}
			
			if (!isset($error) || trim($error) == "") {
				
				$query = "UPDATE `".$apcms['table']['global']['users']."` SET ";
				
				if ($newpassword == 1 && trim($cpassword) != "") {
					$query .= "				`password`='".apcms_Strip($cpassword)."', ";
				}
				$query .= "				`theme`='".apcms_ESC(apcms_Strip($apcms['POST']['theme']))."', 
										`language`='".apcms_ESC(apcms_Strip($apcms['POST']['lang']))."'
								WHERE	`id`='".intval($_SESSION['userid'])."'";
				$db->unbuffered_query($query);
				$success = $apcms['LANGUAGE']['SUCCESS_PROFILE_SAVEd'];
			}
			
			
			
			
			
			
			
			
			break;
		
		
		
		
		case 'register':
			if(!isset($apcms['POST']['username']) || trim($apcms['POST']['username']) == "") {
				$error = $apcms['LANGUAGE']['ERROR_MISSING_USERNAME'];
				$c = "register";
				$include = "register";
				$includefile = $PATH."/includes/register.inc.php";
			} elseif(!isset($apcms['POST']['password1']) || trim($apcms['POST']['password1']) == "") {
				$error = $apcms['LANGUAGE']['ERROR_MISSING_FIRST_PASSWORD'];
				$c = "register";
				$include = "register";
				$includefile = $PATH."/includes/register.inc.php";
			} elseif(!isset($apcms['POST']['password2']) || trim($apcms['POST']['password2']) == "") {
				$error = $apcms['LANGUAGE']['ERROR_MISSING_SECOND_PASSWORD'];
				$c = "register";
				$include = "register";
				$includefile = $PATH."/includes/register.inc.php";
			} elseif(trim($apcms['POST']['password2']) != trim($apcms['POST']['password1'])) {
				$error = $apcms['LANGUAGE']['ERROR_PASSWORDS_DOESNT_MATCH'];
				$c = "register";
				$include = "register";
				$includefile = $PATH."/includes/register.inc.php";
			} elseif(!isset($apcms['POST']['email']) || trim($apcms['POST']['email']) == "") {
				$error = $apcms['LANGUAGE']['ERROR_MISSING_EMAIL'];
				$c = "register";
				$include = "register";
				$includefile = $PATH."/includes/register.inc.php";
			} elseif(!apcms_ValidateEmail($apcms['POST']['email'])) {
				$error = $apcms['LANGUAGE']['ERROR_EMAIL_NOT_CORRECT'];
				$c = "register";
				$include = "register";
				$includefile = $PATH."/includes/register.inc.php";
			} else {
				
				$sel = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['users']."` WHERE `nickname`='".apcms_ESC($apcms['POST']['username'])."'");
				if (isset($sel[0]) && intval($sel[0]) >= 1) {
					$error = $apcms['LANGUAGE']['ERROR_NICK_ALREADY_REGISTERED'];
					$c = "register";
					$include = "register";
					$includefile = $PATH."/includes/register.inc.php";
				} else {
					$sel = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['users']."` WHERE `email`='".apcms_ESC($apcms['POST']['email'])."'");
					if (isset($sel[0]) && intval($sel[0]) >= 1) {
						$error = $apcms['LANGUAGE']['ERROR_EMAIL_ALREADY_REGISTERED'];
						$c = "register";
						$include = "register";
						$includefile = $PATH."/includes/register.inc.php";
					} else {
						$cpassword = apcms_CryptPasswd(trim($apcms['POST']['password1']));
						$actkey = apcms_GenRandomString(8);
						$INSERT = "INSERT INTO `".$apcms['table']['global']['users']."` 
											 (
												`nickname`, 
												`password`, 
												`email`, 
												`groups`, 
												`actkey`,
												`regdate` 
									) VALUES ( 
												'".apcms_ESC($apcms['POST']['username'])."', 
												'".apcms_ESC($cpassword)."', 
												'".apcms_ESC($apcms['POST']['email'])."', 
												'a:1:{i:0;i:3;}', 
												'".apcms_ESC($actkey)."', 
												'".time()."' 
									) ";
						$db->unbuffered_query($INSERT);
						
						$fromname = apcms_Strip($apcms['emailfrom']);
						$frommail = apcms_Strip($apcms['emailadress']);
						
						$toname = apcms_Strip($apcms['POST']['username']);
						$tomail = apcms_Strip($apcms['POST']['email']);
						
						$subject = str_replace("{username}", apcms_Strip($apcms['POST']['username']), $apcms['LANGUAGE']['REGISTER_ACTMAIL_SUBJECT']);
						$subject = str_replace("{baseurl}", $apcms['baseURL'], $subject);
						
						$body = $apcms['LANGUAGE']['REGISTER_ACTMAIL_BODY'];
					
						$body = str_replace("{username}", apcms_Strip($apcms['POST']['username']), $body);
						$body = str_replace("{acturl}", $apcms['baseURL']."?c=activate&amp;key=".$actkey, $body);
						
						$from    = "$fromname <$frommail>";
						$to      = "$toname <$tomail>";
						$headers  = "From: $from\r\n";
						$headers .= "Reply-To: $frommail\r\n";
						$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n\r\n";
						mail("$to", "$subject", "$body", "$headers");
						
						$apcms['redirect_url'] = $apcms['POST']['referer'];
						$apcms['redirect_time'] = 10;
						$success = $apcms['LANGUAGE']['SUCCESS_REGISTERED'];
						unset($_SESSION['regref']);
					}
				}
			}
			break;
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
}



if (isset($apcms['GET']['what'])) {
	switch ($apcms['GET']['what']) {
		
		case 'logout':
			unset($apcms['user']);
			session_unset();
			session_destroy();
			setcookie("apcms[userid]", "", time()-999);
			setcookie("apcms[nickname]", "", time()-999);
			$_SESSION['groups'] = array(2);
			$apcms['redirect_url'] = $apcms['referer'];
			$apcms['redirect_time'] = 3;
			$success = $apcms['LANGUAGE']['SUCCESS_LOGGED_OUT'];
			break;
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
}

?>