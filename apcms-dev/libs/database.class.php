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
 * Klasse für alle gebräuchlichen Datenbank-Abfragen
 *
 * @access         public
 * @return         void
 * @author         Alexander Mieland
 * @copyright      2000-  by Alexander 'dma147' Mieland
 */
class BP_DB
    {
    
    /** 
     * @var string Der Servername oder die IP-Adresse des Datenbank-Servers (z.B. localhost) 
     */
    var $MySQL_HostName     =      'localhost';
    
    /** 
     * @var string Der Username des Datenbank-Users
     */
    var $MySQL_UserName     =      'root';
    
    /** 
     * @var string Das Passwort des Datenbank-Users
     */
    var $MySQL_Password     =      '';
    
    /** 
     * @var string Der Name der Datenbank
     */
    var $MySQL_Database     =      'bp';
    
    ////////////////////////////////////////////////////////
    
    var $link               =       0;
    var $queryid            =       0;
    var $query              =       '';
    var $errno              =       0;
    var $errdesc            =       '';
    var $limitstart         =       0;
    var $limitlength        =       0;
    var $mysqlversion       =       0;
    var $DEBUGGING          =       0;
    var $QUERYCOUNTER       =       0;
    var $QUERYARRAY         =       array();
    
    
    /**
     * Initialisiert die Class und connected zur Datenbank
     *
     * @param          string $MySQL_HostName Name oder IP des Datenbank-Servers
     * @param          string $MySQL_UserName Name des Datenbank-User
     * @param          string $MySQL_Password Passwort des Datenbank-Users
     * @param          string $MySQL_Database Name der Datenbank
     * @param          int $persitent Persistent connecten? (0/1)
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function BP_DB($MySQL_HostName,$MySQL_UserName,&$MySQL_Password,$MySQL_Database, $persitent=0) 
        {
        $this->MySQL_HostName=$MySQL_HostName;
        $this->MySQL_UserName=$MySQL_UserName;
        $this->MySQL_Password=$MySQL_Password;
        $this->MySQL_Database=$MySQL_Database;
        if ($persitent >= 1)
            $this->pconnect();
        else 
            $this->connect();
        }    

    /**
     * Startet das Debugging
     *
     * @param          int $DEBUGGING Debugging an oder aus (1/0)
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function setDebug($DEBUGGING=0) 
        {
        if ($DEBUGGING>=1)
            $this->DEBUGGING=1;
        }
    
    /**
     * Gibt Fehlermeldungen aus
     *
     * @param          string $errormsg Error-Message
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function error($errormsg) 
        {
        $this->errdesc = mysql_error();
        $this->errno = mysql_errno();
        $QUERYSTRING = (trim($_SERVER['QUERY_STRING'])!=""?"?".$_SERVER['QUERY_STRING']:"");
        $SCRIPT = (eregi("php", $_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:(eregi("php", $_SERVER['SCRIPT_FILENAME'])?$_SERVER['SCRIPT_FILENAME']:$_SERVER['SCRIPT_NAME'])).$QUERYSTRING;
        $errormsg .= "<br /><span style=\"font-weight:bolder\">Beschreibung:</span> ".$this->errdesc."\n<br />";
        $errormsg .= "<span style=\"font-weight:bolder\">Fehlernummer:</span> ".$this->errno."\n<br />";
        $errormsg .= "<span style=\"font-weight:bolder\">MySQL-Version:</span> ".$this->mysqlversion()."\n<br />";
        $errormsg .= "<span style=\"font-weight:bolder\">PHP-Version:</span> ".phpversion()."\n<br />";
        $errormsg .= "<span style=\"font-weight:bolder\">Zeit:</span> ".date("d.m.Y, H:i")." Uhr\n<br />";
        $errormsg .= "<span style=\"font-weight:bolder\">Script:</span> ".$SCRIPT."\n<br />";
        $errormsg .= "<span style=\"font-weight:bolder\">Referer:</span> ".$_SERVER['HTTP_REFERER']."\n<br><br />";
        die($errormsg);
        }
    
    /**
     * Gibt die Version des MySQL-Servers aus
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         string
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function mysqlversion() 
        {
        if($this->link)
            list($this->mysqlversion) = $this->query_first("SELECT VERSION()");
        if(!$this->mysqlversion)
            $this->mysqlversion="unknown";
        return $this->mysqlversion;
        }

    /**
     * Connectet zur Datenbank
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function connect() 
        {
        $this->link = @mysql_connect($this->MySQL_HostName,$this->MySQL_UserName,$this->MySQL_Password);
        if (!$this->link) 
            {
            $this->error("<span style=\"font-weight:bolder\">Der Datenbank-Server (".$this->MySQL_HostName.") konnte nicht connected werden!</span><br /><span style=\"color:red;font-weight:bolder\">!</span>linkID = @mysql_connect(".$this->MySQL_HostName.", ".$this->MySQL_UserName.", ***);<br />");
            }
        if ($this->MySQL_Database != "") 
            {
            $this->select_db($this->MySQL_Database);
            }
        }
    
    /**
     * Connectet persistent zur Datenbank
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function pconnect() 
        {
        $this->link = @mysql_pconnect($this->MySQL_HostName,$this->MySQL_UserName,$this->MySQL_Password);
        if (!$this->link) 
            {
            $this->error("<span style=\"font-weight:bolder\">Der Datenbank-Server (".$this->MySQL_HostName.") konnte nicht persistent connected werden!</span><br /><span style=\"color:red;font-weight:bolder\">!</span>linkID = @mysql_<span style=\"color:red;font-weight:bolder\">p</span>connect(".$this->MySQL_HostName.", ".$this->MySQL_UserName.", ***);<br />");
            }
        if ($this->MySQL_Database != "") 
            {
            $this->select_db($this->MySQL_Database);
            }
        }
    
    /**
     * Schliesst die Connection zur Datenbank
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function close() 
        {
        @mysql_close($this->link);
        }
    
    /**
     * Selektiert die Datenbank
     *
     * @param          string $MySQL_Database Der Datenbank-Name
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function select_db($MySQL_Database="") 
        {
        if ($MySQL_Database!="") 
            $this->MySQL_Database=$MySQL_Database;
        if(!@mysql_select_db($this->MySQL_Database, $this->link)) 
            $this->error("<span style=\"font-weight:bolder\">Die Datenbank konnte nach dem Connect nicht erreicht werden!</span><br /><span style=\"color:red;font-weight:bolder\">!</span>@mysql_select_db(".$this->MySQL_Database.", ".$this->link.");<br />");
        }
    
    /**
     * Macht ein @mysql_query() und liefert query-id zurück
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          int $limitstart Start eines eventl. Limits
     * @param          int $limitlength Länge eines eventl. Limits
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         int
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function query($sqlquery, $limitstart=0, $limitlength=0) 
        {
        if($limitlength != 0)
            $sqlquery .= " LIMIT $limitstart, $limitlength";
        $this->queryid = @mysql_query($sqlquery, $this->link);
        if (!$this->queryid)
            $this->error("<span style=\"font-weight:bolder\">Falscher oder Inkorrekter SQL-String: </span> ".$sqlquery."<br />");
        if ($this->DEBUGGING>=1)
            {
            $this->QUERYCOUNTER++;
            $this->QUERYARRAY[] = $sqlquery;
            }
        return $this->queryid;
        }
 
    /**
     * Macht ein @mysql_unbuffered_query() und liefert query-id zurück
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          int $limitstart Start eines eventl. Limits
     * @param          int $limitlength Länge eines eventl. Limits
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         int
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function unbuffered_query($sqlquery, $limitstart=0, $limitlength=0) 
        {
        if($limitlength != 0) 
            $sqlquery .= " LIMIT $limitstart, $limitlength";
        $this->queryid = @mysql_unbuffered_query($sqlquery, $this->link);
        if (!$this->queryid) 
            $this->error("<span style=\"font-weight:bolder\">Falscher oder Inkorrekter SQL-String: </span> ".$sqlquery."<br />");
        if ($this->DEBUGGING>=1)
            {
            $this->QUERYCOUNTER++;
            $this->QUERYARRAY[] = $sqlquery;
            }
        return $this->queryid;
        }

    /**
     * Macht ein @mysql_query() mit LIMIT 0,1, danach ein @mysql_fetch_array() und liefert komplettes Resultset zurück (macht danach auch ein @mysql_free_result())
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          string $mode Fetch-Mode (row/assoc)
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function query_first($sqlquery, $mode='row') 
        {
        $this->queryid = $this->query($sqlquery, 0, 1);
        if ($mode == "row")
            $returnarray = $this->fetch_row($this->queryid);
        else 
            $returnarray = $this->fetch_array($this->queryid);
        $this->free($this->queryid);
        return $returnarray;
        }

    /**
     * Macht ein @mysql_unbuffered_query() mit LIMIT 0,1, danach ein @mysql_fetch_array() und liefert komplettes Resultset zurück (macht danach auch ein @mysql_free_result())
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          string $mode Fetch-Mode (row/assoc)
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function unbuffered_query_first($sqlquery, $mode='row') 
        {
        $this->queryid = $this->unbuffered_query($sqlquery, 0, 1);
        if ($mode == "row")
            $returnarray = $this->fetch_row($this->queryid);
        else 
            $returnarray = $this->fetch_array($this->queryid);
        $this->free($this->queryid);
        return $returnarray;
        }
    
    /**
     * Macht ein @mysql_fetch_array() und liefert komplettes Resultset zurück
     *
     * @param          int $queryid die queryid (zurückgegeben von z.B. $this->query())
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function fetch_array($queryid=-1) 
        {
        if ($queryid != -1) 
            $this->queryid = $queryid;
        $this->record = @mysql_fetch_array($this->queryid, MYSQL_ASSOC);
        return $this->record;
        }
    
    /**
     * Macht ein @mysql_fetch_row() und liefert komplettes Resultset zurück
     *
     * @param          int $queryid die queryid (zurückgegeben von z.B. $this->query())
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function next_record($queryid=-1) 
        {
        if ($queryid != -1) 
            $this->queryid = $queryid;
        $this->record = @mysql_fetch_row($this->queryid);
        return $this->record;
        }
    
    /**
     * Macht ein @mysql_fetch_row() und liefert komplettes Resultset zurück
     *
     * @param          int $queryid die queryid (zurückgegeben von z.B. $this->query())
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function fetch_row($queryid=-1) 
        {
        if ($queryid != -1) 
            $this->queryid = $queryid;
        $this->record = @mysql_fetch_row($this->queryid);
        return $this->record;
        }

    /**
     * Macht eine komplette mysql-Abfrage und liefert den kompletten Tabellen-Inhalt in einem Array zurück (macht danach auch ein @mysql_free_result())
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          int $limitstart Start eines eventl. Limits
     * @param          int $limitlength Länge eines eventl. Limits
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function getAll_assoc($sqlquery, $limitstart=0, $limitlength=0) 
        {
        $this->queryid = $this->query($sqlquery, $limitstart, $limitlength);
        if (!$this->queryid) 
            $this->error("<span style=\"font-weight:bolder\">Falscher oder Inkorrekter SQL-String: </span> ".$sqlquery."<br />");
        $returnarray = array();
        $retcount = 0;
        while ($this->record = $this->fetch_array($this->queryid))
            {
            $returnarray[$retcount] = $this->record;
            $retcount++;
            }
        $this->free($this->queryid);
        return $returnarray;
        }
    
    /**
     * Macht eine komplette mysql-Abfrage und liefert den kompletten Tabellen-Inhalt in einem Array zurück (macht danach auch ein @mysql_free_result())
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          int $limitstart Start eines eventl. Limits
     * @param          int $limitlength Länge eines eventl. Limits
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function getAll_row($sqlquery, $limitstart=0, $limitlength=0) 
        {
        $this->queryid = $this->query($sqlquery, $limitstart, $limitlength);
        if (!$this->queryid) 
            $this->error("<span style=\"font-weight:bolder\">Falscher oder Inkorrekter SQL-String: </span> ".$sqlquery."<br />");
        $returnarray = array();
        $retcount = 0;
        while ($this->record = $this->fetch_row($this->queryid))
            {
            $returnarray[$retcount] = $this->record;
            $retcount++;
            }
        $this->free($this->queryid);
        return $returnarray;
        }
    
    /**
     * Macht eine komplette unbuffered_mysql-Abfrage und liefert den kompletten Tabellen-Inhalt in einem Array zurück (macht danach auch ein @mysql_free_result())
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          int $limitstart Start eines eventl. Limits
     * @param          int $limitlength Länge eines eventl. Limits
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function unbuffered_getAll_assoc($sqlquery, $limitstart=0, $limitlength=0) 
        {
        $this->queryid = $this->unbuffered_query($sqlquery, $limitstart, $limitlength);
        if (!$this->queryid) 
            $this->error("<span style=\"font-weight:bolder\">Falscher oder Inkorrekter SQL-String: </span> ".$sqlquery."<br />");
        $returnarray = array();
        $retcount = 0;
        while ($this->record = $this->fetch_array($this->queryid))
            {
            $returnarray[$retcount] = $this->record;
            $retcount++;
            }
        $this->free($this->queryid);
        return $returnarray;
        }
    
    /**
     * Macht eine komplette unbuffered_mysql-Abfrage und liefert den kompletten Tabellen-Inhalt in einem Array zurück (macht danach auch ein @mysql_free_result())
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          int $limitstart Start eines eventl. Limits
     * @param          int $limitlength Länge eines eventl. Limits
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function unbuffered_getAll_row($sqlquery, $limitstart=0, $limitlength=0) 
        {
        $this->queryid = $this->unbuffered_query($sqlquery, $limitstart, $limitlength);
        if (!$this->queryid) 
            $this->error("<span style=\"font-weight:bolder\">Falscher oder Inkorrekter SQL-String: </span> ".$sqlquery."<br />");
        $returnarray = array();
        $retcount = 0;
        while ($this->record = $this->fetch_row($this->queryid))
            {
            $returnarray[$retcount] = $this->record;
            $retcount++;
            }
        $this->free($this->queryid);
        return $returnarray;
        }
    
    /**
     * Liefert die Anzahl der Datensätze
     *
     * @param          int $queryid die queryid (zurückgegeben von z.B. $this->query())
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         int
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function num_rows($queryid=-1) 
        {
        if ($queryid != -1) 
            $this->queryid = $queryid;
        return @mysql_num_rows($this->queryid);
        }
    
    /**
     * Liefert die Anzahl der Datensätze, die verändert wurden
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         int
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function affected_rows() 
        {
        return @mysql_affected_rows($this->link);
        }
    
    /**
     * Liefert die auto_increment ID des letzten INSERT
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         int
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function insert_id() 
        {
        return @mysql_insert_id($this->link);
        }
    
    /**
     * Setzt den Zeiger auf angegebenen Datensatz im resultset
     *
     * @param          int $result die queryid (zurückgegeben von z.B. $this->query())
     * @param          int $nr Nummer des Datensatzes zu dem der Zeiger gesetzt werden soll
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function data_seek($result,$nr)
        {
        if(!@mysql_data_seek($result,$nr)) 
            $this->error("<span style=\"font-weight:bolder\">Kann Zeiger nicht auf Datensatz ".$i." in resultset ".$result." setzen!</span>");
        }
    
    /**
     * Gibt ein resultset komplett frei, leert den damit verbunden speicher
     *
     * @param          int $result die queryid (zurückgegeben von z.B. $this->query())
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         void
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function free($queryid=-1)
        {
        if ($queryid != -1) 
            $this->queryid = $queryid;
        if (!@mysql_free_result($this->queryid))
            $this->error("<span style=\"font-weight:bolder\">Kann Resultset nicht frei machen!<br>Kein offenes Resultset mehr vorhanden.</span><br>");
        $this->queryid = -1;
        }
    
    /**
     * Gibt Debug-Informationen zur Anzahl der benötigten Querys und der Querys im Einzelnen aus<br>
     * Gibt ein Array aus mit den elementen 'num' und 'sql'
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function GetNumQuerys()
        {
        if ($this->DEBUGGING>=1)
            return $this->QUERYCOUNTER;
        else 
            return false;
        }
    
    /**
     * Gibt Debug-Informationen zur Anzahl der benötigten Querys und der Querys im Einzelnen aus<br>
     * Gibt ein Array aus mit den elementen 'num' und 'sql'
     *
     * @since          0.0.1
     * @version        0.0.2
     * @access         public
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function GetSavedQuerys()
        {
        if ($this->DEBUGGING>=1)
            return $this->QUERYARRAY;
        else 
            return false;
        }
    
    /**
     * Gibt ein multidim Array zurück mit den EXPLAIN Werten eines Querys
     *
     * @param          string $sqlquery Das SQL-Query
     * @param          int $limitstart Start eines eventl. Limits
     * @param          int $limitlength Länge eines eventl. Limits
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function explainAll($sqlquery, $limitstart=0, $limitlength=0) 
        {
        $sqlquery = "EXPLAIN ".$sqlquery;
        $this->queryid = $this->query($sqlquery, $limitstart, $limitlength);
        if (!$this->queryid) 
            $this->error("<span style=\"font-weight:bolder\">Falscher oder Inkorrekter SQL-String: </span> ".$sqlquery."<br />");
        $returnarray = array();
        $retcount = 0;
        while ($this->record = $this->fetch_array($this->queryid))
            {
            $returnarray[$retcount] = $this->record;
            $retcount++;
            }
        $this->free($this->queryid);
        return $returnarray;
        }
    
    /**
     * Splittet einen langen Querystring und gibt die einzelnen Querys in einem Array zurück
     *
     * @param          string $sql Das SQL-Query
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function ParseQuerys($sql)
        {
        $sql = stripslashes(_BP_trim($sql));
        $ret = array();
        $sql = preg_replace( array("`^#.*\n`m","`^/\*.*\*/\n`m","`^--.*\n`m","`\n|\r\n|\r`m"), array("","","","\n"), $sql);
        $ret = preg_split("/;\n/m", $sql);
        if (!preg_match('/;\n/m', $ret[count($ret)-1]))
            {
            $sqlreturn = $ret[count($ret)-1];
            array_splice($ret, count($ret) -1, 1);
            $ret[] = (preg_match("`;$`", _BP_trim($sqlreturn))?substr(_BP_trim($sqlreturn), 0, strlen(_BP_trim($sqlreturn))-1):_BP_trim($sqlreturn));
            }
        $ret = _BP_ArrayTrim($ret);
        return $ret;
        }
    
    /**
     * Führt alle Querys aus dem Array aus und gibt eventuelle Daten über das Ergebnis zurück
     *
     * @param          array $sqlarray Das SQL-Query-Array
     * @since          0.0.1
     * @version        0.0.2
     * @access         private
     * @return         array
     * @author         Alexander Mieland
     * @copyright      2000-2004 by APP - Another PHP Program
     */
    function DoQuerys($sqlarray)
        {
        $query_num = count($sqlarray);
        $ret = array();
        require_once($_SESSION['PATH']."/libs/benchmark.class.".$_SESSION['SUFFIX']);
        $b1 = new BP_BENCH();
        $b1->Start();
        if ($query_num==1)
            {
            $sql = _BP_trim($sqlarray[0]);
            if (preg_match("`^SELECT[\s]+`i", $sql))
                {
                $result = $this->unbuffered_getAll_assoc($sql);
                $ret['queryreturn'] = $result;
                }
            elseif (preg_match("`^UPDATE[\s]+`i", $sql))
                {
                $result = $this->unbuffered_query($sql);
                $ret['num'] = $this->affected_rows();
                $ret['queryreturn'][0] = array();
                }
            elseif (preg_match("`^INSERT[\s]+INTO[\s]+`i", $sql))
                {
                $result = $this->unbuffered_query($sql);
                $ret['num'] = $this->affected_rows();
                $ret['queryreturn'][0] = array();
                }
            elseif (preg_match("`^DROP[\s]+TABLE[\s]+`i", $sql))
                {
                $result = $this->unbuffered_query($sql);
                $ret['queryreturn'][0] = array();
                }
            elseif (preg_match("`^TRUNCATE[\s]+TABLE[\s]+`i", $sql))
                {
                $result = $this->unbuffered_query($sql);
                $ret['num'] = $this->affected_rows();
                $ret['queryreturn'][0] = array();
                }
            elseif (preg_match("`^CREATE[\s]+TABLE[\s]+`i", $sql))
                {
                $result = $this->unbuffered_query($sql);
                $ret['queryreturn'][0] = array();
                }
            elseif (preg_match("`^EXPLAIN[\s]+`i", $sql))
                {
                $result = $this->unbuffered_getAll_assoc($sql);
                $ret['queryreturn'] = $result;
                }
            else 
                {
                $result = $this->unbuffered_query($sql);
                $ret['num'] = $this->affected_rows();
                $ret['queryreturn'][0] = array();
                }
            if (!isset($ret['num']) || $ret['num'] <= 0)
                $ret['num'] = 0;
            }
        else
            {
            for ($a=0;$a<$query_num;$a++)
                {
                $sql = _BP_trim($sqlarray[$a]);
                $this->unbuffered_query($sql);
                }
            $ret['num'] = $a;
            }
        $b1->Stop();
        $ret['runtime'] = $b1->BenchmarkTime();
        return $ret;
        }
    
    
    
    
    
    
    
    
    
    
    
    
    
    }








?>