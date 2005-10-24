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



/** Include der Smarty-Klassen */
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']);
$HEADERISLOADED = 1;

/** Neues Template starten */
$HEADER = _APCMS_StartNewTemplate($TITLE_LOCATION);


if (@file_exists($_SESSION['APCMS']['ETC_DIR']."/header.extra.".$_SESSION['APCMS']['SUFFIX']))
    {
    $fp_exm = @fopen($_SESSION['APCMS']['ETC_DIR']."/header.extra.".$_SESSION['APCMS']['SUFFIX'], "r");
    $EXTRAMETA = @fread($fp_exm, @filesize($_SESSION['APCMS']['ETC_DIR']."/header.extra.".$_SESSION['APCMS']['SUFFIX']));
    @fclose($fp_exm);
    $HEADER->assign("EXTRAMETA", $EXTRAMETA);
    }



/* Ausgabe der HTML-Daten an den Browser */
$HEADCONTENT = $HEADER->fetch('header.minimal.html');




?>