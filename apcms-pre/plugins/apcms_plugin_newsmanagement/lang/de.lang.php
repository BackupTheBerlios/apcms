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



if (!defined('IN_apcms')) {
	exit;
}


/** German language file for the APCms */

$apcms['LANGUAGE']['apcms_plugin_newsmanagement']	=	array(
	
	'CONFIG_IPP'			=>		'Newsartikel pro Seite',
	'CONFIG_IPP_BLAHBLAH'	=>		'Wieviele Newsartikel sollen pro Seite angezeigt werden?',
	
	'CONFIG_DF'				=>		'Datum Formatierung',
	'CONFIG_DF_BLAHBLAH'	=>		'Formatierung der Zeitangaben (anhand der date() funktion)',
	
	'CONFIG_SAUTHOR'		=>		'Autor anzeigen?',
	'CONFIG_SAUTHOR_BLAHBLAH'	=>		'Soll der Autor eines Artikels angezeigt werden?',
	
	'CONFIG_BBCODE'			=>		'BBCode benutzen?',
	'CONFIG_BBCODE_BLAHBLAH'	=>		'Soll BBCode benutzt werden um die Artikel zu formatieren?',
	
	'CONFIG_GUESTS'			=>		'D&uuml;rfen Guests kommentieren?',
	'CONFIG_GUESTS_BLAHBLAH'	=>		'Soll es nicht registrierten Usern erlaubt sein, Newsartikel zu kommentieren?',
	
	
	
	
	'COMMENTS'				=>		'Kommentar(e)',
	'VIEWS'					=>		'Views',
	'COMMENT_TITLE'			=>		'Titel des Kommentars',
	'COMMENT_BODY'			=>		'Text des Kommentars',
	'COMMENT_SAVE'			=>		'Kommentar speichern...',
	'NO_COMMENTS'			=>		'Keine Kommentare vorhanden.',
	
	
	
	
	'SUCCESS_COMMENT_SAVED'	=>		'Kommentar gespeichert!',
	
	'ERROR_NO_USERNAME'		=>		'Du musst einen Usernamen angeben!',
	'ERROR_NO_EMAIL'		=>		'Du musst Deine EMail Adresse angeben!',
	'ERROR_NO_TEXT'			=>		'Du musst einen Text f&uuml;r Dein Kommentar angeben!',
	
	
	
	
	
	
	
	
);

?>