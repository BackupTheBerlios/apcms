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



/** Include der Smarty-Klassen */
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']);


/** Neues Template starten */
$FOOTER = _APCMS_StartNewTemplate();



if ((_APCMS_ActionIsActive('index_useronlinestats') && _APCMS_UserAccess('index_useronlinestats')) && (isset($contentinclude) && $contentinclude=="index"))
    {
    $FOOTER->assign("useronline_on", 1);
    $FOOTER->assign("onlinetimeout_minutes", $onlinetimeout_minutes);
    $FOOTER->assign("useronline_onlinenum_formatted", $OnlineUserIndexStats['useronline_onlinenum_formatted']);
    $FOOTER->assign("useronline_onlineuser_formatted", $OnlineUserIndexStats['useronline_onlineuser_formatted']);
    }



if ((_APCMS_ActionIsActive('index_usertodayonline') && _APCMS_UserAccess('index_usertodayonline')) && (isset($contentinclude) && $contentinclude=="index"))
    {
    $FOOTER->assign("usertodayonline_on", 1);
    $FOOTER->assign("usertodayonline_num_formatted", $TodayOnlineUserStats['usertodayonline_num_formatted']);
    $FOOTER->assign("usertodayonline_user_formatted", $TodayOnlineUserStats['usertodayonline_user_formatted']);
    }



/* Ausgabe der HTML-Daten an den Browser */
$FOOTERCONTENT = $FOOTER->fetch('footer.full.html');

?>