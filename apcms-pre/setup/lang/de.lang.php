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
 * $Id: de.lang.php,v 1.8 2006/05/18 12:03:25 dma147 Exp $
 */

/*)\
\(*/


@ob_flush();

/** 
 * German language for the APCms 
 */
$apcms['LANGUAGE']	=	array(
	
	'YES'							=>		'Ja',
	'NO'							=>		'Nein',
	'ACTIVATED'						=>		'Aktiviert',
	'DEACTIVATED'					=>		'Deaktiviert',
	'CONTINUE'						=>		'Weiter ...',
	'hidden'						=>		'Versteckt',
	'PHPVERSION'					=>		'PHP Version',
	'START_INSTALLATION'			=>		'Installation jetzt starten!',
	
	
	'STEP0_WELCOME'					=>		'Hallo und willkommen im Setup-Interface Deines APCms!',
	'STEP0_WELCOME_BLAHBLAH'		=>		'Das Du hier gelandet bist kann nur eines bedeuten: Du hast das APCms gerade entpackt, auf Deinen Webserver geladen und willst es nun installieren. Da spricht nichts dagegen. Fangen wir doch am besten gleich an...',
	'STEP0_SOME_INFORMATION'		=>		'Schauen wir uns zuerst einmal das System an, auf dem das APCms laufen soll:',
	'STEP0_REQUIREMENTS'			=>		'empfohlene Systemvoraussetzungen',
	'STEP0_FEATURE'					=>		'Eigenschaft',
	'STEP0_PREFFERED'				=>		'Empfohlen',
	'STEP0_REAL'					=>		'Vorhanden',
	'STEP0_WRITING_IN'				=>		'Schreiben in',
	'STEP0_SOME_RED'				=>		'Wenn Du oben etwas Rotes siehst, so musst Du diese Dinge nun zuerst einmal korrigieren, bevor wir hier fortfahren können. Rote Meldungen beziehen sich grundstätzlich nur auf die Möglichkeit des Schreibens in verschiedenen Verzeichnissen.<br /> Ist es dem Webserver nicht erlaubt in eines der Verzeichnisse zu schreiben, so wird das APCms nicht ordnungsgemäß funktionieren, weshalb wir hier nun abbrechen, bis der Fehler korrigiert ist.',
	'STEP0_NEXT_STEP'				=>		'Es scheint alles in Ordnung zu sein. Blaue Meldungen, falls vorhanden, kann man erstmal getrost ignorieren, da sie wenn überhaupt nur kleine Teile des APCms einschränken.<br /><br />Bitte klicke nun auf &quot;Weiter...&quot; um fortzufahren...',
	
	
	'STEP1_DESCRIPTION'				=>		'Hier musst Du nun die Zugangsdaten zu Deinem MySQL-Server eingeben',
	'STEP1_HINT1'					=>		'<b>MySQL-Server</b><br />Der Datenbank-Server in dem sämtliche Daten gespeichert werden.<br /><br /><b>Zugangsdaten</b><br />Hiermit sind der Hostname, der Username, das Passwort und der Datenbankname gemeint, die Du von Deinem Provider erhalten haben solltest.<br />Weisst Du diese Daten nicht (mehr), so wende Dich bitte an Deinen Provider und erfrage sie dort.',
	'STEP1_HOSTNAME'				=>		'Hostname des MySQL-Servers',
	'STEP1_USERNAME'				=>		'Username des MySQL-Users',
	'STEP1_PASSWORD'				=>		'Passwort des MySQL-Users',
	'STEP1_DATABASE'				=>		'Datenbank (muss existieren)',
	'STEP1_PREFIX'					=>		'Tabellen-Prefix',
	'STEP1_UNIQUE'					=>		'Eindeutige Kennziffer f&uuml;r die Tabellen',
	'STEP1_NO_HOSTNAME'				=>		'Keinen Hostnamen angegeben! Bitte gib einen Hostnamen an. In der Regel sollte diese &quot;localhost&quot; sein.<br />Das m&uuml;ssen wir nochmal machen...',
	'STEP1_NO_USERNAME'				=>		'Keinen Usernamen angegeben! Bitte gib einen Usernamen an.<br />Das m&uuml;ssen wir nochmal machen...',
	'STEP1_NO_PASSWORD'				=>		'Kein Passwort angegeben! Bitte gib ein Passwort an.<br />Das m&uuml;ssen wir nochmal machen...',
	'STEP1_NO_DATABASE'				=>		'Keine Datenbank angegeben! Bitte gib eine Datenbank an, die aber schon existieren muss.<br />Das m&uuml;ssen wir nochmal machen...',
	
	'STEP2_DESCRIPTION'				=>		'Hier erstellst Du Dir selbst einen Administrator der dann dazu berechtigt ist, alle Einstellungen im Admincenter vorzunehmen und Plugins zu installieren, konfigurieren oder zu l&ouml;schen.',
	'STEP2_HINT1'					=>		'<b>Administrator</b><br />Der Administrator eines Systems ist ein normaler User, mit besonderen Rechten. In der Regel ist der Administrator auch der Initiator eines Projekts, der dann sogenannte Moderatoren um sich schart, die die Kommunikation mit den Usern &uuml;bernehmen.',
	'STEP2_ADMIN_USERNAME'			=>		'Username des Admins',
	'STEP2_ADMIN_PASSWORD'			=>		'Passwort des Admins',
	'STEP2_ADMIN_EMAIL'				=>		'EMail des Admins',
	'STEP2_NO_USERNAME'				=>		'Du musst einen Usernamen f&uuml;r den Administrator eingeben!<br />Das m&uuml;ssen wir nochmal machen...',
	'STEP2_NO_PASSWORD'				=>		'Du musst ein Passwort f&uuml;r den Administrator eingeben!<br />Das m&uuml;ssen wir nochmal machen...',
	'STEP2_NO_EMAIL'				=>		'Du musst eine EMail f&uuml;r den Administrator eingeben!<br />Das m&uuml;ssen wir nochmal machen...',
	
	'STEP3_FINAL_CHECK'				=>		'Sehr gut. Es scheint als haben wir alle Daten zusammen, die wir f&uuml;r die Installation des APCMS ben&ouml;tigen.<br />Lass uns diese Daten noch einmal kurz gegenchecken:',
	'STEP3_FINAL_CHECK2'			=>		'Sollte noch etwas falsch sein oder fehlen, so &auml;ndere diese jetzt. Du kannst jederzeit zur&uuml;ck gehen (auch mit dem Zur&uuml;ck-Button Deines Browser) um Daten zu &auml;ndern.',
	
	'STEP4_STARTING_INSTALLATION'	=>		'Starte Installation...',
	
	'DEF_CONNECTING_DB'				=>		'Stelle Verbindung zur MySQL-Datenbank her',
	'DEF_DROP_TABLE'				=>		'L&ouml;sche Tabelle',
	'DEF_CREATE_TABLE'				=>		'Erstelle Tabelle',
	'DEF_INSERT_DATA'				=>		'Schreibe Daten in Tabelle',
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
);




@ob_flush();

?>