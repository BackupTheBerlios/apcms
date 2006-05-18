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
 * @subpackage setup
 * 
 * $Id: footer.php,v 1.2 2006/05/18 11:15:59 dma147 Exp $
 */

/*)\
\(*/


@ob_flush();
echo '			</td>
			<td id="apcms_rightSideBar" valign="top"><span class="small_desc">'.$sidebar.'</span></td>
		</tr>
	</table>

	<div id="copyright">
		Powered by <a href="http://www.php-programs.de" class="copyright">APCms '.$apcms['version'].'</a>; Copyright &copy; 2000- &nbsp; &nbsp;Alexander &acute;dma147&acute; Mieland<br />
		All trademarks are properties of their respective holders
	</div>

</body>
</html>';
@ob_flush();

?>