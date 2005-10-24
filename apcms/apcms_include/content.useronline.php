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
// $Id $
// +----------------------------------------------------------------------+



$HEADER_LOCATION_STRING .= '&nbsp; &nbsp;&raquo;&nbsp; <a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX']."?s=useronline".$_SESSION['SID2'].'"'._APCMS_HelpSystem($_LANGUAGE['click_to_reload']).'>'.$_LANGUAGE['useronline'].'</a>'; 
 
/** Anzeige des Standortes auf UserOnline */ 
$ONLINE_ANZEIGE = '... schaut sich gerade an, welche {#if#useronline#}<a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=useronline"{#if#enable_helpsys#}'._APCMS_HelpSystem($_LANGUAGE['click_to_reload']).'{#endif#enable_helpsys#}>{#endif#useronline#}'.$_LANGUAGE['user_online'].'{#if#useronline#}</a>{#endif#useronline#} sind.'; 
/** Alle User-Online-Updates durchzühren (den User betreffend) */ 
_APCMS_UpdateOnlineUser($ONLINE_ANZEIGE); 
$TITLE_LOCATION = $_LANGUAGE['useronline'];

 
 
/** Prüfen ob Aktion "apcms" active, also eingeschalten ist */ 
if (!_APCMS_ActionIsActive('useronline')) 
    { 
    _APCMS_MsgBox($_LANGUAGE['useronline_is_deactivated'], $_LANGUAGE['useronline_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH']); 
    } 
 
 
/** Prüfen ob der User die Aktion "apcms" ausführen darf */ 
if (!_APCMS_UserAccess('useronline')) 
    { 
    _APCMS_MsgBox($_LANGUAGE['no_access'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH']); 
    } 
 
 
/** Include der Smarty-Klassen */ 
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']); 
 
/** Neues Template starten */ 
$UONLINE = _APCMS_StartNewTemplate(); 
 
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, beginnt hier 
//   
 
 
$CONTENTTITEL       =       $_LANGUAGE['useronline']; 
$CONTENTINHALT      =       ''; 
 
 
 
 
$query = "SELECT `zeit`,`ip`,`userid`,`publicname`,`onlineanzeige` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online` ORDER BY `zeit` DESC"; 
$seluo = $db->unbuffered_getAll_row($query); 
 
 
$CONTENTINHALT .= '<table width="100%" border="0" cellspacing="1" cellpadding="2">'; 
$CONTENTINHALT .= ' <tr class="tC2L">'; 
$CONTENTINHALT .= '     <td width="160"><strong>'.$_LANGUAGE['user'].'</strong></td>'; 
if (_APCMS_ActionIsActive('show_uo_location') && _APCMS_UserAccess('show_uo_location')) 
    { 
    $CONTENTINHALT .= '     <td><strong>'.$_LANGUAGE['location'].'</strong></td>'; 
    } 
$CONTENTINHALT .= '     <td width="100"><strong>'.$_LANGUAGE['last_activity'].'</strong></td>'; 
$CONTENTINHALT .= ' </tr>'; 
$guestnum = 1; 
for ($a=0;$a<count($seluo);$a++) 
    { 
    $class = (isset($class)&&$class=="A"?"B":"A"); 
    $lastact = date("H:i:s", $seluo[$a][0])." ".$_LANGUAGE['uhr']; 
    if ($seluo[$a][2]<=0 && trim($seluo[$a][3]) == "") 
        {  
        $publicname = $_LANGUAGE['guest_number'].$guestnum.(_APCMS_ActionIsActive('show_ips')&&_APCMS_UserAccess('show_ips')?" (".$seluo[$a][1].")":""); 
        $guestnum++; 
        } 
    else  
        $publicname = (_APCMS_ActionIsActive('show_userdetails')&&_APCMS_UserAccess('show_userdetails')?'<a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=userdetails&userid='.$seluo[$a][2].$_SESSION['SID2'].'"'._APCMS_HelpSystem($_LANGUAGE['show_userdetails_desc']).'>':'').htmlspecialchars(stripslashes($seluo[$a][3])).(_APCMS_ActionIsActive('show_userdetails')&&_APCMS_UserAccess('show_userdetails')?'</a>':'').(_APCMS_ActionIsActive('show_ips')&&_APCMS_UserAccess('show_ips')?" (".$seluo[$a][1].")":""); 
    $CONTENTINHALT .= ' <tr class="t'.$class.'2L">'; 
    $CONTENTINHALT .= '     <td width="220">'.$publicname.'</td>'; 
    if (_APCMS_ActionIsActive('show_uo_location') && _APCMS_UserAccess('show_uo_location')) 
        { 
        $onlineanzeige = stripslashes($seluo[$a][4]); 
        /** Parst einen String nach APCMS-eigenen Access-Vars und baut ihn entsprechend der aktuellen Userrechte um */ 
        $onlineanzeige = _APCMS_ParseAccessVars($onlineanzeige); 
        $CONTENTINHALT .= '     <td>'.$onlineanzeige.'</td>'; 
        } 
    $CONTENTINHALT .= '     <td width="100">'.$lastact.'</td>'; 
    $CONTENTINHALT .= ' </tr>'; 
    } 
$CONTENTINHALT .= ' </table>'; 
 
 
 
 
$UONLINE->assign("CONTENTTITEL", $CONTENTTITEL); 
$UONLINE->assign("CONTENTINHALT", $CONTENTINHALT); 
 
 
 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Ausgabe startet hier 
//   
 
/* Ausgabe der HTML-Daten an den Browser */ 
$CONTENT = $UONLINE->fetch('content.'.$contentinclude.'.html'); 
 
 
//   
//  Die eigentliche Ausgabe endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
 
 
 
?>