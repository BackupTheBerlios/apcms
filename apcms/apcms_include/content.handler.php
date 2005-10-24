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
 
/** Neues Template starten */ 
$HANDLER = _APCMS_StartNewTemplate(); 
 
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, beginnt hier 
//   
 
$CONTENTTITEL = $_LANGUAGE['firstpage']; 
$CONTENTINHALT = ''; 
$BACKUPDIR = $_SESSION['APCMS']['TMP_DIR']."/backups"; 
 
if (isset($_SERVER['HTTP_REFERER']) && trim($_SERVER['HTTP_REFERER']) != "") 
    $REFERER = _APCMS_trim($_SERVER['HTTP_REFERER']); 
if (!isset($REFERER) || trim($REFERER) == "") 
    { 
    $REFERER = $_SESSION['APCMS']['REL_URL'].'/'; 
    } 
 
if (!isset($_POST['action']) || trim($_POST['action']) == "") 
    { 
    $REDIRECT_URL = $REFERER; 
    $REDIRECT_TIME = 3; 
    $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Keine Daten übergeben!", "Diese Datei kann nicht direkt aufgerufen werden.", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
    } 
else  
    { 
    switch ($_POST['action']) 
        { 
        /////////////////////////////////////////////////////////////////// 
        case "save_globalpref": 
            if (!_APCMS_ActionIsActive('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['admin_is_deactivated'], $_LANGUAGE['admin_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            if (!_APCMS_UserAccess('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['no_access_desc'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "makesqlquery": 
            if (!_APCMS_ActionIsActive('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['admin_is_deactivated'], $_LANGUAGE['admin_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            if (!_APCMS_UserAccess('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['no_access_desc'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "makesqlbackup": 
            if (!_APCMS_ActionIsActive('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['admin_is_deactivated'], $_LANGUAGE['admin_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            if (!_APCMS_UserAccess('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['no_access_desc'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "deletesqlbackup": 
            if (!_APCMS_ActionIsActive('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['admin_is_deactivated'], $_LANGUAGE['admin_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            if (!_APCMS_UserAccess('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['no_access_desc'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "setcaching": 
            if (!_APCMS_ActionIsActive('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['admin_is_deactivated'], $_LANGUAGE['admin_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            if (!_APCMS_UserAccess('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['no_access_desc'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "setlangopts": 
            if (!_APCMS_ActionIsActive('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['admin_is_deactivated'], $_LANGUAGE['admin_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            if (!_APCMS_UserAccess('can_access_admin')) 
                { 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['no_access_desc'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                } 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "": 
            
            
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "": 
            
            
            break; 
        /////////////////////////////////////////////////////////////////// 
        } 
    
    
    
    
    
    
    
    switch ($_POST['action']) 
        { 
        /////////////////////////////////////////////////////////////////// 
        case "save_globalpref": 
            if (!isset($_POST['NEW']['title']) || _APCMS_trim($_POST['NEW']['title']) == "") 
                { 
                foreach($_POST['NEW'] as $key => $val) 
                    { 
                    $_SESSION['POSTDATA'][$key] = $val; 
                    } 
                $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].$_SESSION['SID2']; 
                $REDIRECT_TIME = 3; 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Feld &quot;Titel der Seite&quot; ist leer!", "Es muss ein Titel angegeben werden, da sonst kein Link zur Startseite (im Header oben) angezeigt wird.", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                break; 
                } 
            if (!isset($_POST['NEW']['online_timeout']) || _APCMS_trim($_POST['NEW']['online_timeout']) == "" || _APCMS_trim($_POST['NEW']['online_timeout']) <= 0) 
                { 
                foreach($_POST['NEW'] as $key => $val) 
                    { 
                    $_SESSION['POSTDATA'][$key] = $val; 
                    } 
                $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].$_SESSION['SID2']; 
                $REDIRECT_TIME = 3; 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Wert in Feld &quot;Online-Timeout&quot; ist zu klein!", "Es muss ein Wert >= 1 eingegeben werden, da sonst die Online-Anzeige unrealistisch ist.", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                break; 
                } 
            if (!isset($_POST['NEW']['news_num']) || _APCMS_trim($_POST['NEW']['news_num']) == "" || _APCMS_trim($_POST['NEW']['news_num']) <= 0) 
                { 
                foreach($_POST['NEW'] as $key => $val) 
                    { 
                    $_SESSION['POSTDATA'][$key] = $val; 
                    } 
                $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].$_SESSION['SID2']; 
                $REDIRECT_TIME = 3; 
                $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Wert in Feld &quot;Anzahl der News im Portal&quot; ist zu klein!", "Es muss ein Wert >= 1 eingegeben werden, da sonst keine News angezeigt werden.", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
                break; 
                } 
            $query = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config` SET  
                                                                                        `title`='".addslashes(_APCMS_trim($_POST['NEW']['title']))."',  
                                                                                        `description`='".addslashes(_APCMS_trim($_POST['NEW']['description']))."',  
                                                                                        `timezone`='".(float) $_POST['NEW']['timezone']."',  
                                                                                        `style`='".addslashes(_APCMS_trim($_POST['NEW']['style']))."',  
                                                                                        `online_timeout`='".intval(intval(_APCMS_trim($_POST['NEW']['online_timeout'])*60))."',  
                                                                                        `news_num`='".intval(_APCMS_trim($_POST['NEW']['news_num']))."'"; 
            $db->unbuffered_query($query); 
             
             
            $updatecachefile = _APCMS_MakeCacheFileName("admin", "s=admin&ainclude=globalpref"); 
            $query = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache` SET `mustupdate`='1' WHERE `filename`='".$updatecachefile."'"; 
            $db->unbuffered_query($query); 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].'&newsess=1'.$_SESSION['SID2']; 
            $REDIRECT_TIME = 3; 
            $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Einstellungen gespeichert!", "Die neuen Einstellungen wurden erfolgreich gespeichert.", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "makesqlquery": 
            $_SESSION['POSTDATA'] = array(); 
            $QUERYARRAY = array(); 
            $queryArray = $db->ParseQuerys($_POST['NEW']['sqlquery']); 
            $return = $db->DoQuerys($queryArray); 
            if(isset($return['queryreturn']) && count($return['queryreturn']) >= 1) 
                { 
                $_SESSION['POSTDATA']['queryreturn'] = $return['queryreturn']; 
                $HANDLER->assign("POPUP", "'".$_SESSION['APCMS']['REL_URL']."/?s=queryresults&noheadersnfooters=1".$_SESSION['SID2']."', 'QueryResult', 'top=1, left=1, width=".(eregi("%", $_SESSION['APCMS']['TABLE']['WIDTH'])?755:($_SESSION['APCMS']['TABLE']['WIDTH']+26)).", height=555, resizeable=yes, scrollbars=yes'"); 
                } 
            $_SESSION['POSTDATA']['querynum'] = $return['num']; 
            $_SESSION['POSTDATA']['runtime'] = $return['runtime']; 
            $_SESSION['POSTDATA']['QUERYSTRING'] = ""; 
            for($a=0;$a<count($queryArray);$a++) 
                { 
                if ($_SESSION['POSTDATA']['QUERYSTRING']!="") $_SESSION['POSTDATA']['QUERYSTRING'] .= "\n\n"; 
                $_SESSION['POSTDATA']['QUERYSTRING'] .= (!preg_match("`;$`", $queryArray[$a])?$queryArray[$a].";":$queryArray[$a]); 
                } 
            if ($return['num'] >= 2) 
                { 
                $p_query = "Querys"; 
                $p_wurde = "wurden"; 
                } 
            else  
                { 
                $p_query = "Query"; 
                $p_wurde = "wurde"; 
                } 
            $updatecachefile = _APCMS_MakeCacheFileName("admin", "s=admin&ainclude=dbopts"); 
            $query = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache` SET `mustupdate`='1' WHERE `filename`='".$updatecachefile."'"; 
            $db->unbuffered_query($query); 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].$_SESSION['SID2']; 
            $REDIRECT_TIME = 1; 
            $HANDLER->assign("STATUSMSG", _APCMS_MsgBox($return['num']." ".$p_query." ".$p_wurde." in ".$return['runtime']." Sekunden ausgeführt!", "Die Ausgabe eventueller Ergebnismengen findet im sich öffnenden Fenster statt", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "makesqlbackup": 
            $STATUSMSG = ''; 
            $TEMPDIR = $_SESSION['APCMS']['TMP_DIR']; 
            $ARCHIVDIR = "./backups"; 
            unset($UPDATECONF); 
        	if (!isset($_POST['complete']) || $_POST['complete'] != 1){$_POST['complete'] = 0;} 
        	if (!isset($_POST['drop']) || $_POST['drop'] != 1){$_POST['drop'] = 0;} 
        	if (!isset($_POST['pack']) || $_POST['pack'] != 1){$_POST['pack'] = 0;} 
        	$DATA_BACKUP = $_POST['complete']; 
        	$DATA_BACKUP .= "|^|"; 
        	$DATA_BACKUP .= (isset($_POST['complete'])&&$_POST['complete']==1?serialize(array()):serialize($_POST['tables'])); 
        	$DATA_BACKUP .= "|^|"; 
        	$DATA_BACKUP .= $_POST['data']; 
        	$DATA_BACKUP .= "|^|"; 
        	$DATA_BACKUP .= $_POST['drop']; 
        	$DATA_BACKUP .= "|^|"; 
        	$DATA_BACKUP .= $_POST['pack']; 
            if (!isset($_POST['delete']) && isset($_POST['bakautomatik']) && $_POST['bakautomatik'] == 1) 
            	{ 
            	$UPDATECONF = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config` SET "; 
            	$UPDATECONF .= "		`auto_backup`='1', "; 
            	$UPDATECONF .= "		`time_backup`='".$_POST['interval']."', "; 
            	$UPDATECONF .= "		`last_backup`='".time()."', "; 
            	$UPDATECONF .= "		`data_backup`='".addslashes($DATA_BACKUP)."' "; 
            	$_SESSION['APCMS']['CONFIG']['auto_backup'] = 1; 
            	$_SESSION['APCMS']['CONFIG']['time_backup'] = $_POST['interval']; 
            	$_SESSION['APCMS']['CONFIG']['last_backup'] = time(); 
            	$_SESSION['APCMS']['CONFIG']['data_backup'] = $DATA_BACKUP; 
            	$STATUSMSG .= '<b>Backup-Automatik gestartet!</b><br />'; 
            	} 
            elseif (!isset($_POST['delete']) && (count($_POST) >= 1 && !isset($_POST['bakautomatik']))) 
            	{ 
            	$UPDATECONF = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config` SET "; 
            	$UPDATECONF .= "		`auto_backup`='0', "; 
            	$UPDATECONF .= "		`time_backup`='0', "; 
            	$UPDATECONF .= "		`last_backup`='0', "; 
            	$UPDATECONF .= "		`data_backup`='".addslashes($DATA_BACKUP)."' "; 
            	$_SESSION['APCMS']['CONFIG']['auto_backup'] = 0; 
            	$_SESSION['APCMS']['CONFIG']['time_backup'] = 0; 
            	$_SESSION['APCMS']['CONFIG']['last_backup'] = 0; 
            	$_SESSION['APCMS']['CONFIG']['data_backup'] = $DATA_BACKUP; 
            	$STATUSMSG .= '<b>Backup-Automatik gestoppt!</b><br />'; 
            	} 
            if (isset($UPDATECONF)) 
            	{ 
            	$db->unbuffered_query($UPDATECONF); 
            	} 
            unset($UPDATECONF); 
            if (!isset($_POST['delete']) && isset($_POST['delautomatik']) && $_POST['delautomatik'] == 1) 
            	{ 
            	$UPDATECONF = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config` SET "; 
            	$UPDATECONF .= "		`auto_backdel`='1', "; 
            	$UPDATECONF .= "		`time_backdel`='".$_POST['delage']."', "; 
            	$UPDATECONF .= "		`last_backdel`='".time()."' "; 
            	$_SESSION['APCMS']['CONFIG']['auto_backdel'] = 1; 
            	$_SESSION['APCMS']['CONFIG']['time_backdel'] = $_POST['delage']; 
            	$_SESSION['APCMS']['CONFIG']['last_backdel'] = time(); 
            	$STATUSMSG .= '<b>Lösch-Automatik gestartet!</b><br />'; 
            	} 
            elseif (!isset($_POST['delete']) && (count($_POST) >= 1 && !isset($_POST['delautomatik']))) 
            	{ 
            	$UPDATECONF = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config` SET "; 
            	$UPDATECONF .= "		`auto_backdel`='0', "; 
            	$UPDATECONF .= "		`time_backdel`='0', "; 
            	$UPDATECONF .= "		`last_backdel`='0' "; 
            	$_SESSION['APCMS']['CONFIG']['auto_backdel'] = 0; 
            	$_SESSION['APCMS']['CONFIG']['time_backdel'] = 0; 
            	$_SESSION['APCMS']['CONFIG']['last_backdel'] = 0; 
            	$STATUSMSG .= '<b>Lösch-Automatik gestoppt!</b><br />'; 
            	} 
            if (isset($UPDATECONF)) 
            	{ 
            	$db->unbuffered_query($UPDATECONF); 
            	} 
            if (isset($_POST['backup']) && $_POST['backup'] == 1) 
            	{ 
            	if (isset($_POST['complete']) && $_POST['complete'] == 1) 
            		{ 
            		_APCMS_MakeSQLBackup(1,NULL, $_POST['data'], $_POST['drop']); 
            		} 
            	else 
            		{ 
            		_APCMS_MakeSQLBackup(0, $_POST['tables'], $_POST['data'], $_POST['drop']); 
            		} 
            	if ($_POST['pack'] == 1) 
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
            	$STATUSMSG .= '<b>Backup gespeichert!</b><br />'; 
            	} 
            $updatecachefile = _APCMS_MakeCacheFileName("admin", "s=admin&ainclude=backupopts"); 
            $query = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache` SET `mustupdate`='1' WHERE `filename`='".$updatecachefile."'"; 
            $db->unbuffered_query($query); 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].$_SESSION['SID2']; 
            $REDIRECT_TIME = 3; 
            $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Backup ausgeführt und Einstellungen gespeichert!", "Das Backup wurde erfolgreich gespeichert<br />Eventuell gemachte Einstellungen, die Automatik betreffend, wurden gespeichert.<br /><br />".$STATUSMSG, $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "deletesqlbackup": 
            for ($a=0;$a<count($_POST['del']);$a++) 
                @unlink($BACKUPDIR."/".$_POST['del'][$a]); 
            $updatecachefile = _APCMS_MakeCacheFileName("admin", "s=admin&ainclude=backupopts"); 
            $query = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache` SET `mustupdate`='1' WHERE `filename`='".$updatecachefile."'"; 
            $db->unbuffered_query($query); 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].$_SESSION['SID2']; 
            $REDIRECT_TIME = 3; 
            $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Backup(s) erfolgreich gelöscht!", "&nbsp;", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "setcaching": 
            $query = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config` SET `cache_aktiv`='".(!isset($_POST['NEW']['cache_aktiv'])||$_POST['NEW']['cache_aktiv']==0?0:$_POST['NEW']['cache_aktiv'])."', `cache_aktinterval`='".($_POST['NEW']['cache_aktinterval']*60)."'"; 
            $db->unbuffered_query($query); 
            $_SESSION['APCMS']['CONFIG']['cache_aktiv'] = (!isset($_POST['NEW']['cache_aktiv'])||$_POST['NEW']['cache_aktiv']==0?0:$_POST['NEW']['cache_aktiv']); 
            $_SESSION['APCMS']['CONFIG']['cache_aktinterval'] = ($_POST['NEW']['cache_aktinterval']*60); 
            if (isset($_POST['NEW']['reset_cache']) && $_POST['NEW']['reset_cache'] == 1) 
                { 
                $STYLESDIR = $_SESSION['APCMS']['STYLES_DIR']; 
            	$fe = opendir($STYLESDIR); 
            	while ($style = readdir($fe)) 
            		{ 
            		if ($style != "." && $style != ".." && $style != "index.".$_SESSION['APCMS']['SUFFIX'] && $style != "cvs" && $style != "CVS") 
            			{ 
                    	$fc = opendir($STYLESDIR."/".$style."/cache"); 
                    	while ($cfile = readdir($fc)) 
                    		{ 
                    		if ($cfile != "." && $cfile != ".." && $cfile != "index.".$_SESSION['APCMS']['SUFFIX'] && $cfile != "cvs" && $cfile != "CVS") 
                    			{ 
                    			unlink($STYLESDIR."/".$style."/cache/".$cfile); 
                    			} 
                    		} 
                    	closedir($fc); 
                    	$fc = opendir($STYLESDIR."/".$style."/templates_c"); 
                    	while ($cfile = readdir($fc)) 
                    		{ 
                    		if ($cfile != "." && $cfile != ".." && $cfile != "index.".$_SESSION['APCMS']['SUFFIX'] && $cfile != "cvs" && $cfile != "CVS") 
                    			{ 
                    			unlink($STYLESDIR."/".$style."/templates_c/".$cfile); 
                    			} 
                    		} 
                    	closedir($fc); 
            			} 
            		}
            	closedir($fe); 
                } 
            $query = "TRUNCATE TABLE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache`"; 
            $db->unbuffered_query($query); 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].$_SESSION['SID2']; 
            $REDIRECT_TIME = 3; 
            $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Caching-Einstellungen gespeichert!", "&nbsp;", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "setlangopts": 
            $query = "UPDATE `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config` SET  
                                                                                        `language`='"._APCMS_trim($_POST['NEW']['deflang'])."'"; 
            $db->unbuffered_query($query); 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL'].'/?s='.$_POST['FROM']['s'].'&ainclude='.$_POST['FROM']['ainclude'].'&newsess=1'.$_SESSION['SID2']; 
            $REDIRECT_TIME = 3; 
            $HANDLER->assign("STATUSMSG", _APCMS_MsgBox("Einstellungen gespeichert!", "Die neuen Einstellungen wurden erfolgreich gespeichert.", $REDIRECT_URL, $REDIRECT_TIME, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "": 
             
             
             
             
             
             
             
             
             
             
             
             
            break; 
        /////////////////////////////////////////////////////////////////// 
        case "": 
             
             
             
             
             
             
             
             
             
             
             
             
            break; 
        /////////////////////////////////////////////////////////////////// 
         
         
         
        } 
    } 
 
 
 
 
 
 
 
$HANDLER->assign("CONTENTTITEL", $CONTENTTITEL); 
$HANDLER->assign("CONTENTINHALT", $CONTENTINHALT); 
 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Ausgabe startet hier 
//   
 
/* Ausgabe der HTML-Daten an den Browser */ 
$CONTENT = $HANDLER->fetch('content.'.$contentinclude.'.html'); 
 
 
//   
//  Die eigentliche Ausgabe endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
 
 
 
?>