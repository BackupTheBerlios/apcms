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



/** Include der Smarty-Klassen */ 
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']); 
$HEADERISLOADED = 1; 
 
/** Neues Template starten */ 
$HEADER = _APCMS_StartNewTemplate($TITLE_LOCATION); 
 
 
if (@file_exists($_SESSION['APCMS']['ETC_DIR']."/header.extra.".$_SESSION['APCMS']['SUFFIX'])) 
    { 
    $fp_exm = @fopen($_SESSION['APCMS']['ETC_DIR']."/header.extra.".$_SESSION['APCMS']['SUFFIX'], "r"); 
    $EXTRAMETA = @fread($fp_exm, @filesize($_SESSION['APCMS']['ETC_DIR']."/header.extra.".$_SESSION['APCMS']['SUFFIX'])); 
    @fclose($fp_exm); 
    $HEADER->assign("EXTRAMETA", $EXTRAMETA); 
    } 
 
if (isset($REDIRECT_URL) && isset($REDIRECT_TIME)) 
    { 
    $HEADER->assign("REDIRECTURL", $REDIRECT_URL); 
    $HEADER->assign("REDIRECTTIME", $REDIRECT_TIME); 
    unset($REDIRECT_URL); 
    unset($REDIRECT_TIME); 
    } 
if (isset($_SESSION['LOGGEDIN']) && $_SESSION['LOGGEDIN'] == 1) 
    { 
    $HEADER->assign("loggedin", 1); 
    } 
$NAVBUTTONS = ''; 
 
 
 
 
 
$NAVBUTTONS .= _APCMS_GenNavButton($_LANGUAGE['button_portal'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=portal'.$_SESSION['SID2'], $_LANGUAGE['button_portal_help1'], $_LANGUAGE['button_portal_help2']); 
if (_APCMS_ActionIsActive('can_access_admin') && _APCMS_UserAccess('can_access_admin')) 
    { 
    $NAVBUTTONS .= " "._APCMS_GenNavButton($_LANGUAGE['button_admin'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], $_LANGUAGE['button_admin_help1'], $_LANGUAGE['button_admin_help2']); 
    } 
if (isset($_SESSION['LOGGEDIN']) && $_SESSION['LOGGEDIN'] == 1) 
    { 
    $NAVBUTTONS .= " "._APCMS_GenNavButton($_LANGUAGE['button_profil'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=profil'.$_SESSION['SID2'], $_LANGUAGE['button_profil_help1'], $_LANGUAGE['button_profil_help2']); 
    $NAVBUTTONS .= " "._APCMS_GenNavButton($_LANGUAGE['button_logout'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=login&delete=1'.$_SESSION['SID2'], $_LANGUAGE['button_logout_help1'], $_LANGUAGE['button_logout_help2']); 
    } 
else  
    { 
    $NAVBUTTONS .= " "._APCMS_GenNavButton($_LANGUAGE['button_register'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=registrieren'.$_SESSION['SID2'], $_LANGUAGE['button_register_help1'], $_LANGUAGE['button_register_help2']); 
    } 
$NAVBUTTONS .= " "._APCMS_GenNavButton($_LANGUAGE['button_help'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=help'.$_SESSION['SID2'], $_LANGUAGE['button_help_help1'], $_LANGUAGE['button_help_help2']); 
$NAVBUTTONS .= " "._APCMS_GenNavButton($_LANGUAGE['button_regeln'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=regeln'.$_SESSION['SID2'], $_LANGUAGE['button_regeln_help1'], $_LANGUAGE['button_regeln_help2']); 
 
 
 
 
 
 
 
 
 
$HEADER->assign("NAVBUTTONS", $NAVBUTTONS); 
 
 
if (isset($HEADER_LOCATION_STRING)) 
    $HEADER->assign("HEADER_LOCATION_STRING", $HEADER_LOCATION_STRING); 
 
/* Ausgabe der HTML-Daten an den Browser */ 
$HEADCONTENT = $HEADER->fetch('header.full.html'); 
 
 
 
 
?>