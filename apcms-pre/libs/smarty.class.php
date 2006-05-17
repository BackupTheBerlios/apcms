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
 * 
 * $Id: smarty.class.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
 */

/*)\
\(*/



/**
 * Exit the script when IN_apcms_admin is not defined
 */
if (!defined('IN_apcms')) {
	exit;
}


/** Set the Smarty Library Path */
@define('SMARTY_DIR', $apcms['path']."/libs/smarty/");
/** Include the Smarty class */
require(SMARTY_DIR.'Smarty.class.php');



class APC_Smarty extends Smarty {
	
	function APC_Smarty($themepath) {
		$this->Smarty();
		$this->cache_dir = $themepath.'/cache/';
		$this->config_dir = $themepath.'/configs/';
		$this->template_dir = $themepath.'/templates/';
		$this->compile_dir = $themepath.'/templates_c/';
		$this->compile_check = true;
		$this->debugging = false;
	}
	
}
?>