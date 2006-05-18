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
 * $Id: step.0.php,v 1.2 2006/05/18 09:06:16 dma147 Exp $
 */

/*)\
\(*/


$sidebar = '';
if (!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = 'de';
}
include("./setup/lang/".$_SESSION['lang'].".lang.".$SUFFIX);


include("./setup/header.".$SUFFIX);


$WRITEABLEDIRS = array(
	$apcms['path'], 
	$apcms['path']."/tmp", 
	$apcms['path']."/themes/default/cache", 
	$apcms['path']."/themes/default/templates_c", 
);

echo "<b>".$apcms['LANGUAGE']['STEP0_WELCOME']."</b><br /><br />\n";
echo $apcms['LANGUAGE']['STEP0_WELCOME_BLAHBLAH']."<br /><br />\n";
echo $apcms['LANGUAGE']['STEP0_SOME_INFORMATION']."<br />\n";

echo '<br />
 <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
   <td colspan="3"><b>'.$apcms['LANGUAGE']['STEP0_REQUIREMENTS'].':</b></td>
  </tr>
  <tr>
   <td><u>'.$apcms['LANGUAGE']['STEP0_FEATURE'].'</u></td>
   <td><u>'.$apcms['LANGUAGE']['STEP0_PREFFERED'].'</u></td>
   <td><u>'.$apcms['LANGUAGE']['STEP0_REAL'].'</u></td>
  </tr>
  <tr class="row1">
   <td>'.$apcms['LANGUAGE']['PHPVERSION'].'</td>
   <td>5.1.0</td>
   <td><span style="color: '.((version_compare(phpversion(), "5.1.0")==-1) ? ('blue') : ('green')).'">'.phpversion().'</span></td>
  </tr>
  <tr class="row2">
   <td>GDLib Version</td>
   <td>2.0.15</td>
   <td><span style="color: '.((version_compare(apcms_getGDVersion(), "2.0.15")==-1) ? ('blue') : ('green')).'">'.apcms_getGDVersion().'</span></td>
  </tr>
  <tr class="row1">
   <td>GDLib Truecolor</td>
   <td>'.$apcms['LANGUAGE']['YES'].'</td>
   <td><span style="color: '.((!apcms_haveTCSupport()) ? ('blue') : ('green')).'">'.((apcms_haveTCSupport()) ? $apcms['LANGUAGE']['YES'] : $apcms['LANGUAGE']['NO']).'</span></td>
  </tr>
  <tr class="row2">
   <td>GDLib TTF</td>
   <td>'.$apcms['LANGUAGE']['YES'].'</td>
   <td><span style="color: '.((!apcms_haveTTFSupport()) ? ('blue') : ('green')).'">'.((apcms_haveTTFSupport()) ? $apcms['LANGUAGE']['YES'] : $apcms['LANGUAGE']['NO']).'</span></td>
  </tr>
  <tr class="row1">
   <td>GDLib XPM</td>
   <td>'.$apcms['LANGUAGE']['YES'].'</td>
   <td><span style="color: '.((!apcms_haveXPMSupport()) ? ('blue') : ('green')).'">'.((apcms_haveXPMSupport()) ? $apcms['LANGUAGE']['YES'] : $apcms['LANGUAGE']['NO']).'</span></td>
  </tr>
  <tr class="row2">
   <td>GDLib WBMP</td>
   <td>'.$apcms['LANGUAGE']['YES'].'</td>
   <td><span style="color: '.((!apcms_haveWBMPSupport()) ? ('blue') : ('green')).'">'.((apcms_haveWBMPSupport()) ? $apcms['LANGUAGE']['YES'] : $apcms['LANGUAGE']['NO']).'</span></td>
  </tr>
  <tr class="row1">
   <td>GDLib JPEG</td>
   <td>'.$apcms['LANGUAGE']['YES'].'</td>
   <td><span style="color: '.((!apcms_haveJPEGSupport()) ? ('blue') : ('green')).'">'.((apcms_haveJPEGSupport()) ? $apcms['LANGUAGE']['YES'] : $apcms['LANGUAGE']['NO']).'</span></td>
  </tr>
  <tr class="row2">
   <td>GDLib PNG</td>
   <td>'.$apcms['LANGUAGE']['YES'].'</td>
   <td><span style="color: '.((!apcms_havePNGSupport()) ? ('blue') : ('green')).'">'.((apcms_havePNGSupport()) ? $apcms['LANGUAGE']['YES'] : $apcms['LANGUAGE']['NO']).'</span></td>
  </tr>
  <tr class="row1">
   <td>GDLib GIF</td>
   <td>'.$apcms['LANGUAGE']['YES'].'</td>
   <td><span style="color: '.((!apcms_haveGIFSupport()) ? ('blue') : ('green')).'">'.((apcms_haveGIFSupport()) ? $apcms['LANGUAGE']['YES'] : $apcms['LANGUAGE']['NO']).'</span></td>
  </tr>
  <tr class="row2">
   <td>safe_mode</td>
   <td>'.$apcms['LANGUAGE']['DEACTIVATED'].'</td>
   <td><span style="color: '.((get_cfg_var("safe_mode")) ? ('blue') : ('green')).'">'.((get_cfg_var("safe_mode")) ? $apcms['LANGUAGE']['ACTIVATED'] : $apcms['LANGUAGE']['DEACTIVATED']).'</span></td>
  </tr>
  <tr class="row1">
   <td>register_globals</td>
   <td>'.$apcms['LANGUAGE']['DEACTIVATED'].'</td>
   <td><span style="color: '.((get_cfg_var("register_globals")) ? ('blue') : ('green')).'">'.((get_cfg_var("register_globals")) ? $apcms['LANGUAGE']['ACTIVATED'] : $apcms['LANGUAGE']['DEACTIVATED']).'</span></td>
  </tr>
  <tr class="row2">
   <td>open_basedir</td>
   <td>'.$apcms['LANGUAGE']['DEACTIVATED'].'</td>
   <td><span style="color: '.((get_cfg_var("open_basedir")) ? ('blue') : ('green')).'">'.((get_cfg_var("open_basedir")) ? $apcms['LANGUAGE']['ACTIVATED'] : $apcms['LANGUAGE']['DEACTIVATED']).'</span></td>
  </tr>
  <tr class="row1">
   <td>upload_max_filesize</td>
   <td>2M</td>
   <td><span style="color: green">'.get_cfg_var("upload_max_filesize").'</span></td>
  </tr>';

$row = "row1";
$rederror = 0;
for ($a=0;$a<count($WRITEABLEDIRS);$a++) {
	if ($row == "row1") { $row = "row2"; } else { $row = "row1"; }
	if (!is_writeable($WRITEABLEDIRS[$a])) {
		$rederror = 1;
	}
	echo '  <tr class="'.$row.'">
	   <td>'.$apcms['LANGUAGE']['STEP0_WRITING_IN'].' '.$WRITEABLEDIRS[$a].'</td>
	   <td>Ja</td>
	   <td><span style="'.((is_writeable($WRITEABLEDIRS[$a])) ? ('color: green') : ('color: red; font-weight: bolder')).'">'.((is_writeable($WRITEABLEDIRS[$a])) ? $apcms['LANGUAGE']['YES'] : $apcms['LANGUAGE']['NO']).'</span></td>
	  </tr>
	';
}
echo '</table><br />';

if ($rederror == 1) {
	echo $apcms['LANGUAGE']['STEP0_SOME_RED']."<br />\n";
} else {
	echo $apcms['LANGUAGE']['STEP0_NEXT_STEP'];
	echo "<br />\n<div align=\"center\">\n";
	echo "	<form name=\"stepform\" action=\"".$_SERVER['PHP_SELF']."?setup[step]=1\" method=\"post\">\n";
	echo "		<br />\n<input type=\"submit\" name=\"submit\" value=\"".$apcms['LANGUAGE']['CONTINUE']."\" />\n";
	echo "	</form>\n";
	echo "</div>\n<br />\n";
}

include("./setup/footer.".$SUFFIX);

?>