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
 * Initial class for the eplugin
 *
 * @access public
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
class APCms_Plugin_Example {


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
	
	
	/** 
	 * @var array This holds the configuration items loaded from the database, not the default ones
	 */
	var $config = array();
	
	
	function APCms_Plugin_Example($test=false) {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms, $hook;
		
		
		/*
		 ////////////////////////////////////////////////////////////////////////
							Start of plugin-configuration
		 ////////////////////////////////////////////////////////////////////////
		*/
		
		/** The directoryname of this plugin */
		$this->dirname				=	'apcms_plugin_example';
		
		/** The name of this plugin */
		$this->plugin				=	'Example plugin';
		
		/** The description of this plugin */
		$this->description			=	'This is an example plugin to show how it must look like';
		
		/** The name of the author of this plugin */
		$this->author_name			=	'Alexander \'dma147\' Mieland';
		
		/** The email adress of the author */
		$this->author_email			=	'dma147@linux-stats.org';
		
		/** The homepage of the author or of this plugin */
		$this->author_homepage		=	'http://www.php-programs.de/apcms_plugin_example.html';
		
		/** The version of this plugin */
		$this->version				=	'0.0.1';
		
		/** the minimum required version of APCms */
		$this->apcms_version		=	'0.0.1_pre1';
		
		/** The configuration items for the administration interface */
		$this->config_items			=	array(
			
			
			/** name of the formfield */
			'title'					=>		array(
				
				/** Type of the data in the formfield 
					can be one of: integer, string, text, bool  */
				'type' 					=>	'string',
				
				/** Title of the formfield */
				'name'					=>	$apcms['LANGUAGE']['apcms_plugin_example']['CONFIG_NAME'],
				
				/** description of the formfield */
				'description'			=>	$apcms['LANGUAGE']['apcms_plugin_example']['CONFIG_NAME_DESC'],
				
				/** default value of the formfield */
				'default'				=>	'Example plugin'
			),
			
			
			'foofield'				=>		array(
				'type' 					=>	'string',
				'name'					=>	$apcms['LANGUAGE']['apcms_plugin_example']['CONFIG_FOO'],
				'description'			=>	$apcms['LANGUAGE']['apcms_plugin_example']['CONFIG_FOO_DESC'],
				'default'				=>	'content of foo'
			),
			
			
			'barfield'				=>		array(
				'type' 					=>	'integer',
				'name'					=>	$apcms['LANGUAGE']['apcms_plugin_example']['CONFIG_BAR'],
				'description'			=>	$apcms['LANGUAGE']['apcms_plugin_example']['CONFIG_BAR_DESC'],
				'default'				=>	1234
			),
			
			
			
			
			
			
			
		);
		
		/*
		 ////////////////////////////////////////////////////////////////////////
							End of plugin-configuration
		 ////////////////////////////////////////////////////////////////////////
		*/
		
		/** Sets the path to the plugin directory */
		$this->pluginpath = @realpath(@dirname(__FILE__));
		
		/** Loads the configuration from the database */
		$retconf = $db->unbuffered_query_first("SELECT `config` FROM `".$apcms['table']['global']['plugins']."` WHERE `name`='".$this->dirname."'");
		if (isset($retconf) && count($retconf) >= 1) {
			$this->config = unserialize(stripslashes(trim($retconf[0])));
		}
		
		/** Only if $test = False, then run the _init_plugin method to initialise the plugin */
		if ($test === false) {
			$this->_init_plugin();
		}
		
	}
	
	
	
	
	
	
	/**
	 * Install routine for the plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function install() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		
		/** Make the install here as you need it */
		
		$query = "DROP TABLE IF EXISTS `".$apcms['mysql_prefix']."plugin_example`;";
		$db->unbuffered_query($query);
		
		$query = "CREATE TABLE `".$apcms['mysql_prefix']."plugin_example` (
					  `id` int(11) NOT NULL auto_increment,
					  `foo` int(11) NOT NULL default '0',
					  `bar` int(11) NOT NULL default '0',
					  PRIMARY KEY (`id`)
					)";
		$db->unbuffered_query($query);
		
		
		
	}
	
	
	
	
	
	/**
	 * Update routine for the plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function update($oldversion) {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		
		/** Make the update here as you need it
			The old version can be found in: $oldversion
			The new version can be found in: $this->version
		*/
		
		
		return true;
		
	}
	
	
	
	
	
	/**
	 * Uninstall routine for the plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function uninstall() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		
		/** Make the uninstall here as you need it */
		
		
		$query = "DROP TABLE `".$apcms['mysql_prefix']."plugin_example`";
		$db->unbuffered_query($query);
	
	}
	
	
	
	
	
	
	
	/**
	 * initiating the plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function _init_plugin() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms;
		
		
		/** Make the initial stuff here. You can switches or if-conditions here
			which then loads some other plugin-methods. Just as usual...
		*/
		
		
		if (!isset($_GET['action'])) {
			$this->DoNothing();
		
		} else {
			$this->DoNotMore();
		
		}
		
		
		
		return true;
	}
	
	
	
	
	
	
	function DoNothing() {
		return true;
	}
	
	
	function DoNotMore() {
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



?>