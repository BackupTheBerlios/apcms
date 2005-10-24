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



$HEADER_LOCATION_STRING .= '&nbsp; &nbsp;&raquo;&nbsp; <a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX']."?s=profil".$_SESSION['SID2'].'"'._APCMS_HelpSystem($_LANGUAGE['profil_desc']).'>'.$_LANGUAGE['profil'].'</a>'; 
$TITLE_LOCATION     =        $_LANGUAGE['profil'];

/** Anzeige des Standortes auf UserOnline */ 
$ONLINE_ANZEIGE = $_LANGUAGE['is_in_the'].' {#if#can_access_admin#}<a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=profil"{#if#enable_helpsys#}'._APCMS_HelpSystem($_LANGUAGE['profil_desc']).'{#endif#enable_helpsys#}>{#endif#can_access_profile#}'.$_LANGUAGE['profil'].'{#if#can_access_profile#}</a>{#endif#can_access_profile#}.'; 
/** Alle User-Online-Updates durchzühren (den User betreffend) */ 
_APCMS_UpdateOnlineUser($ONLINE_ANZEIGE); 
 
 
 
/** Prüfen ob Aktion "apcms" active, also eingeschalten ist */ 
if (!_APCMS_ActionIsActive('can_access_profile')) 
    { 
    _APCMS_MsgBox($_LANGUAGE['profile_is_deactivated'], $_LANGUAGE['profile_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH']); 
    } 
 
 
/** Prüfen ob der User die Aktion "apcms" ausführen darf */ 
if (!_APCMS_UserAccess('can_access_profile')) 
    { 
    _APCMS_MsgBox($_LANGUAGE['no_access'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH']); 
    } 
 
 
/** Include der Smarty-Klassen */ 
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']); 
 
/** Neues Template starten */ 
$ADMINMAIN = _APCMS_StartNewTemplate(); 
$NAVIGATION = ''; 
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, beginnt hier 
//   
 
 
$CONTENTTITEL       =       $_LANGUAGE['admincenter']; 
$CONTENTINHALT      =       ''; 
 
$ainclude = ""; 
if (isset($_GET['ainclude']) && trim($_GET['ainclude']) != "") 
    { 
    $ainclude = str_replace("..", "", trim($_GET['ainclude'])); 
    } 
if (isset($_POST['ainclude']) && trim($_POST['ainclude']) != "") 
    { 
    $ainclude = str_replace("..", "", trim($_POST['ainclude'])); 
    } 
if (trim($ainclude) == "") 
    { 
    $ainclude = "main"; 
    } 
 
 
require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_adminmenue.class.".$_SESSION['APCMS']['SUFFIX']); 
$ADMINMENUE = new APCMS_ADMINMENUE('', $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']); 
 
if ($ainclude == "main") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 1); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "globalpref") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 1); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "modules") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 1); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "useropts") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 1); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "styleopts") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 1); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "langopts") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 1); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "cacheopts") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 1); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "dbopts") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 1); 
        $ADMINMENUE->AddSubEntry($_LANGUAGE['nav_backup_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=backupopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "backupopts") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
        $ADMINMENUE->AddSubEntry($_LANGUAGE['nav_backup_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=backupopts'.$_SESSION['SID2'], 1); 
    } 
elseif ($ainclude == "makebackup") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
        $ADMINMENUE->AddSubEntry($_LANGUAGE['nav_backup_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=backupopts'.$_SESSION['SID2'], 0); 
    } 
elseif ($ainclude == "replaybackup") 
    { 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_firstpage'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_preferences'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=globalpref'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_module'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=modules'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_user_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=useropts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_style_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=styleopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=langopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_lang_cache'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=cacheopts'.$_SESSION['SID2'], 0); 
    $ADMINMENUE->AddEntry($_LANGUAGE['nav_db_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=dbopts'.$_SESSION['SID2'], 0); 
        $ADMINMENUE->AddSubEntry($_LANGUAGE['nav_backup_pref'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=admin&ainclude=backupopts'.$_SESSION['SID2'], 0); 
    } 
 
$NAVIGATION = $ADMINMENUE->GetMenue(); 
 
 
 
 
include ($_SESSION['APCMS']['INC_DIR'].'/content.admin.'.$ainclude.'.'.$_SESSION['APCMS']['SUFFIX']); 
 
 
$ADMINMAIN->assign("CONTENTTITEL", $CONTENTTITEL); 
$ADMINMAIN->assign("CONTENTINHALT", $CONTENTINHALT); 
$ADMINMAIN->assign("NAVIGATION", $NAVIGATION); 
 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Ausgabe startet hier 
//   
 
/* Ausgabe der HTML-Daten an den Browser */ 
$CONTENT = $ADMINMAIN->fetch('content.admin.html'); 
 
 
//   
//  Die eigentliche Ausgabe endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
 
 
 
?>