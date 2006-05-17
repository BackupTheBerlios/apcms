<?php
/**
 * Project:		APCms: (Another PHP) Complex module system
 *
 * This source file is subject to version 2 of the GPL,
 * that is bundled with this package in the file LICENSE, and is
 * available through the world-wide-web at the following url:
 * http://www.gnu.org/copyleft/gpl.html.
 * If you did not receive a copy of the GPL license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * <dma147@php-programs.de> so we can mail you a copy immediately.
 *
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-general-subscribe@lists.php.net
 *
 * @link http://apcms.php-programs.de
 * @version 0.0.1-pre1
 * @copyright Copyright: 2000-2006 Alexander 'dma147' Mieland
 * @author Alexander 'dma147' Mieland <dma147@php-programs.de>
 * @access public
 * @package apcms
 * @subpackage libraries
 * 
 * $Id: benchmark.class.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
 */

/*)\
\(*/



/**
 * Exit the script when IN_apcms_admin is not defined
 */
if (!defined('IN_apcms')) {
	exit;
}


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
class BP_BENCH
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
    function BP_BENCH()
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