<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | APBoard v3.0.0                                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2004 APP - Another PHP Program                    |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2 of the GPL,                 |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// | If you did not receive a copy of the GPL license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | <dma147 at mieland-programming dot de> so we can mail you a copy     |
// | immediately.                                                         |
// +----------------------------------------------------------------------+
// | Authors: Alexander Mieland <dma147 at mieland-programming dot de>    |
// |          Eric Appelt <lacritima at php-lexikon dot de>               |
// +----------------------------------------------------------------------+
//
// +----------------------------------------------------------------------+
// $Id: index.php,v 1.1 2005/10/24 21:23:16 dma147 Exp $
// +----------------------------------------------------------------------+
// $RCSfile: index.php,v $
// $Revision: 1.1 $
// $Date: 2005/10/24 21:23:16 $
// $Author: dma147 $
// +----------------------------------------------------------------------+



@session_destroy();

header ("Location: ../../index.php");
exit;

?>