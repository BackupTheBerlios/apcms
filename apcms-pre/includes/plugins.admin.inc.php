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
 * @subpackage includes
 */

/*)\
\(*/



/**
 * Exit the script when IN_apcms_admin is not defined
 */
if (!defined('IN_apcms_admin')) {
	exit;
}

/**
 * Sets the Subtitle of the page
 */
$PAGE_SUBTITLE 		= $apcms['LANGUAGE']['ADMIN_PLUGINS'];

$AOUT .= "<h3>.: ".$apcms['LANGUAGE']['ADMIN_PLUGINS']." :.</h3><br />\n";

/*
$PLUGINS = array();
$fdir = opendir($apcms['path']."/plugins");
while ($thisplugin = readdir($fdir)) {
	if (ereg("^apcms", $thisplugin)) {
		$PLUGINS[] = trim($thisplugin);
	}
}
*/

$AOUT .= "\n<div id=\"content1\">\n";
$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
$AOUT .= "		<tr class=\"content2\">\n";
$AOUT .= "			<td>\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_PLUGINS_DESCRIPTION']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";
$AOUT .= "	</table>\n";
$AOUT .= "</div><br />\n";


if (isset($_GET['deactivate']) && apcms_Strip($_GET['deactivate']) != "") {
	$db->unbuffered_query("UPDATE `".$apcms['table']['global']['plugins']."` SET `active`='0' WHERE `name`='".apcms_ESC(apcms_Strip($_GET['deactivate']))."'");
	$db->unbuffered_query("UPDATE `".$apcms['table']['global']['leftsidebar']."` SET `hidden`='1' WHERE `plugin`='".apcms_ESC(apcms_Strip($_GET['deactivate']))."'");
	$db->unbuffered_query("UPDATE `".$apcms['table']['global']['rightsidebar']."` SET `hidden`='1' WHERE `plugin`='".apcms_ESC(apcms_Strip($_GET['deactivate']))."'");
	$success = $apcms['LANGUAGE']['SUCCESS_PLUGIN_DEACTIVATED'];
	$apcms['redirect_url'] = $apcms['baseURL']."?c=admin&amp;act=plugins";
	$apcms['redirect_time'] = 3;
} elseif (isset($_GET['activate']) && apcms_Strip($_GET['activate']) != "") {
	$db->unbuffered_query("UPDATE `".$apcms['table']['global']['plugins']."` SET `active`='1' WHERE `name`='".apcms_ESC(apcms_Strip($_GET['activate']))."'");
	$db->unbuffered_query("UPDATE `".$apcms['table']['global']['leftsidebar']."` SET `hidden`='0' WHERE `plugin`='".apcms_ESC(apcms_Strip($_GET['activate']))."'");
	$db->unbuffered_query("UPDATE `".$apcms['table']['global']['rightsidebar']."` SET `hidden`='0' WHERE `plugin`='".apcms_ESC(apcms_Strip($_GET['activate']))."'");
	$success = $apcms['LANGUAGE']['SUCCESS_PLUGIN_ACTIVATED'];
	$apcms['redirect_url'] = $apcms['baseURL']."?c=admin&amp;act=plugins";
	$apcms['redirect_time'] = 3;
} elseif (isset($_GET['delete']) && apcms_Strip($_GET['delete']) != "") {
	$apcms['PLUGIN'][apcms_Strip($_GET['delete'])]->uninstall();
	$db->unbuffered_query("DELETE FROM `".$apcms['table']['global']['plugins']."` WHERE `name`='".apcms_ESC(apcms_Strip($_GET['delete']))."'");
	$db->unbuffered_query("DELETE FROM `".$apcms['table']['global']['rightsidebar']."` WHERE `plugin`='".apcms_ESC(apcms_Strip($_GET['delete']))."'");
	$db->unbuffered_query("DELETE FROM `".$apcms['table']['global']['leftsidebar']."` WHERE `plugin`='".apcms_ESC(apcms_Strip($_GET['delete']))."'");
	$success = $apcms['LANGUAGE']['SUCCESS_PLUGIN_DEINSTALLED'];
	$apcms['redirect_url'] = $apcms['baseURL']."?c=admin&amp;act=plugins";
	$apcms['redirect_time'] = 3;
} elseif (isset($_GET['install']) && apcms_Strip($_GET['install']) != "") {
	
	$plugin_name = apcms_Strip($_GET['install']);
	if (intval($_GET['local']) >= 1) {
		
		require_once($PATH."/plugins/".$plugin_name."/".$plugin_name.".".$SUFFIX);
		$thisplugin = new $plugin_name(true);
		$thisplugin->install();
		$config_items = $thisplugin->config_items;
		$config = array();
		
		foreach($config_items AS $key => $val) {
			$config[$key] = $config_items[$key]['default'];
		}
		$query = "INSERT INTO `".$apcms['table']['global']['plugins']."` 
								(
									`name`,
									`md5`,
									`config`, 
									`version` 
					) VALUES 	(
									'".apcms_ESC($plugin_name)."',
									'".md5(apcms_ESC($plugin_name))."',
									'".addslashes(serialize($config))."', 
									'".apcms_ESC($thisplugin->version)."'
								)";
		$db->unbuffered_query($query);
		
	} else {
		
		if (intval($_GET['update']) >= 1) {
			
			$url = "http://apcms.php-programs.de/download/plugins/".$plugin_name.".tar.gz";
			$return = apcms_GetHTML($url);
			$pplugin = preg_replace("`^.*\s*\n\s*\n\s*`isU", "", $return['html']);
			$fp = fopen($apcms['path']."/plugins/".$plugin_name.".tar.gz", "w");
			fwrite($fp, $pplugin);
			fclose($fp);
			
			require_once($PATH."/plugins/".$plugin_name."/".$plugin_name.".".$SUFFIX);
			$oldplugin = new $plugin_name(true);
			$oldversion = $oldplugin->version;
			
			$retoldconf = $db->unbuffered_query_first("SELECT `config` FROM `".$apcms['table']['global']['plugins']."` WHERE `name`='".apcms_ESC($plugin_name)."'");
			$oldconf = unserialize(stripslashes(trim($retoldconf[0])));
			apcms_DeleteDirectory($apcms['path']."/plugins/".$plugin_name);
			
			require_once("Archive/Tar.php");
			
			$tar = new Archive_Tar($apcms['path']."/plugins/".$plugin_name.".tar.gz");
			$tar->extract($apcms['path']."/plugins/");
			@unlink($apcms['path']."/plugins/".$plugin_name.".tar.gz");
			apcms_ChmodDirectory($apcms['path']."/plugins/".$plugin_name, 777);
			
			require_once($PATH."/plugins/".$plugin_name."/".$plugin_name.".".$SUFFIX);
			$newplugin = new $plugin_name(true);
			$newplugin->update($oldversion);
			
			$config_items = $newplugin->config_items;
			$config = array();
			foreach($config_items AS $key => $val) {
				if (!in_array($key, $oldconf)) {
					$config[$key] = $config_items[$key]['default'];
				} else {
					$config[$key] = $oldconf[$key];
				}
			}
			
			$query = "INSERT INTO `".$apcms['table']['global']['plugins']."` 
									(
										`name`,
										`md5`,
										`config`, 
										`version` 
						) VALUES 	(
										'".apcms_ESC($plugin_name)."',
										'".md5(apcms_ESC($plugin_name))."',
										'".addslashes(serialize($config))."', 
										'".apcms_ESC($newplugin->version)."'
									)";
			$db->unbuffered_query($query);
			
		} else {
			
			$url = "http://apcms.php-programs.de/download/plugins/".$plugin_name.".tar.gz";
			$return = apcms_GetHTML($url);
			$pplugin = preg_replace("`^.*\s*\n\s*\n\s*`isU", "", $return['html']);
			$fp = fopen($apcms['path']."/plugins/".$plugin_name.".tar.gz", "w");
			fwrite($fp, $pplugin);
			fclose($fp);
			
			if (file_exists($apcms['path']."/plugins/".$plugin_name."/".$plugin_name.".".$SUFFIX)) {
				apcms_DeleteDirectory($apcms['path']."/plugins/".$plugin_name);
			}
			
			require_once("Archive/Tar.php");
			
			$tar = new Archive_Tar($apcms['path']."/plugins/".$plugin_name.".tar.gz");
			$tar->extract($apcms['path']."/plugins/");
			@unlink($apcms['path']."/plugins/".$plugin_name.".tar.gz");
			apcms_ChmodDirectory($apcms['path']."/plugins/".$plugin_name, 777);
			
			require_once($PATH."/plugins/".$plugin_name."/".$plugin_name.".".$SUFFIX);
			$thisplugin = new $plugin_name(true);
			$thisplugin->install();
			$config_items = $thisplugin->config_items;
			$config = array();
			
			foreach($config_items AS $key => $val) {
				$config[$key] = $config_items[$key]['default'];
			}
			$query = "INSERT INTO `".$apcms['table']['global']['plugins']."` 
									(
										`name`,
										`md5`,
										`config`, 
										`version`
						) VALUES 	(
										'".apcms_ESC($plugin_name)."',
										'".md5(apcms_ESC($plugin_name))."',
										'".addslashes(serialize($config))."', 
										'".apcms_ESC($thisplugin->version)."'
									)";
			$db->unbuffered_query($query);
			
		}
		
	}
	
}



$AOUT .= "<a href=\"".$apcms['baseURL']."?c=admin&amp;act=installplugins\"><img src=\"".$apcms['themesurl']."/images/download.png\" width=\"50\" height=\"50\" alt=\"".$apcms['LANGUAGE']['ADMIN_PLUGINS_INSTALL_NEW_PLUGINS']."\" title=\"".$apcms['LANGUAGE']['ADMIN_PLUGINS_INSTALL_NEW_PLUGINS']."\" /></a> &nbsp; &nbsp; <a href=\"".$apcms['baseURL']."?c=admin&amp;act=installplugins\">".$apcms['LANGUAGE']['ADMIN_PLUGINS_INSTALL_NEW_PLUGINS']."</a><br /><br />\n";

$AOUT .= "<form name=\"registerform\" action=\"".$apcms['baseURL']."?c=admin&amp;act=plugins\" method=\"post\">\n";
$AOUT .= "<input type=\"hidden\" name=\"save\" value=\"1\" />\n";
$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";

$AOUT .= "		<tr>\n";
$AOUT .= "			<td>\n";
$AOUT .= "				<b><u>".$apcms['LANGUAGE']['GLOBAL_PLUGIN']."</u></b>\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"120\" align=\"center\">\n";
$AOUT .= "				<b><u>".$apcms['LANGUAGE']['GLOBAL_OPTIONS']."</u></b>\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";


$retplugins = $db->unbuffered_GetAll_row("SELECT * FROM `".$apcms['table']['global']['plugins']."`");
if(count($retplugins) >= 1) {
	for($a=0;$a<count($retplugins);$a++) {
		$plugin_id = intval($retplugins[$a][0]);
		$plugin_name = stripslashes(trim($retplugins[$a][1]));
		$plugin_md5 = stripslashes(trim($retplugins[$a][2]));
		$plugin_config = stripslashes(trim($retplugins[$a][4]));
		require_once($PATH."/plugins/".$plugin_name."/".$plugin_name.".".$SUFFIX);
		$apcms['PLUGIN'][$plugin_name] = new $plugin_name(true);
		$plugin[$plugin_name]['id'] = $plugin_id;
		$plugin[$plugin_name]['name'] = $plugin_name;
		$plugin[$plugin_name]['md5'] = $plugin_md5;
		$plugin[$plugin_name]['config'] = unserialize($plugin_config);
	}
}
if (isset($retplugins) && count($retplugins) >= 1) {
	for ($a=0;$a<count($retplugins);$a++) {
		
		if(is_array($plugin[$retplugins[$a][1]]['config']) && count($plugin[$retplugins[$a][1]]['config']) >= 1) {
			$ptitle = "<a href=\"".$apcms['baseURL']."?c=admin&amp;act=pluginconfigure&amp;id=".intval($retplugins[$a][0])."\">".apcms_Strip($apcms['PLUGIN'][$retplugins[$a][1]]->plugin)."</a>";
			$configicon = "<a href=\"".$apcms['baseURL']."?c=admin&amp;act=pluginconfigure&amp;id=".intval($retplugins[$a][0])."\"><img src=\"".$apcms['themesurl']."/images/admin/config.png\" width=\"16\" height=\"16\" alt=\"".$apcms['LANGUAGE']['GLOBAL_CONFIGURE']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_CONFIGURE']."\" /></a>&nbsp;\n";
		} else {
			$ptitle = apcms_Strip($apcms['PLUGIN'][$retplugins[$a][1]]->plugin);
			$configicon = "				<img src=\"".$apcms['themesurl']."/images/blank.png\" width=\"16\" height=\"16\" alt=\"\" />&nbsp;\n";
		}
		
		
		
		
		
		$AOUT .= "		<tr>\n";
		$AOUT .= "			<td>\n";
		$AOUT .= "				<b>".$ptitle."</b><br />\n";
		$AOUT .= "				".apcms_Strip($apcms['PLUGIN'][$retplugins[$a][1]]->description)."<br />\n";
		$AOUT .= "				Version: <a href=\"".apcms_Strip($apcms['PLUGIN'][$retplugins[$a][1]]->author_homepage)."\">".apcms_Strip($apcms['PLUGIN'][$retplugins[$a][1]]->version)."</a>; Author: <a href=\"mailto:".apcms_Strip($apcms['PLUGIN'][$retplugins[$a][1]]->author_email)."\">".apcms_Strip($apcms['PLUGIN'][$retplugins[$a][1]]->author_name)."</a><br />\n";
		$AOUT .= "			</td>\n";
		$AOUT .= "			<td width=\"120\" align=\"right\">\n";
		$AOUT .= "				\n".$configicon."\n";
		if (intval($retplugins[$a][3]) == 1) {
			$AOUT .= "				<a href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins&amp;deactivate=".$retplugins[$a][1]."\"><img src=\"".$apcms['themesurl']."/images/admin/deactivate.png\" width=\"16\" height=\"16\" alt=\"".$apcms['LANGUAGE']['GLOBAL_DEACTIVATE']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_DEACTIVATE']."\" /></a>&nbsp;\n";
		} else {
			$AOUT .= "				<a href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins&amp;activate=".$retplugins[$a][1]."\"><img src=\"".$apcms['themesurl']."/images/admin/activate.png\" width=\"16\" height=\"16\" alt=\"".$apcms['LANGUAGE']['GLOBAL_ACTIVATE']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_ACTIVATE']."\" /></a>&nbsp;\n";
		}
		$AOUT .= "				<a href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins&amp;delete=".$retplugins[$a][1]."\"><img src=\"".$apcms['themesurl']."/images/admin/delete.png\" width=\"16\" height=\"16\" alt=\"".$apcms['LANGUAGE']['GLOBAL_DELETE']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_DELETE']."\" /></a>&nbsp;\n";
		$AOUT .= "				\n";
		$AOUT .= "				&nbsp; &nbsp;\n";
		$AOUT .= "			</td>\n";
		$AOUT .= "		</tr>\n";
		$AOUT .= "		<tr><td colspan=\"2\"><hr></td></tr>\n";
	}
}

$AOUT .= "	</table>\n";
$AOUT .= "</form><br />\n";




































?>