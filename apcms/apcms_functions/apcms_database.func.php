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



require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_database.class.".$_SESSION['APCMS']['SUFFIX']);
$db = new APCMS_DB($_SESSION['MYSQLDATA']['HOST'], $_SESSION['MYSQLDATA']['USER'], $_SESSION['MYSQLDATA']['PASSWD'], $_SESSION['MYSQLDATA']['DB']);
if ($_SESSION['APCMS']['BOARD']['DEBUGGING'] == true)
    $db->setDebug(1); 
else 
    $db->setDebug(0); 


?>