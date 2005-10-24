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
// $Header $
// +----------------------------------------------------------------------+



$CONTENTTITEL       .=       '&nbsp; &raquo; &nbsp;'.$_LANGUAGE['backup_opts']; 
$CONTENTINHALT      .=       ''; 
$BACKUPFORM         =        ''; 
$tables             =        array(); 
$BACKUPDIR          =        $_SESSION['APCMS']['TMP_DIR']."/backups"; 
$TITLE_LOCATION     =        $_LANGUAGE['admincenter'].' - '.$_LANGUAGE['backup_opts'];

$backupdata_array = explode("|^|", $_SESSION['APCMS']['CONFIG']['data_backup']); 
 
$complete = intval($backupdata_array[0]); 
$tables = unserialize($backupdata_array[1]); 
$data = $backupdata_array[2]; 
$drop = intval($backupdata_array[3]); 
$pack = intval($backupdata_array[4]); 
 
 
if (!file_exists($BACKUPDIR."/.htaccess")) 
	{ 
	$htaccess = "<Directory ".$BACKUPDIR.">\n\tOrder Deny,Allow\n\tDeny from all\n\tAllow from localhost\n</Directory>\n"; 
	$fp = fopen($BACKUPDIR."/.htaccess", "w+"); 
	fwrite($fp, $htaccess); 
	fclose($fp); 
	chmod($BACKUPDIR."/.htaccess", 0755); 
	} 
 
if (isset($_GET['recover']) && isset($_GET['backup']) && $_GET['recover'] == 1 && trim($_GET['backup']) != "") 
    { 
    _APCMS_RecoverDBBackup($_GET['backup']); 
    $ADMINMAIN->assign("STATUSMSG", _APCMS_MsgBox($_LANGUAGE['backup_successful_recovered'], "&nbsp;", '', 0, 0, $_SESSION['APCMS']['TABLE']['WIDTH'])."<br />"); 
    } 
elseif (isset($_GET['download']) && isset($_GET['backup']) && $_GET['download'] == 1 && trim($_GET['backup']) != "") 
    { 
    $file = $BACKUPDIR."/".$_GET['backup']; 
    $fp = fopen($file,"r"); 
    if (eregi(".gz$", $_GET['backup'])) 
        header("Content-Type: application/x-gzip-compressed"); 
    elseif (eregi(".tar$", $_GET['backup'])) 
        header("Content-Type: application/x-tar-compressed"); 
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-length: ".filesize($BACKUPDIR."/".$_GET['backup'])); 
    header("Content-disposition: attachment; filename=".basename($_GET['backup'])); 
    while (!feof($fp))  
        { 
        $buff = fread($fp,4096); 
        print $buff; 
        } 
    } 
 
if (isset($tdbgcolor) && $tdbgcolor == $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']) { $tdbgcolor = $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']; } else { $tdbgcolor = $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']; } 
$BACKUPFORM .= '<table style="background-color:'.$_SESSION['APCMS']['TABLE']['BGCOLOR'].'" width="100%" border="0" cellspacing="1" cellpadding="2">'; 
$BACKUPFORM .= '<form name="NewBackupForm" action="'.$_SERVER['PHP_SELF']."?s=handler".$_SESSION['SID2'].'" method="POST">'; 
$BACKUPFORM .= '<input type="hidden" name="s" value="handler"> 
                <input type="hidden" name="action" value="makesqlbackup"> 
                <input type="hidden" name="backup" value="1"> 
                <input type="hidden" name="FROM[s]" value="admin"> 
                <input type="hidden" name="FROM[ainclude]" value="backupopts"> 
                <input type="hidden" name="'.session_name().'" value="'.session_id().'">'; 
$BACKUPFORM .= '<tr>'; 
$BACKUPFORM .= '<td rowspan="3" style="background-color:'.$tdbgcolor.'" align="left"><span class="normal"><select style="width:210px" name="tables[]" size="15" multiple>'; 
$QUERY = $db->unbuffered_query("SHOW TABLES"); 
$co = 0; 
while ($THISTABLE = $db->fetch_row($QUERY)) 
	{ 
	if (count($tables) >= 1) 
		{ 
		if (@in_array($THISTABLE[0], $tables)) 
			{ 
			$BACKUPFORM .= '<option value="'.$THISTABLE[0].'" selected>'.$THISTABLE[0].'</option>'; 
			} 
		else 
			{ 
			$BACKUPFORM .= '<option value="'.$THISTABLE[0].'">'.$THISTABLE[0].'</option>'; 
			} 
		} 
	else 
		{ 
		$BACKUPFORM .= '<option value="'.$THISTABLE[0].'"'; 
		if ($co==0) { $BACKUPFORM .= ' selected'; } 
		$BACKUPFORM .= '>'.$THISTABLE[0].'</option>'; 
		} 
	$co++; 
	} 
$BACKUPFORM .= '</select></span></td>'; 
$BACKUPFORM .= '<td width="260" style="background-color:'.$tdbgcolor.'" align="left" valign="top"><span class="normal"> 
					<select name="data"> 
						<option value="0"> --- '.$_LANGUAGE['please_choose'].' --- </option>'; 
 
if (isset($data) && $data == "data") 
	{ 
	$BACKUPFORM .= '		<option value="data" selected>'.$_LANGUAGE['structur_and_content'].'</option>'; 
	$BACKUPFORM .= '		<option value="structure">'.$_LANGUAGE['only_structure'].'</option>'; 
	$BACKUPFORM .= '		<option value="dataonly">'.$_LANGUAGE['only_content'].'</option>'; 
	} 
elseif (isset($data) && $data == "structure") 
	{ 
	$BACKUPFORM .= '		<option value="data">'.$_LANGUAGE['structur_and_content'].'</option>'; 
	$BACKUPFORM .= '		<option value="structure" selected>'.$_LANGUAGE['only_structure'].'</option>'; 
	$BACKUPFORM .= '		<option value="dataonly">'.$_LANGUAGE['only_content'].'</option>'; 
	} 
elseif (isset($data) && $data == "dataonly") 
	{ 
	$BACKUPFORM .= '		<option value="data">'.$_LANGUAGE['structur_and_content'].'</option>'; 
	$BACKUPFORM .= '		<option value="structure">'.$_LANGUAGE['only_structure'].'</option>'; 
	$BACKUPFORM .= '		<option value="dataonly" selected>'.$_LANGUAGE['only_content'].'</option>'; 
	} 
else 
	{ 
	$BACKUPFORM .= '		<option value="data" selected>'.$_LANGUAGE['structur_and_content'].'</option>'; 
	$BACKUPFORM .= '		<option value="structure">'.$_LANGUAGE['only_structure'].'</option>'; 
	$BACKUPFORM .= '		<option value="dataonly">'.$_LANGUAGE['only_content'].'</option>'; 
	} 
$BACKUPFORM .= '	</select><br>'; 
 
if (isset($drop) && $drop == 1) 		          {$BACKUPFORM .= '	<input type="checkbox" name="drop" value="1" checked> '.$_LANGUAGE['with_drop_table'].'<br>';} 
elseif (isset($drop) && $drop == "0")             {$BACKUPFORM .= '	<input type="checkbox" name="drop" value="1"> '.$_LANGUAGE['with_drop_table'].'<br>';} 
elseif (!isset($drop))	                          {$BACKUPFORM .= '	<input type="checkbox" name="drop" value="1" checked> '.$_LANGUAGE['with_drop_table'].'<br>';} 
 
if (isset($pack) && $pack == 1) 		          {$BACKUPFORM .= '	<input type="checkbox" name="pack" value="1" checked> '.$_LANGUAGE['pack_with_gzip'].'<br>';} 
elseif (isset($pack) && $pack == "0")             {$BACKUPFORM .= '	<input type="checkbox" name="pack" value="1"> '.$_LANGUAGE['pack_with_gzip'].'<br>';} 
elseif (!isset($pack))	                          {$BACKUPFORM .= '	<input type="checkbox" name="pack" value="1" checked> '.$_LANGUAGE['pack_with_gzip'].'<br>';} 
 
if (isset($complete) && $complete == 1)           {$BACKUPFORM .= '	<input type="checkbox" name="complete" value="1" checked> '.$_LANGUAGE['complete_database'].'<br>';} 
elseif (isset($complete) && $complete == "0")     {$BACKUPFORM .= '	<input type="checkbox" name="complete" value="1"> '.$_LANGUAGE['complete_database'].'<br>';} 
elseif (!isset($complete))                        {$BACKUPFORM .= '	<input type="checkbox" name="complete" value="1"> '.$_LANGUAGE['complete_database'].'<br>';} 
 
$BACKUPFORM .= '	</span></td>'; 
$BACKUPFORM .= '<td width="75" style="background-color:'.$tdbgcolor.'" align="center" valign="middle"><span class="normal"><input type="submit" name="submit" value="'.$_LANGUAGE['start_backup'].'"></span></td>'; 
$BACKUPFORM .= '</tr>'; 
$BACKUPFORM .= '<tr>'; 
if ($_SESSION['APCMS']['CONFIG']['auto_backup'] == 1) {$C_automatik = ' checked';} 
else {$C_automatik = '';} 
if ($_SESSION['APCMS']['CONFIG']['auto_backdel'] == 1) {$C_delmatik = ' checked';} 
else {$C_delmatik = '';} 
$BAKAUTO['TIME'] = array(3600,7200,18000,43200,86400,172800,345600,604800,1209600,2419200); 
$BAKAUTO['TEXT'] = array($_LANGUAGE['every_hour'],$_LANGUAGE['every_two_hours'],$_LANGUAGE['every_five_hours'],$_LANGUAGE['every_12_hours'],$_LANGUAGE['every_24_hours'],$_LANGUAGE['every_2_days'],$_LANGUAGE['every_4_days'],$_LANGUAGE['every_7_days'],$_LANGUAGE['every_2_weeks'],$_LANGUAGE['every_4_weeks']); 
$DELAUTO['TIME'] = array(43200,86400,172800,345600,604800,1209600,2419200,4838400,14515200); 
$DELAUTO['TEXT'] = array($_LANGUAGE['12_hours'],$_LANGUAGE['24_hours'],$_LANGUAGE['2_days'],$_LANGUAGE['4_days'],$_LANGUAGE['7_days'],$_LANGUAGE['2_weeks'],$_LANGUAGE['4_weeks'],$_LANGUAGE['2_months'],$_LANGUAGE['6_months']); 
$BACKUPFORM .= '<td colspan="2" style="background-color:'.$tdbgcolor.'" align="center" valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
						<tr> 
							<td colspan="2"><span class="normal">&nbsp;&nbsp;'.$_LANGUAGE['start_backup_automation'].'<br> 
							<input type="checkbox" name="bakautomatik" value="1"'.$C_automatik.'> '.$_LANGUAGE['yes_start_backupauto'].'<br></span></td> 
						</tr> 
						<tr> 
							<td><span class="normal">'.$_LANGUAGE['time_between_backups'].'</span></td> 
							<td width="50%"><span class="normal"><select name="interval">'; 
for ($BA=0;$BA<count($BAKAUTO['TIME']);$BA++) 
	{ 
	if ($_SESSION['APCMS']['CONFIG']['time_backup'] >= 1) 
		{ 
		if ($BAKAUTO['TIME'][$BA] == $_SESSION['APCMS']['CONFIG']['time_backup']) 
			{ 
			$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'" selected>'.$BAKAUTO['TEXT'][$BA].'</option>'; 
			} 
		else 
			{ 
			$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'">'.$BAKAUTO['TEXT'][$BA].'</option>'; 
			} 
		} 
	else 
		{ 
		if ($BA==3) 
			{ 
			$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'" selected>'.$BAKAUTO['TEXT'][$BA].'</option>'; 
			} 
		else 
			{ 
			$BACKUPFORM .= 				'<option value="'.$BAKAUTO['TIME'][$BA].'">'.$BAKAUTO['TEXT'][$BA].'</option>'; 
			} 
		} 
	} 
$BACKUPFORM .= '				</select></span></td> 
						</tr> 
					</table> 
					</td>'; 
$BACKUPFORM .= '</tr>'; 
$BACKUPFORM .= '<tr>'; 
$BACKUPFORM .= '<td colspan="2" style="background-color:'.$tdbgcolor.'" align="center" valign="top"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
						<tr> 
							<td colspan="2"><span class="normal">&nbsp;&nbsp;'.$_LANGUAGE['del_old_backups'].'<br> 
							<input type="checkbox" name="delautomatik" value="1"'.$C_delmatik.'> '.$_LANGUAGE['yes_del_old_backups'].'<br></span></td> 
						</tr> 
						<tr> 
							<td><span class="normal">'.$_LANGUAGE['all_older_than'].'</span></td> 
							<td width="50%"><span class="normal"><select name="delage">'; 
for ($BA=0;$BA<count($DELAUTO['TIME']);$BA++) 
	{ 
	if ($_SESSION['APCMS']['CONFIG']['time_backdel'] >= 1) 
		{ 
		if ($DELAUTO['TIME'][$BA] == $_SESSION['APCMS']['CONFIG']['time_backdel']) 
			{ 
			$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'" selected>'.$DELAUTO['TEXT'][$BA].'</option>'; 
			} 
		else 
			{ 
			$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'">'.$DELAUTO['TEXT'][$BA].'</option>'; 
			} 
		} 
	else 
		{ 
		if ($BA==6) 
			{ 
			$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'" selected>'.$DELAUTO['TEXT'][$BA].'</option>'; 
			} 
		else 
			{ 
			$BACKUPFORM .= 				'<option value="'.$DELAUTO['TIME'][$BA].'">'.$DELAUTO['TEXT'][$BA].'</option>'; 
			} 
		} 
	} 
$BACKUPFORM .= '				</select>&nbsp;&nbsp;'.$_LANGUAGE['delete'].'</span></td> 
						</tr> 
					</table> 
					</td>'; 
$BACKUPFORM .= '</tr>'; 
$BACKUPFORM .= '</form>'; 
$BACKUPFORM .= '</table><br>'; 
unset($BACKUPS); 
$bc = 0; 
$fd = opendir($BACKUPDIR); 
while ($backup = readdir($fd)) 
	{ 
	if ($backup!="." && $backup!=".." && $backup!="index.".$_SESSION['APCMS']['SUFFIX'] && $backup!="cvs" && $backup!="CVS" && $backup!=".htaccess") 
		{ 
		$BACKUPS['NAME'][$bc] = $backup; 
		$BACKUPS['FILE'][$bc] = $BACKUPDIR."/".$backup; 
		$BACKUPS['TIME'][$bc] = filemtime($BACKUPDIR."/".$backup); 
		$BACKUPS['SIZE'][$bc] = filesize($BACKUPDIR."/".$backup); 
		$bc++; 
		} 
	} 
closedir($fd); 
@reset($BACKUPS); 
@array_multisort($BACKUPS['TIME'], SORT_DESC, SORT_NUMERIC, $BACKUPS['NAME'], $BACKUPS['FILE'], $BACKUPS['SIZE']); 
if ($tdbgcolor == $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']) { $tdbgcolor = $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']; } else { $tdbgcolor = $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']; } 
if (count($BACKUPS['NAME']) >= 1) 
	{ 
	$BACKUPFORM .= '<table width="100%" border="0" cellspacing="1" cellpadding="2">'; 
	$BACKUPFORM .= '<form name="UPForm" action="'.$_SERVER['PHP_SELF']."?s=handler".$_SESSION['SID2'].'" method="POST">'; 
	$BACKUPFORM .= '<input type="hidden" name="s" value="handler"> 
                    <input type="hidden" name="action" value="deletesqlbackup"> 
                    <input type="hidden" name="FROM[s]" value="admin"> 
                    <input type="hidden" name="FROM[ainclude]" value="backupopts"> 
                    <input type="hidden" name="'.session_name().'" value="'.session_id().'">'; 
	$BACKUPFORM .= '<tr>'; 
	$BACKUPFORM .= '<td width="20" style="background-color:'.$tdbgcolor.'" align="center"><span class="normalbold">I</span></td>'; 
	$BACKUPFORM .= '<td style="background-color:'.$tdbgcolor.'" align="left"><span class="normalbold">'.$_LANGUAGE['filename'].'</span></td>'; 
	$BACKUPFORM .= '<td width="100" style="background-color:'.$tdbgcolor.'" align="right"><span class="normalbold">'.$_LANGUAGE['filesize'].'</span></td>'; 
	$BACKUPFORM .= '<td width="120" style="background-color:'.$tdbgcolor.'" align="right"><span class="normalbold">'.$_LANGUAGE['date'].'</span></td>'; 
	$BACKUPFORM .= '<td width="55" style="background-color:'.$tdbgcolor.'" align="center"><span class="normalbold">'.$_LANGUAGE['options'].'</span></td>'; 
	$BACKUPFORM .= '</tr>'; 
	for ($bco=0;$bco<count($BACKUPS['NAME']);$bco++) 
		{ 
		if ($tdbgcolor == $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']) { $tdbgcolor = $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']; } else { $tdbgcolor = $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']; } 
		$BACKUPFORM .= '<tr>'; 
		$BACKUPFORM .= '<td width="20" style="background-color:'.$tdbgcolor.'" align="center"><img src="'.$_SESSION['APCMS']['STYLES_URL'].'/'.$_SESSION['APCMS']['STYLE'].'/images//dltree/gz.gif" align="absmiddle" width="20" border="0" alt="" title=""></td>'; 
		$BACKUPFORM .= '<td style="background-color:'.$tdbgcolor.'" align="left"><span class="normal"><a href="'.$_SESSION['APCMS']['REL_URL'].'/?s=admin&ainclude=backupopts&backup='.$BACKUPS['NAME'][$bco].'&download=1">'.$BACKUPS['NAME'][$bco].'</a></span></td>'; 
		$BACKUPFORM .= '<td width="100" style="background-color:'.$tdbgcolor.'" align="right"><span class="normal">'.$BACKUPS['SIZE'][$bco].'</span></td>'; 
		$BACKUPFORM .= '<td width="120" style="background-color:'.$tdbgcolor.'" align="right"><span class="normal">'.date("d.m.Y, H:i",$BACKUPS['TIME'][$bco]).'</span></td>'; 
		$BACKUPFORM .= '<td width="55" style="background-color:'.$tdbgcolor.'" align="center"><span class="normal">'; 
		$BACKUPFORM .= "	<a href=\"".$_SESSION['APCMS']['REL_URL']."/?s=admin&ainclude=backupopts&backup=".$BACKUPS['NAME'][$bco]."&recover=1\"><img src=\"".$_SESSION['APCMS']['STYLES_URL']."/".$_SESSION['APCMS']['STYLE']."/images/icons/wiederherstellen.gif\" height=14 border=\"0\" valign=\"absmiddle\" align=\"middle\" title=\"".$_LANGUAGE['alt_recover_backup']."\" alt=\"".$_LANGUAGE['alt_recover_backup']."\"></a>"; 
		$BACKUPFORM .= '	<input type="checkbox" name="del[]" value="'.$BACKUPS['NAME'][$bco].'"></span></td>'; 
		$BACKUPFORM .= '</tr>'; 
		} 
	if ($tdbgcolor == $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']) { $tdbgcolor = $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']; } else { $tdbgcolor = $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']; } 
	$BACKUPFORM .= '<tr>'; 
	$BACKUPFORM .= '<td colspan="5" style="background-color:'.$tdbgcolor.'" align="right"><span class="normalbold"> 
						<input type="submit" name="delete" value="'.$_LANGUAGE['delete_button'].'"> 
						</span></td>'; 
	$BACKUPFORM .= '</tr>'; 
	$BACKUPFORM .= '</form>'; 
	$BACKUPFORM .= '</table>'; 
	} 
else 
	{ 
	$BACKUPFORM .= '<table width="100%" border="0" cellspacing="1" cellpadding="2">'; 
	$BACKUPFORM .= '<tr>'; 
	$BACKUPFORM .= '<td style="background-color:'.$tdbgcolor.'" align="center"><span class="normalbold">'.$_LANGUAGE['no_backups'].'</span></td>'; 
	$BACKUPFORM .= '</tr>'; 
	$BACKUPFORM .= '</table>'; 
	} 
 
 
 
require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_admintable.class.".$_SESSION['APCMS']['SUFFIX']); 
$ADMINTABLE1 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']); 
$ADMINTABLE1->AddRow('<strong> .: '.$_LANGUAGE['backup_opts'].' :.</strong><br /><br />'.$BACKUPFORM, '', 2); 
$CONTENTINHALT .= $ADMINTABLE1->GetTable().""; 
 
 
?>