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



$CONTENTTITEL       .=       '&nbsp; &raquo; &nbsp;'.$_LANGUAGE['database_options'];
$CONTENTINHALT      .=       '';
$TITLE_LOCATION     =        $_LANGUAGE['admincenter'].' - '.$_LANGUAGE['database_options'];

require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_admintable.class.".$_SESSION['APCMS']['SUFFIX']);
$ADMINTABLE1 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE1->AddRow('<strong> .: '.$_LANGUAGE['database_options'].' :.</strong><br /><br />'.$_LANGUAGE['database_options_desc'], '', 2);
$CONTENTINHALT .= $ADMINTABLE1->GetTable()."<br />";

$ADMINTABLE2 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE2->OpenForm('dboptform', $_SERVER['PHP_SELF']."?s=handler".$_SESSION['SID2']);
$ADMINTABLE2->AddRow('<strong>'.$_LANGUAGE['do_querys_in_db'].'</strong><br />
<span style="color:red">'.$_LANGUAGE['do_querys_in_db_desc'].'</span>', '', 2);
$ADMINTABLE2->AddRow('<textarea rows="16" style="width:560px" name="NEW[sqlquery]">'.(isset($_SESSION['POSTDATA'])&&trim($_SESSION['POSTDATA']['QUERYSTRING'])!=""?$_SESSION['POSTDATA']['QUERYSTRING']:"EXPLAIN SELECT * FROM {\$USERTABLE} WHERE `userid`='1';").'</textarea>', '', 2);
$ADMINTABLE2->AddRow('<strong>'.$_LANGUAGE['following_vars_available'].'</strong><br />
'.$_LANGUAGE['following_vars_available_desc'].'<br />', '', 2);
$ADMINTABLE2->AddRow('&nbsp;<input type="hidden" name="s" value="handler">
                            <input type="hidden" name="action" value="makesqlquery">
                            <input type="hidden" name="FROM[s]" value="admin">
                            <input type="hidden" name="FROM[ainclude]" value="dbopts">
                            <input type="hidden" name="'.session_name().'" value="'.session_id().'">', '', 2);
$ADMINTABLE2->AddRow('<input type="submit" name="submit" value="'.$_LANGUAGE['DO_SQL'].'">&nbsp;&nbsp;<input type="reset" name="reset" value="'.$_LANGUAGE['empty_query_field'].'">', '', 2);







$ADMINTABLE2->CloseForm();
$CONTENTINHALT .= $ADMINTABLE2->GetTable();
unset($_SESSION['POSTDATA']);


















?>