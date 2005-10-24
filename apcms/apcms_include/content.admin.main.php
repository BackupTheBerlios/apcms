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



// +----------------------------------------------------------------------+
$VFILE = 'http://www.php-programs.de/versions.txt';
$check_version = 1;
$check_supportpages = 1;
// +----------------------------------------------------------------------+



$CONTENTTITEL       .=       '&nbsp; &raquo; &nbsp;'.$_LANGUAGE['main_title'];
$TITLE_LOCATION     =        $_LANGUAGE['admincenter'].' - '.$_LANGUAGE['main_title'];



$color = $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'];
$NEWPACMSVERSION = '';
$NEWVERSION = '';
$vstatus = array();
if ($check_version == 1)
    {
    $vstatus = _APCMS_GetStatusCodeFromUrl($VFILE);
    $versionstxt = $vstatus['html'];
    $match = array();
    preg_match("`([\s]*(APCMS)[\s]*)([0-9\.]*)([\s]*)`i", $versionstxt, $match);
    if (isset($match[3]) && $match[3] != "")
        $NEWPACMSVERSION = $match[3];
    if ((version_compare(_APCMS_version(), $NEWPACMSVERSION)==-1))
        {
        $NEWVERSION = _APCMS_MakeHref("http://www.php-programs.de", _APCMS_MakeImg($_SESSION['APCMS']['STYLES_URL']."/".$_SESSION['APCMS']['STYLE']."/images/gfx/newversion.gif", 'Neue Version verfügbar!!!'), "APCMS-Homepage", "_blank");
        }
    }
$OnlineUserArray = _APCMS_GetUserOnline('indexstats');

if (!$lastbackup = _APCMS_GetLastBackup())
    {
    $LASTBACKUPTIME = "<span style=\"color:red\"><b><blink>Noch kein Backup!</blink></b></span>";
    $LASTBACKUPFILE = "<span style=\"color:red\"><b>--</b></span>";
    }
elseif ($lastbackup['time'] <= ($akt_time-604800)) 
    {
    $LASTBACKUPTIME = "<span style=\"color:red\"><blink>"._APCMS_FormattedDateTime($lastbackup['time'])."</blink></span>";
    $LASTBACKUPFILE = "<span style=\"color:red\">"._APCMS_SpecialChars($lastbackup['file'])."</span>";
    }
else 
    {
    $LASTBACKUPTIME = _APCMS_FormattedDateTime($lastbackup['time']);
    $LASTBACKUPFILE = _APCMS_SpecialChars($lastbackup['file']);
    }

require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_admintable.class.".$_SESSION['APCMS']['SUFFIX']);
$ADMINTABLE1 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE1->AddRow('<strong>Versions-Information</strong>', '', 2);
$ADMINTABLE1->AddRow('<strong>APCMS-Version</stron>', ($NEWVERSION!=""?$NEWVERSION."&nbsp; &nbsp;":"").' <strong>'._APCMS_version().'</stron>');
$ADMINTABLE1->AddRow('PHP-Version', phpversion());
$ADMINTABLE1->AddRow('MySQL-Version', $db->mysqlversion());
$ADMINTABLE1->AddRow('GDLib-Version', _APCMS_getGDVersion());
$CONTENTINHALT .= $ADMINTABLE1->GetTable()."<br />";

$ADMINTABLE2 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE2->AddRow('<strong>System-Information</strong>', '', 2);
$ADMINTABLE2->AddRow('Date', $ACTUALTIME_FORMATTED);
$ADMINTABLE2->AddRow('Install-Date', _APCMS_FormattedDateTime($akt_installdate));
$ADMINTABLE2->AddRow('Letztes Backup vom', $LASTBACKUPTIME);
$ADMINTABLE2->AddRow('Letztes Backup', $LASTBACKUPFILE);
$ADMINTABLE2->AddRow('reg. User', _APCMS_RegUsersNum());
$ADMINTABLE2->AddRow('User Online', $OnlineUserArray['useronline_onlinenum']);
$CONTENTINHALT .= $ADMINTABLE2->GetTable()."<br />";

$ADMINTABLE3 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE3->AddRow('<strong>Support-Information</strong>', '', 2);
$ADMINTABLE3->AddRow('APP - Another PHP Program', _APCMS_MakeHref('http://www.php-programs.de/', "http://www.php-programs.de/", "", "_blank"));
$ADMINTABLE3->AddRow('Support-Forum', _APCMS_MakeHref('http://www.php-programs.de/apboard/main.php', "http://www.php-programs.de/apboard/main.php", "", "_blank"));
$ADMINTABLE3->AddRow('Dokumentation', _APCMS_MakeHref($_SESSION['APCMS']['REL_URL'].'/apcms_docs/', $_SESSION['APCMS']['REL_URL']."/apcms/apcms_docs/", "", "_blank"));
$CONTENTINHALT .= $ADMINTABLE3->GetTable();


?>