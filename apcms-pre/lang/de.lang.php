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
 * @subpackage languages
 * 
 * $Id: de.lang.php,v 1.2 2006/05/17 11:47:35 dma147 Exp $
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
 * German language for the APCms 
 */
$apcms['LANGUAGE']	=	array(
	
	
	
	
	'GLOBAL_BACK_TO_APCMS'				=>		'Zur&uuml;ck zum APCms',
	'GLOBAL_USERNAME'					=>		'Username',
	'GLOBAL_PASSWORD'					=>		'Passwort',
	'GLOBAL_LOGIN'						=>		'Einloggen',
	'GLOBAL_LOGOUT'						=>		'Ausloggen',
	'GLOBAL_NOT_LOGGED_IN'				=>		'Du bist nicht eingeloggt.',
	'GLOBAL_LOGGED_IN_AS'				=>		'Eingeloggt als: ',
	'GLOBAL_EMAIL'						=>		'EMail: ',
	'GLOBAL_POWEREDBY'					=>		'Powered by',
	'GLOBAL_REGISTER'					=>		'Registrieren',
	'GLOBAL_PASSWORD_FORGOTTEN'			=>		'Passwort?',
	'GLOBAL_DELETE'						=>		'Löschen...',
	'GLOBAL_DEACTIVATE'					=>		'Deaktivieren...',
	'GLOBAL_ACTIVATE'					=>		'Aktivieren...',
	'GLOBAL_CONFIGURE'					=>		'Konfigurieren...',
	'GLOBAL_PLUGIN'						=>		'Plugin',
	'GLOBAL_OPTIONS'					=>		'Optionen',
	'GLOBAL_UPDATE'						=>		'Updaten...',
	'GLOBAL_ALREADY_INSTALLED'			=>		'Already installed...',
	'GLOBAL_INSTALL'					=>		'Installieren...',
	'GLOBAL_SEND_PASSWORD'				=>		'Passwort zuschicken...',
	'GLOBAL_READ_MORE'					=>		'Den ganzen Artikel lesen',
	'GLOBAL_UNKNOWN'					=>		'Unbekannt',
	'GLOBAL_YES'						=>		'Ja',
	'GLOBAL_NO'							=>		'Nein',
	
	
	
	'REGISTER_TITLE'					=>		'Registrieren',
	'REGISTER_SUBTITLE'					=>		'Registriere einen eigenen Account auf '.$apcms['title'],
	'REGISTER_DESCRIPTION'				=>		'Hier kannst Du Dir einen eigenen Account registrieren.',
	'REGISTER_PASSWORD_TWICE'			=>		'Bitte das Passwort nochmal eingeben, um sicherzustellen, das es auch wirklich korrekt ist.',
	'REGISTER_EMAIL'					=>		'EMail Adresse',
	'REGISTER_SUBMIT'					=>		'Registrierung abschicken...',
	'REGISTER_ACTMAIL_SUBJECT'			=>		'[REG] Deine Registrierung auf '.$apcms['title'],
	'REGISTER_ACTMAIL_BODY'				=>		'Hallo {username},

du hast Dich soeben bei uns registriert und möchtest 
nun unbedingt noch Deinen Account aktivieren.

Zuerst einmal möchten wir Dich ganz herzlich willkommen
heissen und hoffen, das Du mit uns viel Spaß haben wirst.

Um Deinen Account zu aktivieren, musst Du nur auf den
folgenden Link klicken:

{acturl}

Vielen Dank für Deine Registrierung und viel Spaß und
Erfolg auf unseren Seiten!

Das Team von '.$apcms['title'].'
',
	
	
	'ACTIVATE_TITLE'					=>		'Activation',
	'ACTIVATE_SUBTITLE'					=>		'Activating your account',
	
	
	
	
	'PASSWORD_TITLE'					=>		'Passwort?',
	'PASSWORD_SUBTITLE'					=>		'Lass Dir hier Dein Passwort zusenden',
	'PASSWORD_DESCRIPTION'				=>		'Lass Dir hier Dein Passwort zuschicken.<br />Es wird automatisch ein neues Passwort generiert und an die EMail-Adresse geschickt, die für den Usernamen eingetragen ist.',
	'PASSWORD_EMAIL_SUBJECT'			=>		'[PASSWORD] Hier ist Dein neues Passwort für {title}',
	'PASSWORD_EMAIL_BODY'				=>		'Hallo {username},

Du hast soeben die Passwort-Zusenden Funktion benutzt um
Dir Dein Passwort zuschicken zu lassen. Nun, hier ist es:

Username:  {username}
Passwort:  {password}

Mit diesen Daten kannst Du Dich nun bei uns unter
{baseurl}
einloggen.

Das Team von {title}
',
	
	
	'USER_PROFILE'						=>		'User-Profil',
	'USER_PROFILE_TITLE'				=>		'Userprofil',
	'USER_PROFILE_SUBTITLE'				=>		'Deinen Account einstellen',
	'USER_PROFILE_DESCRIPTION'			=>		'Hier kannst Du s&auml;mtliche Einstellung f&uuml;r Deinen Account vornehmen',
	'USER_PROFILE_CHANGE_PASSWORD_DESC'	=>		'Nur eintragen, wenn es ge&auml;ndert werden soll!',
	'USER_PROFILE_THEME'				=>		'Theme / Style / Design',
	'USER_PROFILE_LANGUAGE'				=>		'Bevorzugte Sprache',
	'USER_PROFILE_SAVE'					=>		'Einstellungen speichern...',
	
	
	
	'ADMINCENTER'						=>		'Systemverwaltung',
	'ADMINCENTER_BLAHBLAH'				=>		'Administration des APCms',
	'ADMIN_SAVE'						=>		'Speichern...',
	'ADMIN_MAINPAGE'					=>		'Admin Startseite',
	'ADMIN_NAVBOX_MAIN'					=>		'Einstellungen',
	'ADMIN_GENERAL_CONFIG'				=>		'Allgemeine Einstellungen',
	'ADMIN_PLUGINS'						=>		'Plugin Verwaltung',
	'ADMIN_USERMANAGEMENT'				=>		'User Verwaltung',
	'ADMIN_GROUPMANAGEMENT'				=>		'Gruppen Verwaltung',
	'ADMIN_SIDEBARMANAGEMENT'			=>		'Sidebar Verwaltung',
	'ADMIN_WELCOMEMSG1'					=>		'Hallo '.(isset($_SESSION['nickname'])&&trim($_SESSION['nickname'])!=""?$_SESSION['nickname'].' ':'').'und willkommen in der Systemverwaltung Deines APCms!<br />Hier hast Du vollen Zugriff auf alle Funktionen und Einstellungen des APCms.',
	'ADMIN_SYSINFO'						=>		'System Information',
	'ADMIN_USERINFO'					=>		'User Information',
	
	'ADMIN_GC_TITLE'					=>		'Titel der Seite',
	'ADMIN_GC_SUBTITLE'					=>		'Untertitel der Seite',
	'ADMIN_GC_DESCRIPTION'				=>		'Beschreibung der Seite',
	'ADMIN_GC_EMAILFROM'				=>		'Absender Name',
	'ADMIN_GC_EMAILMAIL'				=>		'Absender EMail-Adresse',
	'ADMIN_GC_SESSLIFETIME'				=>		'Session Lifetime',
	'ADMIN_GC_SESSLIFETIME_EXT'			=>		'Maximale Zeit in Sekunden die man durchgehend eingeloggt sein darf (Default: 3600)',
	
	'ADMIN_PLUGINS_DESCRIPTION'			=>		'Dies ist die Pluginverwaltung des APCms.<br />Hier k&ouml;nnen Plugins installiert, konfiguriert und deinstalliert werden.',
	'ADMIN_PLUGINS_INSTALL_NEW_PLUGINS'	=>		'Klicke hier um neue Plugins zu installieren...',
	'ADMIN_INSTALLPLUGINS_DESCRIPTION'	=>		'Installiere oder update Plugins',
	
	'ADMIN_PCONFIG'						=>		'Plugin-Konfiguration',
	'ADMIN_PCONFIG_DESC'				=>		'<b>Einstellen der Plugin-Konfiguration</b><br />Einzustellendes Plugin: ',
	
	
	
	
	
	
	
	'SYSINFO_ACTVERSION'				=>		'Installierte Version des APCms',
	'SYSINFO_AVAILVERSION'				=>		'Aktuellste verfügbare Version des APCms',
	'SYSINFO_REGUSER'					=>		'Registrierte Mitglieder',
	'SYSINFO_REGUSER_ACTIVE'			=>		'Davon aktive Mitglieder',
	'SYSINFO_REGUSER_INACTIVE'			=>		'Und inaktive Mitglieder',
	
	
	
	
	'SUCCESS_LOGGED_IN'					=>		'Du hast Dich erfolgreich <b>ein</b>geloggt! Du wirst in 3 Sekunden weitergeleitet...',
	'SUCCESS_LOGGED_OUT'				=>		'Du hast Dich erfolgreich <b>aus</b>geloggt! Du wirst in 3 Sekunden weitergeleitet...',
	'SUCCESS_REGISTERED'				=>		'Du hast erfolgreich einen Account registriert.<br />Dieser muss aber noch aktiviert werden, bevor Du Dich einloggen kannst. Dir wurde soeben eine EMail an die angegebene Adresse zugeschickt, in der die Anweisungen zur Aktivierung stehen. <br />Bitte rufe jetzt Deine EMails ab und aktiviere Deinen Account.<br /><br />Du wirst in 10 Sekunden weitergeleitet...',
	'SUCCESS_ACCOUNT_ACTIVATED'			=>		'Du hast Deinen Account erfolgreich aktiviert!<br />Logge Dich nun mit den Daten ein, die Du bei der Registrierung angegeben hast.',
	'SUCCESS_SAVED'						=>		'Erfolgreich gespeichert!',
	'SUCCESS_PLUGIN_DEACTIVATED'		=>		'Plugin deaktiviert!',
	'SUCCESS_PLUGIN_ACTIVATED'			=>		'Plugin aktiviert!',
	'SUCCESS_PLUGIN_DEINSTALLED'		=>		'Plugin deinstalliert!',
	'SUCCESS_PASSWORD_SENT'				=>		'Das neue Passwort wurde erfolgreich an die EMail-Adresse des Accounts geschickt.',
	'SUCCESS_PROFILE_SAVEd'				=>		'Dein Profil wurde erfolgreich gespeichert!',
	
	
	
	'ERROR_MISSING_USERNAME'			=>		'Du musst Deinen Usernamen angeben.',
	'ERROR_MISSING_PASSWORD'			=>		'Du musst Dein Passwort angeben.',
	'ERROR_MISSING_FIRST_PASSWORD'		=>		'Du musst ein Passwort angeben!',
	'ERROR_MISSING_SECOND_PASSWORD'		=>		'Das zweite Passwort-Feld musst Du auch noch ausf&uuml;llen!',
	'ERROR_MISSING_EMAIL'				=>		'Du musst Deine EMail-Adresse angeben!',
	'ERROR_USER_UNKNOWN'				=>		'Dieser User ist nicht in usnerer Datenbank.',
	'ERROR_ACCESS_DENIED'				=>		'Du bist leider nicht dazu berechtigt, diese Aktion auszuf&uuml;hren!<br />Du wirst in 3 Sekunden weitergeleitet...',
	'ERROR_PASSWORDS_DOESNT_MATCH'		=>		'Die beiden Passw&ouml;rter sind nicht identisch!',
	'ERROR_NICK_ALREADY_REGISTERED'		=>		'Der Username ist bereits vergeben. Bitte wähle einen anderen Usernamen.',
	'ERROR_EMAIL_ALREADY_REGISTERED'	=>		'Ein User mit dieser EMail-Adresse ist bereits registriert.',
	'ERROR_ACTIVATE_WRONG_KEY'			=>		'Der Aktivierungs-Key ist leider falsch. Bitte folge dem Link in der Registrierungs-EMail.',
	'ERROR_ACTIVATE_NOT_EXIST'			=>		'Ein Account mit diesem Aktivierungs-Key besteht nicht in unserer Datenbank. Bitte wende Dich an einen <a href="'.$apcms['baseURL'].'?c=adminlist">Administrator</a> bei weiteren Fragen.',
	'ERROR_ACTIVATE_ALREADY_ACTIVATED'	=>		'Der Account wurde bereits aktiviert.',
	'ERROR_ACCOUNT_NOT_ACTIVATED'		=>		'Dieser Account wurde noch nicht aktiviert. Wenn es Dein Account ist, so rufe bitte Deine EMails ab und folge dem Link aus der Registrierungs-EMail.<br />Bitte wende Dich an einen <a href="'.$apcms['baseURL'].'?c=adminlist">Administrator</a> bei weiteren Fragen.',
	'ERROR_EMAIL_NOT_CORRECT'			=>		'Die EMail scheint nicht korrekt zu sein.<br />Bitte wende Dich an einen <a href="'.$apcms['baseURL'].'?c=adminlist">Administrator</a> bei weiteren Fragen.',
	'ERROR_NOT_LOGGEDIN'				=>		'Du musst registriert und eingeloggt sein, um diese Aktion auszuf&uuml;hren!',
	'ERROR_NO_PLUGIN_GIVEN'				=>		'Es wurde kein zu konfigurierendes Plugin &uuml;bergeben!',
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
);











?>