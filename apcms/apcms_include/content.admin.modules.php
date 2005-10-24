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



$CONTENTTITEL       .=       '&nbsp; &raquo; &nbsp;Modul-Optionen';
$CONTENTINHALT      .=       '';
$TITLE_LOCATION     =        $_LANGUAGE['admincenter'].' - Modul-Optionen';



require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_admintable.class.".$_SESSION['APCMS']['SUFFIX']);

$ADMINTABLE1 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE1->AddRow('<strong>.: Modul-Optionen :.</strong><br /><br />
', '', 2);
$CONTENTINHALT .= $ADMINTABLE1->GetTable()."<br />";


$ADMINTABLE2 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE2->OpenForm('langform', $_SERVER['PHP_SELF']."?s=handler".$_SESSION['SID2']);
$ADMINTABLE2->AddRow('<b></b><br />', '');
$ADMINTABLE2->AddRow('<b></b><br />', '');
$ADMINTABLE2->AddRow('<b></b><br />', '');
$ADMINTABLE2->AddRow('<b></b><br />', '');
$ADMINTABLE2->AddRow('<b></b><br />', '');


$ADMINTABLE2->AddRow('&nbsp;<input type="hidden" name="s" value="handler">
                            <input type="hidden" name="action" value="setcaching">
                            <input type="hidden" name="FROM[s]" value="admin">
                            <input type="hidden" name="FROM[ainclude]" value="langopts">
                            <input type="hidden" name="'.session_name().'" value="'.session_id().'">', '', 2);


$ADMINTABLE2->AddRow('<input type="submit" name="saveopts" value="Einstellungen speichern...">&nbsp;&nbsp;<input type="reset" name="reset" value="Formular Zurücksetzen">&nbsp;&nbsp;<input type="button" name="zurueck" value="Zurück..." OnClick="JavaScript:history.back();">', '', 2);

$ADMINTABLE2->CloseForm();
$CONTENTINHALT .= $ADMINTABLE2->GetTable();


unset($_SESSION['POSTDATA']);










?>