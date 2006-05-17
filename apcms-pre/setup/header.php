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
 * $Id: header.php,v 1.1 2006/05/17 21:23:21 dma147 Exp $
 */

/*)\
\(*/


echo '<?xml version="1.0" encoding="iso-8859-1"?>
<?xml-stylesheet type="text/xsl" href="copy.xsl"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title> APCms v'.$apcms['version'].' - Setup </title>

	<meta name="title" content="APCms v'.$apcms['version'].' - Setup" />
	<meta name="description" content="Setup your APCms" />
	<meta name="Powered-By" content="APCms v.'.$apcms['version'].'" />
	<meta name="revisit-after" content="7 days" />
	<meta name="creation_date" content="2004-04-17" />
	<meta name="robots" content="index, follow" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />
	<link rel="stylesheet" href="'.$apcms['themesurl'].'/theme.css" type="text/css" />
	<link rel="SHORTCUT ICON" href="'.$apcms['themesurl'].'/favicon.ico" />
	
</head>

<body>

	<div id="apcms_head">
		<h1><a class="headlink1" href="'.$apcms['baseURL'].'">APCms v'.$apcms['version'].'</a></h1>
		<h2><a class="headlink2" href="'.$apcms['baseURL'].'">Setup your APCms</a></h2>
	</div>
	
	<table id="apcms_main">
		<tr>
			<td id="apcms_content" valign="top"><br />
';

if (isset($error) && trim($error) != "") {
	echo "				<div id=\"error\">".$error."</div><br />\n";
}
if (isset($success) && trim($success) != "") {
	echo "				<div id=\"success\">".$success."</div><br />\n";
}





?>