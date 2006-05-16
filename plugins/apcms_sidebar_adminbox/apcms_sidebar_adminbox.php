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
 * @subpackage plugins
 */

/*)\
\(*/



/** DON'T DELETE OR MODIFY THE FOLLOWING THREE LINES! */
if (!defined('IN_apcms')) {
	exit;
}

/** Including plugin related language file */
if (file_exists(@realpath(@dirname(__FILE__))."/lang/".$apcms['lang'].".lang.".$SUFFIX)) {
	require_once(@realpath(@dirname(__FILE__))."/lang/".$apcms['lang'].".lang.".$SUFFIX);
} elseif (file_exists(@realpath(@dirname(__FILE__))."/lang/de.lang.".$SUFFIX)) {
	require_once(@realpath(@dirname(__FILE__))."/lang/de.lang.".$SUFFIX);
}

/**
 * Sidebar-Box plugin to show an administration box for APCms
 *
 * @access public
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
class APCms_SideBar_AdminBox {

	

	/** 
	 * @var string The directoryname of this plugin 
	 */
	var $dirname;
	
	/** 
	 * @var string The name of this plugin 
	 */
	var $plugin;
	
	/** 
	 * @var string The description of this plugin 
	 */
	var $description;
	
	/** 
	 * @var string The name of the author of this plugin 
	 */
	var $author_name;
	
	/** 
	 * @var string The email adress of the author 
	 */
	var $author_email;
	
	/** 
	 * @var string The homepage of the author or of this plugin 
	 */
	var $author_homepage;
	
	/** 
	 * @var string The version of this plugin 
	 */
	var $version;
	
	/** 
	 * @var string the minimum required version of APCms 
	 */
	var $apcms_version;
	
	/** 
	 * @var array The configuration items for the administration interface 
	 */
	var $config_items;
	
	/** 
	 * @var string Absolute serverpath to the plugin directory 
	 */
	var $pluginpath;
	
	/** 
	 * @var string Status messages 
	 */
	var $status;
	
	
	function APCms_SideBar_AdminBox() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		/*
		 ////////////////////////////////////////////////////////////////////////
							Start of plugin-configuration
		 ////////////////////////////////////////////////////////////////////////
		*/
		
		/** The directoryname of this plugin */
		$this->dirname				=	'apcms_sidebar_adminbox';
		
		/** The name of this plugin */
		$this->plugin				=	'Administration Box';
		
		/** The description of this plugin */
		$this->description			=	'Sidebar-Plugin to show a link to the Administration interface in your sidebar.';
		
		/** The name of the author of this plugin */
		$this->author_name			=	'Alexander \'dma147\' Mieland';
		
		/** The email adress of the author */
		$this->author_email			=	'dma147@linux-stats.org';
		
		/** The homepage of the author or of this plugin */
		$this->author_homepage		=	'http://www.php-programs.de/apcms_sidebar_adminbox.html';
		
		/** The version of this plugin */
		$this->version				=	'0.0.1';
		
		/** the minimum required version of APCms */
		$this->apcms_version		=	'0.0.1_pre1';
		
		/** The configuration items for the administration interface */
		$this->config_items			=	array();
		
		/*
		 ////////////////////////////////////////////////////////////////////////
							End of plugin-configuration
		 ////////////////////////////////////////////////////////////////////////
		*/
		
		
		$this->pluginpath = @realpath(@dirname(__FILE__));
		$this->_init_plugin();
	}
	
	/**
	 * Install routine for the Sidebar-Box plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function install() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		$selsort = $db->unbuffered_query_first("SELECT MAX(`sort`) FROM `".$apcms['table']['global']['rightsidebar']."`");
		if (isset($selsort) && intval($selsort[0]) >= 1) {
			$sort = intval($selsort[0]) + 1;
		} else {
			$sort = 1;
		}
		
		$boxcontent = "[php]\$apcms['PLUGIN']['apcms_sidebar_adminbox']->ShowAdminBox();[/php]";
		$query = "INSERT INTO `".$apcms['table']['global']['rightsidebar']."` 
								(
									`title`,
									`content`,
									`sort`,
									`hidden`,
									`plugin`
					) VALUES 	(
									'".$apcms['LANGUAGE']['apcms_sidebar_adminbox']['box_title']."',
									'".apcms_ESC($boxcontent)."',
									'".$sort."',
									'0',
									'apcms_sidebar_adminbox'
								);";
		$db->unbuffered_query($query);
		
	}
	
	
	/**
	 * Update routine for the Sidebar-Box  plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function update($oldversion) {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		
		return true;
		
	}
	
	
	
	
	/**
	 * Uninstall routine for the Sidebar-Box plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function uninstall() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		$query = "DELETE FROM `".$apcms['table']['global']['plugins']."` WHERE `name`='apcms_sidebar_adminbox';";
		$db->unbuffered_query($query);
	
		$query = "DELETE FROM `".$apcms['table']['global']['rightsidebar']."` WHERE `plugin`='apcms_sidebar_adminbox';";
		$db->unbuffered_query($query);
		$query = "DELETE FROM `".$apcms['table']['global']['leftsidebar']."` WHERE `plugin`='apcms_sidebar_adminbox';";
		$db->unbuffered_query($query);
		$query = "DELETE FROM `".$apcms['table']['global']['rightsidebar']."` WHERE `plugin`='apcms_sidebar_poweredby';";
		$db->unbuffered_query($query);
	
	}
	
	
	
	
	
	
	
	
	
	function ShowAdminBox() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		echo "<img src=\"".$apcms['themesurl']."/images/navpoint.png\" border=\"0\" alt=\"\" title=\"\" align=\"absmiddle\" /><span class=\"sidebarlink\"><a class=\"link\" href=\"".$apcms['baseURL']."?c=admin\">".$apcms['LANGUAGE']['ADMINCENTER']."</a></span>";
		
	}
	
	
	
	
	
	function _init_plugin() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		return true;
	}
	
	
	
	
	
	
	
	
}



?>