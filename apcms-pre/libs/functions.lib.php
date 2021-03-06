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
 * 
 * $Id: functions.lib.php,v 1.3 2006/05/17 21:21:44 dma147 Exp $
 */

/*)\
\(*/



/**
 * Exit the script when IN_apcms_admin is not defined
 */
if (!defined('IN_apcms')) {
	exit;
}


/**
 * Make apcms emit an error message and terminate the script
 *
 * @access public
 * @param string HTML code to die with
 * @return null
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_die($msg) {
	global $apcms;
    die('<html>
            <head>
            	<title>! APCms: Error !</title>
            </head>
            <body>'.$msg.'</body>
        </html>');
}


/**
 * Crypt a string with md5
 *
 * @access public
 * @param string The string to crypt
 * @return string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_CryptPasswd($pwd) { 
	$cpwd = md5($pwd); 
	return $cpwd; 
} 



/**
 * Checks an email adress 
 *
 * @param          string $email email to test
 * @access         private
 * @return         bool
 * @author         Alexander Mieland
 * @copyright      2000-2004 by APP - Another PHP Program
 */
function apcms_ValidateEmail($email) {
	if (eregi("^[0-9a-z_]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,4}$", $email, $check)) {
		if ( getmxrr(substr(strstr($check[0], '@'), 1), $validate_email_temp) ) {
			return TRUE;
		}
		if(checkdnsrr(substr(strstr($check[0], '@'), 1),"ANY")) {
			return TRUE;
		}
		return TRUE;
	}
	return FALSE;
}




/** Numeric (0-9) */
define( "PWD_ALLOW_NUM", ( 1 << 0 ));
/** lower case alphanumeric (a-z) */
define( "PWD_ALLOW_LC",  ( 1 << 1 ));
/** upper case alphanumeric (A-Z) */
define( "PWD_ALLOW_UC",  ( 1 << 2 ));
/** numeric and lower case alphanumeric (0-9,a-z) */
define( "PWD_ALLOW_DFLT", ( PWD_ALLOW_NUM | PWD_ALLOW_LC ));
/** all numeric and alphanumeric */
define( "PWD_ALLOW_ALL", ( PWD_ALLOW_NUM | PWD_ALLOW_LC  | PWD_ALLOW_UC ));

/**
 * GGenerates a random string with specific length
 *
 * @param          int $pwdLen Length of the random string
 * @param          const $usables alowed characters
 * @access         private
 * @return         string
 * @author         Alexander Mieland
 * @copyright      2000-2004 by APP - Another PHP Program
 */
function apcms_GenRandomString($pwdLen=32,$usables=PWD_ALLOW_ALL) {
	$pwdSource = "";
	$STRING = "";
	if ( $usables & ( 1 << 0 ))     $pwdSource .= "1234567890";
	if ( $usables & ( 1 << 1 ))     $pwdSource .= "abcdefghijklmnopqrstuvwxyz";
	if ( $usables & ( 1 << 2 ))     $pwdSource .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	srand ((double) microtime() * 1000000);
	while ( $pwdLen ) {
		srand ((double) microtime() * 1000000);
		$STRING .= substr( $pwdSource, rand( 0, strlen( $pwdSource )), 1);
		$pwdLen--;
	}
	if (strlen($STRING) <= ($pwdLen-1)) {
		$dif = $pwdLen - strlen($STRING);
		srand ((double) microtime() * 1000000);
		while ( $dif ) {
			srand ((double) microtime() * 1000000);
			$STRING .= substr( $pwdSource, rand( 0, strlen( $pwdSource )), 1);
			$dif--;
		}
	}
	if (strlen($STRING) <= ($pwdLen-1)) {
		$dif = $pwdLen - strlen($STRING);
		srand ((double) microtime() * 1000000);
		while ( $dif ) {
			srand ((double) microtime() * 1000000);
			$STRING .= substr( $pwdSource, rand( 0, strlen( $pwdSource )), 1);
			$dif--;
		}
	}
	return $STRING;
}







/**
 * Strips some dangerous content out of strings
 *
 * @access public
 * @param string The string to strip
 * @return string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_Strip($string, $leavetags=0) { 
	$string = str_replace("\t", "", $string);
	$string = str_replace("\r", "", $string);
	$string = str_replace("\n", "", $string);
	$string = str_replace("\0", "", $string);
	if ($leavetags == 0) {
		$string = strip_tags($string);
		$string = htmlspecialchars($string);
	}
	$string = trim($string);
	return $string;
} 


/**
 * Escapes the string for inserting it into the database
 *
 * @access public
 * @param string The string to strip
 * @return string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_ESC($string) {
	$string = trim($string);
	if(function_exists('mysql_real_escape_string')) {
		$string = mysql_real_escape_string($string);
	} else {
		$string = mysql_escape_string($string);
	}
	return $string;
} 




/**
 * Checks if the given groups have access
 *
 * @access private
 * @return void
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_CheckAccess($action, $groups=array()) {
	global $db, $apcms;
	$selact = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['rights']."` WHERE `action`='".apcms_ESC($action)."'");
	if (isset($selact) && count($selact) >= 1) {
		$allowed_groups = unserialize(stripslashes(trim($selact[2])));
		for ($a=0;$a<count($groups);$a++) {
			if (in_array(intval($groups[$a]), $allowed_groups)) {
				return true;
			}
		}
		return false;
	} else {
		return true;
	}
}




/**
 * Creates and returns some boxes
 *
 * @access public
 * @return string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_DisplayBoxContent($what='loginform') {
	global $apcms;
	$box = '';
	
	switch ($what) {
		
		case 'loginform':
			if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
				$box .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
				$box .= "	<tr>\n";
				$box .= "		<td>".$apcms['LANGUAGE']['GLOBAL_LOGGED_IN_AS'].$_SESSION['nickname']."<br />".$_SESSION['email']."</td>\n";
				$box .= "	</tr>\n";
				$box .= "	<tr>\n";
				$box .= "		<td>&nbsp;</td>\n";
				$box .= "	</tr>\n";
				$box .= "	<tr>\n";
				$box .= "		<td>
									<img src=\"".$apcms['themesurl']."/images/navpoint.png\" border=\"0\" alt=\"\" title=\"\" align=\"absmiddle\" /><span class=\"logoutlink\"><a class=\"link\" href=\"".$apcms['baseURL']."?c=profile\">".$apcms['LANGUAGE']['USER_PROFILE']."</a></span><br />
									<img src=\"".$apcms['themesurl']."/images/navpoint.png\" border=\"0\" alt=\"\" title=\"\" align=\"absmiddle\" /><span class=\"logoutlink\"><a class=\"link\" href=\"".$apcms['baseURL']."?apcms[what]=logout\">".$apcms['LANGUAGE']['GLOBAL_LOGOUT']."</a></span>
								</td>\n";
				$box .= "	</tr>\n";
				$box .= "</table>\n";
			} else {
				$box .= "<form name=\"loginform\" action=\"".$apcms['baseURL']."?c=profile\" method=\"post\">\n";
				$box .= "<input type=\"hidden\" name=\"apcms[what]\" value=\"login\" />\n";
				$box .= "	<table width=\"100%\" border=\"0\"  cellspacing=\"0\" cellpadding=\"2\">\n";
				$box .= "		<tr>\n";
				$box .= "			<td>".$apcms['LANGUAGE']['GLOBAL_USERNAME']."</td>\n";
				$box .= "			<td><input type=\"text\" name=\"apcms[username]\" value=\"".(isset($apcms['POST']['username'])?$apcms['POST']['username']:'')."\" style=\"width:100%\" /></td>\n";
				$box .= "		</tr>\n";
				$box .= "		<tr>\n";
				$box .= "			<td>".$apcms['LANGUAGE']['GLOBAL_PASSWORD']."</td>\n";
				$box .= "			<td><input type=\"password\" name=\"apcms[password]\" value=\"".(isset($apcms['POST']['password'])?$apcms['POST']['password']:'')."\" style=\"width:100%\" /></td>\n";
				$box .= "		</tr>\n";
				$box .= "		<tr>\n";
				$box .= "			<td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"apcms[submit]\" value=\"".$apcms['LANGUAGE']['GLOBAL_LOGIN']."\" /></td>\n";
				$box .= "		</tr>\n";
				$box .= "		<tr>\n";
				$box .= "			<td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
				$box .= "		</tr>\n";
				$box .= "		<tr>\n";
				$box .= "			<td colspan=\"2\">\n";
				$box .= "				<img src=\"".$apcms['themesurl']."/images/navpoint.png\" border=\"0\" alt=\"\" title=\"\" align=\"absmiddle\" /><span class=\"logoutlink\"><a class=\"link\" href=\"".$apcms['baseURL']."?c=register\">".$apcms['LANGUAGE']['GLOBAL_REGISTER']."</a></span><br />\n";
				$box .= "				<img src=\"".$apcms['themesurl']."/images/navpoint.png\" border=\"0\" alt=\"\" title=\"\" align=\"absmiddle\" /><span class=\"logoutlink\"><a class=\"link\" href=\"".$apcms['baseURL']."?c=password\">".$apcms['LANGUAGE']['GLOBAL_PASSWORD_FORGOTTEN']."</a></span>\n";
				$box .= "			</td>\n";
				$box .= "		</tr>\n";
				$box .= "	</table>\n";	
				$box .= "</form>\n";
			}
			break;
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
	return $box;
}






/**
 * Fetches a complete Webpage from a given URI
 *
 * @access public
 * @return array
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_GetHTML($url) { 
    global $errno, $errstr, $apcms, $db;
    $url=trim($url);
    if(!isset($url)) return ''; 
    $status['html'] = '';
    $urlArray = parse_url($url); 
    if (!isset($urlArray['port']))  
        $urlArray['port'] = "80"; 
    if (!isset($urlArray['path']))  
        $urlArray['path'] = "/";
	if (ereg("\?", $url)) {
		$parts = explode("?", $url);
		$urlArray['path'] .= "?".$parts[1];
	}
    $sock = fsockopen($urlArray['host'], $urlArray['port'], $errno, $errstr, 2); 
    if (!$sock) { 
        $status['code'] = "Dead"; 
        $status['contentType'] = ''; 
        $status['html'] = ''; 
        $status['msg'] = ''; 
	} else { 
        $dump = "GET ".$urlArray['path']." HTTP/1.1\r\n"; 
		$dump .= "User-Agent: APCms/".$apcms['version']." (title: ".$apcms['title'].")\r\n";
		$dump .= "Referer: ".$apcms['baseURL']."\r\n";
		$dump .= "Host: ".$urlArray['host']."\r\n\r\n";
        fputs($sock, $dump); 
        socket_set_timeout($sock, 2); 
        while ($str = fgets($sock, 1024)) { 
            $status['html'] .= $str; 
            if (eregi("^http/[0-9]+.[0-9]+ ([0-9]{3}) [a-z ]*", $str)) { 
                $status['code'] = trim(eregi_replace("^http/[0-9]+.[0-9]+ ([0-9]{3})[a-z ]*", "\\1", $str)); 
			} 
            if (eregi("^Content-Type: ", $str)) { 
                $status['contentType'] = trim(eregi_replace("^Content-Type: ", "", $str)); 
			}
		} 
	} 
    fclose($sock); 
    if (!isset($status['code']) || trim($status['code'])=="") 
        $status['code'] = "Dead"; 
    if (!isset($status['contentType']) || trim($status['contentType']) == "") 
        $status['contentType'] = ""; 
    return $status; 
} 




/**
 * Deletes a complete directory with its contents (recursive)
 *
 * @param          string $sourcedir
 * @access         private
 * @return         array
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_DeleteDirectory($sourcedir) {
	
	if (!is_dir($sourcedir)) {
		return unlink($sourcedir);
	}
	
	$filearray = array();
	$sourcedir .= "/";
	$handle = @opendir($sourcedir);
	while ($eintrag = @readdir($handle)) {
		$target = $sourcedir.$eintrag;
		if (is_dir($target) && $eintrag != "." && $eintrag != "..") {
			@unlink($target);
			$slashpos = strrpos($target, "/");
			if ($slashpos) {
				$deldir = substr($target, 0, $slashpos);
				@rmdir($deldir);
			}
			$filearray[$target] = DeleteDirectory($target);
			@unlink($target);
			$slashpos = strrpos($target, "/");
			if ($slashpos) {
				$deldir = substr($target, 0, $slashpos);
				@rmdir($deldir);
			}
		} elseif ($eintrag != "." && $eintrag != "..") {
			$filearray[] = $eintrag;
			@unlink($target);
			$slashpos = strrpos($target, "/");
			if ($slashpos) {
				$deldir = substr($target, 0, $slashpos);
				@rmdir($deldir);
			}
		}
	}
	@closedir($handle);
	return $filearray;
}





/**
 * Chmodes a complete directory with its contents (recursive)
 *
 * @param          string $sourcedir
 * @access         private
 * @return         array
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_ChmodDirectory($sourcedir, $mode=777) {
	
	$filemode = '0'.$mode;
	$filemode = octdec($filemode);
	
	if (!is_dir($sourcedir)) {
		return chmod($sourcedir, $filemode);
	}
	
	$filearray = array();
	$sourcedir .= "/";
	$handle = @opendir($sourcedir);
	while ($eintrag = @readdir($handle)) {
		$target = $sourcedir.$eintrag;
		if (is_dir($target) && $eintrag != "." && $eintrag != "..") {
			@chmod($target, $filemode);
			$slashpos = strrpos($target, "/");
			if ($slashpos) {
				$chmoddir = substr($target, 0, $slashpos);
				@chmod($chmoddir, $filemode);
			}
			$filearray[$target] = apcms_ChmodDirectory($target, $mode);
			@chmod($target, $filemode);
			$slashpos = strrpos($target, "/");
			if ($slashpos) {
				$chmoddir = substr($target, 0, $slashpos);
				@chmod($chmoddir, $filemode);
			}
		} elseif ($eintrag != "." && $eintrag != "..") {
			$filearray[] = $eintrag;
			@chmod($target, $filemode);
			$slashpos = strrpos($target, "/");
			if ($slashpos) {
				$chmoddir = substr($target, 0, $slashpos);
				@chmod($chmoddir, $filemode);
			}
		}
	}
	@closedir($handle);
	return $filearray;
}






/**
 * simple Textoutput
 *
 * @param string $string Der Posting-Text
 * @access private
 * @return string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_simpleTextOut($string) {
	global $apcms, $db;
	$string = trim(strip_tags($string));
	$string=str_replace ("\r", "", $string);
	$string=str_replace ("\l", "", $string);
	$string=str_replace ("\c", "", $string);
	$string=str_replace ("\s", "", $string);
	$string=str_replace("\t","&nbsp;&nbsp;",$string);
	$string=str_replace ("\n", "<br />\n", $string);
	return $string;
}






/**
 * Advanced BBCode
 *
 * @param string $string Der Posting-Text
 * @access private
 * @return string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function apcms_TextOut($string) {
	global $apcms, $db;
	$string = trim(strip_tags($string));
	
	
	$string=eregi_replace("([ \r\n])http://([a-z0-9\._-]+\.[a-z]{2,4}[^ \r\n]+)","\\1[url]http://\\2[/url]",$string);
	$string=eregi_replace("([ \r\n])https://([a-z0-9\._-]+\.[a-z]{2,4}[^ \r\n]+)","\\1[url]https://\\2[/url]",$string);
	$string=eregi_replace("([ \r\n])ftp://([a-z0-9\._-]+\.[a-z]{2,4}[^ \r\n]+)","\\1[url]ftp://\\2[/url]",$string);
	$string=eregi_replace("([ \r\n])(www\.[a-z0-9_-]+\.[a-z]{2,4}[^ \\\"\r\n]*)","\\1[url=http://\\2]\\2[/url]",$string);
	$string=eregi_replace("^http://([a-z0-9\._-]+\.[a-z]{2,4}[^ \r\n]*)","[url]http://\\1[/url]",$string);
	$string=eregi_replace("^https://([a-z0-9\._-]+\.[a-z]{2,4}[^ \r\n]*)","[url]https://\\1[/url]",$string);
	$string=eregi_replace("^ftp://([a-z0-9\._-]+\.[a-z]{2,4}[^ \r\n]*)","[url]ftp://\\1[/url]",$string);
	$string=eregi_replace("^www\.([a-z0-9\._-]+\.[a-z]{2,4}[^ \r\n]*)","[url=http://www.\\1]www.\\1[/url]",$string);
	
	$string=eregi_replace("\\[url\\]www\.([^\\[]*)\\[img\\]www\.([^\\[\\?\\&]*)\\[/img\\]\\[/url\\]","<a href=\"http://www.\\1\"><img src=\"http://www.\\2\" border=\"0\" alt=\"\" title=\"\" /></a>",$string);
	$string=eregi_replace("\\[url\\]http://([^\\[]*)\\[img\\]http://([^\\[\\?\\&]*)\\[/img\\]\\[/url\\]","<a href=\"http://\\1\"><img src=\"http://\\2\" border=\"0\" alt=\"\" title=\"\" /></a>",$string);
	$string=eregi_replace("\\[url\\]www\.([^\\[]*)\\[/url\\]","<a href=\"http://www.\\1\">\\1</a>",$string);
	$string=eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\">\\1</a>",$string);
	$string=eregi_replace("\\[url=\&quot;","[url=\"",$string);
	$string=eregi_replace("\\&quot;\\]","\"]",$string);
	$string=eregi_replace("\\[url=([^\\[]+)\\]([^\\[]+)\\[\\/url\\]","<a href=\"\\1\">\\2</a>",$string);
	$string=eregi_replace("\\[email\\]([^\\[]+)\\[/email\\]","<a href=\"mailto:\\1\">\\1</a>",$string);
	$string=eregi_replace("\\[email=([^\\[]+)\\]([^\\[]+)\\[\\/email\\]","<a href=\"mailto:\\1\">\\2</a>",$string);
	
	$string=eregi_replace("\\[list","[list",$string);
	$string=eregi_replace("\\[/list","[/list",$string);
	$string=str_replace("[list]","<ul type=square>",$string);
	$string=str_replace("[/list]","</ul>",$string);
	$string=str_replace("[list=1]","<ol type=1>",$string);
	$string=str_replace("[list=a]","<ol type=A>",$string);
	$string=str_replace("[list=A]","<ol type=A>",$string);
	$string=str_replace("[/list=1]","</ol>",$string);
	$string=str_replace("[/list=a]","</ol>",$string);
	$string=str_replace("[/list=A]","</ol>",$string);
	$string=str_replace("[*]","<li>",$string);
	$string=str_replace("[/*]","</li>",$string);
	$string=preg_replace("/\\[img\\](http(s?):\\/\\/)?((www.)?[A-Za-z0-9~._\\-\\/]+(\\.gif|\\.jpg|\\.png|\\.bmp))\\[\\/img\\]/i", "<img src=\"http\\2://\\3\" border=\"0\" alt=\"\" title=\"\" />", $string);
	$string=eregi_replace("quote\\]","quote]",$string);
	
	
	/** FIXME */
	$string=str_replace("[quote]\r\n",'<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="quotedtablerahmen"><tr><td><table width="100%" border="0" cellspacing="1" cellpadding="4"><tr><td class="quotedtablecontent">',$string);
	$string=str_replace("[quote]",'<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="quotedtablerahmen"><tr><td><table width="100%" border="0" cellspacing="1" cellpadding="4"><tr><td class="quotedtablecontent">',$string);
	$string=str_replace("[/quote]\r\n",'</td></tr></table></td></tr></table>',$string);
	$string=str_replace("[/quote]",'</td></tr></table></td></tr></table>',$string);
	
	
	$string=preg_replace("/(\[)(mark)(=)([#A-Za-z0-9]+)(])(.*)(\[\/mark\])/siU", "<span style=\"background-color: \\4\">\\6</span>", $string);
	$string=preg_replace("/(\[)(c)(=)([#A-Za-z0-9]+)(])(.*)(\[\/c\])/siU", "<span style=\"color:\\4\">\\6</span>", $string);
	$string=str_replace ("[d]", "<strike>", $string);
	$string=str_replace ("[D]", "<strike>", $string);
	$string=str_replace ("[/d]", "</strike>", $string);
	$string=str_replace ("[/D]", "</strike>", $string);
	$string=str_replace ("[b]", "<b>", $string);
	$string=str_replace ("[B]", "<b>", $string);
	$string=str_replace ("[/b]", "</b>", $string);
	$string=str_replace ("[/B]", "</b>", $string);
	$string=str_replace ("[u]", "<u>", $string);
	$string=str_replace ("[U]", "<u>", $string);
	$string=str_replace ("[/u]", "</u>", $string);
	$string=str_replace ("[/U]", "</u>", $string);
	$string=str_replace ("[i]", "<i>", $string);
	$string=str_replace ("[I]", "<i>", $string);
	$string=str_replace ("[/i]", "</i>", $string);
	$string=str_replace ("[/I]", "</i>", $string);
	$string=str_replace ("[d]", "<strike>", $string);
	$string=str_replace ("[/d]", "</strike>", $string);
	$string=str_replace ("[left]", "<div align=\"left\">", $string);
	$string=str_replace ("[/left]", "</div>", $string);
	$string=str_replace ("[right]", "<div align=\"right\">", $string);
	$string=str_replace ("[/right]", "</div>", $string);
	$string=str_replace ("[block]", "<div align=\"justify\">", $string);
	$string=str_replace ("[/block]", "</div>", $string);
	$string=str_replace ("[f1]", "<span style=\"font-size:0.8em\">", $string);
	$string=str_replace ("[f2]", "<span style=\"font-size:1.0em\">", $string);
	$string=str_replace ("[f3]", "<span style=\"font-size:1.1em\">", $string);
	$string=str_replace ("[f4]", "<span style=\"font-size:1.2em\">", $string);
	$string=str_replace ("[f5]", "<span style=\"font-size:1.3em\">", $string);
	$string=str_replace ("[br]", "<br>", $string);
	$string=str_replace ("[hr]", "<hr size=\"1\" noshade=\"noshade\" />", $string);
	$string=str_replace ("[verdana]", "<span style=\"font-family:Verdana, Arial, Helvetica, sans-serif\">", $string);
	$string=str_replace ("[arial]", "<span style=\"font-family:Arial, Helvetica, sans-serif\">", $string);
	$string=str_replace ("[courier]", "<span style=\"font-family:Courier New, Courier, monospace\">", $string);
	$string=str_replace ("[comic]", "<span style=\"font-family:Comic Sans MS\">", $string);
	$string=str_replace ("[terminal]", "<span style=\"font-family:Terminal, System\">", $string);
	$string=str_replace ("[/f]", "</span>", $string);
	$string=str_replace ("[/verdana]", "</span>", $string);
	$string=str_replace ("[/arial]", "</span>", $string);
	$string=str_replace ("[/courier]", "</span>", $string);
	$string=str_replace ("[/comic]", "</span>", $string);
	$string=str_replace ("[/f1]", "</span>", $string);
	$string=str_replace ("[/f2]", "</span>", $string);
	$string=str_replace ("[/f3]", "</span>", $string);
	$string=str_replace ("[/f4]", "</span>", $string);
	$string=str_replace ("[/f5]", "</span>", $string);
	$string=str_replace ("[blue]", "<span style=\"color:#0000FF\">", $string);
	$string=str_replace ("[/blue]", "</span>", $string);
	$string=str_replace ("[red]", "<span style=\"color:#FF0000\">", $string);
	$string=str_replace ("[/red]", "</span>", $string);
	$string=str_replace ("[green]", "<span style=\"color:#00FF00\">", $string);
	$string=str_replace ("[/green]", "</span>", $string);
	$string=str_replace ("[yellow]", "<span style=\"color:#ffff00\">", $string);
	$string=str_replace ("[/yellow]", "</span>", $string);
	$string=str_replace ("[white]", "<span style=\"color:#ffffff\">", $string);
	$string=str_replace ("[/white]", "</span>", $string);
	$string=str_replace ("[black]", "<span style=\"color:#000000\">", $string);
	$string=str_replace ("[/black]", "</span>", $string);
	$string=str_replace ("[center]", "<div align=\"center\">", $string);
	$string=str_replace ("[/center]", "</div>", $string);
	$string=str_replace ("\r", "", $string);
	$string=str_replace ("\l", "", $string);
	$string=str_replace ("\c", "", $string);
	$string=str_replace ("\s", "", $string);
	$string=str_replace("\t","&nbsp;&nbsp;",$string);
	$string=str_replace ("\n", "<br />\n", $string);
	return $string;
}






/** 
 * Calvulates the maximum alowed uploadsize
 * 
 * @access private
 * @return array
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_MaxUploadSize() { 
	$post_max_size = ini_get('post_max_size');
	$upload_max_filesize = ini_get('upload_max_filesize');
	if (eregi("G", $post_max_size)) {
		$pmfs1 = str_replace("G","",$post_max_size)." GBytes";
		$post_max_size = str_replace("G","",$post_max_size) * 1000000000;
	} elseif (eregi("M", $post_max_size)) {
		$pmfs1 = str_replace("M","",$post_max_size)." MBytes";
		$post_max_size = str_replace("M","",$post_max_size) * 1000000;
	} elseif (eregi("K", $post_max_size)) {
		$pmfs1 = str_replace("K","",$post_max_size)." KBytes";
		$post_max_size = str_replace("K","",$post_max_size) * 1000;
	}
	if (eregi("G", $upload_max_filesize)) {
		$pmfs2 = str_replace("G","",$upload_max_filesize)." GBytes";
		$upload_max_filesize = str_replace("G","",$upload_max_filesize) * 1000000000;
	} elseif (eregi("M", $upload_max_filesize)) {
		$pmfs2 = str_replace("M","",$upload_max_filesize)." MBytes";
		$upload_max_filesize = str_replace("M","",$upload_max_filesize) * 1000000;
	} elseif (eregi("K", $upload_max_filesize)) {
		$pmfs2 = str_replace("K","",$upload_max_filesize)." KBytes";
		$upload_max_filesize = str_replace("K","",$upload_max_filesize) * 1000;
	}
	if ($post_max_size == $upload_max_filesize) {
		$MAX_FILE_SIZE = $post_max_size;
		$FORMATED_MAX_FILE_SIZE = $pmfs1;
	} elseif ($post_max_size < $upload_max_filesize) {
		$MAX_FILE_SIZE = $post_max_size;
		$FORMATED_MAX_FILE_SIZE = $pmfs1;
	} elseif ($post_max_size > $upload_max_filesize) {
		$MAX_FILE_SIZE = $upload_max_filesize;
		$FORMATED_MAX_FILE_SIZE = $pmfs2;
	}
	$array['MAX_FILE_SIZE'] = $MAX_FILE_SIZE;
	$array['FORMATED_MAX_FILE_SIZE'] = $FORMATED_MAX_FILE_SIZE;
	return $array;
}





/** 
 * Gets the version string of the actual used gdlib
 * 
 * @access private
 * @return string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_getGDVersion() { 
	if (function_exists("gd_info")) { 
		$gd_info = gd_info(); 
		@reset ($gd_info); 
		while (@list ($key, $val) = @each ($gd_info)) { 
			if (eregi("ver", $key)) { 
				$STRING = $gd_info[$key]; 
				break 1; 
			} 
		} 
		$STRING = str_replace("bundled","",$STRING); 
		$STRING = str_replace("compatible","",$STRING); 
		$STRING = str_replace(" ","",$STRING); 
		$STRING = str_replace("(","",$STRING); 
		$STRING = str_replace(")","",$STRING); 
		$STRING = str_replace("<","",$STRING); 
		$STRING = str_replace(">","",$STRING); 
		$STRING = str_replace("=","",$STRING); 
		$STRING = "".$STRING; 
		$gdversion = $STRING; 
	} else { 
		ob_start(); 
		$oldlevel=error_reporting(0); 
		phpinfo(); 
		error_reporting($oldlevel); 
		$buffer=ob_get_contents(); 
		ob_end_clean(); 
		$quot1 = preg_quote('<b>GD Version</b>'); 
		$STRING=preg_replace("|(.*)(".$quot1.")(.*)|siU", "\\3", $buffer); 
		$quot2 = preg_quote('</td><td align="left">'); 
		$quot3 = preg_quote('</td></tr>'); 
		$STRING=preg_replace("|(".$quot2.")(.*)(".$quot3.")(.*)|siU", "\\2", $STRING); 
		$firstpos = strpos($STRING, "\n"); 
		$STRING = substr($STRING, 0, $firstpos); 
		if (eregi(" or higher", $STRING)) { 
			$STRING = str_replace(" or higher", "", $STRING); 
		} elseif (eregi("or higher", $STRING)) { 
			$STRING = str_replace("or higher", "", $STRING); 
		} 
		$STRING = "".$STRING; 
		$gdversion = $STRING; 
	} 
	return $gdversion; 
} 





/** 
 * Checks if gdlib supports truecolor
 * 
 * @access private
 * @return bool
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_haveTCSupport() { 
	if (function_exists("imagecreatetruecolor")) { 
		if (!$tmp = ImageCreateTrueColor (10, 10)) { 
			$tcsupport = false; 
		} else { 
			$testcolor = ImageColorAllocate ($tmp, 211, 167, 168); 
			ImageFill ($tmp, 0, 0, $testcolor); 
			$cindex = imagecolorat ($tmp, 4, 4); 
			if ($cindex != $testcolor) { 
				$tcsupport = false; 
			} else { 
				$tcsupport = true; 
			} 
			ImageDestroy($tmp); 
		} 
	} else { 
		$tcsupport = false; 
	} 
	return $tcsupport; 
} 





/** 
 * Checks if gdlib supports truetype fonts
 * 
 * @access private
 * @return bool
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_haveTTFSupport() { 
	if (function_exists("ImageTTFText")) { 
		$ttfsupport = true; 
	} else { 
		$ttfsupport = false; 
	} 
	return $ttfsupport; 
} 






/** 
 * Checks if gdlib supports xpm images
 * 
 * @access private
 * @return bool
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_haveXPMSupport() {
	if (!defined("IMG_XPM")) {
		$xpmsupport = false; 
	} else {
		if (ImageTypes() & IMG_XPM) { 
			$xpmsupport = true; 
		} else { 
			$xpmsupport = false; 
		}
	}
	return $xpmsupport; 
} 






/** 
 * Checks if gdlib supports xbm images
 * 
 * @access private
 * @return bool
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_haveXBMSupport() { 
	if (!defined("IMG_XBM")) {
		$xbmsupport = false; 
	} else {
		if (ImageTypes() & IMG_XBM) { 
			$xbmsupport = true; 
		} else { 
			$xbmsupport = false; 
		}
	}
	return $xbmsupport; 
} 






/** 
 * Checks if gdlib supports wbmp images
 * 
 * @access private
 * @return bool
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_haveWBMPSupport() { 
	if (!defined("IMG_WBMP")) {
		$wbmpsupport = false; 
	} else {
		if (ImageTypes() & IMG_WBMP) { 
			$wbmpsupport = true; 
		} else { 
			$wbmpsupport = false; 
		} 
	}
	return $wbmpsupport; 
} 






/** 
 * Checks if gdlib supports jpeg images
 * 
 * @access private
 * @return bool
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_haveJPEGSupport() { 
	if (!defined("IMG_JPG")) {
		$jpegsupport = false; 
	} else {
		if (ImageTypes() & IMG_JPG) { 
			$jpegsupport = true; 
		} else { 
			$jpegsupport = false; 
		} 
	}
	return $jpegsupport; 
} 






/** 
 * Checks if gdlib supports png images
 * 
 * @access private
 * @return bool
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_havePNGSupport() { 
	if (!defined("IMG_PNG")) {
		$pngsupport = false; 
	} else {
		if (ImageTypes() & IMG_PNG) { 
			$pngsupport = true; 
		} else { 
			$pngsupport = false; 
		} 
	}
	return $pngsupport; 
} 






/** 
 * Checks if gdlib supports gif images
 * 
 * @access private
 * @return bool
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_haveGIFSupport() { 
	if (!defined("IMG_GIF")) {
		$gifsupport = false; 
	}else {
		if (ImageTypes() & IMG_GIF) { 
			$gifsupport = true; 
		} else { 
			$gifsupport = false; 
		} 
	}
	return $gifsupport; 
} 






/** 
 * Scales an image in size
 * 
 * @param string $image complete path to the image
 * @param int $maxwidth maximum width
 * @param int $maxheight maximum height 
 * @param  int $dontrename Should the picture be renamed after resizing?
 * @access private
 * @return string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */ 
function apcms_ImageResize($image, $maxwidth=100, $maxheight=100, $dontrename=0) { 
	$lastpoint = strrpos($image, '.'); 
	$withoutext = substr($image, 0, $lastpoint); 
	$ext = substr($image, ($lastpoint+1), strlen($image)); 
	$imagedata = GetImageSize($image); 
	if ($imagedata[2] == 1)		{ $sim = ImageCreateFromGIF($image); } 
	elseif ($imagedata[2] == 2)	{ $sim = ImageCreateFromJPEG($image); } 
	elseif ($imagedata[2] == 3)	{ $sim = ImageCreateFromPNG($image); } 
	if ($imagedata[0] > $maxwidth || $imagedata[1] > $maxheight) { 
		if ($imagedata[0] > $maxwidth) { 
			$factor_width = round(($imagedata[0] / $maxwidth), 2); 
			$newwidth = $maxwidth; 
			$newheight = round(($imagedata[1] / $factor_width)); 
		} else { 
			$newwidth = $imagedata[0]; 
			$newheight = $imagedata[1]; 
		} 
		if ($newheight > $maxheight) { 
			$factor_height = round(($newheight / $maxheight), 2); 
			$newwidth = round(($newwidth / $factor_height)); 
			$newheight = $maxheight; 
		} 
	} elseif ($imagedata[0] < $maxwidth || $imagedata[1] < $maxheight) { 
		if ($imagedata[0] < $maxwidth) { 
			$factor_width = round(($maxwidth / $imagedata[0]), 2); 
			$newwidth = $maxwidth; 
			$newheight = round(($imagedata[1] * $factor_width)); 
		} else { 
			$newwidth = $imagedata[0]; 
			$newheight = $imagedata[1]; 
		} 
		if ($newheight < $maxheight) { 
			$factor_height = round(($maxheight / $newheight), 2); 
			$newwidth = round(($newwidth * $factor_height)); 
			$newheight = $maxheight; 
		} 
		if ($newwidth > $maxwidth) { 
			$factor_width = round(($newwidth / $maxwidth), 2); 
			$newwidth = $maxwidth; 
			$newheight = round(($newheight / $factor_width)); 
		} elseif ($newheight > $maxheight) { 
			$factor_height = round(($newheight / $maxheight), 2); 
			$newwidth = round(($newwidth / $factor_height)); 
			$newheight = $maxheight; 
		} 
	} else { 
		$newwidth = $imagedata[0]; 
		$newheight = $imagedata[1]; 
	} 
	
	if ($dontrename>=1) {
		$newimage = $withoutext.'.'.$ext; 
		@unlink($newimage);
	} else {
		$newimage = $withoutext.'.thumb.'.$newwidth.'x'.$newheight.'.'.$ext; 
	}
	
	if (!file_exists($newimage)) {
		if (ap_haveTCSupport()) { 
			$dim = ImageCreateTrueColor($newwidth, $newheight); 
		} else { 
			$dim = ImageCreate($newwidth, $newheight); 
			} 
		imagecopyresampled ($dim, $sim, 0, 0, 0, 0, $newwidth, $newheight, $imagedata[0], $imagedata[1]); 
		if ($imagedata[2] == 1) { 
			imageGIF($dim, $newimage); 
		} elseif ($imagedata[2] == 2) { 
			imageJPEG($dim, $newimage, 80); 
		} elseif ($imagedata[2] == 3) { 
			imagePNG($dim, $newimage); 
		} 
		imageDestroy($dim); 
	}
	imageDestroy($sim); 
	$ARRAY['image'] = $newimage;
	$ARRAY['data'] = "width=\"".$newwidth."\" height=\"".$newheight."\"";
	$ARRAY['width'] = intval($newwidth);
	$ARRAY['height'] = intval($newheight);
	return $ARRAY; 
} 





/**
 * formats the filesize string
 *
 * @param          int $bytes the number of bytes
 * @access         private
 * @return         string
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
function ap_GetFormattedBytes($bytes) {
	$spacebytes = $bytes;
	$spacekb = @round($bytes/1000,3);
	if (!isset($spacekb) OR $spacekb <= 0) {
		$spacekb = @round($bytes/1000);
	}
	$spacemb = @round((($bytes/1000)/1000),3);
	if (!isset($spacemb) OR $spacemb <= 0) {
		$spacemb = @round((($bytes/1000)/1000));
	}
	if (strlen($spacebytes) <= 6) {
		$RET = str_replace(".",",",$spacekb)." Kbyte(s)";
	} elseif (strlen($spacebytes) >= 7) {
		$RET = str_replace(".",",",$spacemb)." Mbyte(s)";
	} else {
		$RET = $spacebytes." Bytes";
	}
	return $RET;
}





?>