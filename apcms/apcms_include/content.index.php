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



/** Anzeige des Standortes auf UserOnline */ 
$ONLINE_ANZEIGE = $_LANGUAGE['is_on_the'].' <a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'"{#if#enable_helpsys#}'._APCMS_HelpSystem($_LANGUAGE['click_to_firstpage']).'{#endif#enable_helpsys#}>'.$_LANGUAGE['firstpage'].'</a>.'; 
/** Alle User-Online-Updates durchzühren (den User betreffend) */ 
_APCMS_UpdateOnlineUser($ONLINE_ANZEIGE); 
$TITLE_LOCATION = $_LANGUAGE['firstpage'];
 
/** UserOnline-Statistik für index-seite */ 
if ((_APCMS_ActionIsActive('index_useronlinestats') && _APCMS_UserAccess('index_useronlinestats')) && (isset($contentinclude) && $contentinclude=="index")) 
    { 
    $OnlineUserIndexStats = _APCMS_GetUserOnline('indexstats'); 
    } 
if ((_APCMS_ActionIsActive('index_usertodayonline') && _APCMS_UserAccess('index_usertodayonline')) && (isset($contentinclude) && $contentinclude=="index")) 
    { 
    $TodayOnlineUserStats = _APCMS_GetUserOnline('indextodayonline'); 
    } 
 
 
 
/** Include der Smarty-Klassen */ 
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']); 
 
/** Neues Template starten */ 
$INDEX = _APCMS_StartNewTemplate(); 
 
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, beginnt hier 
//   
 
$CONTENTTITEL = $_LANGUAGE['firstpage']; 
 
 
 
$CONTENTINHALT = 'ein test'; 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
$INDEX->assign("CONTENTTITEL", $CONTENTTITEL); 
$INDEX->assign("CONTENTINHALT", $CONTENTINHALT); 
 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Ausgabe startet hier 
//   
 
/* Ausgabe der HTML-Daten an die Variable $CONTENT */ 
$CONTENT = $INDEX->fetch('content.'.$contentinclude.'.html'); 
 
 
//   
//  Die eigentliche Ausgabe endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
 
 
 
?>