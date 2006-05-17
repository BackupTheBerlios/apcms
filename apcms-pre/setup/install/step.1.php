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
 * $Id: step.1.php,v 1.1 2006/05/17 21:23:21 dma147 Exp $
 */

/*)\
\(*/


@ob_flush();
if (!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = 'de';
}
include("./setup/lang/".$_SESSION['lang'].".lang.".$SUFFIX);
@ob_flush();
$sidebar = $apcms['LANGUAGE']['STEP1_HINT1'];


include("./setup/header.".$SUFFIX);
@ob_flush();

echo "\n<div id=\"content1\">\n";
echo "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
echo "		<tr class=\"content2\">\n";
echo "			<td>\n";
echo "				".$apcms['LANGUAGE']['STEP1_DESCRIPTION']."\n";
echo "			</td>\n";
echo "		</tr>\n";
echo "	</table>\n";
echo "</div><br />\n";


echo "\n<div id=\"content1\">\n";
echo "<form name=\"setupform\" action=\"".$_SERVER['PHP_SELF']."?setup[step]=2\" method=\"post\">\n";
echo "	<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";

echo "		<tr class=\"content2\">\n";
echo "			<td valign=\"top\">\n";
echo "				<label for=\"hostname\" accesskey=\"h\" tabindex=\"1\">".$apcms['LANGUAGE']['STEP1_HOSTNAME']."</label>\n";
echo "			</td>\n";
echo "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
echo "				<input id=\"hostname\" type=\"text\" name=\"form[hostname]\" value=\"localhost\" style=\"width:100%\" />\n";
echo "			</td>\n";
echo "		</tr>\n";

echo "		<tr class=\"content2\">\n";
echo "			<td valign=\"top\">\n";
echo "				<label for=\"username\" accesskey=\"u\" tabindex=\"2\">".$apcms['LANGUAGE']['STEP1_USERNAME']."</label>\n";
echo "			</td>\n";
echo "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
echo "				<input id=\"username\" type=\"text\" name=\"form[username]\" value=\"\" style=\"width:100%\" />\n";
echo "			</td>\n";
echo "		</tr>\n";

echo "		<tr class=\"content2\">\n";
echo "			<td valign=\"top\">\n";
echo "				<label for=\"password\" accesskey=\"p\" tabindex=\"3\">".$apcms['LANGUAGE']['STEP1_PASSWORD']."</label>\n";
echo "			</td>\n";
echo "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
echo "				<input id=\"password\" type=\"password\" name=\"form[password]\" value=\"\" style=\"width:100%\" />\n";
echo "			</td>\n";
echo "		</tr>\n";

echo "		<tr class=\"content2\">\n";
echo "			<td valign=\"top\">\n";
echo "				<label for=\"database\" accesskey=\"d\" tabindex=\"4\">".$apcms['LANGUAGE']['STEP1_DATABASE']."</label>\n";
echo "			</td>\n";
echo "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
echo "				<input id=\"database\" type=\"text\" name=\"form[database]\" value=\"apcms\" style=\"width:100%\" />\n";
echo "			</td>\n";
echo "		</tr>\n";

echo "		<tr class=\"content2\">\n";
echo "			<td valign=\"top\">\n";
echo "				<label for=\"prefix\" accesskey=\"h\" tabindex=\"1\">".$apcms['LANGUAGE']['STEP1_PREFIX']."</label>\n";
echo "			</td>\n";
echo "			<td width=\"230\" align=\"right\" valign=\"top\">\n";
echo "				<input id=\"prefix\" type=\"text\" name=\"form[prefix]\" value=\"apcms_1_\" style=\"width:100%\" />\n";
echo "			</td>\n";
echo "		</tr>\n";


echo "		<tr>\n";
echo "			<td colspan=\"2\" align=\"center\">
						<label for=\"submit\" accesskey=\"s\" tabindex=\"6\">
							<input id=\"submit\" type=\"submit\" name=\"submit\" value=\"".$apcms['LANGUAGE']['CONTINUE']."\" />
						</label>
					</td>\n";
echo "		</tr>\n";


echo "	</table>\n";
echo "</form>\n";
echo "</div><br />\n";



























include("./setup/footer.".$SUFFIX);
@ob_flush();

?>