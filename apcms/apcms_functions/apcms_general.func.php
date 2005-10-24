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



/** 
 * Setzt oder löscht ein Cookie 
 * 
 * @param          string $cookie_name Name des Cookies 
 * @param          string $cookie_data Inhalt des Cookies 
 * @param          int $time Gültig bis (Unix-Timestamp) 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_SetCookie($cookie_name, $cookie_data="", $time=0) 
    { 
    @setcookie("$cookie_name", "$cookie_data", "$time"); 
    return true; 
    } 
     
/** 
 * Messagebox zur Darstellung von Fehler, Hinweise oder sonstigen Meldungen 
 * 
 * @param          string $titel Überschrift 
 * @param          string $msg Die Fehlermeldung 
 * @param          string $REDIRECT_URL Weiterleitungs-URL 
 * @param          string $REDIRECT_TIME Zeit in Sek. bis Weiterleitung 
 * @param          int $critical 1: Script wird abgebrochen | 0: Script läuft weiter 
 * @param          string $width Tabellenbreite der Box 
 * @param          string $fontcol Farbe der Schrift 
 * @param          string $bordercol Farbe des Rahmens der Box 
 * @param          string $tablebg Farbe des Hintergrundes der Box 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         public 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_MsgBox($titel, $msg, $REDIRECT_URL='', $REDIRECT_TIME='', $critical=0, $width='100%', $fontcol='#555555', $bordercol='#666666', $tablebg='#ffc5b7') 
	{ 
	global $HEADERISLOADED, $_LANGUAGE; 
	if (trim($msg) != "") 
        { 
        $msg = " 
        <table align=\"center\" cellspacing=\"1\" cellpadding=\"6\" border=\"0\" width=\"".$width."\" bgcolor=\"".$bordercol."\"> 
          <tr> 
        	<td align=\"center\" valign=\"middle\" bgcolor=\"".$tablebg."\"> 
        		<span style=\"color:".$fontcol.";font-weight:bolder;font-size:16px\"><strong>".$titel."</strong></span> 
        	</td> 
          </tr> 
          <tr> 
        	<td align=\"left\" valign=\"middle\" bgcolor=\"".$tablebg."\"> 
        		<span style=\"color:".$fontcol.";\">".$msg."</span><br /><br />"; 
       if (isset($REDIRECT_URL) && trim($REDIRECT_URL) != "") 
            { 
            $msg .= "<table width=\"100%\" bnorder=\"0\" cellspacing=\"0\" cellpadding=\"0\"> 
                        <tr> 
                            <td>&nbsp; &nbsp; &nbsp;[ <a href=\"".$REDIRECT_URL."\">".$_LANGUAGE['ull_be_redirected']."</a> ]</td> 
                            <td align=\"right\" width=\"30%\">[ <a href=\"javascript:history.back();\">".$_LANGUAGE['back']."</a> ]&nbsp; &nbsp; &nbsp;</td> 
                        </tr> 
                    </table>"; 
            } 
        else  
            { 
            $msg .= "<table width=\"100%\" bnorder=\"0\" cellspacing=\"0\" cellpadding=\"0\"> 
                        <tr> 
                            <td align=\"left\">[ <a href=\"javascript:history.back();\">".$_LANGUAGE['back']."</a> ]&nbsp; &nbsp; &nbsp;</td> 
                        </tr> 
                    </table>"; 
            } 
        $msg .= "</td> 
          </tr> 
        </table>"; 
        if ($critical >= 1) 
            { 
            $_SESSION['APCMS']['BOARD']['DEBUGGING'] = false; 
            if ($HEADERISLOADED == 0)  
                { 
                /** Header includen und anzeigen */ 
                include($_SESSION['APCMS']['INC_DIR']."/header.full.".$_SESSION['APCMS']['SUFFIX']); 
                } 
            echo $msg; 
            /** Footer includen und anzeigen */ 
            include($_SESSION['APCMS']['INC_DIR']."/footer.full.".$_SESSION['APCMS']['SUFFIX']); 
            exit; 
            return; 
            } 
        else  
            { 
            return $msg; 
            } 
        } 
    else  
        { 
        return false; 
        } 
	} 
 
/** Nur numerische Zeichen (0-9) */ 
define( "PWD_ALLOW_NUM", ( 1 << 0 )); 
/** Nur kleine, alphanumerische Zeichen (a-z) */ 
define( "PWD_ALLOW_LC",  ( 1 << 1 )); 
/** Nur grosse, alphanumerische Zeichen (A-Z) */ 
define( "PWD_ALLOW_UC",  ( 1 << 2 )); 
/** Nur numerische Zeichen UND kleine, alphanumerische Zeichen (0-9,a-z) */ 
define( "PWD_ALLOW_DFLT", ( PWD_ALLOW_NUM | PWD_ALLOW_LC )); 
/** Alle numerischen und alphanumerischen Zeichen (0-9,a-z,A-Z) */ 
define( "PWD_ALLOW_ALL", ( PWD_ALLOW_NUM | PWD_ALLOW_LC  | PWD_ALLOW_UC )); 
 
/** 
 * Generiert einen Zufallsstring mit $pwdLen Länge aus $usables Zeichen 
 * 
 * @param          int $pwdLen Länge des zu erzeugenden Strings 
 * @param          const $usables erlaubte Zeichen 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GeneratePasswd($pwdLen=8,$usables=PWD_ALLOW_DFLT) 
	{ 
	$pwdSource = ""; 
	$STRING = ""; 
	if ( $usables & ( 1 << 0 ))     $pwdSource .= "1234567890"; 
	if ( $usables & ( 1 << 1 ))     $pwdSource .= "abcdefghijklmnopqrstuvwxyz"; 
	if ( $usables & ( 1 << 2 ))     $pwdSource .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
	srand ((double) microtime() * 1000000); 
	while ( $pwdLen ) 
		{ 
		srand ((double) microtime() * 1000000); 
		$STRING .= substr( $pwdSource, rand( 0, strlen( $pwdSource )), 1); 
		$pwdLen--; 
		} 
	return $STRING; 
	} 
 
/** 
 * Überprüft eine EMailadresse auf Echtheit 
 * 
 * @param          string $email zu überprüfende EMailadresse 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ValidateMail($email) 
	{ 
    if (eregi("^[0-9a-z_]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,4}$", $email, $check)) 
        { 
        if ( getmxrr(substr(strstr($check[0], '@'), 1), $validate_email_temp) ) 
            { 
            return TRUE; 
            } 
        if(checkdnsrr(substr(strstr($check[0], '@'), 1),"ANY")) 
            { 
            return TRUE; 
            } 
        return TRUE; 
        } 
    return FALSE; 
    } 
 
/** 
 * Überprüft URL auf Erreichbarkeit und gibt Status-Code aus 
 * 
 * @param          string $url 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GetStatusCodeFromUrl($url) 
    { 
    global $errno, $errstr; 
    $statuscode =''; 
    $status = array(); 
    $url=trim($url); 
    if(!isset($url)) return ''; 
    if(!isset($errno)) $errno = 0; 
    if(!isset($errstr)) $errstr = 0; 
    #### Statuscodes ##### 
    $scode['N/A'] = "Ikke HTTP"; 
    $scode['OK']    = "Valid hostname"; 
    $scode['FEJL']  = "Invalid hostname"; 
    $scode['Dead']  = "No responce"; 
    $scode[100]   = "Continue"; 
    $scode[101]   = "Switching Protocols"; 
    $scode[200]   = "OK"; 
    $scode[201]   = "Created"; 
    $scode[202]   = "Accepted"; 
    $scode[203]   = "Non-Authoritative Information"; 
    $scode[204]   = "No Content"; 
    $scode[205]   = "Reset Content"; 
    $scode[206]   = "Partial Content"; 
    $scode[300]   = "Multiple Choices"; 
    $scode[301]   = "Moved Permanently"; 
    $scode[302]   = "Found"; 
    $scode[303]   = "See Other"; 
    $scode[304]   = "Not Modified"; 
    $scode[305]   = "Use Proxy"; 
    $scode[307]   = "Temporary Redirect"; 
    $scode[400]   = "Bad Request"; 
    $scode[401]   = "Unauthorized"; 
    $scode[402]   = "Payment Required"; 
    $scode[403]   = "Forbidden"; 
    $scode[404]   = "Not Found"; 
    $scode[405]   = "Method Not Allowed"; 
    $scode[406]   = "Not Acceptable"; 
    $scode[407]   = "Proxy Authentication Required"; 
    $scode[408]   = "Request Timeout"; 
    $scode[409]   = "Conflict"; 
    $scode[410]   = "Gone"; 
    $scode[411]   = "Length Required"; 
    $scode[412]   = "Precondition Failed"; 
    $scode[413]   = "Request Entity Too Large"; 
    $scode[414]   = "Request-URI Too Long"; 
    $scode[415]   = "Unsupported Media Type"; 
    $scode[416]   = "Requested Range Not Satisfiable"; 
    $scode[417]   = "Expectation Failed"; 
    $scode[500]   = "Internal Server Error"; 
    $scode[501]   = "Not Implemented"; 
    $scode[502]   = "Bad Gateway"; 
    $scode[503]   = "Service Unavailable"; 
    $scode[504]   = "Gateway Timeout"; 
    $scode[505]   = "HTTP Version Not Supported"; 
    $status['html'] = ''; 
    if (eregi("^(http|https|ftp)://(www\.)?.+\.[a-z]{2,}([\/\?]+[a-z#%&0-9:=_-]*)*$", $url) && $url) 
        { 
        $urlArray = parse_url($url); 
        if (!isset($urlArray['port']))  
            $urlArray['port'] = "80"; 
        if (!isset($urlArray['path']))  
            $urlArray['path'] = "/"; 
        $sock = @fsockopen($urlArray['host'], $urlArray['port'], $errno, $errstr, 3); 
        if (!$sock) 
            { 
            $status['code'] = "Dead"; 
            $status['contentType'] = ''; 
            $status['html'] = ''; 
            $status['msg'] = ''; 
            } 
        else 
            { 
            $dump = "GET ".$urlArray['path']." HTTP/1.1\r\n"; 
        	$dump .= "Host: ".$urlArray['host']."\r\n"; 
        	$dump .= "Keep-Alive: 10\r\n"; 
        	$dump .= "Connection: close\r\n\r\n"; 
            @fputs($sock, $dump); 
            @socket_set_timeout($sock, 2); 
            $linecounter = 0; 
            while ($str = @fgets($sock, 1024)) 
                { 
                $linecounter++; 
                $status['html'] .= $str; 
                if (eregi("^http/[0-9]+.[0-9]+ ([0-9]{3}) [a-z ]*", $str)) 
                	{ 
                 	$status['code'] = trim(eregi_replace("^http/[0-9]+.[0-9]+ ([0-9]{3})[a-z ]*", "\\1", $str)); 
                	} 
                if (eregi("^Content-Type: ", $str)) 
                	{ 
                 	$status['contentType'] = trim(eregi_replace("^Content-Type: ", "", $str)); 
                	} 
                if ($linecounter==20) 
                    break; 
            	} 
            } 
        @fclose($sock); 
        } 
    if (!isset($status['code']) || trim($status['code'])=="") 
        $status['code'] = "Dead"; 
    $status['lines'] = $linecounter; 
    $status['msg'] = $scode[$status['code']]; 
    if (!isset($status['contentType']) || trim($status['contentType']) == "") 
        $status['contentType'] = ""; 
    return $status; 
    } 

/** 
 * Startet neues Template-Object und setzt generelle Template-Einstellungen und Variablen 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         obj 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_StartNewTemplate($location='') 
    {
    global $_LANGUAGE; 
    $template = new Smarty; 
    $location = (trim($location)!=""?" - ".trim(strip_tags($location)):"");
    
    /** Generelle Template-Einstellungen setzen */ 
    $template->template_dir       =   $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/templates"; 
    $template->compile_dir        =   $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/templates_c"; 
    $template->config_dir         =   $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/configs"; 
    $template->cache_dir          =   $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/cache"; 
    $template->plugins_dir        =   array($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/plugins"); 
    $template->caching            =   false; 
    $template->force_compile      =   $_SESSION['APCMS']['TEMPLATES']['FORCE_COMPILE']; 
    $template->compile_check      =   $_SESSION['APCMS']['TEMPLATES']['COMPILE_CHECK']; 
    $template->debugging          =   $_SESSION['APCMS']['TEMPLATES']['DEBUGGING']; 
     
    /** Website-Titel an Style übergeben */ 
    $template->assign("headtitle", str_replace("{\$APCMSVERSION}", _APCMS_version(), trim($_SESSION['APCMS']['CONFIG']['title']).$location)); 
    $template->assign("navtitle", str_replace("{\$APCMSVERSION}", _APCMS_version(), trim($_SESSION['APCMS']['CONFIG']['title']))); 
    $template->assign("description", str_replace("{\$APCMSVERSION}", _APCMS_version(), trim($_SESSION['APCMS']['CONFIG']['description']))); 
    
    /** Generelle Style-Variablen */ 
    $template->assign("DIR", $_SESSION['APCMS']['PATH']); 
    $template->assign("JS_DIR", $_SESSION['APCMS']['JS_DIR']); 
    $template->assign("ETC_DIR", $_SESSION['APCMS']['ETC_DIR']); 
    $template->assign("INC_DIR", $_SESSION['APCMS']['INC_DIR']); 
    $template->assign("LIB_DIR", $_SESSION['APCMS']['LIB_DIR']); 
    $template->assign("TMP_DIR", $_SESSION['APCMS']['TMP_DIR']); 
    $template->assign("USR_DIR", $_SESSION['APCMS']['USR_DIR']); 
    $template->assign("STYLES_DIR", $_SESSION['APCMS']['STYLES_DIR']); 
    $template->assign("URL", $_SESSION['APCMS']['URL']); 
    $template->assign("REL_URL", $_SESSION['APCMS']['REL_URL']); 
    $template->assign("JS_URL", $_SESSION['APCMS']['JS_URL']); 
    $template->assign("ETC_URL", $_SESSION['APCMS']['ETC_URL']); 
    $template->assign("INC_URL", $_SESSION['APCMS']['INC_URL']); 
    $template->assign("LIB_URL", $_SESSION['APCMS']['LIB_URL']); 
    $template->assign("TMP_URL", $_SESSION['APCMS']['TMP_URL']); 
    $template->assign("USR_URL", $_SESSION['APCMS']['USR_URL']); 
    $template->assign("STYLES_URL", $_SESSION['APCMS']['STYLES_URL']); 
    $template->assign("STYLE", $_SESSION['APCMS']['STYLE']); 
    $template->assign("tablebg", $_SESSION['APCMS']['TABLE']['BGCOLOR']); 
    $template->assign("tablewidth", $_SESSION['APCMS']['TABLE']['WIDTH']); 
    $template->assign("SID", session_id()); 
    $template->assign("SESSNAME", session_name()); 
    $template->assign("SID1", $_SESSION['SID1']); 
    $template->assign("SID2", $_SESSION['SID2']); 
    $template->assign("PATH", $_SESSION['APCMS']['PATH']); 
    $template->assign("SUFFIX", $_SESSION['APCMS']['SUFFIX']); 
    $template->assign("APCMSVERSION", _APCMS_version()); 
    $template->assign("HELPSYS_NAV_ADMIN", _APCMS_HelpSystem($_LANGUAGE['helpsys_admincenter_desc'])); 
    $template->assign("HELPSYS_NAV_PROFIL", _APCMS_HelpSystem($_LANGUAGE['helpsys_profil_desc'])); 
    $template->assign("HELPSYS_NAV_LOGOUT", _APCMS_HelpSystem($_LANGUAGE['helpsys_logout_desc'])); 
    $template->assign("HELPSYS_NAV_HELP", _APCMS_HelpSystem($_LANGUAGE['helpsys_help_desc'])); 
    $template->assign("HELPSYS_NAV_REGELN", _APCMS_HelpSystem($_LANGUAGE['helpsys_regeln_desc'])); 
    $template->assign("HELPSYS_NAV_REGISTER", _APCMS_HelpSystem($_LANGUAGE['helpsys_register_desc'])); 
    $template->assign("HELPSYS_NAV_LOGIN", _APCMS_HelpSystem($_LANGUAGE['helpsys_login_desc'])); 
    $template->assign("HELPSYS_NAV_PASSWORD", _APCMS_HelpSystem($_LANGUAGE['helpsys_pwforgotten_desc'])); 
    $template->assign("HELPSYS_NAV_IMPRESSUM", _APCMS_HelpSystem($_LANGUAGE['helpsys_impressum_desc'])); 
    $template->assign("HELPSYS_NAV_COPYRIGHT", _APCMS_HelpSystem($_LANGUAGE['helpsys_copyright_desc'])); 
    $template->assign("HELPSYS_NAV_LOGO", _APCMS_HelpSystem($_LANGUAGE['helpsys_logo_desc'])); 
    $template->assign("HELPSYS_NAV_TITEL", _APCMS_HelpSystem($_LANGUAGE['helpsys_title_desc'])); 
    return $template; 
    } 
 
/** 
 * Erzeugt den HelpSystem-Container auf Links 
 * 
 * @param          string $helptext Der anzuzeigende Hilfetext 
 * @param          string $caption Der anzuzeigende Hilfe-Titel 
 * @param          int $delay Die Zeit in Millisek. bis der Container angezeigt werden soll 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_HelpSystem($helptext, $caption='APCMS HelpSystem', $delay='200') 
    { 
    $OUT = ""; 
    if (_APCMS_ActionIsActive('enable_helpsys') && _APCMS_UserAccess('enable_helpsys')) 
        { 
        $OUT = " onmouseover=\"return overlib('".$helptext."',CAPTION,'".$caption."',OFFSETX,0,OFFSETY,42,DELAY,'".$delay."',CAPICON,'".$_SESSION['APCMS']['STYLES_URL']."/".$_SESSION['APCMS']['STYLE']."/images/icons/fragezeichen.gif',FGCOLOR,'".$_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']."',BGCOLOR,'".$_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']."',TEXTCOLOR,'".$_SESSION['APCMS']['HELPSYSTEM']['TEXTCOLOR']."',CAPCOLOR,'".$_SESSION['APCMS']['HELPSYSTEM']['CAPCOLOR']."');\" onmouseout=\"nd();\" "; 
        } 
    return $OUT; 
    } 
 
/** 
 * Überprüft Variablen in der URL auf SQL-Injection oder sonstige unerlaubte Zeichenfolgen 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         void 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_NoScriptKiddies() 
    { 
    global $_LANGUAGE; 
    $scriptlogfile = $_SESSION['APCMS']['LOG_DIR']."/SCRIPTKIDDIES.log.txt"; 
    foreach ($_GET as $secvalue) 
    	{ 
    	if ((@eregi("<[^>]*script*\"?[^>]*>", $secvalue)) || 
    	(@eregi("<[^>]*object*\"?[^>]*>", $secvalue)) || 
    	(@eregi("<[^>]*iframe*\"?[^>]*>", $secvalue)) || 
    	(@eregi("<[^>]*applet*\"?[^>]*>", $secvalue)) || 
    	(@eregi("<[^>]*meta*\"?[^>]*>", $secvalue)) || 
    	(@eregi("<[^>]*style*\"?[^>]*>", $secvalue)) || 
    	(@eregi("<[^>]*form*\"?[^>]*>", $secvalue)) || 
    	(@eregi("<[^>]*img*\"?[^>]*>", $secvalue)) || 
    	(@eregi("\([^>]*\"?[^)]*\)", $secvalue)) || 
    	(@preg_match("`;[\s]*INSERT[\s]+INTO[\s]+`i", $secvalue)) || 
    	(@preg_match("`;[\s]*UPDATE[\s]+`i", $secvalue)) || 
    	(@preg_match("`;[\s]*DELETE[\s]+FROM[\s]+`i", $secvalue)) || 
    	(@preg_match("`;[\s]*TRUNCATE[\s]+`i", $secvalue)) || 
    	(@preg_match("`;[\s]*DROP[\s]+TABLE[\s]+`i", $secvalue)) || 
    	(@preg_match("`;[\s]*DROP[\s]+DATABASE[\s]+`i", $secvalue))) 
    		{ 
    		$SECERROR = "=====================      LOGGING ON      ===================\n"; 
    		$SECERROR .= $_LANGUAGE['possible_security_attack']."\n"; 
    		$SECERROR .= $_LANGUAGE['time'].": ".date("d.m.Y, H:i:s", time())."\n"; 
    		$SECERROR .= $_LANGUAGE['ip_adress'].": ".$_SERVER['REMOTE_ADDR']."\n"; 
    		$SECERROR .= "session-ID: ".session_id()."\n"; 
    		$SECERROR .= $_LANGUAGE['get_string'].":\n"; 
    		$SECERROR .= stripslashes($secvalue)."\n"; 
    		$SECERROR .= "=====================      LOGGING OFF     ===================\n"; 
    		@error_log($SECERROR, 3, $scriptlogfile); 
    		@chmod($scriptlogfile, 0777); 
    		unset($_SESSION); 
    		@session_destroy(); 
    		unset($_SESSION); 
    		@session_destroy(); 
    		echo "<html>\n<head>\n<title> Security Alert! </title>\n<meta http-equiv=\"refresh\" content=\"4;url=http://www.disney.com/\">\n</head>\n<body>\n<pre>\n<b>".$_LANGUAGE['no_script_kiddies_1']."</b>\n\n".htmlspecialchars($SECERROR)."\n\n <b>".$_LANGUAGE['no_script_kiddies_2']."</b>\n</pre>\n</body>\n</html>\n"; 
    		exit; 
    		} 
    	} 
    } 
 
/** 
 * Überprüft anhand der Gruppen, die ein User angehört, ob dieser die angegebene Action ausführen darf 
 * 
 * @param          array $action Die Action, die der User ausführen möchte 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_UserAccess($action) 
    { 
    for ($a=0;$a<count($_SESSION['USERGROUPS']);$a++) 
        { 
        if (@in_array($_SESSION['USERGROUPS'][$a], $_SESSION['ACTIONRIGHTS'][$action])) 
            { 
            return true; 
            } 
        } 
    return false; 
    } 
 
/** 
 * Überprüft anhand des übergebenen Gruppenarray, ob ein User die Action ausführen darf 
 * 
 * @param          array $groupsarray Das Array mit den Usergruppen, die Access haben 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_CanAccess($groupsarray) 
    { 
    if (@eregi(";", $groupsarray) && @eregi(":", $groupsarray)) 
        { 
        $temp = $groupsarray; 
        unset($groupsarray); 
        $groupsarray = array(); 
        $groupsarray = unserialize(stripslashes(chop(trim($temp)))); 
        } 
    for ($a=0;$a<count($_SESSION['USERGROUPS']);$a++) 
        { 
        if (@in_array($_SESSION['USERGROUPS'][$a], $groupsarray)) 
            { 
            return true; 
            } 
        } 
    return false; 
    } 
 
/** 
 * Überprüft Ob ein Feature (Action) an (active) oder aus ist 
 * 
 * @param          array $action Die Action, die der User ausführen möchte 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ActionIsActive($action) 
    { 
    foreach($_SESSION['ACTIONRIGHTS'] as $key => $val) 
        { 
        if ($key == $action) 
            return true; 
        } 
    return false; 
    } 
 
/** 
 * Parst einen String nach APCMS-eigenen Access-Vars und baut ihn entsprechend der aktuellen Userrechte um<br> 
 * Beispiel für solch einen String:<br> 
 * "Ein Link zum {#if#useronline#}&lt;a href=&quot;./index.php?s=useronline&quot;&gt;{#endif#useronline#}zum UserOnline{#if#useronline#}&lt;/a&gt;{#endif#useronline#}."<br> 
 * Wenn der User das entsprechende Recht hat, wird der Link gesetzt, ansonsten bekommt er nur den kompletten Satz, ohne den Link zu sehen. 
 * 
 * @param          string $string Der String der die Access-Vars enthält 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ParseAccessVars($string) 
    { 
    $match1 = array(); 
    $needed_intervals = intval(substr_count($string, "#if#")); 
    $interval_counter = 0; 
    while ($interval_counter<$needed_intervals) 
        { 
        preg_match_all("`(\{#if#([a-z0-9_]*?)#\})(.*)(\{#endif#\\2#\})`iU", $string, $match1); 
        for ($mcount=0;$mcount<count($match1[2]);$mcount++) 
            { 
            if (trim($match1[2][$mcount]) != "") 
                { 
                if (!_APCMS_ActionIsActive($match1[2][$mcount]) && !_APCMS_UserAccess($match1[2][$mcount])) 
                    { 
                    $string = preg_replace("`(\{#if#(".$match1[2][$mcount].")#\})(.*)(\{#endif#\\2#\})`iU", "", $string); 
                    } 
                else  
                    { 
                    $string = preg_replace("`(\{#if#(".$match1[2][$mcount].")#\})(.*)(\{#endif#\\2#\})`iU", "\\3", $string); 
                    } 
                } 
            } 
        $interval_counter++; 
        } 
    return $string; 
    } 
 
/** 
 * Entfernt alle Leerzeichen, Tabs, Umbrüche am Beginn und am Ende eines Strings 
 * 
 * @param          string $text Der String 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_trim($text) 
    { 
    if($text != "")  
        { 
        $text=str_replace(chr(160), " ", $text); 
        $text=str_replace(chr(173), " ", $text); 
        $text=str_replace(chr(240), " ", $text); 
        $text=str_replace("\0", " ", $text); 
        $text = chop(trim($text)); 
        } 
    return $text; 
    } 
 
/** 
 * Dreht alle Buchstaben und Ziffern um 
 * 
 * @param          string $txt Der Posting-Text 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Relict 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_TurnChars($txt) 
    { 
    if(trim($txt) != '') 
        { 
        $txt = strrev($txt); 
        } 
    return $txt; 
    } 
 
/** 
 * Dreht alle Wörter um 
 * 
 * @param          string $txt Der Posting-Text 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Relict 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_TurnWords($txt) 
    { 
    if(trim($txt) != '') 
        { 
        $txt = implode(" ", (array_reverse(explode(" ", $txt)))); 
        } 
    return $txt; 
    } 
 
/** 
 * Kürzt einen String auf die angegebene Länge, ohne Wörter zu unterbrechen 
 * 
 * @param          string $str Der zu kürzende String 
 * @param          int $len Die neue Länge des String 
 * @param          string $el Ein Zusatz, der an den kurzen String angehängt werden soll 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Relict 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_Truncate($str, $len, $el='...') 
    { 
    if($len<1)  
        $len=30; 
    if (strlen($str) > $len)  
        { 
        $xl = strlen($el); 
        if ($len < $xl)  
            { 
            return substr($str, 0, $len); 
            } 
        $str = substr($str, 0, $len-$xl); 
        $spc = strrpos($str, ' '); 
        if ($spc > 0)  
            { 
            $str = substr($str, 0, $spc); 
            } 
        return $str . $el; 
        } 
    return $str; 
    } 
 
/** 
 * Verschlüsselt einen String zuerst nach crypt und dann nochmal nach md5 
 * 
 * @param          string $pwd Der String 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_CryptPasswd($pwd) 
	{ 
	$crypted_passwd = crypt($pwd, "CRYPT_MD5"); 
	$STRING = md5($crypted_passwd); 
	return $STRING; 
	} 
 
/** 
 * Entfernt alle Escapes aus den Elementen eines Arrays 
 * 
 * @param          array $array Das Array 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         array 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ArrayStripslashes(&$array)  
    { 
    reset ($array); 
    foreach ($array as $key => $val) 
        { 
        if (is_string($val))  
            $array[$key] = stripslashes($val); 
        elseif (is_array($val))  
            $array[$key] = _APCMS_ArrayStripslashes($val); 
        } 
    return $array; 
    } 
 
 
/** 
 * Entfernt alle Whitespaces aus den Elementen eines Arrays 
 * 
 * @param          array $array Das Array 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         array 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ArrayTrim(&$array)  
    { 
    reset ($array); 
    foreach ($array as $key => $val) 
        { 
        if (is_string($val))  
            $array[$key] = _APCMS_trim($val);   
        elseif (is_array($val))  
            $array[$key] = _APCMS_ArrayTrim($val); 
        } 
    return $array; 
    } 
 
 
/** 
 * Wandelt den Type aller Elemente eines Arrays in INT um, wenn es sich um Zahlen handelt 
 * 
 * @param          array $array Das Array 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         array 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ArrayIntval(&$array)  
    { 
    reset ($array); 
    foreach ($array as $key => $val) 
        { 
        if (is_numeric($val))  
            $array[$key] = intval($val); 
        elseif (is_array($val))  
            $array[$key] = _APCMS_ArrayIntval($val); 
        } 
    return $array; 
    } 
 
/** 
 * Ersetzt einen Teilstring in allen Elemente eines Arrays 
 * 
 * @param          array $search Der zu ersetzende String 
 * @param          array $replace Der einzufügende String 
 * @param          array $array Das Array 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         array 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ArrayStrReplace($search, $replace, $array)  
    { 
    reset ($array); 
    foreach ($array as $key => $val) 
        { 
        if (!is_array($val))  
            $array[$key] = str_replace($search, $replace, $val); 
        else 
            $array[$key] = _APCMS_ArrayStrReplace($val); 
        } 
    return $array; 
    } 
 
/** 
 * Wandelt einen String so um, dass er in einem yellow-Tipp angezeigt werden kann (alt-text, title-text, etc.) 
 * 
 * @param          string $string Der String 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_String2Yellow($string)  
    { 
    $string = str_replace("<br>", "\n", $string); 
    $string = str_replace("<br />", "\n", $string); 
    $string = strip_tags($string); 
    $string = _APCMS_trim($string); 
    $string = addslashes($string); 
    return $string; 
    } 
 
/** 
 * Erstellt einen Link 
 * 
 * @param          string $url Die Ziel-URI 
 * @param          string $title Der Link-Text 
 * @param          string $helptext Der Hilfetext für das Helpsystem (overlib) 
 * @param          string $target Das Target 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_MakeHref($url, $title, $helptext='', $target='_self')  
    { 
    if ($helptext!="") 
        $helptext = _APCMS_HelpSystem($helptext); 
    $hrefstring = "<a href=\"".$url."\"".($target!=""?" target=\"".$target."\"":"")." ".$helptext.">".$title."</a>"; 
    return $hrefstring; 
    } 
 
/** 
 * Erstellt einen IMG-Tag 
 * 
 * @param          string $picurl Die Ziel-URI 
 * @param          string $alt Der ALT-Text 
 * @param          string $width Die Breite in Pixel 
 * @param          string $height Die Höhe in Pixel 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_MakeImg($picurl, $alt="", $width=0, $height=0)  
    { 
    $sizestring = ""; 
    if ($width>=1) 
        $sizestring .= " width=\"".$width."\""; 
    if ($height>=1) 
        $sizestring .= " height=\"".$height."\""; 
    $imgstring = "<img src=\"".$picurl."\" border=\"0\" ".$sizestring." alt=\""._APCMS_String2Yellow($alt)."\" title=\""._APCMS_String2Yellow($alt)."\" />"; 
    return $imgstring; 
    } 
 
/** 
 * Konvertiert HTML-Code zur Anzeige 
 * 
 * @param          string $text Der zu konvertierende HTML-Code 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_SpecialChars($text)  
    { 
    return htmlspecialchars($text); 
    } 
 
/** 
 * DE-Konvertiert HTML-Code zur Anzeige 
 * 
 * @param          string $text Der zu konvertierende HTML-Code 
 * @since          1.0 
 * @version        2.2 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_DeSpecialChars($text)  
    { 
    $transtable = get_html_translation_table(HTML_SPECIALCHARS); 
    $transtable = array_flip($transtable); 
    $text = strtr($text, $transtable); 
    return $text; 
    } 
 
/** 
 * Gibt Informationen zu globalen Arrays aus 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         public 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_DebugVarsOut() 
    { 
    $DEBUGOUTPUT = ''; 
    $DEBUGOUTPUT .= "\n<hr size=\"1\" noshade>"; 
    $DEBUGOUTPUT .= "<b>\$_SESSION:</b><br>"; 
    $DEBUGOUTPUT .= "session_id(): ".session_id()."<br><br>"; 
    @reset($_SESSION); 
    while (list($key1,$val1) = @each($_SESSION)) 
    	{ 
    	if (!eregi("mysql", $key1)) 
            { 
            if(!is_array($val1)) $val1=htmlspecialchars($val1); 
            $DEBUGOUTPUT .= "<b><span style=\"color:#ff6363\">\$_SESSION['$key1'] = $val1</span></b><br>"; 
            @reset($_SESSION[$key1]); 
            while (list($key2,$val2) = @each($_SESSION[$key1])) 
            	{ 
            	if (!eregi("mysql", $key1)) 
                    { 
                	if(!is_array($val2)) $val2=htmlspecialchars($val2); 
                	$DEBUGOUTPUT .= "<span style=\"color:#f20000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_SESSION['$key1']['$key2'] = $val2</span><br>"; 
                	@reset($_SESSION[$key1][$key2]); 
                	while (list($key3,$val3) = @each($_SESSION[$key1][$key2])) 
                		{ 
                		if(!is_array($val3)) $val3=htmlspecialchars($val3); 
                		$DEBUGOUTPUT .= "<span style=\"color:#aa0000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_SESSION['$key1']['$key2']['$key3'] = $val3</span><br>"; 
                		@reset($_SESSION[$key1][$key2][$key3]); 
                		while (list($key4,$val4) = @each($_SESSION[$key1][$key2][$key3])) 
                			{ 
                			if(!is_array($val4)) $val4=htmlspecialchars($val4); 
                			$DEBUGOUTPUT .= "<span style=\"color:#6d0000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_SESSION['$key1']['$key2']['$key3']['$key4'] = $val4</span><br>"; 
                			} 
                		} 
                    } 
            	} 
            } 
        } 
    if(count($_POST)>0) 
        { 
    	$DEBUGOUTPUT .= "\n<hr size=\"1\" noshade>"; 
    	$DEBUGOUTPUT .= "<b>\$_POST:</b><br><br>"; 
        } 
    @reset($_POST); 
    while (list($key1,$val1) = @each($_POST)) 
    	{ 
    	if(!is_array($val1)) $val1=htmlspecialchars($val1); 
    	$DEBUGOUTPUT .= "<b><span style=\"color:#ff6363\">\$_POST['$key1'] = $val1</span></b><br>"; 
    	@reset($_POST[$key1]); 
    	while (list($key2,$val2) = @each($_POST[$key1])) 
    		{ 
    		if(!is_array($val2)) $val2=htmlspecialchars($val2); 
    		$DEBUGOUTPUT .= "<span style=\"color:#f20000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_POST['$key1'][$key2'] = $val2</span><br>"; 
    		@reset($_POST[$key1][$key2]); 
    		while (list($key3,$val3) = @each($_POST[$key1][$key2])) 
    			{ 
    			if(!is_array($val3)) $val3=htmlspecialchars($val3); 
    			$DEBUGOUTPUT .= "<span style=\"color:#aa0000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_POST['$key1']['$key2']['$key3'] = $val3</span><br>"; 
    			@reset($_POST[$key1][$key2][$key3]); 
    			while (list($key4,$val4) = @each($_POST[$key1][$key2][$key3])) 
    				{ 
    				if(!is_array($val14)) $val4=htmlspecialchars($val4); 
    				$DEBUGOUTPUT .= "<span style=\"color:#6d0000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_POST['$key1']['$key2']['$key3']['$key4'] = $val4</span><br>"; 
    				} 
    			} 
    		} 
    	} 
    if(count($_GET)>0) 
        { 
    	$DEBUGOUTPUT .= "\n<hr size=\"1\" noshade>"; 
    	$DEBUGOUTPUT .= "<b>\$_GET:</b><br><br>"; 
        } 
    @reset($_GET); 
    while (list($key1,$val1) = @each($_GET)) 
    	{ 
    	if(!is_array($val1)) $val1=htmlspecialchars($val1); 
    	$DEBUGOUTPUT .= "<b><span style=\"color:#ff6363\">\$_GET['$key1'] = $val1</span></b><br>"; 
    	@reset($_GET[$key1]); 
    	while (list($key2,$val2) = @each($_GET[$key1])) 
    		{ 
    		if(!is_array($val2)) $val2=htmlspecialchars($val2); 
    		$DEBUGOUTPUT .= "<span style=\"color:#f20000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_GET['$key1']['$key2'] = $val2</span><br>"; 
    		@reset($_GET[$key1][$key2]); 
    		while (list($key3,$val3) = @each($_GET[$key1][$key2])) 
    			{ 
    			if(!is_array($val3)) $val3=htmlspecialchars($val3); 
    			$DEBUGOUTPUT .= "<span style=\"color:#aa0000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_GET['$key1']['$key2']['$key3'] = $val3</span><br>"; 
    			@reset($_GET[$key1][$key2][$key3]); 
    			while (list($key4,$val4) = @each($_GET[$key1][$key2][$key3])) 
    				{ 
    				if(!is_array($val4)) $val4=htmlspecialchars($val4); 
    				$DEBUGOUTPUT .= "<span style=\"color:#6d0000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$_GET['$key1']['$key2']['$key3']['$key4'] = $val4</span><br>"; 
    				} 
    			} 
    		} 
    	} 
    return $DEBUGOUTPUT."\n"; 
    } 
 
/** 
 * Gibt Informationen zu den Vorraussetzungen und den gegebenen Möglichkeiten aus 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         public 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ShowRequirements() 
    { 
    $WRITEABLE_DIRS = array( 
                            './apcms_content', 
                            './apcms_styles/app', 
                            './apcms_styles/app/cache', 
                            './apcms_styles/app/images', 
                            './apcms_styles/app/images/navbuttons', 
                            './apcms_styles/app/templates_c', 
                            './apcms_sysdir', 
                            './apcms_sysdir/backups', 
                            './apcms_sysdir/cache', 
                            './apcms_sysdir/last_backup', 
                            './apcms_sysdir/temp', 
                            './apcms_userdir', 
                            './apcms_userdir/avatare', 
                            './apcms_userdir/profilpics', 
                            './apcms_userdir/userpics', 
                            './apcms_userdir/uploads' 
    ); 
    $INSTALLED_EXTS = array('ftp','gd','mcrypt','sockets','session','zlib'); 
    $OUT = ""; 
    $OUT .= "<br /><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td colspan=\"3\"><strong>empfohlene Systemvoraussetzungen:</strong></td></tr><tr><td colspan=\"3\">&nbsp;</td></tr><tr><td><u>Eigenschaft</u></td><td width=\"80\"><u>empfohlen</u></td><td width=\"80\"><u>vorhanden</u></td></tr> 
    <tr><td>PHP Version</td><td width=\"80\">4.1.0</td><td width=\"80\"><span style=\"color: ".((version_compare(phpversion(), "4.1.0")==-1) ? ("red") : ("green"))."\">".phpversion()."</span></td></tr><tr><td>GDLib Version</td><td width=\"80\">2.0.0</td> 
    <td width=\"80\"><span style=\"color: ".((version_compare(_APCMS_getGDVersion(), "2.0.0")==-1) ? ("red") : ("green"))."\">"._APCMS_getGDVersion()."</span></td></tr><tr><td colspan=\"3\"><strong>Features</strong></td></tr><tr><td>GDLib Truecolor</td><td width=\"80\">Ja</td> 
    <td width=\"80\"><span style=\"color: ".((!_APCMS_haveTCSupport()) ? ("red") : ("green"))."\">".((_APCMS_haveTCSupport()) ? ("Ja") : ("Nein"))."</span></td></tr><tr><td>GDLib TTF Support</td><td width=\"80\">Ja</td><td width=\"80\"><span style=\"color: ".((!_APCMS_haveTTFSupport()) ? ("red") : ("green"))."\">".((_APCMS_haveTTFSupport()) ? ("Ja") : ("Nein"))."</span></td> 
    </tr><tr><td>GDLib PNG Write Support</td><td width=\"80\">Ja</td><td width=\"80\"><span style=\"color: ".((!_APCMS_havePNGSupport()) ? ("red") : ("green"))."\">".((_APCMS_havePNGSupport()) ? ("Ja") : ("Nein"))."</span></td></tr><tr><td>GDLib JPEG Write Support</td><td width=\"80\">Ja</td> 
    <td width=\"80\"><span style=\"color: ".((!_APCMS_haveJPEGSupport()) ? ("red") : ("green"))."\">".((_APCMS_haveJPEGSupport()) ? ("Ja") : ("Nein"))."</span></td></tr><tr><td colspan=\"3\"><strong>Konfiguration</strong></td></tr><tr><td>safe_mode</td><td width=\"80\">deaktiviert</td><td width=\"80\"><span style=\"color: ".((get_cfg_var("safe_mode")) ? ("blue") : ("green"))."\">".((get_cfg_var("safe_mode")) ? ("aktiviert") : ("deaktiviert"))."</span></td> 
    </tr><tr><td>register_globals</td><td width=\"80\">deaktiviert</td><td width=\"80\"><span style=\"color: ".((get_cfg_var("register_globals")) ? ("green") : ("green"))."\">".((get_cfg_var("register_globals")) ? ("aktiviert") : ("deaktiviert"))."</span></td> 
    </tr><tr><td>open_basedir</td><td width=\"80\">deaktiviert</td><td width=\"80\"><span style=\"color: ".((get_cfg_var("open_basedir")) ? ("blue") : ("green"))."\">".((get_cfg_var("open_basedir")) ? ("aktiviert") : ("deaktiviert"))."</span></td> 
    </tr><tr><td>magic_quotes_sybase</td><td width=\"80\">deaktiviert</td><td width=\"80\"><span style=\"color: ".((get_cfg_var("magic_quotes_sybase")) ? ("red") : ("green"))."\">".((get_cfg_var("magic_quotes_sybase")) ? ("aktiviert") : ("deaktiviert"))."</span></td> 
    </tr><tr><td>upload_max_filesize</td><td width=\"80\">&gt; 0</td><td width=\"80\"><span style=\"color: ".((!get_cfg_var("upload_max_filesize")) ? ("blue") : ("green"))."\">".get_cfg_var("upload_max_filesize")."</span></td></tr><tr><td colspan=\"3\"><strong>Verzeichnisrechte</strong></td></tr>"; 
    for ($WDc=0;$WDc<count($WRITEABLE_DIRS);$WDc++) 
        { 
        $OUT .= "<tr><td>Schreibrechte im Verzeichnis &quot;".$WRITEABLE_DIRS[$WDc]."&quot;</td><td width=\"80\">Ja</td><td width=\"80\"><span style=\"color: ".((!is_writeable($WRITEABLE_DIRS[$WDc])) ? ("red") : ("green"))."\">".((is_writeable($WRITEABLE_DIRS[$WDc])) ? ("Ja") : ("Nein"))."</span></td></tr>"; 
        } 
    $OUT .= "<tr><td colspan=\"3\"><strong>Extensions</strong></td></tr>"; 
    for ($IEc=0;$IEc<count($INSTALLED_EXTS);$IEc++) 
        { 
        $OUT .= "<tr><td>Extension &quot;".$INSTALLED_EXTS[$IEc]."&quot;</td><td width=\"80\">Installiert</td><td width=\"80\"><span style=\"color: ".((!extension_loaded($INSTALLED_EXTS[$IEc])) ? ("red") : ("green"))."\">".((!extension_loaded($INSTALLED_EXTS[$IEc])) ? ("nicht installiert") : ("Installiert"))."</span></td></tr>"; 
        } 
    $OUT .= "</table>"; 
    return $OUT; 
    } 
 
/** 
 * Entpackt eine *.gz-Datei zur gleichen Datei ohne Endung ".gz" (Original-Datei bleibt erhalten) 
 * 
 * @param          string $srcName voller Pfad und Dateiname der zu entpackenden Datei 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         void 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GZUnCompressFile($srcName)  
    { 
    $zp = gzopen($srcName, "r"); 
    while(!gzeof($zp)) 
        $string .= gzread($zp, 4096); 
    gzclose($zp); 
    $lastpoint = strrpos($srcName, "."); 
    $dstName = substr($srcName, 0, $lastpoint); 
    $fp = fopen($dstName, "w"); 
    fwrite($fp, $string, strlen($string)); 
    fclose($fp); 
    } 
 
/** 
 * Packt eine Datei mit GZIP und fügt Endung ".gz" an (Original-Datei bleibt erhalten) 
 * 
 * @param          string $srcName voller Pfad und Dateiname der zu packenden Datei 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         void 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GZCompressFile($srcName) 
    { 
    $fp = fopen($srcName, "r"); 
    $data = fread ($fp, filesize($srcName)); 
    fclose($fp); 
    $dstName = $srcName.".gz"; 
    $zp = gzopen($dstName, "w9"); 
    gzwrite($zp, $data); 
    gzclose($zp); 
    } 
 
/** 
 * Holt MIME-Type anhand Datei-Endung 
 * 
 * @param          string $EXTENSION 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Relict 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GetMime($EXTENSION) 
    { 
    if            ((trim($EXTENSION) == "exe") OR (trim($EXTENSION) == "bat") OR (trim($EXTENSION) == "bin") OR (trim($EXTENSION) == "lha") OR (trim($EXTENSION) == "lzh") OR (trim($EXTENSION) == "dll"))         { $MIME = "application/octet-stream"; $ICON = "exe.gif"; } 
    elseif         (trim($EXTENSION) == "doc")         { $MIME = "application/msword"; $ICON = "doc.gif"; } 
    elseif         (trim($EXTENSION) == "pdf")         { $MIME = "application/pdf"; $ICON = "pdf.gif"; } 
    elseif         (trim($EXTENSION) == "eps" OR trim($EXTENSION) == "ps")         { $MIME = "application/postscript"; $ICON = "pdf.gif"; } 
    elseif         (trim($EXTENSION) == "xls")         { $MIME = "application/vnd.ms-excel"; $ICON = "doc.gif"; } 
    elseif         (trim($EXTENSION) == "ppt")         { $MIME = "application/vnd.powerpoint"; $ICON = "doc.gif"; } 
    elseif         (trim($EXTENSION) == "js")          { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "sh")          { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "swf")         { $MIME = "application/x-shockwave-flash"; } 
    elseif         (trim($EXTENSION) == "tar")         { $MIME = "application/x-tar"; $ICON = "tgz.gif"; } 
    elseif         (trim($EXTENSION) == "zip")         { $MIME = "application/x-zip-compressed"; $ICON = "zip.gif"; } 
    elseif         (trim($EXTENSION) == "rar")       { $MIME = "application/rar-compressed"; $ICON = "rar.gif"; } 
    elseif         (trim($EXTENSION) == "ace")       { $MIME = "application/ace-compressed"; $ICON = "ace.gif"; } 
    elseif         (trim($EXTENSION) == "gz")          { $MIME = "application/x-compressed"; $ICON = "tgz.gif"; } 
    elseif         (trim($EXTENSION) == "tgz")         { $MIME = "application/x-compressed"; $ICON = "tgz.gif"; } 
    elseif         (trim($EXTENSION) == "mid")         { $MIME = "audio/midi"; $ICON = "audio.gif"; } 
    elseif         (trim($EXTENSION) == "mp3")         { $MIME = "audio/mpeg"; $ICON = "audio.gif"; } 
    elseif         (trim($EXTENSION) == "rm")          { $MIME = "audio/x-pn-realaudio"; $ICON = "audio.gif"; } 
    elseif         (trim($EXTENSION) == "ra")          { $MIME = "audio/x-realaudio"; $ICON = "audio.gif"; } 
    elseif         (trim($EXTENSION) == "bmp")         { $MIME = "image/bmp"; $ICON = "gif.gif"; } 
    elseif         (trim($EXTENSION) == "jpg" OR trim($EXTENSION) == "jpeg")         { $MIME = "image/jpeg"; $ICON = "jpg.gif"; } 
    elseif         (trim($EXTENSION) == "gif")         { $MIME = "image/gif"; $ICON = "gif.gif"; } 
    elseif         (trim($EXTENSION) == "png")         { $MIME = "image/png"; $ICON = "gif.gif"; } 
    elseif         (trim($EXTENSION) == "tif" OR trim($EXTENSION) == "tiff")         { $MIME = "image/tiff"; $ICON = "gif.gif"; } 
    elseif         (trim($EXTENSION) == "wrl")         { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "css")         { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "htaccess")    { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "htpasswd")    { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "class")       { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "def")         { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "mysql")       { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "sh")          { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "html" OR trim($EXTENSION) == "htm")         { $MIME = "text/plain"; $ICON = "html.gif"; } 
    elseif         (trim($EXTENSION) == "txt")         { $MIME = "text/plain"; $ICON = "txt.gif"; } 
    elseif         (trim($EXTENSION) == "php" OR trim($EXTENSION) == "phps" OR trim($EXTENSION) == "inc" OR trim($EXTENSION) == "tmp" OR trim($EXTENSION) == "temp" OR trim($EXTENSION) == "templ" OR trim($EXTENSION) == "template")         { $MIME = "text/plain"; $ICON = "php.gif"; } 
    elseif         (trim($EXTENSION) == "php3")        { $MIME = "text/plain"; $ICON = "php3.gif"; } 
    elseif         (trim($EXTENSION) == "php4")        { $MIME = "text/plain"; $ICON = "php4.gif"; } 
    elseif         (trim($EXTENSION) == "rtf")         { $MIME = "text/rtf"; $ICON = "doc.gif"; } 
    elseif         (trim($EXTENSION) == "mpeg" OR trim($EXTENSION) == "mpg" OR trim($EXTENSION) == "mpe")         { $MIME = "video/mpeg"; $ICON = "audio.gif"; } 
    elseif         (trim($EXTENSION) == "avi")         { $MIME = "video/x-msvideo"; $ICON = "audio.gif"; } 
    elseif         (trim($EXTENSION) == "mov")         { $MIME = "video/quicktime"; $ICON = "audio.gif"; } 
    else            { $MIME = "application/unknown"; $ICON = "unknown.gif"; } 
    $FILE['MIME']= $MIME; 
    $FILE['ICON']= $ICON; 
    return $FILE; 
    } 
 
/** 
 * Holt die Version der installierten GD-Lib 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_getGDVersion() 
	{ 
	if (function_exists("gd_info")) 
		{ 
		$gd_info = gd_info(); 
		@reset ($gd_info); 
		while (@list ($key, $val) = @each ($gd_info)) 
			{ 
			if (eregi("ver", $key)) 
				{ 
				$STRING = $gd_info[$key]; 
				break 1; 
				} 
			} 
		$STRING = str_replace("bundled","",$STRING); 
		$STRING = str_replace("compatible","",$STRING); 
		$STRING = str_replace(" ","",$STRING); 
		$STRING = str_replace("(","",$STRING); 
		$STRING = str_replace(")","",$STRING); 
		$STRING = str_replace("<","",$STRING); 
		$STRING = str_replace(">","",$STRING); 
		$STRING = str_replace("=","",$STRING); 
		$STRING = "".$STRING; 
		$gdversion = $STRING; 
		#$gdversion = $STRING[0].".".$STRING[2].$STRING[4].$gdversion[5]; 
		} 
	else 
		{ 
		ob_start(); 
		$oldlevel=error_reporting(0); 
		phpinfo(); 
		error_reporting($oldlevel); 
		$buffer=ob_get_contents(); 
		ob_end_clean(); 
		$quot1 = preg_quote('<b>GD Version</b>'); 
		$STRING=preg_replace("|(.*)(".$quot1.")(.*)|siU", "\\3", $buffer); 
		$quot2 = preg_quote('</td><td align="left">'); 
		$quot3 = preg_quote('</td></tr>'); 
		$STRING=preg_replace("|(".$quot2.")(.*)(".$quot3.")(.*)|siU", "\\2", $STRING); 
		$firstpos = strpos($STRING, "\n"); 
		$STRING = substr($STRING, 0, $firstpos); 
		if (eregi(" or higher", $STRING)) 
			{ 
			$STRING = str_replace(" or higher", "", $STRING); 
			} 
		elseif (eregi("or higher", $STRING)) 
			{ 
			$STRING = str_replace("or higher", "", $STRING); 
			} 
		$STRING = "".$STRING; 
		$gdversion = $STRING; 
		#$gdversion = $STRING[0].".".$STRING[2].$STRING[4].$gdversion[5]; 
		} 
	#$gdversion = (float) $gdversion; 
	return $gdversion; 
	} 
 
/** 
 * Testet die GD-Lib auf Truecolor-Unterstützung 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_haveTCSupport() 
	{ 
	if (function_exists("imagecreatetruecolor")) 
		{ 
		if (!$tmp = ImageCreateTrueColor (10, 10)) 
			{ 
			$tcsupport = false; 
			} 
		else 
			{ 
			$testcolor = ImageColorAllocate ($tmp, 211, 167, 168); 
			ImageFill ($tmp, 0, 0, $testcolor); 
			$cindex = imagecolorat ($tmp, 4, 4); 
			if ($cindex != $testcolor) 
				{ 
				$tcsupport = false; 
				} 
			else 
				{ 
				$tcsupport = true; 
				} 
			ImageDestroy($tmp); 
			} 
		} 
	else 
		{ 
		$tcsupport = false; 
		} 
	return $tcsupport; 
	} 
 
/** 
 * Testet die GD-Lib auf TrueType-fonts-Unterstützung 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_haveTTFSupport() 
	{ 
	if (function_exists("ImageTTFText")) 
		{ 
		$ttfsupport = true; 
		} 
	else 
		{ 
		$ttfsupport = false; 
		} 
	return $ttfsupport; 
	} 
 
/** 
 * Testet die GD-Lib auf JPEG-Unterstützung 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_haveJPEGSupport() 
	{ 
	if (ImageTypes() & IMG_JPG) 
		{ 
		$jpegsupport = true; 
		} 
	else 
		{ 
		$jpegsupport = false; 
		} 
	return $jpegsupport; 
	} 
 
/** 
 * Testet die GD-Lib auf PNG-Unterstützung 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_havePNGSupport() 
	{ 
	if (ImageTypes() & IMG_PNG) 
		{ 
		$pngsupport = true; 
		} 
	else 
		{ 
		$pngsupport = false; 
		} 
	return $pngsupport; 
	} 
 
/** 
 * Testet die GD-Lib auf GIF-Unterstützung 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_haveGIFSupport() 
	{ 
	if (ImageTypes() & IMG_GIF) 
		{ 
		$gifsupport = true; 
		} 
	else 
		{ 
		$gifsupport = false; 
		} 
	return $gifsupport; 
	} 
 
/** 
 * Generiert einen Prozent-Balken 
 * 
 * @param          int $percent Die anzuzeigende Prozentzahl 
 * @param          int $notfillcolor Die Hintergrundfarbe, wo kein Farbbalken ist 
 * @param          int $width Die Gesamt-Breite des Balkens 
 * @param          int $height Die Gesamt-Höhe des Balkens 
 * @param          int $fontsize Die Schriftgrösse der Prozent-Anzeige im Balken (in Pixeln!) 
 * @param          int $type (1/0) 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GenerateBar($percent, $notfillcolor='#FFFFFF', $width=100, $height=7, $fontsize=6, $type=1) 
	{ 
	// Original function (c) by Angel 
 	global $n, $db, $APB_rp, $servertime, $styleset_folder, $tablewidth; 
 	if($percent>100) 
		{ 
		$left=$width; 
		} 
	else 
		{ 
		$left=($width/100)*$percent; 
		} 
	$right=$width-$left; 
	if($left <= ($width/2)) 
		{ 
		if($type!=1) 
			{ 
			$retval = '<table width="'.$width.'" height="'.$height.'" cellpadding="0" cellspacing="0" style="width: '.$width.'px; height: '.$height.'px; margin: 0px; border: 1px solid black; background-image: url('.$styleset_folder['icons'].'/bar2.gif); float: right">'; 
			$retval.= '	<tr>'; 
			$retval.= '		<td width="'.$left.'"> </td>'; 
			$retval.= '		<td width="'.$right.'" bgcolor="'.$notfillcolor.'" style="background-color: '.$notfillcolor.'; font-size: '.$fontsize.'px; color: #000000; font-weight: bold" align="right">'.$percent.'%&nbsp;</td>'; 
			$retval.= '	</tr>'; 
			$retval.= '</table>'; 
			} 
		else 
			{ 
			$retval = '<table width="'.$width.'" height="'.$height.'" cellpadding="0" cellspacing="0" style="width: '.$width.'px; height: '.$height.'px; margin: 0px; border: 1px solid black; background-image: url('.$styleset_folder['icons'].'/bar.gif); float: right">'; 
			$retval.= '	<tr>'; 
			$retval.= '		<td width="'.$left.'"> </td>'; 
			$retval.= '		<td width="'.$right.'" bgcolor="'.$notfillcolor.'" style="background-color: '.$notfillcolor.'; font-size: '.$fontsize.'px; color: #000000; font-weight: bold" align="right">'.$percent.'%&nbsp;</td>'; 
			$retval.= '	</tr>'; 
			$retval.= '</table>'; 
			} 
		} 
	else 
		{ 
		if($type!=1) 
			{ 
			$retval = '<table width="'.$width.'" height="'.$height.'" cellpadding="0" cellspacing="0" style="width: '.$width.'px; height: '.$height.'px; margin: 0px; border: 1px solid black; background-image: url('.$styleset_folder['icons'].'/bar2.gif); float: right">'; 
			$retval.= '	<tr>'; 
			$retval.= '		<td width="'.$left.'" align="left" style="font-size: '.$fontsize.'px; color: #000000; font-weight: bold;">&nbsp;'.$percent.'%</td>'; 
			$retval.= '		<td width="'.$right.'" bgcolor="'.$notfillcolor.'" style="background-color: '.$notfillcolor.';"> </td>'; 
			$retval.= '	</tr>'; 
			$retval.= '</table>'; 
			} 
		else 
			{ 
			$retval = '<table width="'.$width.'" height="'.$height.'" cellpadding="0" cellspacing="0" style="width: '.$width.'px; height: '.$height.'px; margin: 0px; border: 1px solid black; background-image: url('.$styleset_folder['icons'].'/bar.gif); float: right">'; 
			$retval.= '	<tr>'; 
			$retval.= '		<td width="'.$left.'" align="left" style="font-size: '.$fontsize.'px; color: #000000; font-weight: bold;">&nbsp;'.$percent.'%</td>'; 
			$retval.= '		<td width="'.$right.'" bgcolor="'.$notfillcolor.'" style="background-color: '.$notfillcolor.';"> </td>'; 
			$retval.= '	</tr>'; 
			$retval.= '</table>'; 
			} 
		} 
	return $retval; 
	} 
 
/** 
 * Dezimale Koordinaten werden in Grad-Koordinaten umgerechnet 
 * 
 * @param          string $coords 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_Coord2Degrees($coords) 
	{ 
	$degrees=floor($coords); 
	$minutes=floor(($coords-$degrees)*60); 
	return $degrees."°".($minutes<10?'0':'').$minutes."'"; 
	} 
 
/** 
 * Grad-Koordinaten werden in Dezimale Koordinaten umgerechnet 
 * 
 * @param          int $degrees 
 * @param          int $minutes 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_Degrees2Coord($degrees,$minutes) 
	{ 
	$coord = ($degrees+$minutes/60); 
	$coord = (float) $coord; 
	return $coord; 
	} 
 
/** 
 * Distanz zwischen zwei Koordinaten wird berechnet<br> 
 * Es werden Meter, Kilometer, Fuß, (Land-)Meilen, Lichtsekunden und Parsec zurückgegeben 
 * 
 * @param          string $lon1 
 * @param          string $lat1 
 * @param          string $lon2 
 * @param          string $lat2 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         array 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GetDistance($lon1, $lat1, $lon2, $lat2) 
	{ 
	$radiuserde = 6378137.0; 
	$long1 = deg2rad ($lon1); 
	$long2 = deg2rad ($lon2); 
	$lat1 = deg2rad ($lat1); 
	$lat2 = deg2rad ($lat2); 
    $dlon = $long2 - $long1; 
    $dlat = $lat2 - $lat1; 
    $a = pow( sin($dlat / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($dlon / 2), 2); 
    $d = 2 * atan2(sqrt($a), sqrt(1 - $a)); 
    $DISTANCE['meter'] 		= (float) @round(($radiuserde * $d), 2); 
    $DISTANCE['feet'] 		= (float) @round(($DISTANCE['meter']*3.28084), 2); 
    $DISTANCE['kilometer'] 	= (float) @round(($DISTANCE['meter'] / 1000), 2); 
    $DISTANCE['meilen'] 	= (float) @round(($DISTANCE['kilometer']*0.62137), 2); 
    $DISTANCE['lichtsekunden'] 	= (float) @round(($DISTANCE['kilometer']/299991.37), 10); 
    $DISTANCE['parsec'] 	= (float) @round(($DISTANCE['kilometer']/149597870), 10); 
    return $DISTANCE; 
	} 
 
 
 
 
 
/** 
 * Zeichnen einer gestrichelten Linie 
 * 
 * @param          object $image 
 * @param          int $x0 
 * @param          int $y0 
 * @param          int $x1 
 * @param          int $y1 
 * @param          object $fg 
 * @param          object $bg 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         void 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_DashedLine($image, $x0, $y0, $x1, $y1, $fg, $bg) 
	{ 
	$st = array($fg, $fg, $fg, $fg, $bg, $bg, $bg, $bg); 
	ImageSetStyle($image, $st); 
	ImageLine($image, $x0, $y0, $x1, $y1, IMG_COLOR_STYLED); 
	} 
 
/** 
 * Skaliert ein Bild in der Grösse 
 * 
 * @param          string $image Kompletter Pfad zur Bild-Datei 
 * @param          int $maxwidth Maximale Breite in Pixeln 
 * @param          int $maxheight Maximale Höhe in Pixeln 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_ImageResize($image, $maxwidth=100, $maxheight=100) 
	{ 
	$lastpoint = strrpos($image, '.'); 
	$withoutext = substr($image, 0, $lastpoint); 
	$ext = '.jpg'; 
	$newimage = $withoutext.'.new'.$ext; 
	$imagedata = GetImageSize($image); 
	if ($imagedata[2] == 1)		{ $sim = ImageCreateFromGIF($image); } 
	elseif ($imagedata[2] == 2)	{ $sim = ImageCreateFromJPEG($image); } 
	elseif ($imagedata[2] == 3)	{ $sim = ImageCreateFromPNG($image); } 
	if ($imagedata[0] > $maxwidth || $imagedata[1] > $maxheight) 
		{ 
		if ($imagedata[0] > $maxwidth) 
			{ 
			$factor_width = round(($imagedata[0] / $maxwidth), 2); 
			$newwidth = $maxwidth; 
			$newheight = round(($imagedata[1] / $factor_width)); 
			} 
		else 
			{ 
			$newwidth = $imagedata[0]; 
			$newheight = $imagedata[1]; 
			} 
		if ($newheight > $maxheight) 
			{ 
			$factor_height = round(($newheight / $maxheight), 2); 
			$newwidth = round(($newwidth / $factor_height)); 
			$newheight = $maxheight; 
			} 
		} 
	elseif ($imagedata[0] < $maxwidth || $imagedata[1] < $maxheight) 
		{ 
		if ($imagedata[0] < $maxwidth) 
			{ 
			$factor_width = round(($maxwidth / $imagedata[0]), 2); 
			$newwidth = $maxwidth; 
			$newheight = round(($imagedata[1] * $factor_width)); 
			} 
		else 
			{ 
			$newwidth = $imagedata[0]; 
			$newheight = $imagedata[1]; 
			} 
		if ($newheight < $maxheight) 
			{ 
			$factor_height = round(($maxheight / $newheight), 2); 
			$newwidth = round(($newwidth * $factor_height)); 
			$newheight = $maxheight; 
			} 
		if ($newwidth > $maxwidth) 
			{ 
			$factor_width = round(($newwidth / $maxwidth), 2); 
			$newwidth = $maxwidth; 
			$newheight = round(($newheight / $factor_width)); 
			} 
		elseif ($newheight > $maxheight) 
			{ 
			$factor_height = round(($newheight / $maxheight), 2); 
			$newwidth = round(($newwidth / $factor_height)); 
			$newheight = $maxheight; 
			} 
		} 
	else 
		{ 
		$newwidth = $imagedata[0]; 
		$newheight = $imagedata[1]; 
		} 
	if (haveTCSupport()) { $dim = ImageCreateTrueColor($newwidth, $newheight); } 
	else { $dim = ImageCreate($newwidth, $newheight); } 
	imagecopyresampled ($dim, $sim, 0, 0, 0, 0, $newwidth, $newheight, $imagedata[0], $imagedata[1]); 
	imageJPEG($dim, $newimage, 100); 
	imageDestroy($sim); 
	imageDestroy($dim); 
	return $newimage; 
	} 
 
/** 
 * Konvertiert RGB nach hex-Farben-Angabe 
 * 
 * @param          int $r Rot-Wert 
 * @param          int $g Grün-Wert 
 * @param          int $b Blau-Wert 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_rgb2hex($r,$g,$b) 
	{ 
	$hexsystem = array('00','01', '02', '03', '04', '05', '06', '07', '08', '09', '0A', '0B', '0C', '0D', '0E', '0F', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '1A', '1B', '1C', '1D', '1E', '1F', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '2A', '2B', '2C', '2D', '2E', '2F', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '3A', '3B', '3C', '3D', '3E', '3F', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '4A', '4B', '4C', '4D', '4E', '4F', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '5A', '5B', '5C', '5D', '5E', '5F', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '6A', '6B', '6C', '6D', '6E', '6F', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '7A', '7B', '7C', '7D', '7E', '7F', '80', '81', '82', '83', '84', '85', '86', '87', '88', '89', '8A', '8B', '8C', '8D', '8E', '8F', '90', '91', '92', '93', '94', '95', '96', '97', '98', '99', '9A', '9B', '9C', '9D', '9E', '9F', 'A0', 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'B0', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'C0', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'C9', 'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'D0', 'D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9', 'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'E0', 'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8', 'E9', 'EA', 'EB', 'EC', 'ED', 'EE', 'EF', 'F0', 'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'F9', 'FA', 'FB', 'FC', 'FD', 'FE', 'FF'); 
	return '#'.$hexsystem[$r].$hexsystem[$g].$hexsystem[$b]; 
	} 
 
/** 
 * Konvertiert HEX nach RGB-Farben-Angabe 
 * 
 * @param          string $hex Der HEX-Farbwert 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         array 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_hex2rgb($hex) 
	{ 
	$hexsystem = array('00','01', '02', '03', '04', '05', '06', '07', '08', '09', '0A', '0B', '0C', '0D', '0E', '0F', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '1A', '1B', '1C', '1D', '1E', '1F', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '2A', '2B', '2C', '2D', '2E', '2F', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '3A', '3B', '3C', '3D', '3E', '3F', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '4A', '4B', '4C', '4D', '4E', '4F', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '5A', '5B', '5C', '5D', '5E', '5F', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '6A', '6B', '6C', '6D', '6E', '6F', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '7A', '7B', '7C', '7D', '7E', '7F', '80', '81', '82', '83', '84', '85', '86', '87', '88', '89', '8A', '8B', '8C', '8D', '8E', '8F', '90', '91', '92', '93', '94', '95', '96', '97', '98', '99', '9A', '9B', '9C', '9D', '9E', '9F', 'A0', 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'B0', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'C0', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'C9', 'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'D0', 'D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9', 'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'E0', 'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8', 'E9', 'EA', 'EB', 'EC', 'ED', 'EE', 'EF', 'F0', 'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'F9', 'FA', 'FB', 'FC', 'FD', 'FE', 'FF'); 
	$rgb = array(); 
	$hex = strtoupper(trim($hex));
	if (eregi("#", $hex)) 
	   $hex = substr($hex, 1, strlen($hex)); 
	$R_temp = sprintf("%02s",substr($hex, 0, 2)); 
	$G_temp = sprintf("%02s",substr($hex, 2, 2)); 
	$B_temp = sprintf("%02s",substr($hex, 4, 2)); 
	for ($a=0;$a<count($hexsystem);$a++) 
	   { 
	   if ($hexsystem[$a] == $R_temp) 
	       { 
	       $rgb['r'] = sprintf("%03d",$a); 
	       } 
	   if ($hexsystem[$a] == $G_temp) 
	       { 
	       $rgb['g'] = sprintf("%03d",$a); 
	       } 
	   if ($hexsystem[$a] == $B_temp) 
	       { 
	       $rgb['b'] = sprintf("%03d",$a); 
	       }
		} 
	return $rgb; 
	} 
 
/** 
 * Generiert die Navbuttons 
 * 
 * @param          string $text Text auf dem Button 
 * @param          string $link Link 
 * @param          string $helptitel Hilfetext-Titel 
 * @param          string $helptext Hilfetext 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GenNavButton($text, $link, $helptitel, $helptext) 
    { 
    $IMGSTRING = ''; 
    $button = strtolower(str_replace(" ", "_", str_replace("-", "_", $text))); 
    if (_APCMS_havePNGSupport()) 
        { $BUTTON = $button.".png"; } 
    elseif (_APCMS_haveJPEGSupport()) 
        { $BUTTON = $button.".jpg"; } 
    elseif (_APCMS_haveGIFSupport()) 
        { $BUTTON = $button.".gif"; } 
    if (!file_exists($_SESSION['APCMS']['STYLES_DIR'].'/'.$_SESSION['APCMS']['STYLE'].'/images/navbuttons/'.$BUTTON)) 
        { 
        $NAVBUTTON = $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/images/navbuttons/navbutton.png"; 
        $NAVBUTTON_DIR = $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/images/navbuttons"; 
        $fontfile = $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/configs/buttonfont.ttf"; 
        if (_APCMS_havePNGSupport()) 
            { $im = imagecreatefrompng($NAVBUTTON); } 
        elseif (_APCMS_haveJPEGSupport()) 
            { $im = imagecreatefromjpeg($NAVBUTTON); } 
        elseif (_APCMS_haveGIFSupport()) 
            { $im = imagecreatefromgif($NAVBUTTON); } 
        $black = ImageColorAllocate ($im, 0, 0, 0); 
        $whiteRGB = _APCMS_hex2rgb($_SESSION['APCMS']['NAVBUTTONS']['COLOR']); 
        
        
        #echo $_SESSION['APCMS']['NAVBUTTONS']['COLOR']."<br>";
        #echo $whiteRGB['r']." | ".$whiteRGB['g']." | ".$whiteRGB['b']."<br>";
        
        
        $white = ImageColorAllocate ($im, intval($whiteRGB['r']), intval($whiteRGB['g']), intval($whiteRGB['b'])); 
        ImageTTFText ($im, 7, 0, 2, 11, $white, $fontfile, $text); 
        if (_APCMS_havePNGSupport()) 
        	{ 
           	imagepng($im, $NAVBUTTON_DIR."/".$BUTTON); 
        	}
        elseif (_APCMS_haveJPEGSupport()) 
        	{
        	imagejpeg($im, $NAVBUTTON_DIR."/".$BUTTON); 
        	}
        elseif (_APCMS_haveGIFSupport()) 
        	{
        	imagegif($im, $NAVBUTTON_DIR."/".$BUTTON); 
        	}
        imagedestroy ($im); 
        } 
    $IMGSTRING .= '<a href="'.$link.'" '._APCMS_HelpSystem('<b>'.$helptitel.'</b><br>'.$helptext).'>'; 
    $IMGSTRING .= _APCMS_MakeImg($_SESSION['APCMS']['STYLES_URL'].'/'.$_SESSION['APCMS']['STYLE'].'/images/navbuttons/'.$BUTTON, ucwords($button)); 
    $IMGSTRING .= '</a>'; 
    return $IMGSTRING; 
    } 
 
/** 
 * Macht eine Session-sichere URL-Weiterleitung 
 * 
 * @param          string $url Ziel-URI 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         void 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_SessionRedirect($url="") 
	{ 
    function _safe_set(&$var_true, $var_false="") 
    	{ 
        if (!isset($var_true)) 
        	{  
        	$var_true = $var_false;  
        	} 
    	} 
    $parse_url = parse_url($url); 
    _safe_set($parse_url["scheme"], "http"); 
    _safe_set($parse_url["host"], $_SERVER['HTTP_HOST']); 
    _safe_set($parse_url["path"], ""); 
    _safe_set($parse_url["query"], ""); 
    _safe_set($parse_url["fragment"], ""); 
    if (substr($parse_url["path"], 0, 1) != "/") 
    	{ 
        $parse_url["path"] = dirname($_SERVER['PHP_SELF'])."/".$parse_url["path"]; 
        } 
    if ($parse_url["query"] != "") 
    	{  
    	$parse_url["query"] = $parse_url["query"]."&amp;";  
    	} 
    $parse_url["query"] = "?".$parse_url["query"].$_SESSION['NAME']."=".strip_tags($_SESSION['ID']); 
    if ($parse_url["fragment"] != "") 
        {  
        $parse_url["fragment"] = "#".$parse_url["fragment"];  
        } 
    $url = $parse_url["scheme"]."://".$parse_url["host"].$parse_url["path"].$parse_url["query"].$parse_url["fragment"]; 
    session_write_close (); 
    header("Location: ".$url); 
    exit;      
	} 
 
/** 
 * Entfernt die SID aus einem String 
 * 
 * @param          string $string Der String aus dem die SID entfernt werden soll 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_StripSIDString($string) 
    { 
    $string = preg_replace("`([\&\?]*?".session_name()."=[a-z0-9]*?)`iU", "", $string); 
    return $string; 
    } 
 
/** 
 * Übernimmt die kompletten Update-Geschichten für Oser-Online 
 * 
 * @param          string $ONLINE_ANZEIGE String der auf der UserOnline-Seite angezeigt werden soll. 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         void 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_UpdateOnlineUser($ONLINE_ANZEIGE='') 
    { 
    global $db, $akt_zeit, $yesterday_lasttstamp, $_LANGUAGE; 
    if (trim($ONLINE_ANZEIGE) == "") 
        $ONLINE_ANZEIGE = $_LANGUAGE['uo_unknown_page']; 
    if ((_APCMS_ActionIsActive('index_useronlinestats') && _APCMS_UserAccess('index_useronlinestats')) || (_APCMS_ActionIsActive('useronline') && _APCMS_UserAccess('useronline'))) 
        { 
        $query = "DELETE FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online` WHERE `zeit`<='".($akt_zeit-$_SESSION['APCMS']['CONFIG']['online_timeout'])."'"; 
        $delonline = $db->unbuffered_query($query); 
        if (isset($_SESSION['APCMS']['USER']['userid']) && $_SESSION['APCMS']['USER']['userid'] >= 1) 
            { 
            $todayonlinearray = array(); 
            $TODAYONLINEARRAY = array(); 
            $TODAYONLINESTRING = ""; 
            $toac = 0; 
            $todayonlinefile = $_SESSION['APCMS']['LOG_DIR']."/users_today_online.log"; 
            if (file_exists($todayonlinefile)) 
                { 
                $todayonlinearray = file($todayonlinefile); 
                if (count($todayonlinearray) >= 1) 
                    { 
                    if ((filemtime($todayonlinefile) <= $yesterday_lasttstamp) && intval($akt_zeit) >= $yesterday_lasttstamp) 
                        { 
                        unset($todayonlinearray); 
                        $todayonlinearray = array(); 
                        } 
                    for ($lcount=0;$lcount<count($todayonlinearray);$lcount++) 
                        { 
                        $thisline = chop(trim($todayonlinearray[$lcount])); 
                        $linearray = explode("|", $thisline); 
                        if (intval($linearray[1]) == $_SESSION['APCMS']['USER']['userid']) 
                            { 
                            $TODAYONLINEARRAY['lasttimeonline'][$toac] = intval($akt_zeit); 
                            $TODAYONLINEARRAY['thisuserid'][$toac] = intval($linearray[1]); 
                            $TODAYONLINEARRAY['thispublicname'][$toac] = $_SESSION['APCMS']['USER']['publicname']; 
                            $ownupdated = 1; 
                            } 
                        else  
                            { 
                            $TODAYONLINEARRAY['lasttimeonline'][$toac] = intval($linearray[0]); 
                            $TODAYONLINEARRAY['thisuserid'][$toac] = intval($linearray[1]); 
                            $TODAYONLINEARRAY['thispublicname'][$toac] = $linearray[2]; 
                            } 
                        $toac++; 
                        } 
                    } 
                } 
            if (!isset($ownupdated) || $ownupdated <= 0) 
                { 
                $TODAYONLINEARRAY['lasttimeonline'][$toac] = $akt_zeit; 
                $TODAYONLINEARRAY['thisuserid'][$toac] = $_SESSION['APCMS']['USER']['userid']; 
                $TODAYONLINEARRAY['thispublicname'][$toac] = $_SESSION['APCMS']['USER']['publicname']; 
                } 
            @reset($TODAYONLINEARRAY); 
            @array_multisort($TODAYONLINEARRAY['lasttimeonline'], SORT_NUMERIC, SORT_DESC, 
                             $TODAYONLINEARRAY['thisuserid'], 
                             $TODAYONLINEARRAY['thispublicname']); 
            for ($TOAc=0;$TOAc<count($TODAYONLINEARRAY['lasttimeonline']);$TOAc++) 
                { 
                $TODAYONLINESTRING .= $TODAYONLINEARRAY['lasttimeonline'][$TOAc]."|".$TODAYONLINEARRAY['thisuserid'][$TOAc]."|".$TODAYONLINEARRAY['thispublicname'][$TOAc]."\n"; 
                } 
            $fp = @fopen($todayonlinefile, "w"); 
            @fwrite($fp, $TODAYONLINESTRING); 
            @fclose($fp); 
            } 
        $query = "SELECT `zeit` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online` WHERE ".(isset($_SESSION['APCMS']['USER']['userid'])?" `userid`='".$_SESSION['APCMS']['USER']['userid']."'":" `sessid`='".$_SESSION['sessid']."'"); 
        $selonline = $db->unbuffered_query_first($query); 
        $QUERY_STRING = _APCMS_StripSIDString($_SERVER['QUERY_STRING']); 
        $QUERY_STRING = preg_replace("`([\&\?]*?s=[a-z0-9]*?)`iU", "", $QUERY_STRING); 
        if (isset($selonline) && is_numeric($selonline[0])) 
            { 
            $query = "UPDATE  
                            `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online`  
                        SET  
                            `zeit`='".$akt_zeit."', 
                            `ip`='".$_SERVER['REMOTE_ADDR']."', 
                            `publicname`='".addslashes((isset($_SESSION['APCMS']['USER']['publicname'])?$_SESSION['APCMS']['USER']['publicname']:""))."', 
                            `userid`='".(isset($_SESSION['APCMS']['USER']['userid'])?$_SESSION['APCMS']['USER']['userid']:0)."', 
                            `hide_user`='', 
                            `onlineanzeige`='".addslashes($ONLINE_ANZEIGE)."', 
                            `last_aktivity`='' 
                      WHERE  
                              ".(isset($_SESSION['APCMS']['USER']['userid'])?" `userid`='".$_SESSION['APCMS']['USER']['userid']."'":" `sessid`='".$_SESSION['sessid']."'"); 
            $db->unbuffered_query($query); 
            } 
        else  
            { 
            $query = "INSERT INTO   
                                    `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online`  
                                (  
                                    `zeit`, 
                                    `ip`, 
                                    `publicname`, 
                                    `userid`, 
                                    `hide_user`, 
                                    `onlineanzeige`, 
                                    `last_aktivity`, 
                                    `sessid`  
                         ) VALUES (  
                                    '".$akt_zeit."', 
                                    '".$_SERVER['REMOTE_ADDR']."', 
                                    '".addslashes((isset($_SESSION['APCMS']['USER']['publicname'])?$_SESSION['APCMS']['USER']['publicname']:""))."', 
                                    '".(isset($_SESSION['APCMS']['USER']['userid'])?$_SESSION['APCMS']['USER']['userid']:0)."', 
                                    '', 
                                    '".addslashes($ONLINE_ANZEIGE)."', 
                                    '', 
                                    '".$_SESSION['sessid']."' 
                                )";  
            $db->unbuffered_query($query); 
            } 
        } 
    } 
 
/** 
 * Holt alle Informationen über OnlineUser 
 * 
 * @param          string $whichstats Type der abzurufenden UserOnline-Daten 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         array 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GetUserOnline($whichstats="indexstats") 
    { 
    global $db, $_LANGUAGE; 
    $OnlineUserArray = array(); 
    switch ($whichstats) 
        { 
        case "indexstats": 
            $query = "SELECT COUNT(`sessid`) FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online`";   
            $seluo_gesnum = $db->unbuffered_query_first($query); 
            $gesnum = intval($seluo_gesnum[0]); 
            $query = "SELECT COUNT(`sessid`) as num FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online` WHERE `userid`>='1'";   
            $seluo_mnum = $db->unbuffered_query_first($query); 
            $mnum = intval($seluo_mnum[0]); 
            $guestnum = $gesnum - $mnum; 
            $uomnun = 'Es '.($gesnum>=2||$gesnum<=0?$_LANGUAGE['sind']:$_LANGUAGE['ist']).' '.$_LANGUAGE['at_this_time'].' '.(_APCMS_ActionIsActive('useronline')&&_APCMS_UserAccess('useronline')?'<a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX']."?s=useronline".$_SESSION['SID2'].'"'._APCMS_HelpSystem($_LANGUAGE['help_useronline_desc']).'>':'').'<strong>'.$gesnum.' '.$_LANGUAGE['user'].'</strong> '.$_LANGUAGE['on_this_site_online'].(_APCMS_ActionIsActive('useronline')&&_APCMS_UserAccess('useronline')?'</a>':'').' ('; 
            $uomnun .= $mnum.' '.($mnum>=2||$mnum<=0?$_LANGUAGE['members']:$_LANGUAGE['member']); 
            $uomnun .= ($guestnum>=1?" ".$_LANGUAGE['and']." ".$guestnum." ":"").($guestnum>=2?$_LANGUAGE['guests']:"").($guestnum==1?$_LANGUAGE['guest']:""); 
            $uomnun .= '):<br />'; 
            $query = "SELECT `userid`,`publicname` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_online` WHERE `userid`>='1' ORDER BY `zeit` DESC";   
            $seluomembers = $db->unbuffered_getAll_row($query); 
            $UserNames = ''; 
            for ($a=0;$a<count($seluomembers);$a++) 
                { 
                if ($UserNames != "")  
                    $UserNames .= ", "; 
                $UserNames .= (_APCMS_ActionIsActive('show_userdetails')&&_APCMS_UserAccess('show_userdetails')?'<a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=userdetails&userid='.$seluomembers[$a][0].$_SESSION['SID2'].'"'._APCMS_HelpSystem($_LANGUAGE['help_userdetails_desc']).'>':'').htmlspecialchars(stripslashes($seluomembers[$a][1])).(_APCMS_ActionIsActive('show_userdetails')&&_APCMS_UserAccess('show_userdetails')?'</a>':''); 
                } 
            $OnlineUserArray['useronline_onlinenum'] = $gesnum; 
            $OnlineUserArray['useronline_onlinenum_formatted'] = $uomnun; 
            $OnlineUserArray['useronline_onlineuser_formatted'] = $UserNames; 
            break; 
        case "indextodayonline": 
            $todayonlinearray = array(); 
            $OnlineUserArray['usertodayonline_num_formatted'] = 0; 
            $OnlineUserArray['usertodayonline_user_formatted'] = ""; 
            $toac = 0; 
            $todayonlinefile = $_SESSION['APCMS']['LOG_DIR']."/users_today_online.log"; 
            if (file_exists($todayonlinefile)) 
                { 
                $todayonlinearray = file($todayonlinefile); 
                if (count($todayonlinearray) >= 1) 
                    { 
                    for ($lcount=0;$lcount<count($todayonlinearray);$lcount++) 
                        { 
                        $thisline = chop(trim($todayonlinearray[$lcount])); 
                        $linearray = explode("|", $thisline); 
                        if (trim($OnlineUserArray['usertodayonline_user_formatted']) != "") $OnlineUserArray['usertodayonline_user_formatted'] .= ", "; 
                        $OnlineUserArray['usertodayonline_user_formatted'] .= (_APCMS_ActionIsActive('show_userdetails')&&_APCMS_UserAccess('show_userdetails')?'<a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=userdetails&userid='.$linearray[1].$_SESSION['SID2'].'"'._APCMS_HelpSystem($_LANGUAGE['help_userdetails_desc']).'>':'').htmlspecialchars(stripslashes($linearray[2])).(_APCMS_ActionIsActive('show_userdetails')&&_APCMS_UserAccess('show_userdetails')?'</a>':'').' ('.date("H:i.s", $linearray[0]).')'; 
                        $OnlineUserArray['usertodayonline_num_formatted']++; 
                        } 
                    $OnlineUserArray['usertodayonline_num_formatted'] .= ($OnlineUserArray['usertodayonline_num_formatted']>=2||$OnlineUserArray['usertodayonline_num_formatted']<=0?" Mitglieder":" Mitglied").":<br>"; 
                    } 
                } 
            break; 
        default: 
            break; 
        } 
    return $OnlineUserArray; 
    } 
 
/** 
 * Gibt die aktuelle Version des APCMS aus 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_version() 
    { 
    $apcmsversion = ''; 
    $fp = @fopen($_SESSION['APCMS']['LIB_DIR']."/preconfig.lib.php", "r"); 
    $content = @fread($fp, 2048); 
    @fclose($fp); 
    $match = array(); 
    preg_match("`(\/\/[\s]*(###)[\s]*)([0-9\.]*)([\s]*(###))`i", $content, $match); 
    if (isset($match[3]) && $match[3] != "") 
        $apcmsversion = $match[3]; 
    if ($apcmsversion == "") 
        $apcmsversion = '0.0.1'; 
    return $apcmsversion; 
    } 
 
/** 
 * Formatiert einen Timestamp zu einem ausfürhlichem Datum, mit Uhrzeit<br> 
 * Beispiel: Montag, 17. Mai 2004, 18:35:21  
 * 
 * @param          int $tstamp Der Unix-Timestamp 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_FormattedDateTime($tstamp) 
    { 
    global $datetime_formatted; 
    $akt_year = intval(date("Y", $tstamp)); 
    $akt_month = intval(date("n", $tstamp)); 
    $akt_day = intval(date("j", $tstamp)); 
    $akt_hour = intval(date("G", $tstamp)); 
    $akt_minute= intval(date("i", $tstamp)); 
    $akt_second= intval(date("s", $tstamp)); 
    $date = strftime ($datetime_formatted, mktime ($akt_hour, $akt_minute, $akt_second, $akt_month, $akt_day, $akt_year)); 
    return $date; 
    } 
 
/** 
 * Holt die Anzahl der registrierten User aus der Datenbank 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_RegUsersNum() 
    { 
    global $db; 
    $query = "SELECT COUNT(`userid`) FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_table`"; 
    $num = $db->unbuffered_query_first($query); 
    $num = $num[0]-1; 
    return $num; 
    } 
 
/** 
 * Sucht das aktuellste Backup und gibt davon die Entstehungszeit und den Dateinamen zurück 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         array 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_GetLastBackup() 
    { 
    $BACKUPDIR = $_SESSION['APCMS']['TMP_DIR']."/backups"; 
    $backuptime = 0; 
    $backupfiles = array(); 
    $opendir = opendir($BACKUPDIR); 
    $counter = 0; 
    while ($thisbackup = readdir($opendir)) 
        { 
        if ($thisbackup!="." && $thisbackup!=".." && $thisbackup!="index.".$_SESSION['APCMS']['SUFFIX'] && $thisbackup!="cvs" && $thisbackup!="CVS" && $thisbackup!=".htaccess") 
            { 
            $backupfiles['file'][$counter] = $thisbackup; 
            $backupfiles['time'][$counter] = filemtime($BACKUPDIR."/".$thisbackup); 
            $counter++; 
            } 
        } 
    closedir($opendir); 
    if(isset($backupfiles['file']) && count($backupfiles['file']) >= 1) 
        { 
        reset($backupfiles); 
        array_multisort($backupfiles['time'], SORT_DESC, SORT_NUMERIC, 
                        $backupfiles['file']); 
        $return['file'] = $backupfiles['file'][0]; 
        $return['time'] = $backupfiles['time'][0]; 
        return $return; 
        } 
    else  
        return false; 
    } 
 
/** 
 * Macht Backups von den Tabellen oder der ganzen Datenbank, Backups werden getrennt in Text-Dateien gespeichert 
 * 
 * @param          int $complete Soll die gesamte Datenbank gebackuppt werden? (1/0) 
 * @param          int $tables Array mit Tabellen, die gebackuppt werden sollen, wenn $complete == 0 
 * @param          int $what Was soll gebackuppt werden? (data/structure/dataonly) 
 * @param          int $drop Soll "DROP TABLE" hinzugefügt werden? (1/0) 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         void 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_MakeSQLBackup($complete=1, $tables="", $what="data", $drop=1) 
	{ 
	global $db, $_LANGUAGE, $akt_time; 
	$filetime = date("Y-m-d-H-i",$akt_time); 
	$success = 0; 
    $old = @ignore_user_abort(1); 
	if ($complete == 1) 
		{ 
		unset($tables); 
		$QUERY = $db->unbuffered_query("SHOW TABLES"); 
		while ($THISTABLE = $db->fetch_row($QUERY)) 
			{ 
			$tables[] = $THISTABLE[0]; 
			} 
		} 
	for ($q=0;$q<count($tables);$q++) 
		{ 
		$table = $tables[$q]; 
		$dateidir = $_SESSION['APCMS']['TMP_DIR']."/last_backup/"; 
		$dateiname = $table.".sql"; 
		$sqltext = "#########################################################\n"; 
		$sqltext .= "## Created by APCMS v"._APCMS_version()."\n"; 
		$sqltext .= "## Copyright © 2000- by Alexander Mieland\n"; 
		$sqltext .= "## APP - Another PHP Program\n"; 
		$sqltext .= "## http://www.php-programs.de\n"; 
		$sqltext .= "## Kontakt: dma147@mieland-programming.de\n"; 
		$sqltext .= "#########################################################\n"; 
		$sqltext .= "##\n"; 
		$sqltext .= "##\n"; 
		$create_text = ""; 
		$insert_text = ""; 
		if ($what == "structure" OR $what == "data") 
			{ 
			if ($drop == 1) 
				{ 
				$create_text .= "##\n"; 
				$create_text .= "##		DROP-data von Tabelle `".$table."`\n"; 
				$create_text .= "##\n"; 
				$create_text .= "DROP TABLE IF EXISTS `".$table."`;\n\n"; 
				} 
			$create_text .= "##\n"; 
			$create_text .= "##		CREATE-data von Tabelle `".$table."`\n"; 
			$create_text .= "##\n"; 
			$sql = "SHOW CREATE TABLE `".$_SESSION['MYSQLDATA']['DB']."`.`".$table."`"; 
			$result = $db->unbuffered_query($sql); 
			if (!isset($result)) 
				{ 
				$sql = "DESCRIBE `".$_SESSION['MYSQLDATA']['DB']."`.`".$table."`"; 
				$result = $db->unbuffered_query($sql); 
				if (isset($result)) 
					{ 
					$fieldnum=0; 
					while ($row = $db->fetch_row($result)) 
						{ 
						$fieldnum++; 
						} 
					$result = $db->unbuffered_query($sql); 
					$create_text .= "CREATE TABLE `".$_SESSION['MYSQLDATA']['DB']."`.`".$table."`"; 
					$tz=0; 
					$sqlende = ""; 
					while ($row = $db->fetch_row($result)) 
						{ 
						$name  = $row[0]; 
						$type  = " ".$row[1]; 
						if ($row[2] == "") {$null = " NOT NULL";} else {$null = " NULL";} 
						if ($row[4] == "") {$default = "";} else {$default = " DEFAULT '".$row[4]."'";} 
						if ($row[5] == "") {$extra = "";} else {$extra = " ".$row[5];} 
						$create_text .= "\t`".$name."`".$type.$null.$default.$extra; 
						$tz++; 
						if ($tz<$fieldnum) $create_text .= ", \n"; 
						} 
					unset($pri_key); 
					unset($mul_key); 
					unset($mul_index_key); 
					unset($uni_key); 
					unset($uni_index_key); 
					unset($full_key); 
					unset($full_index_key); 
					$sql = "SHOW KEYS FROM `".$_SESSION['MYSQLDATA']['DB']."`.`".$table."`"; 
					$key_result = $db->unbuffered_query($sql); 
					while ($row = $db->fetch_row($key_result)) 
						{ 
						$non_unique = $row[1]; 
						$key_name = $row[2]; 
						$column_name = $row[4]; 
						$fulltext = $row[9]; 
						if (ereg("PRIMARY", $key_name)) 
							{ 
							$pri_key[] = $column_name; 
							$pri_index_key[] = $key_name; 
							} 
						elseif ($non_unique) 
							{ 
							if ($fulltext=="FULLTEXT") 
								{ 
								$full_key[] = $column_name; 
								$full_index_key[] = $key_name; 
								} 
							else 
								{ 
								$mul_key[] =  $column_name; 
								$mul_index_key[] = $key_name; 
								} 
							} 
						elseif ((!$non_unique) and (!ereg("PRIMARY", $key_name))) 
							{ 
							$uni_key[] =  $column_name; 
							$uni_index_key[] = $key_name; 
							} 
						} 
					if (count($pri_key)>0) 
						{ 
						$pri_text = " PRIMARY KEY ("; 
						for ($tr=0; $tr<count($pri_key); $tr++) 
							{ 
							$pri_text .= $pri_key[$tr]; 
							if (($tr+1)<count($pri_key)) $pri_text .= ", "; 
							} 
						$pri_text .= ")"; 
						$create_text .= ", \n\t".trim($pri_text); 
						} 
					if (count($mul_key)>0) 
						{ 
						$mul_text = " KEY ("; 
						for ($tr=0; $tr<count($mul_key); $tr++) 
							{ 
							$mul_text .= $mul_key[$tr]; 
							if (($tr+1)<count($mul_key)) $mul_text .= ", "; 
							} 
						$mul_text .= ")"; 
						$create_text .= ", \n\t".trim($mul_text); 
						} 
					if (count($full_key)>0) 
						{ 
						$full_text = " FULLTEXT KEY ("; 
						for ($tr=0; $tr<count($full_key); $tr++) 
							{ 
							$full_text .= $full_key[$tr]; 
							if (($tr+1)<count($full_key)) $full_text .= ", "; 
							} 
						$full_text .= ")"; 
						$create_text .= ", \n\t".trim($full_text); 
						} 
					if (count($uni_key)>0) 
						{ 
						$uni_text = " UNIQUE KEY ("; 
						for ($tr=0; $tr<count($uni_key); $tr++) 
							{ 
							$uni_text .= $uni_key[$tr]; 
							if (($tr+1)<count($uni_key)) $uni_text .= ", "; 
							} 
						$uni_text .= ")"; 
						$create_text .= ", \n\t".trim($uni_text); 
						} 
					$create_text .= "\n);\n\n"; 
					} 
				} 
			else 
				{ 
				$row = $db->fetch_row($result); 
				$create_text .= $row[1].";\n\n"; 
				} 
			} 
		if ($what == "dataonly" OR $what == "data") 
			{ 
			$insert_text .= "##\n"; 
			$insert_text .= "##		INSERT-data von Tabelle `".$table."`\n"; 
			$insert_text .= "##\n"; 
			$R2 = $db->unbuffered_query("SELECT * FROM `".$table."`"); 
			unset($THIS); 
			while ($THIS = $db->fetch_array($R2)) 
				{ 
				$insert_text .= "INSERT INTO `".$table."` ("; 
				@reset ($THIS); 
				unset($key); 
				unset($val); 
				$insert_text1 = ''; 
				$insert_text2 = ''; 
				foreach ($THIS as $key => $val) 
					{ 
					if (!intval($key) AND $key != "0") 
						{ 
						$insert_text1 .= "`".$key."`,"; 
						$insert_text2 .= "'".addslashes($val)."',"; 
						} 
					} 
				$insert_text1 = substr($insert_text1, 0, (strlen($insert_text1)-1)); 
				$insert_text2 = substr($insert_text2, 0, (strlen($insert_text2)-1)); 
				$insert_text .= $insert_text1.") VALUES (".$insert_text2.");\n"; 
				} 
			} 
		if ($create_text != "") 
			{ 
			$create_text = $sqltext.$create_text; 
			if ($TXT=fopen($dateidir.$filetime."_CREATE_".$dateiname, "w")) 
				{ 
				fputs($TXT,$create_text); 
				fclose($TXT); 
				chmod($dateidir.$filetime."_CREATE_".$dateiname, 0666); 
				} 
			} 
		if ($insert_text != "") 
			{ 
			$insert_text = $sqltext.$insert_text; 
			if ($TXT=fopen($dateidir.$filetime."_INSERT_".$dateiname, "w")) 
				{ 
				fputs($TXT,$insert_text); 
				fclose($TXT); 
				chmod($dateidir.$filetime."_INSERT_".$dateiname, 0666); 
				} 
			} 
		} 
	} 
 
/** 
 * Überprüft, ob es Zeit für ein autom. Backup ist und führt dieses gegebenenfalls aus 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_CheckAutoBackup() 
	{ 
	global $db, $akt_time; 
    $TEMPDIR = $_SESSION['APCMS']['TMP_DIR']; 
    $ARCHIVDIR = "./backups"; 
	if ($_SESSION['APCMS']['CONFIG']['auto_backup'] == 1) 
		{ 
        $old = @ignore_user_abort(1); 
		$now = $akt_time; 
		if (($_SESSION['APCMS']['CONFIG']['last_backup']+$_SESSION['APCMS']['CONFIG']['time_backup']) <= $now) 
			{ 
			if ($_SESSION['APCMS']['CONFIG']['data_backup'] != "") 
				{ 
				$DATA_BACKUP = explode("|^|", $_SESSION['APCMS']['CONFIG']['data_backup']); 
				$complete = $DATA_BACKUP[0]; 
				$tables = unserialize(stripslashes($DATA_BACKUP[1])); 
				$data = $DATA_BACKUP[2]; 
				$drop = $DATA_BACKUP[3]; 
				$pack = $DATA_BACKUP[4]; 
            	if (isset($complete) && $complete == 1) 
            		{ 
            		_APCMS_MakeSQLBackup(1,NULL, $data, $drop); 
            		} 
            	else 
            		{ 
            		_APCMS_MakeSQLBackup(0, $tables, $data, $drop); 
            		} 
            	if ($pack == 1) 
            		{ 
            		$archiv = $ARCHIVDIR."/".date("Y-m-d-H-i",time())."_".$_SESSION['MYSQLDATA']['DB'].".tar.gz"; 
            		chdir($TEMPDIR); 
            		if (file_exists($archiv)) 
            			{ 
            			unlink($archiv); 
            			} 
            		require_once("Archive/Tar.".$_SESSION['APCMS']['SUFFIX']); 
            		$tar_object = new Archive_Tar($archiv, "gz"); 
            		$tar_object->setErrorHandling(PEAR_ERROR_RETURN); 
            		$filelist[0]="./last_backup"; 
            		$tar_object->create($filelist); 
            		chmod($archiv, 0666); 
            		chdir("../"); 
            		} 
            	else 
            		{ 
            		$archiv = $ARCHIVDIR."/".date("Y-m-d-H-i",time())."_".$_SESSION['MYSQLDATA']['DB'].".tar"; 
            		chdir($TEMPDIR); 
            		if (file_exists($archiv)) 
            			{ 
            			unlink($archiv); 
            			} 
            		require_once("Archive/Tar.".$_SESSION['APCMS']['SUFFIX']); 
            		$tar_object = new Archive_Tar($archiv, FALSE); 
            		$tar_object->setErrorHandling(PEAR_ERROR_RETURN); 
            		$filelist[0]="./last_backup"; 
            		$tar_object->create($filelist); 
            		chmod($archiv, 0666); 
            		chdir("../"); 
            		} 
            	$fe = opendir($TEMPDIR."/last_backup"); 
            	while ($file = readdir($fe)) 
            		{ 
            		if ($file != "." && $file != ".." && $file != "index.".$_SESSION['APCMS']['SUFFIX'] && $file != "cvs" && $file != "CVS") 
            			{ 
            			unlink($TEMPDIR."/last_backup/".$file); 
            			} 
            		} 
            	closedir($fe); 
				$UPDATECONF = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config` SET "; 
				$UPDATECONF .= "		`last_backup`='".$now."' "; 
				$_SESSION['APCMS']['CONFIG']['last_backup'] = $now; 
				$db->unbuffered_query($UPDATECONF); 
				} 
			else 
				{ 
				return false; 
				} 
			} 
		} 
	return true; 
	} 
 
/** 
 * Überprüft, ob alte Backups autom. gelöscht werden sollen und tut dies gegebenenfalls 
 * 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         bool 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_CheckAutoDelBackup() 
	{ 
	global $db, $akt_time; 
    $backupdir = $_SESSION['APCMS']['TMP_DIR']."/backups"; 
	if ($_SESSION['APCMS']['CONFIG']['auto_backdel'] == 1) 
		{ 
        $old = @ignore_user_abort(1); 
		$now = time(); 
		$fe = opendir($backupdir); 
		while ($file = readdir($fe)) 
			{ 
            if ($file!="." && $file!=".." && $file!="index.".$_SESSION['APCMS']['SUFFIX'] && $file!="cvs" && $file!="CVS" && $file!=".htaccess") 
				{ 
				if (filemtime($backupdir."/".$file) <= ($akt_time - $_SESSION['APCMS']['CONFIG']['time_backdel'])) 
					{ 
					unlink($backupdir."/".$file); 
					} 
				} 
			} 
		closedir($fe); 
		} 
	return true; 
	} 
 
/** 
 * Spielt ein Backup zurück in die Datenbank und gibt eine Status-Message aus 
 * 
 * @param          string $backupfile Der Dateiname des Backups 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_RecoverDBBackup($backupfile) 
	{ 
	global $db, $akt_time, $_LANGUAGE; 
    $backupdir = $_SESSION['APCMS']['TMP_DIR']; 
	$pbackupfile = $backupdir."/backups/".$backupfile; 
	$recoverdir = $backupdir."/last_backup"; 
	if (!file_exists($pbackupfile)) 
		{ 
		return $_LANGUAGE['backup_not_found']; 
		} 
	require_once("Archive/Tar.".$_SESSION['APCMS']['SUFFIX']); 
	if (eregi(".gz$", $backupfile)) { $zipped = TRUE; } else { $zipped = FALSE; } 
	$tar_object = new Archive_Tar($pbackupfile, $zipped); 
	$tar_object->setErrorHandling(PEAR_ERROR_RETURN); 
	$tar_object->extract($backupdir); 
	$fe = opendir($recoverdir); 
	chdir($recoverdir); 
	while ($file = readdir($fe)) 
		{ 
		if (ereg("_CREATE_", $file)) 
			{ 
			unset($rec); 
			$drop = ""; 
			$create = ""; 
			$rec = file($file); 
			for ($a=0;$a<count($rec);$a++) 
				{ 
				if (!ereg("^##", $rec[$a])) 
					{ 
					if (ereg("DROP TABLE", $rec[$a])) 
						{ 
						$drop .= $rec[$a]; 
						} 
					else 
						{ 
						$create .= $rec[$a]; 
						} 
					} 
				} 
			if (trim($drop) != "") 
				{ 
				$db->unbuffered_query(preg_replace("|(`;([\ \\r\\n]{0,})$)|","`",$drop)); 
				#print("<pre>".preg_replace("|(`;([\ \\r\\n]{0,})$)|","`",$drop)."</pre>"); 
				} 
			$db->unbuffered_query(preg_replace("|(\)([\ (TYPE=MyISAM)]{0,});([\ \\r\\n]{0,})$)|",")",$create)); 
			#print("<pre>".preg_replace("|(\)([\ (TYPE=MyISAM)]{0,});([\ \\r\\n]{0,})$)|",")",$create)."</pre>"); 
			} 
		} 
	chdir("../../"); 
	closedir($fe); 
	$fe = opendir($recoverdir); 
	chdir($recoverdir); 
	while ($file = readdir($fe)) 
		{ 
		if (ereg("_INSERT_", $file)) 
			{ 
			unset($rec); 
			$insert = ""; 
			$fop = fopen($file, "r"); 
			$rec = fread($fop, filesize($file)); 
			fclose($fop); 
			$insert = explode("\nINSERT INTO", $rec); 
			for ($blu=0;$blu<count($insert);$blu++) 
				{ 
				if ($blu >= 1) 
					{ 
					$db->unbuffered_query("INSERT INTO".preg_replace("|(\);([\ \\r\\n]{0,})$)|",")",$insert[$blu])); 
					#print("<pre>INSERT INTO".preg_replace("|(\);([\ \\r\\n]{0,})$)|",")",$insert[$blu])."</pre>"); 
					} 
				} 
			} 
		} 
	chdir("../../"); 
	closedir($fe); 
	$fe = opendir($recoverdir); 
	while ($file = readdir($fe)) 
		{ 
		if ($file != "." && $file != ".." && $file != "index.".$_SESSION['APCMS']['SUFFIX'] && $file != "cvs" && $file != "CVS") 
			{ 
			unlink($recoverdir."/".$file); 
			} 
		} 
	closedir($fe); 
	return $_LANGUAGE['backup_recovered1'].$backupfile.$_LANGUAGE['backup_recovered2']; 
	} 
 
/** 
 * Baut aus dem Namen des Includefiles und des Querystrings, den Namen des Cache-Files und gibt ihn zurück 
 * 
 * @param          string $contentinclude Der Name des ersten Includes (ohne "content." und ohne die Endung ".php" 
 * @param          string $querystring der Querystring aus $_SERVER['QUERY_STRING'] 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_MakeCacheFileName($contentinclude, $querystring) 
    { 
    $querystring = str_replace("s=".$contentinclude, "", preg_replace("`([\&\?]*?".session_name()."=[a-z0-9]*?)`iU", "", $querystring)); 
    $querystring = str_replace("=", "", $querystring); 
    $querystring = str_replace("&", "", $querystring); 
    $querystring = str_replace("ainclude", "", $querystring); 
    $querystring = str_replace("uinclude", "", $querystring); 
    $querystring = htmlspecialchars((trim($querystring)!=""?$querystring:"")); 
    $cachedinclude = md5(crypt($contentinclude, "CRYPT_MD5")); 
    $cachedquery = md5(crypt($querystring, "CRYPT_MD5")); 
    $cachedfile = $cachedinclude.$cachedquery; 
    return $cachedfile; 
    } 
 
/** 
 * Aktualisiert eine gecachte Seite 
 * 
 * @param          string $cachedfile Der Name der Cachedatei 
 * @param          string $htmldata der komplette html-Quelltext der Seite 
 * @since          0.0.1 
 * @version        0.0.1 
 * @access         private 
 * @return         string 
 * @author         Alexander Mieland 
 * @copyright      2000-2004 by APP - Another PHP Program 
 */ 
function _APCMS_UpdateCachedFile($cachedfile, $htmldata) 
    { 
    global $db, $akt_time; 
    $cachedir = $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/cache"; 
    $cachefile = $cachedir."/".$cachedfile; 
    $fp = fopen($cachefile, "w"); 
    fwrite($fp, $htmldata); 
    fclose($fp); 
    $filesize = filesize($cachefile); 
    $query = "SELECT `id` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache` WHERE `filename`='".$cachedfile."'"; 
    $cret = $db->unbuffered_query_first($query, 'row'); 
    if (!isset($cret) || $cret[0] <= 0) 
        { 
        $query = "INSERT INTO `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache` (`filename`,`filesize`,`lastupdate`,`mustupdate`) VALUES ('".$cachedfile."','".$filesize."','".$akt_time."','0')"; 
        } 
    else  
        { 
        $query = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache` SET `filename`='".$cachedfile."',`filesize`='".$filesize."',`lastupdate`='".$akt_time."',`mustupdate`='0' WHERE `id`='".$cret[0]."'"; 
        } 
    $db->unbuffered_query($query); 
    return $cachefile; 
    } 
 
 
 
 
 
 
 
 
 
 
?>