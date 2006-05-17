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
 * $Id: installplugins.admin.inc.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
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


$LOCPLUGINS = array();
$fdir = opendir($apcms['path']."/plugins");
while ($thisplugin = readdir($fdir)) {
	if (ereg("^apcms", $thisplugin)) {
		require_once($PATH."/plugins/".$thisplugin."/".$thisplugin.".".$SUFFIX);
		$plugobj[$thisplugin] = new $thisplugin(true);
		$LOCPLUGINS['name'][] = trim($thisplugin);
		$LOCPLUGINS['plugin'][] = apcms_Strip($plugobj[$thisplugin]->plugin);
		$LOCPLUGINS['version'][] = apcms_Strip($plugobj[$thisplugin]->version);
		$LOCPLUGINS['description'][] = apcms_Strip($plugobj[$thisplugin]->description);
		$LOCPLUGINS['author_name'][] = apcms_Strip($plugobj[$thisplugin]->author_name);
		$LOCPLUGINS['author_email'][] = apcms_Strip($plugobj[$thisplugin]->author_email);
		$LOCPLUGINS['homepage'][] = apcms_Strip($plugobj[$thisplugin]->author_homepage);
	}
}

$ALLPLUGINS = array();
$return = apcms_GetHTML('http://apcms.php-programs.de/download/plugins/plugin.lst');
$pluginlist = preg_replace("`^.*\s*\n\s*\n\s*`isU", "", $return['html']);
$plistarray = explode("\n", trim($pluginlist));
for ($a=0;$a<count($plistarray);$a++) {
	$linear = explode("\t", trim($plistarray[$a]));
	
	if (in_array(trim($linear[0]), $LOCPLUGINS['name'])) {
		$pversion = apcms_Strip($plugobj[trim($linear[0])]->version);
		if (version_compare($pversion, apcms_Strip($linear[2]), "<")) {
			$ALLPLUGINS['name'][] = trim($linear[0]);
			$ALLPLUGINS['plugin'][] = apcms_Strip($linear[1]);
			$ALLPLUGINS['version'][] = apcms_Strip($linear[2]);
			$ALLPLUGINS['description'][] = apcms_Strip($linear[6]);
			$ALLPLUGINS['author_name'][] = apcms_Strip($linear[3]);
			$ALLPLUGINS['author_email'][] = apcms_Strip($linear[4]);
			$ALLPLUGINS['homepage'][] = apcms_Strip($linear[5]);
		} elseif (version_compare($pversion, apcms_Strip($linear[2]), ">")) {
			$ALLPLUGINS['name'][] = trim($linear[0]);
			$ALLPLUGINS['plugin'][] = apcms_Strip($plugobj[trim($linear[0])]->plugin);
			$ALLPLUGINS['version'][] = apcms_Strip($plugobj[trim($linear[0])]->version);
			$ALLPLUGINS['description'][] = apcms_Strip($plugobj[trim($linear[0])]->description);
			$ALLPLUGINS['author_name'][] = apcms_Strip($plugobj[trim($linear[0])]->author_name);
			$ALLPLUGINS['author_email'][] = apcms_Strip($plugobj[trim($linear[0])]->author_email);
			$ALLPLUGINS['homepage'][] = apcms_Strip($plugobj[trim($linear[0])]->author_homepage);
		} else {
			$ALLPLUGINS['name'][] = trim($linear[0]);
			$ALLPLUGINS['plugin'][] = apcms_Strip($linear[1]);
			$ALLPLUGINS['version'][] = apcms_Strip($linear[2]);
			$ALLPLUGINS['description'][] = apcms_Strip($linear[6]);
			$ALLPLUGINS['author_name'][] = apcms_Strip($linear[3]);
			$ALLPLUGINS['author_email'][] = apcms_Strip($linear[4]);
			$ALLPLUGINS['homepage'][] = apcms_Strip($linear[5]);
		}
	} else {
		$ALLPLUGINS['name'][] = trim($linear[0]);
		$ALLPLUGINS['plugin'][] = apcms_Strip($linear[1]);
		$ALLPLUGINS['version'][] = apcms_Strip($linear[2]);
		$ALLPLUGINS['description'][] = apcms_Strip($linear[6]);
		$ALLPLUGINS['author_name'][] = apcms_Strip($linear[3]);
		$ALLPLUGINS['author_email'][] = apcms_Strip($linear[4]);
		$ALLPLUGINS['homepage'][] = apcms_Strip($linear[5]);
	}
}


for ($a=0;$a<count($LOCPLUGINS['name']);$a++) {
	if (in_array(trim($LOCPLUGINS['name'][$a]), $ALLPLUGINS['name'])) {
		for($z=0;$z<count($ALLPLUGINS['name']);$z++) {
			if ($ALLPLUGINS['name'][$z] == $LOCPLUGINS['name'][$a]) {
				break;
			}
		}
		$pversion = $ALLPLUGINS['version'][$z];
		if (version_compare($pversion, $LOCPLUGINS['version'][$a], "<")) {
			$ALLPLUGINS['name'][$z] = trim($linear[0]);
			$ALLPLUGINS['plugin'][$z] = apcms_Strip($linear[1]);
			$ALLPLUGINS['version'][$z] = $LOCPLUGINS['version'][$a];
			$ALLPLUGINS['description'][$z] = $LOCPLUGINS['description'][$a];
			$ALLPLUGINS['author_name'][$z] = $LOCPLUGINS['author_name'][$a];
			$ALLPLUGINS['author_email'][$z] = $LOCPLUGINS['author_email'][$a];
			$ALLPLUGINS['homepage'][$z] = $LOCPLUGINS['homepage'][$a];
		}
	} else {
		$ALLPLUGINS['name'][] = $LOCPLUGINS['name'][$a];
		$ALLPLUGINS['plugin'][] = $LOCPLUGINS['plugin'][$a];
		$ALLPLUGINS['version'][] = $LOCPLUGINS['version'][$a];
		$ALLPLUGINS['description'][] = $LOCPLUGINS['description'][$a];
		$ALLPLUGINS['author_name'][] = $LOCPLUGINS['author_name'][$a];
		$ALLPLUGINS['author_email'][] = $LOCPLUGINS['author_email'][$a];
		$ALLPLUGINS['homepage'][] = $LOCPLUGINS['homepage'][$a];
	}
}


@reset($LOCPLUGINS);
array_multisort($LOCPLUGINS['name'], SORT_STRING, SORT_ASC,
				$LOCPLUGINS['plugin'],
				$LOCPLUGINS['version'],
				$LOCPLUGINS['description'],
				$LOCPLUGINS['author_name'],
				$LOCPLUGINS['author_email'],
				$LOCPLUGINS['homepage']
				);
@reset($LOCPLUGINS);

@reset($ALLPLUGINS);
array_multisort($ALLPLUGINS['name'], SORT_STRING, SORT_ASC,
				$ALLPLUGINS['plugin'],
				$ALLPLUGINS['version'],
				$ALLPLUGINS['description'],
				$ALLPLUGINS['author_name'],
				$ALLPLUGINS['author_email'],
				$ALLPLUGINS['homepage']
				);
@reset($ALLPLUGINS);


$AOUT .= "\n<div id=\"content1\">\n";
$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
$AOUT .= "		<tr class=\"content2\">\n";
$AOUT .= "			<td>\n";
$AOUT .= "				".$apcms['LANGUAGE']['ADMIN_INSTALLPLUGINS_DESCRIPTION']."\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";
$AOUT .= "	</table>\n";
$AOUT .= "</div><br />\n";

$AOUT .= "<form name=\"registerform\" action=\"".$apcms['baseURL']."?c=admin&amp;act=plugins\" method=\"post\">\n";
$AOUT .= "<input type=\"hidden\" name=\"install\" value=\"1\" />\n";
$AOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
$AOUT .= "		<tr>\n";
$AOUT .= "			<td>\n";
$AOUT .= "				<b><u>".$apcms['LANGUAGE']['GLOBAL_PLUGIN']."</u></b>\n";
$AOUT .= "			</td>\n";
$AOUT .= "			<td width=\"100\" align=\"center\">\n";
$AOUT .= "				<b><u>".$apcms['LANGUAGE']['GLOBAL_OPTIONS']."</u></b>\n";
$AOUT .= "			</td>\n";
$AOUT .= "		</tr>\n";

if (isset($ALLPLUGINS) && count($ALLPLUGINS['name']) >= 1) {
	for ($a=0;$a<count($ALLPLUGINS['name']);$a++) {
		$plugin_name = apcms_Strip($ALLPLUGINS['name'][$a]);
		$vailable_version = apcms_Strip($ALLPLUGINS['version'][$a]);
		$plugin = apcms_Strip($ALLPLUGINS['plugin'][$a]);
		$retplugin = $db->unbuffered_query_first("SELECT * FROM `".$apcms['table']['global']['plugins']."` WHERE `name`='".apcms_ESC($plugin_name)."'");
		
		
		if (isset($retplugin[0]) && intval($retplugin[0]) >= 1) {
			/** Plugin is already installed */
			
			$plugin_version = apcms_Strip($plugobj[trim($plugin_name)]->version);
			
			if (version_compare($plugin_version, $vailable_version, "<")) {
				/** installed Plugin is older than the official one from the server */
				$installicon = "<a href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins&amp;install=".$plugin_name."&amp;local=0&amp;update=1\"><img src=\"".$apcms['themesurl']."/images/admin/update.png\" width=\"66\" height=\"50\" alt=\"".$apcms['LANGUAGE']['GLOBAL_UPDATE']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_UPDATE']."\" /></a>";
				
			} elseif (version_compare($plugin_version, $vailable_version, "==")) {
				/** installed Plugin is the same version as the official one from the server */
				$installicon = "<img src=\"".$apcms['themesurl']."/images/admin/already.installed.png\" width=\"66\" height=\"50\" alt=\"".$apcms['LANGUAGE']['GLOBAL_ALREADY_INSTALLED']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_ALREADY_INSTALLED']."\" /></a>";
			
			} else {
				/** installed Plugin is newer than the official one from the server */
				$installicon = "<img src=\"".$apcms['themesurl']."/images/admin/already.installed.png\" width=\"66\" height=\"50\" alt=\"".$apcms['LANGUAGE']['GLOBAL_ALREADY_INSTALLED']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_ALREADY_INSTALLED']."\" /></a>";
			}
			
		
		} else {
			/** Plugin is NOT installed */
			
			if (!file_exists($PATH."/plugins/".$plugin_name."/".$plugin_name.".".$SUFFIX)) {
				/** Plugin has to be installed directly from the server */
				$installicon = "<a href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins&amp;install=".$plugin_name."&amp;local=0&amp;update=0\"><img src=\"".$apcms['themesurl']."/images/admin/install.from.server.png\" width=\"66\" height=\"50\" alt=\"".$apcms['LANGUAGE']['GLOBAL_INSTALL']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_INSTALL']."\" /></a>";
			
			} else {
				/** Plugin already exists locally... */
				
				$plugin_version = apcms_Strip($plugobj[trim($plugin_name)]->version);
				
				if (version_compare($plugin_version, $vailable_version, "<")) {
					/** Local plugin is older than the official one from the server and must be downloaded again */
					$installicon = "<a href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins&amp;install=".$plugin_name."&amp;local=0&amp;update=0\"><img src=\"".$apcms['themesurl']."/images/admin/update.png\" width=\"66\" height=\"50\" alt=\"".$apcms['LANGUAGE']['GLOBAL_UPDATE']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_UPDATE']."\" /></a>";
				
				} elseif (version_compare($plugin_version, $vailable_version, "==")) {
					/** Local Plugin is the same as the official one and can be installed from local */
					$installicon = "<a href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins&amp;install=".$plugin_name."&amp;local=1&amp;update=0\"><img src=\"".$apcms['themesurl']."/images/admin/install.from.local.png\" width=\"66\" height=\"50\" alt=\"".$apcms['LANGUAGE']['GLOBAL_ALREADY_INSTALLED']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_ALREADY_INSTALLED']."\" /></a>";
				
				} else {
					/** Local Plugin is newer than the official one and must be installed from local */
					$installicon = "<a href=\"".$apcms['baseURL']."?c=admin&amp;act=plugins&amp;install=".$plugin_name."&amp;local=1&amp;update=0\"><img src=\"".$apcms['themesurl']."/images/admin/install.from.local.png\" width=\"66\" height=\"50\" alt=\"".$apcms['LANGUAGE']['GLOBAL_ALREADY_INSTALLED']."\" title=\"".$apcms['LANGUAGE']['GLOBAL_ALREADY_INSTALLED']."\" /></a>";
				}
				
			}
		}
		
		$AOUT .= "		<tr>\n";
		$AOUT .= "			<td>\n";
		$AOUT .= "				<b>".$plugin."</b><br />\n";
		$AOUT .= "				".apcms_Strip($ALLPLUGINS['description'][$a])."<br />\n";
		$AOUT .= "				Version: <a href=\"".apcms_Strip($ALLPLUGINS['homepage'][$a])."\">".apcms_Strip($ALLPLUGINS['version'][$a])."</a>; Author: <a href=\"mailto:".apcms_Strip($ALLPLUGINS['author_email'][$a])."\">".apcms_Strip($ALLPLUGINS['author_name'][$a])."</a><br />\n";
		$AOUT .= "			</td>\n";
		$AOUT .= "			<td width=\"100\" align=\"center\">".$installicon."</td>\n";
		$AOUT .= "		</tr>\n";
		$AOUT .= "		<tr><td colspan=\"2\"><hr></td></tr>\n";
	}
}

$AOUT .= "	</table>\n";
$AOUT .= "</form><br />\n";



?>