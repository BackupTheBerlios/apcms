<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | APCMS v0.0.2                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-     APP - Another PHP Program                    |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2 of the GPL,                 |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// +----------------------------------------------------------------------+
// | Authors: Alexander Mieland <dma147 at mieland-programming dot de>    |
// +----------------------------------------------------------------------+
// $Header $
// +----------------------------------------------------------------------+



if (chop(trim($_SERVER['SERVER_NAME'])) == "") 
/** Hostname wird gesucht */ 
	{ $hostname = chop(trim($_SERVER['HTTP_HOST'])); } 
else  
	{ $hostname = chop(trim($_SERVER['SERVER_NAME'])); } 
if (chop(trim($_SERVER['SCRIPT_NAME'])) == "") 
/** absoluter Pfad wird gesucht */ 
	{ $filename = chop(trim($_SERVER['PHP_SELF'])); } 
else  
	{ $filename = chop(trim($_SERVER['SCRIPT_NAME'])); } 
$lastslash = strrpos($filename , "/"); 
$webdir = substr($filename, 0, $lastslash); 
$_SESSION['APCMS']['URL'] = "http://".$hostname.$webdir; 
 
$_SESSION['APCMS']['JS_DIR']      = $_SESSION['APCMS']['PATH']."/apcms_js"; 
$_SESSION['APCMS']['CLASS_DIR']   = $_SESSION['APCMS']['PATH']."/apcms_classes"; 
$_SESSION['APCMS']['ETC_DIR']     = $_SESSION['APCMS']['PATH']."/apcms_configs"; 
$_SESSION['APCMS']['INC_DIR']     = $_SESSION['APCMS']['PATH']."/apcms_include"; 
$_SESSION['APCMS']['LIB_DIR']     = $_SESSION['APCMS']['PATH']."/apcms_functions"; 
$_SESSION['APCMS']['LOG_DIR']     = $_SESSION['APCMS']['PATH']."/apcms_log"; 
$_SESSION['APCMS']['MOD_DIR']     = $_SESSION['APCMS']['PATH']."/apcms_modules"; 
$_SESSION['APCMS']['TMP_DIR']     = $_SESSION['APCMS']['PATH']."/apcms_sysdir"; 
$_SESSION['APCMS']['USR_DIR']     = $_SESSION['APCMS']['PATH']."/apcms_userdir"; 
$_SESSION['APCMS']['STYLES_DIR']  = $_SESSION['APCMS']['PATH']."/apcms_styles"; 
 
$_SESSION['APCMS']['JS_URL']      = $_SESSION['APCMS']['REL_URL']."/apcms_js"; 
$_SESSION['APCMS']['CLASS_URL']   = $_SESSION['APCMS']['REL_URL']."/apcms_classes"; 
$_SESSION['APCMS']['ETC_URL']     = $_SESSION['APCMS']['REL_URL']."/apcms_configs"; 
$_SESSION['APCMS']['INC_URL']     = $_SESSION['APCMS']['REL_URL']."/apcms_include"; 
$_SESSION['APCMS']['LIB_URL']     = $_SESSION['APCMS']['REL_URL']."/apcms_functions"; 
$_SESSION['APCMS']['LOG_URL']     = $_SESSION['APCMS']['REL_URL']."/apcms_log"; 
$_SESSION['APCMS']['MOD_URL']     = $_SESSION['APCMS']['REL_URL']."/apcms_modules"; 
$_SESSION['APCMS']['TMP_URL']     = $_SESSION['APCMS']['REL_URL']."/apcms_sysdir"; 
$_SESSION['APCMS']['USR_URL']     = $_SESSION['APCMS']['REL_URL']."/apcms_userdir"; 
$_SESSION['APCMS']['STYLES_URL']  = $_SESSION['APCMS']['REL_URL']."/apcms_styles"; 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
?>