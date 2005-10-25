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



$CONTENTTITEL       .=       '&nbsp; &raquo; &nbsp;'.$_LANGUAGE['caching_options'];
$CONTENTINHALT      .=       '';
$TITLE_LOCATION     =        $_LANGUAGE['admincenter'].' - '.$_LANGUAGE['caching_options'];


require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_admintable.class.".$_SESSION['APCMS']['SUFFIX']);

$ADMINTABLE1 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE1->AddRow('<strong>.: '.$_LANGUAGE['caching_options'].' :.</strong><br /><br />'.$_LANGUAGE['caching_opts_description'], '', 2);
$CONTENTINHALT .= $ADMINTABLE1->GetTable()."<br />";


$ADMINTABLE2 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE2->OpenForm('cacheform', $_SERVER['PHP_SELF']."?s=handler".$_SESSION['SID2']);
$ADMINTABLE2->AddRow($_LANGUAGE['activate_caching'], '<input type="checkbox" name="NEW[cache_aktiv]" value="1"'.($_SESSION['APCMS']['CONFIG']['cache_aktiv']==1?" checked":"").' />');
$ADMINTABLE2->AddRow($_LANGUAGE['cache_timeout'], '<input style="width:220px" type="text" name="NEW[cache_aktinterval]" value="'.($_SESSION['APCMS']['CONFIG']['cache_aktinterval']/60).'" />');

$ADMINTABLE2->AddRow($_LANGUAGE['reset_cache'], '<input type="checkbox" name="NEW[reset_cache]" value="1" />');
$ADMINTABLE2->AddRow('&nbsp;<input type="hidden" name="s" value="handler">
                            <input type="hidden" name="action" value="setcaching">
                            <input type="hidden" name="FROM[s]" value="admin">
                            <input type="hidden" name="FROM[ainclude]" value="cacheopts">
                            <input type="hidden" name="'.session_name().'" value="'.session_id().'">', '', 2);
$ADMINTABLE2->AddRow('<input type="submit" name="saveopts" value="'.$_LANGUAGE['save_settings'].'">&nbsp;&nbsp;<input type="reset" name="reset" value="'.$_LANGUAGE['reset_formular'].'">&nbsp;&nbsp;<input type="button" name="zurueck" value="'.$_LANGUAGE['history_back'].'" OnClick="JavaScript:history.back();">', '', 2);
$ADMINTABLE2->CloseForm();
$CONTENTINHALT .= $ADMINTABLE2->GetTable();


unset($_SESSION['POSTDATA']);






?>