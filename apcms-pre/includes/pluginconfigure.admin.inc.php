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
 * 
 * $Id: pluginconfigure.admin.inc.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
 */

/*)\
\(*/



/**
 * Exit the script when IN_apcms is not defined
 */
if (!defined('IN_apcms_admin')) {
	exit;
}

/**
 * Sets the Subtitle of the page
 */
$PAGE_SUBTITLE 		= $apcms['LANGUAGE']['ADMIN_PCONFIG'];

if (isset($_GET['id']) && intval($_GET['id']) >= 1) {
	$pid = intval($_GET['id']);
	$AOUT .= "<h3>.: ".$apcms['LANGUAGE']['ADMIN_PCONFIG']." :.</h3><br />\n";
	
	
	
	/** Save the new configuration... */
	if (isset($_POST['save']) && intval($_POST['save']) >= 1) {
		
		$retplugin = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['plugins']."` WHERE `id`='".$pid."'");
		if (isset($retplugin[1]) && trim($retplugin[1]) != "") {
			$name = trim($retplugin[1]);
			$config = unserialize(stripslashes(trim($retplugin[4])));
		}
		
		$newconfig = array();
		foreach($_POST['pconf'] AS $key => $val) {
			
			if ($val == "byes") {
				$val = true;
			} elseif ($val == "bno") {
				$val = false;
			}
			$newconfig[trim($key)] = $val;
		}
		
		$config_items = $apcms['PLUGIN'][$name]->config_items;
		$config = array();
		foreach($config_items AS $key => $val) {
			if (!in_array($key, $newconfig)) {
				$config[$key] = $config_items[$key]['default'];
			} else {
				$config[$key] = $newconfig[$key];
			}
		}
		
		$query = "UPDATE `".$apcms['table']['global']['plugins']."` SET `config`='".apcms_ESC(serialize($config))."' WHERE `id`='".$pid."'";
		$db->unbuffered_query($query);
		$success = $apcms['LANGUAGE']['SUCCESS_SAVED'];
		unset($config);
	}
	
	
	
	$retplugin = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['plugins']."` WHERE `id`='".$pid."'");
	if (isset($retplugin[1]) && trim($retplugin[1]) != "") {
		$name = trim($retplugin[1]);
		$config = unserialize(stripslashes(trim($retplugin[4])));
	}
	
	$AOUT .= "\n<div id=\"adminmain1\">\n";
	$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
	$AOUT .= "		<tr class=\"adminmain2\">\n";
	$AOUT .= "			<td>\n";
	$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_PCONFIG_DESC']." ".$name."\n";
	$AOUT .= "			</td>\n";
	$AOUT .= "		</tr>\n";
	$AOUT .= "	</table>\n";
	$AOUT .= "</div><br />\n";

	
	$AOUT .= "\n<div id=\"adminmain1\">\n";
	$AOUT .= "<form name=\"pcform\" action=\"".$apcms['baseURL']."?c=admin&amp;act=pluginconfigure&amp;id=".$pid."\" method=\"post\">\n";
	$AOUT .= "<input type=\"hidden\" name=\"save\" value=\"1\" />\n";
	$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
	
	
	foreach($apcms['PLUGIN'][$name]->config_items AS $key => $val) {
		$formitem = "";
		
		$itemname = trim($key);
		$type = $val['type'];
		$title = $val['name'];
		if (isset($val['description']) && trim($val['description']) != "") {
			$desc = $val['description'];
		}
		$default = $val['default'];
		
		$formitem .= "		<tr class=\"adminmain2\">\n";
		$formitem .= "			<td valign=\"top\">\n";
		$formitem .= "				<b>".$title."</b>\n";
		if (isset($desc) && trim($desc) != "") {
			$formitem .= "				<br /><span class=\"small_desc\">".$desc."</span>\n";
		}
		$formitem .= "			</td>\n";
		$formitem .= "			<td width=\"300\" align=\"right\" valign=\"top\">\n";
		
		
		
		if ($type == "integer" || $type == "int" || $type == "INT") {
			if (isset($config[$itemname]) && intval($config[$itemname]) >= 0) {
				$value = intval($config[$itemname]);
			} else {
				$value = intval($apcms['PLUGIN'][$name]->config_items[$itemname]['default']);
			}
			$formitem .= "				<input type=\"text\" name=\"pconf[".$itemname."]\" value=\"".$value."\" style=\"width:100%\" />\n";
		
		} elseif ($type == "string" || $type == "STRING") {
			if (isset($config[$itemname]) && trim($config[$itemname]) != "") {
				$value = trim($config[$itemname]);
			} else {
				$value = trim($apcms['PLUGIN'][$name]->config_items[$itemname]['default']);
			}
			$formitem .= "				<input type=\"text\" name=\"pconf[".$itemname."]\" value=\"".$value."\" style=\"width:100%\" />\n";
		
		} elseif ($type == "text" || $type == "TEXT" || $type == "textarea") {
			if (isset($config[$itemname]) && trim($config[$itemname]) != "") {
				$value = trim($config[$itemname]);
			} else {
				$value = trim($apcms['PLUGIN'][$name]->config_items[$itemname]['default']);
			}
			$formitem .= "				<textarea name=\"pconf[".$itemname."]\" rows=\"6\" style=\"width:100%\">".$value."</textarea>\n";
		
		} elseif ($type == "bool" || $type == "boolean" || $type == "BOOL") {
			if (isset($config[$itemname])) {
				$value = $config[$itemname];
			} else {
				$value = false;
			}
			$formitem .= "				<select name=\"pconf[".$itemname."]\" style=\"width:100%\">\n";
			if ($value === true) {
				$formitem .= "					<option value=\"byes\" selected=\"selected\">".$apcms['LANGUAGE']['GLOBAL_YES']."</option>\n";
				$formitem .= "					<option value=\"bno\">".$apcms['LANGUAGE']['GLOBAL_NO']."</option>\n";
			} else {
				$formitem .= "					<option value=\"byes\">".$apcms['LANGUAGE']['GLOBAL_YES']."</option>\n";
				$formitem .= "					<option value=\"bno\" selected=\"selected\">".$apcms['LANGUAGE']['GLOBAL_NO']."</option>\n";
			}
			$formitem .= "				</select>\n";
			
		} else {
			if (isset($config[$itemname]) && trim($config[$itemname]) != "") {
				$value = trim($config[$itemname]);
			} else {
				$value = trim($apcms['PLUGIN'][$name]->config_items[$itemname]['default']);
			}
			$formitem .= "				<input type=\"text\" name=\"pconf[".$itemname."]\" value=\"".$value."\" style=\"width:100%\" />\n";
		
		}
		
		
		$formitem .= "			</td>\n";
		$formitem .= "		</tr>\n";
		
		$AOUT .= $formitem;
		
	}
	
	$AOUT .= "		<tr>\n";
	$AOUT .= "			<td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"submit\" value=\"".$apcms['LANGUAGE']['ADMIN_SAVE']."\" /></td>\n";
	$AOUT .= "		</tr>\n";
	
	
	
	$AOUT .= "	</table>\n";
	$AOUT .= "</form>\n";
	$AOUT .= "</div><br />\n";
	
	
	
	
} else {
	$error = $apcms['LANGUAGE']['ERROR_NO_PLUGIN_GIVEN'];
}








































?>