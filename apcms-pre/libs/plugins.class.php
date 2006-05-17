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
 * Handling class for the plugin
 *
 * @access         public
 * @author         Alexander Mieland
 * @copyright      2000-  Alexander 'dma147' Mieland
 */
class apcms_Plugin {
	
	var $maincontent = '';
	var $aboveHeadBanner = '';
	var $belowHeadBanner = '';
	var $aboveFootBanner = '';
	var $belowCopyright = '';
	
	/**
	* Sets the content of the MainContent hook
	*
	* @access public
	* @param string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Set_MainContent($content) {
		$this->maincontent .= $content;
	}
	
	/**
	* Gets and returns the content of the MainContent hook
	*
	* @access public
	* @return string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Get_MainContent() {
		return $this->maincontent;
	}
	
	/**
	* Sets the content of the aboveHeadBanner hook
	*
	* @access public
	* @param string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Set_aboveHeadBanner($content) {
		$this->aboveHeadBanner .= $content;
	}
	
	/**
	* Gets and returns the content of the aboveHeadBanner hook
	*
	* @access public
	* @return string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Get_aboveHeadBanner() {
		return $this->aboveHeadBanner;
	}
	
	/**
	* Sets the content of the belowHeadBanner hook
	*
	* @access public
	* @param string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Set_belowHeadBanner($content) {
		$this->belowHeadBanner .= $content;
	}
	
	/**
	* Gets and returns the content of the belowHeadBanner hook
	*
	* @access public
	* @return string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Get_belowHeadBanner() {
		return $this->belowHeadBanner;
	}
	
	/**
	* Sets the content of the aboveFootBanner hook
	*
	* @access public
	* @param string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Set_aboveFootBanner($content) {
		$this->aboveFootBanner .= $content;
	}
	
	/**
	* Gets and returns the content of the aboveFootBanner hook
	*
	* @access public
	* @return string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Get_aboveFootBanner() {
		return $this->aboveFootBanner;
	}
	
	/**
	* Sets the content of the belowCopyright hook
	*
	* @access public
	* @param string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Set_belowCopyright($content) {
		$this->belowCopyright .= $content;
	}
	
	/**
	* Gets and returns the content of the belowCopyright hook
	*
	* @access public
	* @return string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function Get_belowCopyright() {
		return $this->belowCopyright;
	}
	
	
	
	
	
	
	
	/**
	* Sets the content of a general hook
	*
	* @access public
	* @param mixed A unique id
	* @param string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function HookIn($id, $content) {
		$this->Hook[$id] .= $content;
	}
	
	
	
	
	
	
	/**
	* Gets and returns the content of general hook
	*
	* @access public
	* @param mixed A unique id
	* @return string the content
	* @author Alexander Mieland
	* @copyright 2000- by Alexander 'dma147' Mieland
	*/
	function HookOut($id) {
		return $this->Hook[$id];
	}
	
	
	
	
	
	
	
	
	
	
	
	
}


?>