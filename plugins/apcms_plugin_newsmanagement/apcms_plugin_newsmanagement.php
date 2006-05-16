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
 * News Management plugin for APCms
 *
 * @access public
 * @author Alexander Mieland
 * @copyright 2000- by Alexander 'dma147' Mieland
 */
class APCms_Plugin_NewsManagement {

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
	
	var $newstable = '';
	var $commentstable = '';
	var $config = array();
	
	function APCms_Plugin_NewsManagement($test=false) {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms, $hook;
		
		
		/*
		 ////////////////////////////////////////////////////////////////////////
							Start of plugin-configuration
		 ////////////////////////////////////////////////////////////////////////
		*/
		
		/** The directoryname of this plugin */
		$this->dirname				=	'apcms_plugin_newsmanagement';
		
		/** The name of this plugin */
		$this->plugin				=	'News-Management';
		
		/** The description of this plugin */
		$this->description			=	'Complete Newssystem for your APCms, with comments and voting functions.';
		
		/** The name of the author of this plugin */
		$this->author_name			=	'Alexander \'dma147\' Mieland';
		
		/** The email adress of the author */
		$this->author_email			=	'dma147@linux-stats.org';
		
		/** The homepage of the author or of this plugin */
		$this->author_homepage		=	'http://www.php-programs.de/apcms_plugin_newsmanagement.html';
		
		/** The version of this plugin */
		$this->version				=	'0.0.2';
		
		/** the minimum required version of APCms */
		$this->apcms_version		=	'0.0.1_pre1';
		
		/** The configuration items for the administration interface */
		$this->config_items			=	array(
			
			
			'items_per_page'		=>		array(
				'type' 					=>	'integer',
				'name'					=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_IPP'],
				'description'			=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_IPP_BLAHBLAH'],
				'default'				=>	15
			),
			
			
			'dateformat'			=>		array(
				'type' 					=>	'string',
				'name'					=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_DF'],
				'description'			=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_DF_BLAHBLAH'],
				'default'				=>	'd.m.Y, H:i'
			),
			
			
			'show_author'			=>		array(
				'type' 					=>	'boolean',
				'name'					=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_SAUTHOR'],
				'description'			=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_SAUTHOR_BLAHBLAH'],
				'default'				=>	true
			),
			
			
			'use_bbcode'			=>		array(
				'type' 					=>	'boolean',
				'name'					=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_BBCODE'],
				'description'			=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_BBCODE_BLAHBLAH'],
				'default'				=>	true
			),
		
			'guest_comments'		=>		array(
				'type' 					=>	'boolean',
				'name'					=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_GUESTS'],
				'description'			=>	$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['CONFIG_GUESTS_BLAHBLAH'],
				'default'				=>	true
			)
		
		
		);
		
		/*
		 ////////////////////////////////////////////////////////////////////////
							End of plugin-configuration
		 ////////////////////////////////////////////////////////////////////////
		*/
		
		
		$this->newstable = $apcms['mysql_prefix']."plugin_newsmanagement_news";
		$this->commentstable = $apcms['mysql_prefix']."plugin_newsmanagement_comments";
		$this->pluginpath = @realpath(@dirname(__FILE__));
		
		$retconf = $db->unbuffered_query_first("SELECT `config` FROM `".$apcms['table']['global']['plugins']."` WHERE `name`='".$this->dirname."'");
		if (isset($retconf) && count($retconf) >= 1) {
			$this->config = unserialize(stripslashes(trim($retconf[0])));
		}
		if ($test === false)
			$this->_init_plugin();
	}
	
	/**
	 * Install routine for the newsmanagement plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function install() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms, $hook;
		
		
		
		
		$this->status[] = "Creating `".$this->newstable."`...";
		$query = "DROP TABLE IF EXISTS `".$this->newstable."`;";
		$db->unbuffered_query($query);
		$query = "CREATE TABLE `".$this->newstable."` (
					  `id` int(11) NOT NULL auto_increment,
					  `uid` int(11) NOT NULL default '0',
					  `postdate` int(11) NOT NULL default '0',
					  `title` varchar(64) NOT NULL,
					  `body` text NOT NULL,
					  `extbody` text NOT NULL,
					  `views` int(11) NOT NULL default '0',
					  PRIMARY KEY (`id`),
					  KEY `uid` (`uid`),
					  KEY `postdate` (`postdate`)
					)";
		$db->unbuffered_query($query);
		
		$this->status[] = "Creating `".$this->commentstable."`...";
		$query = "DROP TABLE IF EXISTS `".$this->commentstable."`;";
		$db->unbuffered_query($query);
		$query = "CREATE TABLE `".$this->commentstable."` (
					  `id` int(11) NOT NULL auto_increment,
					  `nid` int(11) NOT NULL default '0',
					  `uid` int(11) NOT NULL default '0',
					  `postdate` int(11) NOT NULL default '0',
					  `title` varchar(64) NOT NULL,
					  `body` text NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `nid` (`nid`),
					  KEY `uid` (`uid`),
					  KEY `postdate` (`postdate`)
					)";
		$db->unbuffered_query($query);
		
		
		$query = "INSERT INTO `".$this->newstable."` (`uid`, `postdate`, `title`, `body`, `extbody`, `views`) VALUES ('1', '".time()."', 'Willkommen in Deinem APCms', 'Du hast soeben das APCms erfolgreich installiert!\r\nHerzlichen Glückwunsch für diese Entscheidung.', 'Du kannst diese News in der News-Verwaltung ändern oder löschen.\r\n\r\nViel Spaß mit Deinem APCms!', 0)";
		$db->unbuffered_query($query);
		
		
	}
	
	
	
	
	
	/**
	 * Update routine for the newsmanagement plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function update($oldversion) {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms, $hook;
		
		
		
		return true;
		
	}
	
	
	
	
	/**
	 * Uninstall routine for the newsmanagement plugin
	 *
	 * @access private
	 * @author Alexander Mieland
	 * @copyright 2000- by Alexander 'dma147' Mieland
	 */
	function uninstall() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms, $hook;
		
		
		$this->status[] = "Deleting `".$this->newstable."`...";
		$query = "DROP TABLE IF EXISTS `".$this->newstable."`";
		$db->unbuffered_query($query);
	
		$this->status[] = "Deleting `".$this->commentstable."`...";
		$query = "DROP TABLE IF EXISTS `".$this->commentstable."`";
		$db->unbuffered_query($query);
	
	}
	
	
	
	function _init_plugin() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms, $hook;
		
		
		if (!isset($_GET['news']) || trim($_GET['news']['action']) == "") {
			$this->ShowNews();
		
		} elseif (isset($_GET['news']) && trim($_GET['news']['action']) == "read") {
			$this->ReadNews(intval($_GET['news']['id']));
			
		} 
		
		
		
	}
	
	
	
	
	
	function ShowNews() {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms, $hook;
		$NOUT = '';
		
		/** Include the Smarty class */
		require_once($apcms['path']."/libs/smarty.class.php");
		
		$retnews = $db->unbuffered_GetAll_row("SELECT * FROM `".$this->newstable."` ORDER BY `postdate` DESC LIMIT 0,".$this->config['items_per_page']."");
		if (isset($retnews) && count($retnews) >= 1) {
			
			for ($a=0;$a<count($retnews);$a++) {
				$mainbox_head = apcms_Strip($retnews[$a][3]);
				if ($this->config['use_bbcode'] === true) {
					$mainbox_content = apcms_TextOut(stripslashes($retnews[$a][4]));
				} else {
					$mainbox_content = apcms_simpleTextOut(stripslashes($retnews[$a][4]));
				}
				if (trim(stripslashes($retnews[$a][5])) != "") {
					$mainbox_content .= "\n<br />[<a href=\"".$apcms['baseURL']."?news[action]=read&amp;news[id]=".intval($retnews[$a][0])."\">".$apcms['LANGUAGE']['GLOBAL_READ_MORE']."...</a>]\n";
				}
				$authorname = "";
				if ($this->config['show_author'] === true) {
					$retuser = $db->unbuffered_query_first("SELECT `nickname` FROM `".$apcms['table']['global']['users']."` WHERE `id`='".intval($retnews[$a][1])."'");
					if (isset($retuser[0]) && trim($retuser[0]) != "") {
						$authorname .= " @ ".apcms_Strip($retuser[0]);
					} else {
						$authorname .= " @ ".$apcms['LANGUAGE']['GLOBAL_UNKNOWN'];
					}
				}
				
				$retcnum = $db->unbuffered_query_first("SELECT COUNT(*) FROM `".$this->commentstable."` WHERE `nid`='".intval($retnews[$a][0])."'");
				$commentnum = intval($retcnum[0]);
				
				$mainbox_foot = "<table class=\"apcms_mainboxfoot\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr>\n<td class=\"apcms_mainboxfoot\">\n";
				$mainbox_foot .= date($this->config['dateformat'], intval($retnews[$a][2])).$authorname;
				$mainbox_foot .= "\n</td>\n<td width=\"50%\" class=\"apcms_mainboxfoot\" align=\"right\">\n";
				$mainbox_foot .= "[ ".intval($retnews[$a][6])." ".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['VIEWS']." | ".$commentnum." <a href=\"".$apcms['baseURL']."?news[action]=read&amp;news[id]=".intval($retnews[$a][0])."#comments\">".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['COMMENTS']."</a> ]";
				$mainbox_foot .= "\n</td>\n</tr>\n</table>\n";
				
				$mbox = new APC_Smarty($apcms['themesdir'].'/'.$apcms['theme']);
				$mbox->assign('mainbox_head', $mainbox_head);
				$mbox->assign('mainbox_content', $mainbox_content);
				$mbox->assign('mainbox_foot', $mainbox_foot);
				$mbout = $mbox->fetch('mainbox.tpl');
				$NOUT .= $mbout;
			}
			
		} else {
			
			/** FIXME */
			/** maybe create something better looking...? */
			$NOUT .= "No news available";
			
		}
		
		/** Give the output to the Hook event of the mainpage (main.php) */
		$hook->Set_MainContent($NOUT);
	}
	
	
	
	
	
	
	
	function ReadNews($newsid) {
		/** globalising of the needed variables, objects and arrays */
		global $db, $apcms, $hook;
		$NOUT = '';
		
		
		$retnews = $db->unbuffered_query_first("SELECT * FROM `".$this->newstable."` WHERE `id`='".intval($newsid)."'");
		if (isset($retnews) && count($retnews) >= 1) {
			
			$postdate = intval($retnews[2]);
			$title = apcms_Strip($retnews[3]);
			if ($this->config['use_bbcode'] === true) {
				$body = apcms_TextOut(stripslashes($retnews[4]));
				$extbody = apcms_TextOut(stripslashes($retnews[5]));
			} else {
				$body = apcms_simpleTextOut(stripslashes($retnews[4]));
				$extbody = apcms_simpleTextOut(stripslashes($retnews[5]));
			}
			$views = intval($retnews[6])+1;
			$authorname = "";
			$db->unbuffered_query("UPDATE `".$this->newstable."` SET `views`='".$views."' WHERE `id`='".intval($newsid)."'");
			
			if ($this->config['show_author'] === true) {
				$retuser = $db->unbuffered_query_first("SELECT `nickname` FROM `".$apcms['table']['global']['users']."` WHERE `id`='".intval($retnews[1])."'");
				if (isset($retuser[0]) && trim($retuser[0]) != "") {
					$authorname .= " @ ".apcms_Strip($retuser[0]);
				} else {
					$authorname .= " @ ".$apcms['LANGUAGE']['GLOBAL_UNKNOWN'];
				}
			}
			$retcnum = $db->unbuffered_query_first("SELECT COUNT(*) FROM `".$this->commentstable."` WHERE `nid`='".intval($newsid)."'");
			$commentnum = intval($retcnum[0]);
			
			/** Include the Smarty class */
			require_once($apcms['path']."/libs/smarty.class.php");
		
			if ($this->config['use_bbcode'] === true) {
				$mainbox_head = apcms_Strip($retnews[3]);
				$mainbox_content = apcms_TextOut(stripslashes($retnews[4]));
				if (trim(stripslashes($retnews[5])) != "") {
					$mainbox_content .= "\n<br />".apcms_TextOut(stripslashes($retnews[5]));
				}
			} else {
				$mainbox_head = apcms_simpleTextOut($retnews[3]);
				$mainbox_content = apcms_simpleTextOut(stripslashes($retnews[4]));
				if (trim(stripslashes($retnews[5])) != "") {
					$mainbox_content .= "\n<br />".apcms_simpleTextOut(stripslashes($retnews[5]));
				}
			}
			$mainbox_foot = "<table class=\"apcms_mainboxfoot\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr>\n<td class=\"apcms_mainboxfoot\">\n";
			$mainbox_foot .= date($this->config['dateformat'], intval($retnews[2])).$authorname;
			$mainbox_foot .= "\n</td>\n<td width=\"50%\" class=\"apcms_mainboxfoot\" align=\"right\">\n";
			$mainbox_foot .= "[ ".intval($retnews[6])." ".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['VIEWS']." | ".$commentnum." <a href=\"".$apcms['baseURL']."?news[action]=read&amp;news[id]=".intval($retnews[0])."\">".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['COMMENTS']."</a> ]";
			$mainbox_foot .= "\n</td>\n</tr>\n</table>\n";
			
			$mbox = new APC_Smarty($apcms['themesdir'].'/'.$apcms['theme']);
			$mbox->assign('mainbox_head', $mainbox_head);
			$mbox->assign('mainbox_content', $mainbox_content);
			$mbox->assign('mainbox_foot', $mainbox_foot);
			$mbout = $mbox->fetch('mainbox.tpl');
			$NOUT .= $mbout."\n<a name=\"comments\"></a>\n\n<hr size=\"1\" noshade=\"noshade\" /><b><u>".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['COMMENTS']."</u></b>\n<br />\n<br />\n";
			
			/** Save the comment */
			if (isset($_POST['news']['action']) && trim($_POST['news']['action']) == "comment") {
				
				
				if (isset($_SESSION['isloggedin']) && intval($_SESSION['isloggedin']) >= 1) {
					$_POST['news']['username'] = $_SESSION['nickname'];
					$_POST['news']['email'] = $_SESSION['email'];
					$uid = $_SESSION['userid'];
				} else {
					$uid = 0;
				}
				
				
				if (!isset($_POST['news']['username']) || trim($_POST['news']['username']) == "") {
					$error = $apcms['LANGUAGE']['apcms_plugin_newsmanagement']['ERROR_NO_USERNAME'];
				
				} elseif (!isset($_POST['news']['email']) || trim($_POST['news']['email']) == "") {
					$error = $apcms['LANGUAGE']['apcms_plugin_newsmanagement']['ERROR_NO_EMAIL'];
				
				} elseif (!isset($_POST['news']['comment']) || trim($_POST['news']['comment']) == "") {
					$error = $apcms['LANGUAGE']['apcms_plugin_newsmanagement']['ERROR_NO_TEXT'];
				
				} else {
					
					$query = "INSERT INTO `".$this->commentstable."` (`nid`, `uid`, `postdate`, `title`, `body`) VALUES (
									'".intval($_POST['news']['nid'])."', 
									'".intval($uid)."', 
									'".time()."', 
									'".apcms_ESC(apcms_Strip($_POST['news']['title']))."', 
									'".apcms_ESC(trim($_POST['news']['comment']))."' 
								)";
					$db->unbuffered_query($query);
					
					$success = $apcms['LANGUAGE']['apcms_plugin_newsmanagement']['SUCCESS_COMMENT_SAVED'];
				}
			}
			
			$retcomments = $db->unbuffered_GetAll_row("SELECT * FROM `".$this->commentstable."` WHERE `nid`='".intval($newsid)."' ORDER BY `postdate`");
			if (isset($retcomments) && count($retcomments) >= 1) {
				
				for ($a=0;$a<count($retcomments);$a++) {
					$mainbox_head = apcms_Strip($retcomments[$a][4]);
					$mainbox_content = apcms_TextOut(stripslashes($retcomments[$a][5]));
					$authorname = "";
					if ($this->config['show_author'] === true) {
						$retuser = $db->unbuffered_query_first("SELECT `nickname` FROM `".$apcms['table']['global']['users']."` WHERE `id`='".intval($retcomments[$a][2])."'");
						if (isset($retuser[0]) && trim($retuser[0]) != "") {
							$authorname .= " @ ".apcms_Strip($retuser[0]);
						} else {
							$authorname .= " @ ".$apcms['LANGUAGE']['GLOBAL_UNKNOWN'];
						}
					}
					
					$mainbox_foot = "<table class=\"apcms_mainboxfoot\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr>\n<td class=\"apcms_mainboxfoot\">\n";
					$mainbox_foot .= date($this->config['dateformat'], intval($retcomments[$a][3])).$authorname;
					$mainbox_foot .= "\n</td>\n</tr>\n</table>\n";
					
					$mbox = new APC_Smarty($apcms['themesdir'].'/'.$apcms['theme']);
					$mbox->assign('mainbox_head', $mainbox_head);
					$mbox->assign('mainbox_content', $mainbox_content);
					$mbox->assign('mainbox_foot', $mainbox_foot);
					$mbout = $mbox->fetch('mainbox.tpl');
					$NOUT .= $mbout."\n\n<hr size=\"1\" noshade=\"noshade\" />";
				}
				
			} else {
				
				/** FIXME */
				/** maybe create something better looking...? */
				$NOUT .= "<br /><br /><div align=\"center\">".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['NO_COMMENTS']."</div>\n\n<hr size=\"1\" noshade=\"noshade\" />";
				
			}
			
			
			if (isset($error) && trim($error) != "") {
				$NOUT .= "<div id=\"error\">".$error."</div>";
				$error = "";
			}
			if (isset($success) && trim($success) != "") {
				$NOUT .= "<div id=\"success\">".$success."</div>";
				$success = "";
			}
			
			
			
			if ( (isset($_SESSION['isloggedin']) && intval($_SESSION['isloggedin']) >= 1) || ($this->config['guest_comments'] === true) ) {
				$NOUT .= "\n<br />\n<div id=\"content1\">\n";
				
				
				$NOUT .= "<form name=\"commentform\" action=\"".$apcms['baseURL']."?news[action]=read&amp;news[id]=".intval($newsid)."#comments\" method=\"post\">\n";
				$NOUT .= "<input type=\"hidden\" name=\"news[action]\" value=\"comment\" />\n";
				$NOUT .= "<input type=\"hidden\" name=\"news[nid]\" value=\"".intval($newsid)."\" />\n";
				$NOUT .= "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
				
				
				
				if (isset($_SESSION['isloggedin']) && intval($_SESSION['isloggedin']) >= 1) {
					$NOUT .= "		<tr class=\"content2\">\n";
					$NOUT .= "			<td valign=\"top\">\n";
					$NOUT .= "				<label for=\"username\" accesskey=\"u\" tabindex=\"-1\">".$apcms['LANGUAGE']['GLOBAL_USERNAME']."</label>\n";
					$NOUT .= "			</td>\n";
					$NOUT .= "			<td width=\"330\" align=\"right\" valign=\"top\">\n";
					$NOUT .= "				<input id=\"username\" type=\"text\" name=\"news[username]\" value=\"".$_SESSION['nickname']."\" disabled=\"disabled\" readonly=\"readonly\" style=\"width:100%\" />\n";
					$NOUT .= "			</td>\n";
					$NOUT .= "		</tr>\n";
					
					$NOUT .= "		<tr class=\"content2\">\n";
					$NOUT .= "			<td valign=\"top\">\n";
					$NOUT .= "				<label for=\"email\" accesskey=\"e\" tabindex=\"-1\">".$apcms['LANGUAGE']['GLOBAL_EMAIL']."</label>\n";
					$NOUT .= "			</td>\n";
					$NOUT .= "			<td width=\"330\" align=\"right\" valign=\"top\">\n";
					$NOUT .= "				<input id=\"email\" type=\"text\" name=\"news[email]\" value=\"".$_SESSION['email']."\" disabled=\"disabled\" readonly=\"readonly\" style=\"width:100%\" />\n";
					$NOUT .= "			</td>\n";
					$NOUT .= "		</tr>\n";
				} else {
					$NOUT .= "		<tr class=\"content2\">\n";
					$NOUT .= "			<td valign=\"top\">\n";
					$NOUT .= "				<label for=\"username\" accesskey=\"u\" tabindex=\"1\">".$apcms['LANGUAGE']['GLOBAL_USERNAME']."</label>\n";
					$NOUT .= "			</td>\n";
					$NOUT .= "			<td width=\"330\" align=\"right\" valign=\"top\">\n";
					$NOUT .= "				<input id=\"username\" type=\"text\" name=\"news[username]\" value=\"".(isset($_POST['news']['username'])&&trim($_POST['news']['username'])!=""?apcms_Strip($_POST['news']['username']):"")."\" style=\"width:100%\" />\n";
					$NOUT .= "			</td>\n";
					$NOUT .= "		</tr>\n";
					
					$NOUT .= "		<tr class=\"content2\">\n";
					$NOUT .= "			<td valign=\"top\">\n";
					$NOUT .= "				<label for=\"email\" accesskey=\"e\" tabindex=\"2\">".$apcms['LANGUAGE']['GLOBAL_EMAIL']."</label>\n";
					$NOUT .= "			</td>\n";
					$NOUT .= "			<td width=\"330\" align=\"right\" valign=\"top\">\n";
					$NOUT .= "				<input id=\"email\" type=\"text\" name=\"news[email]\" value=\"".(isset($_POST['news']['email'])&&trim($_POST['news']['email'])!=""?apcms_Strip($_POST['news']['email']):"")."\" style=\"width:100%\" />\n";
					$NOUT .= "			</td>\n";
					$NOUT .= "		</tr>\n";
				}
				
				$NOUT .= "		<tr class=\"content2\">\n";
				$NOUT .= "			<td valign=\"top\">\n";
				$NOUT .= "				<label for=\"title\" accesskey=\"t\" tabindex=\"3\">".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['COMMENT_TITLE']."</label>\n";
				$NOUT .= "			</td>\n";
				$NOUT .= "			<td width=\"330\" align=\"right\" valign=\"top\">\n";
				$NOUT .= "				<input id=\"title\" type=\"text\" name=\"news[title]\" value=\"".(isset($_POST['news']['title'])&&trim($_POST['news']['title'])!=""?apcms_Strip($_POST['news']['title']):"")."\" style=\"width:100%\" />\n";
				$NOUT .= "			</td>\n";
				$NOUT .= "		</tr>\n";
				
				
				$NOUT .= "		<tr class=\"content2\">\n";
				$NOUT .= "			<td valign=\"top\">\n";
				$NOUT .= "				<label for=\"comment\" accesskey=\"c\" tabindex=\"4\">".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['COMMENT_BODY']."</label>\n";
				$NOUT .= "			</td>\n";
				$NOUT .= "			<td width=\"330\" align=\"right\" valign=\"top\">\n";
				$NOUT .= "				<textarea id=\"comment\" name=\"news[comment]\" rows=\"6\" style=\"width:100%\">".(isset($_POST['news']['comment'])&&trim($_POST['news']['comment'])!=""?trim($_POST['news']['comment']):"")."</textarea>\n";
				$NOUT .= "			</td>\n";
				$NOUT .= "		</tr>\n";
				
				$NOUT .= "		<tr>\n";
				$NOUT .= "			<td colspan=\"2\" align=\"center\">
										<label for=\"submit\" accesskey=\"s\" tabindex=\"4\">
											<input id=\"submit\" onfocus=\"formInUse=true;\" type=\"submit\" name=\"news[submit]\" value=\"".$apcms['LANGUAGE']['apcms_plugin_newsmanagement']['COMMENT_SAVE']."\" />
										</label>
									</td>\n";
				$NOUT .= "		</tr>\n";
				
				$NOUT .= "	</table>\n";
				$NOUT .= "</form>\n";
				$NOUT .= "</div><br />\n";
		
				$NOUT .= "	<script type=\"text/javascript\">\n";
				if (isset($_SESSION['isloggedin']) && intval($_SESSION['isloggedin']) >= 1) {
					$NOUT .= "		document.getElementById('title').focus();\n";
				} else {
					$NOUT .= "		document.getElementById('username').focus();\n";
				}
				$NOUT .= "	</script>\n";
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		} else {
			
			
			
		}
		
		
		
		
		
		/** Give the output to the Hook event of the mainpage (main.php) */
		$hook->Set_MainContent($NOUT);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}



?>