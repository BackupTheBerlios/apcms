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
 * $Id: config.inc.php,v 1.2 2006/05/17 11:47:34 dma147 Exp $
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
 * ALL Notices, Warnings and errors will be showed 
 */
@error_reporting(E_ALL);


/** 
 * Set max_execution_time to 60 seconds 
 */
@set_time_limit(60);


/** 
 * Set magic_quotes_runtime to off
 */
@ini_set('magic_quotes_runtime', 'off');


/** 
 * Set the Path separator related to the used OS
 */
if (!defined('PATH_SEPARATOR')) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        define('PATH_SEPARATOR', ';');
    } else {
        define('PATH_SEPARATOR', ':');
    }
}

/** 
 * Set the Directory separator related to the used OS
 */
if (!defined('DIRECTORY_SEPARATOR')) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        define('DIRECTORY_SEPARATOR', '\\');
    } else {
        define('DIRECTORY_SEPARATOR', '/');
    }
}

if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
    /** This solves some problems with IE and its cache */
    @session_cache_limiter('public');
}

/** 
 * Set a session name for the apcms session 
 */
$oldsessname = session_name('APCSESS');


/** 
 * Start the session 
 */
session_start();


/** 
 * Stores the session name
 */
$_SESSION['name'] = session_name();

/** 
 * Stores the session id
 */
$_SESSION['id'] = session_id();

/** 
 * Stores the SID for use in uris
 */
$_SESSION['sid'] = $_SESSION['name']."=".$_SESSION['id'];

$PATH = @realpath(@dirname(__FILE__));
/** 
 * Find and save the absolute server-path for later use 
 */
$apcms['path'] = $PATH;

$old_include = @ini_get('include_path');
$new_include = $old_include.PATH_SEPARATOR."/usr/share/php/PEAR".PATH_SEPARATOR.".".PATH_SEPARATOR.@realpath($PATH."/../..");
@ini_set('include_path', $new_include.PATH_SEPARATOR.$PATH.'/libs/bundled_pear');




$lastpointpos = strrpos($_SERVER['PHP_SELF'], ".");
/** 
 * Find and save the file-extension for later use 
 */
$SUFFIX = substr($_SERVER['PHP_SELF'], ($lastpointpos+1), strlen($_SERVER['PHP_SELF']));


$error = "";
$success = "";
$DEBUGOUT = '';
$PAGE_TITLE = '';
$PAGE_SUBTITLE = '';
$apcms['redirect_url'] = '';
$apcms['redirect_time'] = '';

/** 
 * Include the global functions file 
 */
include($PATH."/libs/functions.lib.".$SUFFIX);

/** 
 * Stores the server path to the themes directory
 */
$apcms['themesdir'] = $PATH.'/themes';
/** 
 * Stores the url to the themes directory
 */
$apcms['themesurl'] = './themes';

$apcms['HTTPPath'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", str_replace(basename(__FILE__), "", __FILE__));
/** 
 * Stores the complete URI to the script
 */
$apcms['baseURL'] = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . (!strstr($_SERVER['HTTP_HOST'], ':') && !empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '') . $apcms['HTTPPath'];

if (isset($_SERVER['HTTP_REFERER'])) {
	$apcms['referer'] = $_SERVER['HTTP_REFERER'];
} else {
	$apcms['referer'] = '';
}

if (!isset($_REQUEST)) {
    $_REQUEST = &$HTTP_REQUEST_VARS;
}
if (!isset($_POST)) {
    $_POST = &$HTTP_POST_VARS;
}
if (!isset($_GET)) {
    $_GET = &$HTTP_GET_VARS;
}
if (!isset($_SESSION)) {
    $_SESSION = &$HTTP_SESSION_VARS;
}
if (!isset($_COOKIE)) {
    $_COOKIE = &$HTTP_COOKIE_VARS;
}
if (!isset($_SERVER)) {
    $_SERVER = &$HTTP_SERVER_VARS;
}
if (extension_loaded('filter') && input_name_to_filter(ini_get('filter.default')) !== FILTER_UNSAFE_RAW) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = input_get(INPUT_POST, $key, FILTER_UNSAFE_RAW);
    }
    foreach ($_GET as $key => $value) {
        $_GET[$key] = input_get(INPUT_GET, $key, FILTER_UNSAFE_RAW);
    }
    foreach ($_COOKIE as $key => $value) {
        $_COOKIE[$key] = input_get(INPUT_COOKIE, $key, FILTER_UNSAFE_RAW);
    }
    foreach ($_SESSION as $key => $value) {
        $_SESSION[$key] = input_get(INPUT_SESSION, $key, FILTER_UNSAFE_RAW);
    }
}


/** 
 * Merge GET vars into the apcms array 
 */
$apcms['GET']    = &$_GET['apcms'];
/** 
 * Merge POST vars into the apcms array 
 */
$apcms['POST']   = &$_POST['apcms'];
/** 
 * Merge COOKIE vars into the apcms array 
 */
$apcms['COOKIE'] = &$_COOKIE['apcms'];

/** 
 * Attempt to fix IIS compatibility 
 */
if (empty($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . '?' . (!empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '');
}


if (file_exists($PATH."/config.local.inc.".$SUFFIX) && filesize($PATH."/config.local.inc.".$SUFFIX) > 0) {
	define('IS_installed', true);
	$apcms['IS_installed'] = true;
}

/** 
 * Set the version string 
 */
$apcms['version']         = '0.0.1-pre2';

/** 
 * Set the default theme 
 */
$apcms['defaultTemplate'] = 'default';

/** 
 * Set the default language 
 */
$apcms['defaultLanguage'] = 'de';

if (!defined('IN_installer') && !defined('IS_installed')) {
    header("Location: ./apcms_installer.".$SUFFIX);
    apcms_die("Not installed!");
}

if (file_exists($PATH."/config.local.inc.".$SUFFIX)) {
	/** 
	 * Include of the user defined configuration 
	 */
	include($PATH."/config.local.inc.".$SUFFIX);
}

/** 
 * Connect to the database 
 */
include($PATH."/libs/database.func.".$SUFFIX);

if (isset($MYSQLDATA['PREFIX']) && trim($MYSQLDATA['PREFIX']) != "") {
	$ptrenner = "_";
} else {
	$ptrenner = "";
}
/** 
 * Holds the whole mysql-prefix for the tables
 */
$apcms['mysql_prefix'] = $MYSQLDATA['PREFIX'].$ptrenner.$MYSQLDATA['UNIQUE'].'_';

$pgrep = preg_quote($MYSQLDATA['PREFIX'].$ptrenner.$MYSQLDATA['UNIQUE']);
$rettables = $db->unbuffered_getAll_row("SHOW TABLES");
for ($a=0;$a<count($rettables);$a++) {
	if (ereg("^".$MYSQLDATA['PREFIX'].$ptrenner.$MYSQLDATA['UNIQUE'], stripslashes(trim($rettables[$a][0]))) && !ereg("_plugin_", stripslashes(trim($rettables[$a][0])))) {
		$table = stripslashes(trim($rettables[$a][0]));
		$group = preg_replace("`".$pgrep."_([^_]+)_[^_]+$`", "\\1", $table);
		$name  = preg_replace("`".$pgrep."_[^_]+_([^_]+)$`", "\\1", $table);
		$apcms['table'][$group][$name] = $apcms['mysql_prefix'].$group.'_'.$name.'';
	}
}

$retconf = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['config']."`");
/** 
 * Holds the title of the page
 */
$apcms['title'] = htmlspecialchars(stripslashes(trim($retconf[0])));
/** 
 * Holds the subtitle of the page
 */
$apcms['subtitle'] = htmlspecialchars(stripslashes(trim($retconf[1])));
/** 
 * Holds the description of the page
 */
$apcms['description'] = htmlspecialchars(stripslashes(trim($retconf[2])));
/** 
 * Holds the session lifetime in seconds
 */
$apcms['sesslifetime'] = intval($retconf[3]);
/** 
 * Holds the EMail name of the page
 */
$apcms['emailfrom'] = stripslashes(trim($retconf[4]));
/** 
 * Holds the EMail address of the page
 */
$apcms['emailadress'] = stripslashes(trim($retconf[5]));

$userid = 0;
if (isset($apcms['COOKIE']['userid']) && intval($apcms['COOKIE']['userid']) >= 1) {
	$_SESSION['isloggedin'] = true;
	if (!isset($_SESSION['userid']) || intval($_SESSION['userid']) <= 0) {
		
		
		$cpassword = trim($apcms['COOKIE']['password']);
		$seluser = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['users']."` WHERE `id`='".intval($apcms['COOKIE']['userid'])."' AND `nickname`='".apcms_ESC($apcms['COOKIE']['nickname'])."' AND `password`='".apcms_ESC($cpassword)."'");
		if (isset($seluser[0]) && intval($seluser[0]) >= 1) {
			
			$userid = intval($seluser[0]);
			$nickname = stripslashes(trim($seluser[1]));
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
			
		}
		
		
		
	}
} else {
	unset($apcms['user']);
	session_unset();
	setcookie("apcms[userid]", "", time()-999);
	setcookie("apcms[nickname]", "", time()-999);
	$_SESSION['name'] = session_name();
	$_SESSION['id'] = session_id();
	$_SESSION['sid'] = $_SESSION['name']."=".$_SESSION['id'];
	$_SESSION['isloggedin'] = false;
}

if (!isset($_SESSION['isloggedin']) || $_SESSION['isloggedin'] === false) {
	$_SESSION['groups'] = array(2);
	$THEME = $apcms['defaultTemplate'];
	$LANG  = $apcms['defaultLanguage'];
} else {
	$THEME = $_SESSION['theme'];
	$LANG  = $_SESSION['language'];
}

$apcms['theme'] = $THEME;
$apcms['lang'] = $LANG;
$apcms['themesurl'] = $apcms['baseURL']."themes/".$apcms['theme'];


/** 
 * Include the language file 
 */
require_once($PATH."/lang/".$LANG.".lang.".$SUFFIX);


require_once($PATH."/libs/plugins.class.".$SUFFIX);
$hook = new apcms_Plugin();

$retplugins = $db->unbuffered_getAll_row("SELECT * FROM `".$apcms['table']['global']['plugins']."` WHERE `active`='1'");
if(count($retplugins) >= 1) {
	for($a=0;$a<count($retplugins);$a++) {
		$plugin_id = intval($retplugins[$a][0]);
		$plugin_name = stripslashes(trim($retplugins[$a][1]));
		$plugin_md5 = stripslashes(trim($retplugins[$a][2]));
		$plugin_config = stripslashes(trim($retplugins[$a][4]));
		require_once($PATH."/plugins/".$plugin_name."/".$plugin_name.".".$SUFFIX);
		$apcms['PLUGIN'][$plugin_name] = new $plugin_name();
		$plugin[$plugin_name]['id'] = $plugin_id;
		$plugin[$plugin_name]['name'] = $plugin_name;
		$plugin[$plugin_name]['md5'] = $plugin_md5;
		$plugin[$plugin_name]['config'] = unserialize($plugin_config);
	}
}


/** 
 * Including some handlers 
 */
include($PATH."/libs/handlers.lib.".$SUFFIX);

?>