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
 */

/*)\
\(*/


/**
 * Defines the installer constant
 */
define('IN_installer', true);

/**
 * Defines the upgrader constant
 */
define('IN_upgrader', true);

/**
 * Defines the IN_apcms constant
 */
define('IN_apcms', true);

/**
 * Defines the admin constant
 */
define('IN_apcms_admin', true);

/**
 * Inclusion of the main configuration
 */
include('config.inc.php');

if (!defined('IS_installed')) {
	
	
	
	
	
	
} else {
	header("Location: ./index.php");
}

?>