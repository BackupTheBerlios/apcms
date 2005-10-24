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
// | Authors: Alexander Mieland <dma147 at linux-stats dot org>           |
// +----------------------------------------------------------------------+
// $Id $
// +----------------------------------------------------------------------+



if (isset($_GET['delete']) && is_numeric($_GET['delete']) == 1) 
    { 
    $HEADER_LOCATION_STRING .= '&nbsp; &nbsp;&raquo;&nbsp; <a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX']."?s=login&delete=1".$_SESSION['SID2'].'">'.$_LANGUAGE['logout'].'</a>'; 
    /** Anzeige des Standortes auf UserOnline */ 
    $ONLINE_ANZEIGE = $_LANGUAGE['has_just_logged_out']; 
    $TITLE_LOCATION = $_LANGUAGE['logout'];
    } 
if (isset($_POST['dologin']) && is_numeric($_POST['dologin']) == 1) 
    { 
    $HEADER_LOCATION_STRING .= '&nbsp; &nbsp;&raquo;&nbsp; <a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX']."".$_SESSION['SID1'].'">'.$_LANGUAGE['login'].'</a>'; 
    /** Anzeige des Standortes auf UserOnline */ 
    $ONLINE_ANZEIGE = $_LANGUAGE['is_logging_in']; 
    $TITLE_LOCATION = $_LANGUAGE['login'];
    } 
 
/** Alle User-Online-Updates durchzühren (den User betreffend) */ 
_APCMS_UpdateOnlineUser($ONLINE_ANZEIGE); 

 
/** Include der Smarty-Klassen */ 
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']); 
 
/** Neues Template starten */ 
$LOGIN = _APCMS_StartNewTemplate(); 
 
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, beginnt hier 
//   
 
 
if (isset($_GET['delete']) && is_numeric($_GET['delete']) == 1) 
    { 
    _APCMS_SetCookie("APCMS[USERDATA]", "", (time()-99999)); 
    $query = "DELETE FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online` WHERE `sessid`='".$_SESSION['sessid']."' OR `userid`='".$_SESSION['APCMS']['USER']['userid']."'"; 
    $delonline = $db->unbuffered_query($query); 
    unset($_SESSION['APCMS']['USER']); 
    unset($_SESSION['USER']); 
    unset($_SESSION['LOGGEDIN']); 
    $REDIRECT_URL = $_SESSION['APCMS']['REL_URL']."/".$_SESSION['SID1']; 
    $REDIRECT_TIME = 3; 
    $LOGIN->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['logged_out'], $_LANGUAGE['logged_out_desc'], $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
    } 
 
 
 
if (isset($_POST['dologin']) && is_numeric($_POST['dologin']) == 1) 
    { 
    if ((!isset($_POST['username']) || trim($_POST['username']) == "") || (!isset($_POST['userpass']) || trim($_POST['userpass']) == "")) 
        { 
        $REDIRECT_URL = $_SESSION['APCMS']['REL_URL']."/".$_SESSION['SID1']; 
        $REDIRECT_TIME = 3; 
        $LOGIN->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['no_data_typed_in'], $_LANGUAGE['no_data_typed_in_desc'], $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
        } 
    else  
        { 
        $thispassword = _APCMS_CryptPasswd(trim($_POST['userpass'])); 
        $query = "SELECT * FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_table` WHERE `username`='".trim($_POST['username'])."' AND `userpassword`='".$thispassword."'"; 
        $getuser_return = $db->unbuffered_query_first($query, 'assoc'); 
        unset($_SESSION['APCMS']['USER']); 
        if (isset($getuser_return) && count($getuser_return) >= 1) 
            { 
            foreach($getuser_return as $key => $val) 
                { 
                $_SESSION['APCMS']['USER'][$key] = stripslashes($val); 
                } 
            $_SESSION['LOGGEDIN'] = 1; 
            $cookiecontent = $_SESSION['APCMS']['USER']['userid']."|".$_SESSION['APCMS']['USER']['userpassword']."|".time(); 
            _APCMS_SetCookie("APCMS[USERDATA]", "$cookiecontent", (time()+31536000)); 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL']."/".$_SESSION['SID1']; 
            $REDIRECT_TIME = 3; 
            $LOGIN->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['successful_logged_in'], $_LANGUAGE['successful_logged_in_desc'], $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            } 
        else  
            { 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL']."/".$_SESSION['SID1']; 
            $REDIRECT_TIME = 3; 
            $LOGIN->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['user_unknown'], $_LANGUAGE['user_unknown_desc'], $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            } 
        } 
    } 
 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Ausgabe startet hier 
//   
 
/* Ausgabe der HTML-Daten an den Browser */ 
$CONTENT = $LOGIN->fetch('content.'.$contentinclude.'.html'); 
 
 
//   
//  Die eigentliche Ausgabe endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
 
 
 
?>