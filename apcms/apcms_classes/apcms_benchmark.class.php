<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | APCMS v0.0.2                                                         |
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
// $Id: apcms_benchmark.class.php,v 1.1 2005/10/24 21:22:08 dma147 Exp $
// +----------------------------------------------------------------------+
// $RCSfile: apcms_benchmark.class.php,v $
// $Revision: 1.1 $
// $Date: 2005/10/24 21:22:08 $
// $Author: dma147 $
// +----------------------------------------------------------------------+





/**
 * Klasse zur Zeitmessung von Abläufen.
 *
 * @since          0.0.1
 * @version        0.0.2
 * @access         public
 * @return         void
 * @author         Alexander Mieland
 * @copyright      2000-2004 by APP - Another PHP Program
 */
class APCMS_BENCH
    {
    
    /** Der Startwert */
    var $Start;
    /** Der Endwert */
    var $Stop;
    
    /**
     * Initialisiert die Class und setzt die Zeitwerte auf Null.
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function APCMS_BENCH()
        {
        $this->Start = 0;
        $this->Stop = 0;
        }
    
    /**
     * Gibt die aktuelle Zeit in Microsekunden zurück.
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         float
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function GetMicroTime()
        { 
        list($usec, $sec) = explode(" ",microtime()); 
        return ((float)$usec + (float)$sec); 
        }
    
    /**
     * Startet den Benchmark.
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function Start()
        {
        $this->Start = $this->GetMicroTime();
        }
    
    /**
     * Stoppt den Benchmark.
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function Stop()
        {
        usleep(1);
        $this->Stop = $this->GetMicroTime();
        }
    
    /**
     * Gibt die Zeit in Sekunden zurück, die zwischen den beiden Benchmark-Timern abgelaufen ist.
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         float
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function BenchmarkTime()
        {
        $result = (float) substr(((float)$this->Stop - (float)$this->Start), 0, 6);
        return $result;
        }
    
    }



?>