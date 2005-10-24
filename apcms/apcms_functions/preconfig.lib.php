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



/** Kontrollieren ob Array $_SESSION vorhanden, wenn nicht, dann Konfiguration starten */
// ### 0.0.2 ###
if(!isset($_SESSION) || !isset($_SESSION['APCMS']) || !isset($_SESSION['APCMS']['SUFFIX']) || trim($_SESSION['APCMS']['SUFFIX']) == "")
    {
    $_SESSION['sessid'] = session_id();
    $_SESSION['SID1'] = "?".session_name()."=".session_id();
    $_SESSION['SID2'] = "&".session_name()."=".session_id();
    $_SESSION['APCMS']['SUFFIX'] = $SUFFIX;
    $_SESSION['APCMS']['REL_URL'] = ".";
    /** Include der Basis-Konfiguration des Systems */
    include($_SESSION['APCMS']['PATH']."/apcms_configs/configuration.base.".$_SESSION['APCMS']['SUFFIX']);
    /** Include der Konfigurations-Funktionen des Systems */
    include($_SESSION['APCMS']['PATH']."/apcms_functions/apcms_config.func.".$_SESSION['APCMS']['SUFFIX']);
    }





















?>