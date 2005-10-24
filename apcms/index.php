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



/** ALLE Fehler, Warnings und Notices werden gnadenlos angezeigt */
@error_reporting(E_ALL);
/** Maximale Ausführungszeit wird auf 120 Sekunden begrenzt */
@set_time_limit(120);

@ini_alter("session.use_cookies", 0);
@ini_alter("session.use_trans_sid", 0);

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
    {
    /** Internet Exploder hat Probleme mit dem Cache bei Sessions */
    @session_cache_limiter('public');
    }

/** Alter Session-Name wird gespeichert und zu APSESS geändert */
$oldsession_name = session_name('APSESS');

/** Session starten */
session_start();

if (isset($_GET['newsess']) && $_GET['newsess'] == 1)
    {
    unset($_SESSION);
    @session_destroy();
    unset($_SESSION);
    @session_destroy();
    /** Alter Session-Name wird gespeichert und zu APSESS geändert */
    $oldsession_name = session_name('APSESS');
    /** Session starten */
    session_start();
    }

$_SESSION['APCMS']['PATH'] = preg_replace("`(\/apcms_)(classes|config|content|docs|functions|include|js|log|modules|styles|sysdir|userdir)`i","",@realpath(@dirname(__FILE__)));
@ini_set('include_path',@realpath($_SESSION['APCMS']['PATH']."/../..").":.:".@ini_get('include_path'));

/** Finden der Datei-Extension und speichern in Session */
$lastpointpos = strrpos($_SERVER['PHP_SELF'], ".");
$SUFFIX = substr($_SERVER['PHP_SELF'], ($lastpointpos+1), strlen($_SERVER['PHP_SELF']));

/** Generelle Vor-Konfiguration starten */
$HEADERISLOADED = 0;
include($_SESSION['APCMS']['PATH']."/apcms_functions/preconfig.lib.".$SUFFIX);
unset($contentinclude);

if ((!isset($contentinclude)) && isset($_GET['s']) && trim($_GET['s']) != "")
    {
    $contentinclude = str_replace("..","", trim($_GET['s']));
    }
elseif ((!isset($contentinclude)) && isset($_POST['s']) && trim($_POST['s']) != "")
    {
    $contentinclude = str_replace("..","", trim($_POST['s']));
    }
else
    {
    if (!isset($contentinclude))
        {
        $contentinclude = "index";
        }
    else
        {
        $contentinclude = str_replace("..","", trim($contentinclude));
        }
    }
$firstinclude = $_SESSION['APCMS']['INC_DIR'].'/content.'.$contentinclude.'.'.$_SESSION['APCMS']['SUFFIX'];
$langfile = 'content.'.$contentinclude.'.'.$_SESSION['APCMS']['SUFFIX'];

/** Include der Debug-Funktionen des Systems */
require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_benchmark.class.".$_SESSION['APCMS']['SUFFIX']);
$Benchmark = new APCMS_BENCH();
$Benchmark->Start();

/** Datenbank connecten */
include($_SESSION['APCMS']['LIB_DIR']."/apcms_database.func.".$_SESSION['APCMS']['SUFFIX']);
/** Generelle Haupt-Konfiguration starten */
include($_SESSION['APCMS']['LIB_DIR']."/proconfig.lib.".$_SESSION['APCMS']['SUFFIX']);
/** Include der Basis-Funktionen des Systems */
include($_SESSION['APCMS']['LIB_DIR']."/apcms_general.func.".$_SESSION['APCMS']['SUFFIX']);
/** Überprüft Variablen in der URL auf SQL-Injection oder sonstige unerlaubte Zeichenfolgen */
_APCMS_NoScriptKiddies();
$TITLE_LOCATION = "";
$CONTENTTITEL = "";
$CONTENTINHALT = "";
$CONTENT = "";
$target_url = "";
$OnlineUserIndexStats = array();
$TodayOnlineUserStats = array();

if ((!isset($_SESSION['APCMS']['CONFIG']['cache_aktiv']) || $_SESSION['APCMS']['CONFIG']['cache_aktiv'] == 0) || ($contentinclude == "handler" || $contentinclude == "queryresults" || $contentinclude == "admin") || (isset($must_update_cached_file) && $must_update_cached_file == 1) || ($CACHEDFILE['lastupdate'] <= ($akt_time-$_SESSION['APCMS']['CONFIG']['cache_aktinterval'])))
    {
    /** Include der Smarty-Klassen */
    require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']);
    $HEADER_LOCATION_STRING  = '&nbsp; &nbsp;&raquo;&nbsp; <a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'].'"'._APCMS_HelpSystem($_LANGUAGE['click_to_firstpage']).'>'.$_LANGUAGE['firstpage'].'</a>';
    /////////////////////////////////////////////////////////////////////////////////
    //
    //  Die eigentliche Abarbeitung von Funktionen und Variablen, beginnt hier
    //


    /** Prüfen ob Aktion "apcms" active, also eingeschalten ist */
    if (!_APCMS_ActionIsActive('apcms'))
        {
        _APCMS_MsgBox($_LANGUAGE['apcms_is_deactivated'], $_LANGUAGE['apcms_is_deactivated_desc'], '', '', 1, $_SESSION['APCMS']['TABLE']['WIDTH']);
        }


    /** Prüfen ob der User die Aktion "apcms" ausführen darf */
    if (!_APCMS_UserAccess('apcms'))
        {
        _APCMS_MsgBox($_LANGUAGE['no_access'], $_LANGUAGE['no_access_desc'], '', '', 1, $_SESSION['APCMS']['TABLE']['WIDTH']);
        }


    include ($firstinclude);


    //
    //  Die eigentliche Abarbeitung von Funktionen und Variablen, endet hier
    //
    /////////////////////////////////////////////////////////////////////////////////
    //
    //  Die Ausgabe wird hier zusammengebaut und in Variablen gespeichert
    //

    /** Header includen und anzeigen */
    if (isset($_GET['noheadersnfooters']) && $_GET['noheadersnfooters'] == 1)
        include($_SESSION['APCMS']['INC_DIR']."/header.minimal.".$_SESSION['APCMS']['SUFFIX']);
    else
        include($_SESSION['APCMS']['INC_DIR']."/header.full.".$_SESSION['APCMS']['SUFFIX']);

    /** Neues Template starten */
    $MAINOUT = _APCMS_StartNewTemplate();


    $MAINOUT->assign("CONTENTTITEL", $CONTENTTITEL);
    $MAINOUT->assign("CONTENTINHALT", $CONTENT);


    /** Ausgabe der HTML-Daten an den Browser */
    $MAINCONTENT = $MAINOUT->fetch('index.html');

    /** Footer includen und anzeigen */
    if (isset($_GET['noheadersnfooters']) && $_GET['noheadersnfooters'] == 1)
        include($_SESSION['APCMS']['INC_DIR']."/footer.minimal.".$_SESSION['APCMS']['SUFFIX']);
    else
        include($_SESSION['APCMS']['INC_DIR']."/footer.full.".$_SESSION['APCMS']['SUFFIX']);

    /** Die komplette Ausgabe befindet sich in der Variablen $DOCUMENT_OUT */
    $DOCUMENT_OUT = $HEADCONTENT.$MAINCONTENT.$FOOTERCONTENT;
    }

if(!isset($DOCUMENT_OUT) || trim($DOCUMENT_OUT) == "")
    $DOCUMENT_OUT = "";


//
//  Die eigentliche Ausgabe endet hier
//
/////////////////////////////////////////////////////////////////////////////////
//
//  Ab hier wird alles an den Browser geschickt!
//


if ($_SESSION['APCMS']['CONFIG']['cache_aktiv'] == 1 && $contentinclude != "admin" && $contentinclude != "handler" && $contentinclude != "queryresults")
    {
    if ((!file_exists($cachedir."/".$cachedfile)) || (isset($must_update_cached_file) && $must_update_cached_file == 1) || ($CACHEDFILE['lastupdate'] <= ($akt_time-$_SESSION['APCMS']['CONFIG']['cache_aktinterval'])))
        $DOCUMENT = _APCMS_UpdateCachedFile($cachedfile, $DOCUMENT_OUT);
    /** Erst ab hier findet die Ausgabe statt! Vorher wurde noch nichts an den Browser geschickt! */
    $fp = fopen($cachedir."/".$cachedfile, "rb");
    $HTMLDATA = fread($fp, filesize($cachedir."/".$cachedfile));
    fclose($fp);
    echo $HTMLDATA;
    }
else
    {
    echo $DOCUMENT_OUT;
    }





/** Debug-Informationen werden ab hier ausgegeben, falls gewünscht */
$DEBUGOUT = "";
if ($_SESSION['APCMS']['BOARD']['DEBUGGING'] == true)
    {
    $SAVEDQUERYS = $db->GetSavedQuerys();
    $DEBUGOUT .= "<br><br>".$_LANGUAGE['debug_start'];
    $Benchmark->Stop();
    $DEBUGOUT .= "<br><br>".$_LANGUAGE['page_loading_1']." ".$Benchmark->BenchmarkTime()." ".$_LANGUAGE['page_loading_2'];
    $DEBUGOUT .= "<hr size=\"1\" noshade>";
    $DEBUGOUT .= "<br><b>".$_LANGUAGE['needed_querys']."</b> ".$db->GetNumQuerys()."<br>";
    $DEBUGOUT .= "<hr size=\"1\" noshade>";
    for($sqc=0;$sqc<count($SAVEDQUERYS);$sqc++)
        {
        $DEBUGOUT .= "<b>Query ".($sqc+1).":</b> "._APCMS_SpecialChars($SAVEDQUERYS[$sqc])."<br>";
        }
    $DEBUGOUT .= "<hr size=\"1\" noshade>";
    $DEBUGOUT .= _APCMS_ShowRequirements();
    $DEBUGOUT .= _APCMS_DebugVarsOut();
    echo $DEBUGOUT;
    }


//
//  Die eigentliche Ausgabe endet hier
//
/////////////////////////////////////////////////////////////////////////////////

@ob_flush();
@ignore_user_abort();
_APCMS_CheckAutoDelBackup();
_APCMS_CheckAutoBackup();
$db->close();
?>