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
 * 
 * $Id: index.php,v 1.2 2006/05/17 11:47:34 dma147 Exp $
 */

/*)\
\(*/



/**
 * Defines the initial constant to prevent hacking 
 */
@define('IN_apcms', true);


if (isset($_GET['c']) && trim($_GET['c']) != "") {
	$c = htmlspecialchars(urldecode(trim($_GET['c'])));
	$c = str_replace("./", "", $c);
	$c = str_replace("../", "", $c);
	$c = str_replace("..", "", $c);
	$include = $c;
	$template = $c;
	$includefile = "./includes/".$c.".inc.php";
} else {
	$c = "main";
	$include = "main";
	$template = $c;
	$includefile = "./includes/main.inc.php";
}

///////////////////////////////////////////////////////////////////////////////

/** 
 * Include the global configuration 
 */
include("config.inc.php");

///////////////////////////////////////////////////////////////////////////////

/** 
 * Include the Smarty class 
 */
require_once($apcms['path']."/libs/smarty.class.".$SUFFIX);

/** 
 * initiating the smarty class
 */
$smarty = new APC_Smarty($apcms['themesdir'].'/'.$THEME);


$LeftSideBar = '';
$RightSideBar = '';

$retleft = $db->unbuffered_GetAll_row("SELECT * FROM `".$apcms['table']['global']['leftsidebar']."` WHERE `hidden` != '1' ORDER BY `sort`");
$cleft = count($retleft);
if ($cleft >= 1) {
	for($a=0;$a<$cleft;$a++) {
		$navbox_content = stripslashes(trim($retleft[$a][2]));
		
		unset($matches);
		preg_match_all ("/(\[)(php)(])(.*)(\[\/php\])/siU", $navbox_content, $matches);
		for ($countthis=0;$countthis<count($matches[0]);$countthis++) {
			unset($buffer);
			ob_start();
			$oldlevel=error_reporting(0);
			eval($matches[4][$countthis]);
			error_reporting($oldlevel);
			$buffer=ob_get_contents();
			ob_end_clean();
			$navbox_content = str_replace($matches[0][$countthis], $buffer, $navbox_content);
		}
		
		unset($matches);
		preg_match_all ("/(\[box=)([^\]]+)(\])/siU", $navbox_content, $matches);
		for ($countthis=0;$countthis<count($matches[0]);$countthis++) {
			$boxcontent = apcms_DisplayBoxContent($matches[2][$countthis]);
			$navbox_content = str_replace($matches[0][$countthis], $boxcontent, $navbox_content);
		}
		
		$lnav = new APC_Smarty($apcms['themesdir'].'/'.$THEME);
		$lnav->assign('navbox_head', apcms_Strip($retleft[$a][1]));
		$lnav->assign('navbox_content', $navbox_content);
		$lout = $lnav->fetch('navbox.tpl');
		$LeftSideBar .= $lout;
	}
}

$retright = $db->unbuffered_GetAll_row("SELECT * FROM `".$apcms['table']['global']['rightsidebar']."` WHERE `hidden` != '1' ORDER BY `sort`");
$cright = count($retright);
if ($cright >= 1) {
	for($a=0;$a<$cright;$a++) {
		$navbox_content = stripslashes(trim($retright[$a][2]));
		
		unset($matches);
		preg_match_all ("/(\[)(php)(])(.*)(\[\/php\])/siU", $navbox_content, $matches);
		for ($countthis=0;$countthis<count($matches[0]);$countthis++) {
			unset($buffer);
			ob_start();
			$oldlevel=error_reporting(0);
			eval($matches[4][$countthis]);
			error_reporting($oldlevel);
			$buffer=ob_get_contents();
			ob_end_clean();
			$navbox_content = str_replace($matches[0][$countthis], $buffer, $navbox_content);
		}
		
		unset($matches);
		preg_match_all ("/(\[box=)([^\]]+)(\])/siU", $navbox_content, $matches);
		for ($countthis=0;$countthis<count($matches[0]);$countthis++) {
			$boxcontent = apcms_DisplayBoxContent($matches[2][$countthis]);
			$navbox_content = str_replace($matches[0][$countthis], $boxcontent, $navbox_content);
		}
		
		$lnav = new APC_Smarty($apcms['themesdir'].'/'.$THEME);
		$lnav->assign('navbox_head', apcms_Strip($retright[$a][1]));
		$lnav->assign('navbox_content', $navbox_content);
		$lout = $lnav->fetch('navbox.tpl');
		$RightSideBar .= $lout;
	}
}

$smarty->assign('apcms_leftSideBar', $LeftSideBar);
$smarty->assign('apcms_rightSideBar', $RightSideBar);

$COUT = "";
if (!apcms_CheckAccess('global_access', $_SESSION['groups'])) {
	$error = $apcms['LANGUAGE']['ERROR_ACCESS_DENIED'];
	$apcms['redirect_url'] = $apcms['referer'];
	$apcms['redirect_time'] = 3;
} else {
	include($includefile);
}

$smarty->assign('CONTENT', "<br />".$COUT);

if (isset($PAGE_TITLE) && trim($PAGE_TITLE) != "") {
	$TITLE = $apcms['title']." - ".$PAGE_TITLE;
} else {
	$TITLE = $apcms['title'];
}

$smarty->assign('TITLE', $TITLE);
$smarty->assign('head_version', $apcms['version']);
$smarty->assign('head_title', $PAGE_TITLE);
$smarty->assign('head_subtitle', $PAGE_SUBTITLE);
$smarty->assign('SUBTITLE', $apcms['subtitle']);
$smarty->assign('DESCRIPTION', $apcms['description']);
$smarty->assign('THEME', $THEME);
$smarty->assign('THEMEDIR', $apcms['themesdir']."/".$THEME);
$smarty->assign('THEMEURL', $apcms['themesurl']);
$smarty->assign('apcms', $apcms);
$smarty->assign('apcms_Title', $TITLE);
$smarty->assign('apcms_Subtitle', $apcms['subtitle']);
$smarty->assign('apcms_Baseurl', $apcms['baseURL']);

if (isset($apcms['redirect_url']) && trim($apcms['redirect_url']) != "") {
	$smarty->assign('redirect_url', $apcms['redirect_url']);
	$smarty->assign('redirect_time', (isset($apcms['redirect_time'])&&intval($apcms['redirect_time'])>=1?$apcms['redirect_time']:'3') );
}
if (isset($error) && trim($error) != "") {
	$smarty->assign('error', $error);
}
if (isset($success) && trim($success) != "") {
	$smarty->assign('success', $success);
}

$apcms_aboveHeadBanner = '';
$apcms_belowHeadBanner = '';
$apcms_aboveFootBanner = '';
$apcms_belowCopyright = '';

$apcms_aboveHeadBanner = $hook->Get_aboveHeadBanner();
$apcms_belowHeadBanner = $hook->Get_belowHeadBanner();
$apcms_aboveFootBanner = $hook->Get_aboveFootBanner();
$apcms_belowCopyright = $hook->Get_belowCopyright();

if (isset($apcms_aboveHeadBanner) && trim($apcms_aboveHeadBanner) != "") {
	$smarty->assign('apcms_aboveHeadBanner', $apcms_aboveHeadBanner);
}
if (isset($apcms_belowHeadBanner) && trim($apcms_belowHeadBanner) != "") {
	$smarty->assign('apcms_belowHeadBanner', $apcms_belowHeadBanner);
}
if (isset($apcms_aboveFootBanner) && trim($apcms_aboveFootBanner) != "") {
	$smarty->assign('apcms_aboveFootBanner', $apcms_aboveFootBanner);
}
if (isset($apcms_belowCopyright) && trim($apcms_belowCopyright) != "") {
	$smarty->assign('apcms_belowCopyright', $apcms_belowCopyright);
}


/** 
 * The complete Output of the application is here
 */
$OUT = $smarty->fetch($template.'.tpl');

///////////////////////////////////////////////////////////////////////////////

@header('HTTP/1.0 200');
@header('X-Website: APCms');

echo $OUT;

///////////////////////////////////////////////////////////////////////////////

/*

$DEBUGOUT .= "<br />\n<br />\n<br />\n\n<pre>";
ob_start();
print_r($apcms);
$debug_apcms = ob_get_contents();
ob_end_clean();
ob_start();
print_r($_SESSION);
$debug_session = ob_get_contents();
ob_end_clean();
$DEBUGOUT .= "<strong>\$_SESSION:</strong>\n".$debug_session;
$DEBUGOUT .= "\n\n<strong>\$apcms:</strong>\n".$debug_apcms;
$DEBUGOUT .= "</pre>";
echo $DEBUGOUT;
$Benchmark->Stop();
$DEBUGOUT = "\n\n		<br />\n		<br />\n		This page was created in ".$Benchmark->BenchmarkTime()." seconds\n";
echo $DEBUGOUT;
*/

?>