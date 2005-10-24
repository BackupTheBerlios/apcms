# phpMyAdmin SQL Dump
# version 2.5.7
# http://www.phpmyadmin.net
#
# Host: localhost
# Erstellungszeit: 14. Juni 2004 um 11:25
# Server Version: 4.0.18
# PHP-Version: 5.0.0RC3
# 
# Datenbank: `apcms`
# 

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_action_rights`
#

DROP TABLE IF EXISTS `apcms_dev_action_rights`;
CREATE TABLE `apcms_dev_action_rights` (
  `action` varchar(255) NOT NULL default '',
  `groups` varchar(255) NOT NULL default 'a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}',
  `active` tinyint(1) NOT NULL default '1',
  KEY `action` (`action`),
  KEY `active` (`active`)
) TYPE=MyISAM;

#
# Daten für Tabelle `apcms_dev_action_rights`
#

INSERT INTO `apcms_dev_action_rights` (`action`, `groups`, `active`) VALUES ('apcms', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1),
('useronline', 'a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}', 1),
('index_useronlinestats', 'a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}', 1),
('can_access_admin', 'a:1:{i:0;i:1;}', 1),
('show_ips', 'a:1:{i:0;i:1;}', 1),
('show_userdetails', 'a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}', 1),
('show_uo_location', 'a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}', 1),
('enable_helpsys', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1),
('index_usertodayonline', 'a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}', 1),
('portal', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1);

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_cache`
#

DROP TABLE IF EXISTS `apcms_dev_cache`;
CREATE TABLE `apcms_dev_cache` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(64) NOT NULL default '',
  `filesize` int(6) NOT NULL default '0',
  `lastupdate` int(15) NOT NULL default '0',
  `mustupdate` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Daten für Tabelle `apcms_dev_cache`
#


# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_config`
#

DROP TABLE IF EXISTS `apcms_dev_config`;
CREATE TABLE `apcms_dev_config` (
  `title` varchar(255) NOT NULL default 'APBoard v3.0.0 - Development Version - APP - Another PHP Program',
  `description` varchar(255) NOT NULL default '',
  `installdate` int(15) NOT NULL default '0',
  `ppp` tinyint(3) NOT NULL default '15',
  `tpp` tinyint(3) NOT NULL default '25',
  `p_min_length` tinyint(3) NOT NULL default '4',
  `p_max_length` int(15) NOT NULL default '0',
  `p_max_imgages` tinyint(3) NOT NULL default '10',
  `p_max_smilies` tinyint(3) NOT NULL default '10',
  `p_min_interval` tinyint(3) NOT NULL default '20',
  `timezone` decimal(3,2) NOT NULL default '1.00',
  `online_timeout` int(15) NOT NULL default '900',
  `style` varchar(100) NOT NULL default 'app',
  `language` varchar(20) NOT NULL default 'de_sie',
  `news_num` int(3) NOT NULL default '10',
  `auto_backup` tinyint(1) NOT NULL default '0',
  `auto_backdel` tinyint(1) NOT NULL default '0',
  `time_backup` int(15) NOT NULL default '0',
  `time_backdel` int(15) NOT NULL default '0',
  `last_backup` int(15) NOT NULL default '0',
  `data_backup` text NOT NULL,
  `last_backdel` int(15) NOT NULL default '0',
  `cache_aktiv` tinyint(1) NOT NULL default '0',
  `cache_aktinterval` int(11) NOT NULL default '3600'
) TYPE=MyISAM;

#
# Daten für Tabelle `apcms_dev_config`
#

INSERT INTO `apcms_dev_config` (`title`, `description`, `installdate`, `ppp`, `tpp`, `p_min_length`, `p_max_length`, `p_max_imgages`, `p_max_smilies`, `p_min_interval`, `timezone`, `online_timeout`, `style`, `language`, `news_num`, `auto_backup`, `auto_backdel`, `time_backup`, `time_backdel`, `last_backup`, `data_backup`, `last_backdel`, `cache_aktiv`, `cache_aktinterval`) VALUES ('APCMS v{$APCMSVERSION} - Development Version', 'Entwickler-Version des APCMS v{$APCMSVERSION} - In Arbeit seit 03.05.2004 - (c) 2004 by Alexander Mieland', 1083535200, 15, 25, 4, 0, 10, 10, 20, '1.00', 900, 'app', 'de_sie', 10, 1, 1, 43200, 86400, 1087165209, '1|^|a:0:{}|^|data|^|1|^|1', 1087165209, 0, 3600);

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_language`
#

DROP TABLE IF EXISTS `apcms_dev_language`;
CREATE TABLE `apcms_dev_language` (
  `packid` int(11) NOT NULL default '1',
  `file` varchar(200) NOT NULL default 'content.admin.php',
  `variable` varchar(200) NOT NULL default '',
  `text` text NOT NULL,
  KEY `packid` (`packid`),
  KEY `file` (`file`)
) TYPE=MyISAM;

#
# Daten für Tabelle `apcms_dev_language`
#

INSERT INTO `apcms_dev_language` (`packid`, `file`, `variable`, `text`) VALUES (1, 'content.index.php', 'click_to_firstpage', '<b>Startseite</b><br />Hier klicken, um die Startseite neu zu laden.'),
(1, 'content.index.php', 'firstpage', 'Startseite'),
(1, 'content.index.php', 'apcms_is_deactivated', 'Das APCMS ist momentan leider deaktiviert!'),
(1, 'content.index.php', 'apcms_is_deactivated_desc', '<b>Das APCMS ist momentan leider deaktiviert.<br>Bitte versuchen Sie es später noch einmal.'),
(1, 'content.index.php', 'no_access', 'Keine Berechtigung!'),
(1, 'content.index.php', 'no_access_desc', '<b>Sie haben leider nicht die Berechtigung, diese Aktion durchzuführen.'),
(1, 'content.index.php', 'is_on_the', '... befindet sich auf der'),
(1, 'header.full.php', 'button_portal', 'Portal'),
(1, 'header.full.php', 'button_admin', 'Admincenter'),
(1, 'header.full.php', 'button_profil', 'Usercenter'),
(1, 'header.full.php', 'button_logout', 'Logout'),
(1, 'header.full.php', 'button_register', 'Registrieren'),
(1, 'header.full.php', 'button_help', 'Hilfe'),
(1, 'header.full.php', 'button_regeln', 'Regeln'),
(1, 'header.full.php', 'button_portal_help1', 'Zum Portal...'),
(1, 'header.full.php', 'button_portal_help2', 'Hier gelangen in unser Portal, wo Sie alle Neuigkeiten rund um unser Thema erfahren können.'),
(1, 'header.full.php', 'button_admin_help1', 'Zum Admincenter...'),
(1, 'header.full.php', 'button_admin_help2', 'Hier gelangen Sie in das Admincenter, wo Sie alles zur Seite und den Modulen einstellen können.'),
(1, 'header.full.php', 'button_profil_help1', 'Zu Ihrem Profil...'),
(1, 'header.full.php', 'button_profil_help2', 'Hier gelangen Sie in Ihr Usercenter, wo Sie alles zu Ihrer Person und Forengewohnheiten einstellen können.'),
(1, 'header.full.php', 'button_logout_help1', 'Ausloggen...'),
(1, 'header.full.php', 'button_logout_help2', 'Loggen Sie sich hier aus. Es werden dann alle Cookies von Ihrem Rechner gelöscht.'),
(1, 'header.full.php', 'button_register_help1', 'Registrieren...'),
(1, 'header.full.php', 'button_register_help2', 'Registrieren Sie sich hier Ihren eigenen Account und erhalten Sie so noch viele weitere Möglichkeiten in diesem System.'),
(1, 'header.full.php', 'button_help_help1', 'Hilfe...'),
(1, 'header.full.php', 'button_help_help2', 'Hier erhalten Sie weitergehende Hilfe zu allen Bereichen.'),
(1, 'header.full.php', 'button_regeln_help1', 'Regeln...'),
(1, 'header.full.php', 'button_regeln_help2', 'Was kann man tun, was sollte man tun und was darf man nicht tun?'),
(1, 'footer.full.php', 'debug_start', '<strong><u>DEBUG-Output</u></strong>'),
(1, 'footer.full.php', 'page_loading_1', 'Die Seite benötigte'),
(1, 'footer.full.php', 'page_loading_2', 'Sekunden zum laden.'),
(1, 'footer.full.php', 'needed_querys', 'Benötigte Querys:'),
(1, 'content.admin.main.php', 'admin_desc', '<b>Admin-Center</b><br />Hier klicken, um diese Seite neu zu laden.'),
(1, 'content.admin.main.php', 'admincenter', 'Admincenter'),
(1, 'content.admin.main.php', 'is_in_the', '... befindet sich gerade im'),
(1, 'content.admin.main.php', 'admin_is_deactivated', 'Das Admin-Center ist deaktiviert!'),
(1, 'content.admin.main.php', 'admin_is_deactivated_desc', '<b>Das Admin-Center ist momentan leider deaktiviert.<br>Bitte versuchen Sie es später noch einmal.'),
(1, 'content.admin.main.php', 'no_access', 'Keine Berechtigung!'),
(1, 'content.admin.main.php', 'no_access_desc', '<b>Sie haben leider nicht die Berechtigung, diese Aktion durchzuführen.'),
(1, 'content.admin.php', 'admin_desc', '<b>Admin-Center</b><br />Hier klicken, um diese Seite neu zu laden.'),
(1, 'content.admin.php', 'admincenter', 'Admincenter'),
(1, 'content.admin.php', 'is_in_the', '... befindet sich gerade im'),
(1, 'content.admin.php', 'admin_is_deactivated', 'Das Admin-Center ist deaktiviert!'),
(1, 'content.admin.php', 'admin_is_deactivated_desc', '<b>Das Admin-Center ist momentan leider deaktiviert.<br>Bitte versuchen Sie es später noch einmal.'),
(1, 'content.admin.php', 'no_access', 'Keine Berechtigung!'),
(1, 'content.admin.php', 'no_access_desc', '<b>Sie haben leider nicht die Berechtigung, diese Aktion durchzuführen.'),
(1, 'content.admin.php', 'nav_firstpage', '<b>Startseite</b>'),
(1, 'content.admin.php', 'nav_preferences', '<b>Einstellungen</b>'),
(1, 'content.admin.php', 'nav_module', '<b>Module</b>'),
(1, 'content.admin.php', 'nav_user_pref', '<b>User-Optionen</b>'),
(1, 'content.admin.php', 'nav_style_pref', '<b>Style-Optionen</b>'),
(1, 'content.admin.php', 'nav_lang_pref', '<b>Sprach-Optionen</b>'),
(1, 'content.admin.php', 'nav_db_pref', '<b>Datenbank-Optionen</b>'),
(1, 'content.admin.php', 'nav_global_pref', 'Allgemeine Optionen'),
(1, 'content.admin.php', 'nav_backup_pref', 'Backup-Optionen'),
(1, 'content.admin.php', 'nav_make_backup', 'Backup erstellen'),
(1, 'content.admin.php', 'nav_replay_backup', 'Backup einspielen'),
(1, 'content.login.php', 'logout', 'Logout'),
(1, 'content.login.php', 'login', 'Login'),
(1, 'content.login.php', 'has_just_logged_out', '... hat sich gerade ausgeloggt.'),
(1, 'content.login.php', 'is_logging_in', '... loggt sich gerade ein.'),
(1, 'content.login.php', 'logged_out', 'Ausgeloggt!'),
(1, 'content.login.php', 'logged_out_desc', '<b>Sie haben sich erfolgreich ausgeloggt!</b><br>Sämtliche, von diesem System angelegten Cookies wurden gelöscht.'),
(1, 'content.login.php', 'no_data_typed_in', 'Keine Daten angegeben!'),
(1, 'content.login.php', 'no_data_typed_in_desc', '<b>Sie haben Ihre Userdaten nicht angegeben!</b>'),
(1, 'content.login.php', 'successful_logged_in', 'Erfolgreich eingeloggt!'),
(1, 'content.login.php', 'successful_logged_in_desc', '<b>Sie haben sich soeben erfolgreich eingeloggt!</b><br>Viel Spaß auf unseren Seiten.'),
(1, 'content.login.php', 'user_unknown', 'Daten/User unbekannt!'),
(1, 'content.login.php', 'user_unknown_desc', '<b>Ein User mit diesen Daten ist uns leider nicht bekannt!</b>'),
(1, 'content.portal.php', 'portal', 'Portal'),
(1, 'content.portal.php', 'portal_desc', '<b>Portal</b><br />Hier klicken, um diese Seite neu zu laden.'),
(1, 'content.portal.php', 'is_on_the', '... befindet sich auf dem'),
(1, 'content.portal.php', 'portal_desc1', '<b>Portal</b><br />Hier gelangen Sie auf das Portal, wo Sie News und Infos rund um unser Thema finden'),
(1, 'content.portal.php', 'portal_is_deactivated', 'Das Portal ist deaktiviert!'),
(1, 'content.portal.php', 'portal_is_deactivated_desc', '<b>Das Portal ist momentan leider deaktiviert.<br>Bitte versuchen Sie es später noch einmal.'),
(1, 'content.portal.php', 'no_access', 'Keine Berechtigung!'),
(1, 'content.portal.php', 'no_access_desc', '<b>Sie haben leider nicht die Berechtigung, diese Aktion durchzuführen.'),
(1, 'content.useronline.php', 'useronline', 'UserOnline'),
(1, 'content.useronline.php', 'click_to_reload', '<b>UserOnline-Anzeige</b><br />Hier klicken, um diese Seite neu zu laden.'),
(1, 'content.useronline.php', 'user_online', 'User online'),
(1, 'content.useronline.php', 'useronline_is_deactivated', 'Die UserOnline-Anzeige ist deaktiviert!'),
(1, 'content.useronline.php', 'useronline_is_deactivated_desc', '<b>Die UserOnline-Anzeige ist momentan leider deaktiviert.<br>Bitte versuchen Sie es später noch einmal.'),
(1, 'content.useronline.php', 'no_access', 'Keine Berechtigung!'),
(1, 'content.useronline.php', 'no_access_desc', '<b>Sie haben leider nicht die Berechtigung, diese Aktion durchzuführen.'),
(1, 'content.useronline.php', 'user', 'User'),
(1, 'content.useronline.php', 'location', 'Location'),
(1, 'content.useronline.php', 'last_activity', 'Letzte Aktivität'),
(1, 'content.useronline.php', 'uhr', 'Uhr'),
(1, 'content.useronline.php', 'guest_number', 'Gast Nr.'),
(1, 'content.useronline.php', 'show_userdetails_desc', '<b>UserDetails</b><br />Klicken Sie hier, um sich Einzelheiten über diesen User anzusehen.'),
(1, 'apcms_general.func.php', 'ull_be_redirected', 'Sie werden gleich weitergeleitet...'),
(1, 'apcms_general.func.php', 'back', 'Zurück'),
(1, 'apcms_general.func.php', 'helpsys_admincenter_desc', '<b>Zum Admincenter...</b><br>Hier gelangen Sie in das Admincenter, wo Sie alles zur Seite und den Modulen einstellen können.'),
(1, 'apcms_general.func.php', 'helpsys_profil_desc', '<b>Zum Usercenter...</b><br>Hier gelangen Sie in Ihr Usercenter, wo Sie alles zu Ihrer Person einstellen können.'),
(1, 'apcms_general.func.php', 'helpsys_logout_desc', '<b>Ausloggen</b><br>Loggen Sie sich hier aus. Es werden dann alle Cookies von Ihrem Rechner gelöscht.'),
(1, 'apcms_general.func.php', 'helpsys_help_desc', '<b>Hilfe</b><br>Hier erhalten Sie weitergehende Hilfe zu allen Bereichen.'),
(1, 'apcms_general.func.php', 'helpsys_regeln_desc', '<b>Regeln</b><br>Was kann man tun, was sollte man tun und was darf man nicht tun?'),
(1, 'apcms_general.func.php', 'helpsys_register_desc', '<b>Registrieren</b><br>Registrieren Sie sich hier Ihren eigenen Account und erhalten Sie so noch viele weitere Möglichkeiten in diesem System.'),
(1, 'apcms_general.func.php', 'helpsys_login_desc', '<b>Einloggen</b><br>Loggen Sie sich hier als registrierter User ein.'),
(1, 'apcms_general.func.php', 'helpsys_pwforgotten_desc', '<b>Passwort vergessen?</b><br>Hier können Sie sich Ihr Passwort zuschicken lassen.'),
(1, 'apcms_general.func.php', 'helpsys_impressum_desc', '<b>Unser Impressum</b><br>Hier erhalten Sie Informationen zu unserem Projekt und wie Sie uns erreichen können.'),
(1, 'apcms_general.func.php', 'helpsys_copyright_desc', '<b>Das Copyright, die Credits</b><br>Hier finden Sie Informationen zum Hersteller des Systems.'),
(1, 'apcms_general.func.php', 'helpsys_logo_desc', '<b>Unser Logo</b><br>Durch Klick auf das Logo gelangen Sie immer wieder zur Startseite zurück.'),
(1, 'apcms_general.func.php', 'helpsys_title_desc', '<b>Der Titel der Seite</b><br>Durch Klick auf den Titel gelangen Sie immer wieder zur Startseite zurück.'),
(1, 'apcms_general.func.php', 'possible_security_attack', 'Mögliche Security-Attacke!'),
(1, 'apcms_general.func.php', 'time', 'Zeit'),
(1, 'apcms_general.func.php', 'ip_adress', 'IP-Adresse'),
(1, 'apcms_general.func.php', 'get_string', 'Über GET übergebener String'),
(1, 'apcms_general.func.php', 'no_script_kiddies_1', 'Script-Kiddies haben bei uns keine Chance!'),
(1, 'apcms_general.func.php', 'no_script_kiddies_2', '... geh spielen! Und tschüss...'),
(1, 'apcms_general.func.php', 'uo_unknown_page', '... befindet sich auf einer, dem System unbekannten Seite.'),
(1, 'apcms_general.func.php', 'sind', 'sind'),
(1, 'apcms_general.func.php', 'ist', 'ist'),
(1, 'apcms_general.func.php', 'at_this_time', 'zur Zeit'),
(1, 'apcms_general.func.php', 'help_useronline_desc', '<b>UserOnline-Anzeige</b><br />Hier werden ihnen alle User aufgelistet, die gerade auf unseren Seiten online sind.'),
(1, 'apcms_general.func.php', 'user', 'User'),
(1, 'apcms_general.func.php', 'on_this_site_online', 'auf unseren Seiten online'),
(1, 'apcms_general.func.php', 'members', 'Mitglieder'),
(1, 'apcms_general.func.php', 'member', 'Mitglied'),
(1, 'apcms_general.func.php', 'and', 'und'),
(1, 'apcms_general.func.php', 'guests', 'Gäste'),
(1, 'apcms_general.func.php', 'guest', 'Gast'),
(1, 'apcms_general.func.php', 'help_userdetails_desc', '<b>UserDetails</b><br />Klicken Sie hier, um sich Einzelheiten über diesen User anzusehen..'),
(1, 'content.admin.php', 'main_title', 'Hauptseite'),
(1, 'content.admin.php', 'nav_lang_cache', '<strong>Caching-Optionen</strong>'),
(1, 'apcms_general.func.php', 'backup_not_found', 'Backup-Datei nicht gefunden. Wurde sie eventl. durch die autom. Löschfunktion gelöscht?'),
(1, 'apcms_general.func.php', 'backup_recovered1', 'Backup &quot;'),
(1, 'apcms_general.func.php', 'backup_recovered2', '&quot; erfolgreich in die Datenbank zurückgespielt!'),
(1, 'content.admin.php', 'backup_opts', 'Backup-Optionen'),
(1, 'content.admin.php', 'backup_successful_recovered', 'Backup erfolgreich zurück gespielt!'),
(1, 'content.admin.php', 'please_choose', 'Bitte wählen!'),
(1, 'content.admin.php', 'structur_and_content', 'Struktur und Inhalt (CREATE+INSERT)'),
(1, 'content.admin.php', 'only_structure', 'Nur Struktur (CREATE TABLE)'),
(1, 'content.admin.php', 'only_content', 'Nur Inhalt (INSERT INTO)'),
(1, 'content.admin.php', 'with_drop_table', 'Mit &quot;DROP TABLE&quot;'),
(1, 'content.admin.php', 'pack_with_gzip', 'Backup mit GZIP packen'),
(1, 'content.admin.php', 'complete_database', '<b>Komplette Datenbank</b>'),
(1, 'content.admin.php', 'start_backup', 'Backup!'),
(1, 'content.admin.php', 'every_hour', 'jede Stunde'),
(1, 'content.admin.php', 'every_two_hours', 'alle 2 Stunden'),
(1, 'content.admin.php', 'every_five_hours', 'alle 5 Stunden'),
(1, 'content.admin.php', 'every_12_hours', 'alle 12 Stunden'),
(1, 'content.admin.php', 'every_24_hours', 'alle 24 Stunden'),
(1, 'content.admin.php', 'every_2_days', 'alle 2 Tage'),
(1, 'content.admin.php', 'every_4_days', 'alle 4 Tage'),
(1, 'content.admin.php', 'every_7_days', 'alle 7 Tage'),
(1, 'content.admin.php', 'every_2_weeks', 'alle 2 Wochen'),
(1, 'content.admin.php', 'every_4_weeks', 'alle 4 Wochen'),
(1, 'content.admin.php', '12_hours', '12 Stunden'),
(1, 'content.admin.php', '24_hours', '24 Stunden'),
(1, 'content.admin.php', '2_days', '2 Tage'),
(1, 'content.admin.php', '4_days', '4 Tage'),
(1, 'content.admin.php', '7_days', '7 Tage'),
(1, 'content.admin.php', '2_weeks', '2 Wochen'),
(1, 'content.admin.php', '4_weeks', '4 Wochen'),
(1, 'content.admin.php', '2_months', '2 Monate'),
(1, 'content.admin.php', '6_months', '6 Monate'),
(1, 'content.admin.php', 'start_backup_automation', '<b>Eingestelltes Backup zeitgesteuert ausführen?</b>'),
(1, 'content.admin.php', 'yes_start_backupauto', 'Ja, Automatik starten'),
(1, 'content.admin.php', 'time_between_backups', 'Zeitinterval zw. Backups'),
(1, 'content.admin.php', 'del_old_backups', '<b>Alte Backups automatisch löschen?</b>'),
(1, 'content.admin.php', 'yes_del_old_backups', 'Ja, automatisches Löschen starten'),
(1, 'content.admin.php', 'all_older_than', 'Alle Backups, älter als'),
(1, 'content.admin.php', 'delete', 'löschen'),
(1, 'content.admin.php', 'filename', 'Dateiname'),
(1, 'content.admin.php', 'filesize', 'Dateigröße'),
(1, 'content.admin.php', 'date', 'Datum'),
(1, 'content.admin.php', 'options', 'Options'),
(1, 'content.admin.php', 'alt_recover_backup', 'Backup in die Datenbank zurückspielen, bisherige Daten überschreiben...\\n\\nACHTUNG: Es erfolgt KEINE Nachfrage!\\nDas Backup wird sofort in die Datenbank eingespielt!'),
(1, 'content.admin.php', 'delete_button', 'Löschen'),
(1, 'content.admin.php', 'no_backups', 'Keine Datenbank-Backups vorhanden...'),
(1, 'content.admin.php', 'caching_options', 'Caching-Optionen'),
(1, 'content.admin.php', 'caching_opts_description', 'Hier haben Sie die Möglichkeit, das Caching-Verhalten des Systems einzustellen.<br />\r\n<strong>Beachten Sie,</strong> dass das Caching nicht nur Vorteile hat (ein schnelleres Laden der Seiten), sondern auch grosse Nachteile. \r\nSo kann es vorkommen, dass eine Seite nicht sofort aktuell dargestellt wird, nachdem sich etwas im Inhalt der Seite geändert hat.<br />\r\nAus diesem Grund können Sie unten auch eine Zeit in Minuten einstellen, nach der eine gecachte Seite auf jeden Fall aktualisiert werden soll.\r\nDie Erfahrung hat gezeigt, dass ein Wert von 60 Minuten ein ganz guter Kompromiss zwischen der Performance und der Aktualität Ihrer Seiten ist.<br />\r\nAber auch ein kleinerer Wert kann gut sein, wenn sich Ihre Seiten sehr schnell ändern.\r\nJe kleiner der Wert ist, desto aktueller sind Ihre Seiten. Je höher der Wert ist, desto seltener werden sie  zwangs-aktualisiert und desto schneller sind Ihre Seiten geladen.<br />\r\n<strong>Beachten Sie dabei aber auch</strong>, dass die Seiten generell aktualisiert werden, wenn sich etwas ändert, wobei allerdings die User-Online-Anzeigen nicht zu solchen Änderungen zählen.'),
(1, 'content.admin.php', 'activate_caching', '<b>Caching einschalten</b><br />Aktivieren Sie hier das Caching. Beachten Sie, dass bei den ersten Seitenaufrufen nach der Aktivierung noch keine Performance-Steigerung festzustellen ist, da die Seiten dann erst gecached werden müssen.'),
(1, 'content.admin.php', 'cache_timeout', '<b>Zeitinterval für Zwangsaktualisierung</b><br />Stellen Sie hier die Zeit in Minuten ein, bis eine gecachte Seite auf jeden Fall aktualisiert werden soll.'),
(1, 'content.admin.php', 'reset_cache', '<b><span style="color:red">Cache reseten</span></b><br />Wenn Sie diese Checkbox aktivieren, werden alle bisher gecachten Dateien gelöscht und der Cache resetet. Dies ist eine Möglichkeit, um alle Dateien auf einmal zu aktualisieren.'),
(1, 'content.admin.php', 'save_settings', 'Einstellungen speichern...'),
(1, 'content.admin.php', 'reset_formular', 'Formular Zurücksetzen'),
(1, 'content.admin.php', 'history_back', 'Zurück...'),
(1, 'content.admin.php', 'database_options', 'Datenbank-Optionen'),
(1, 'content.admin.php', 'database_options_desc', 'Hier haben Sie die Möglichkeit, Ihre Datenbank zu sichern, oder ein Backup wieder einzuspielen.<br />\r\nSie können die Backups auch zeitgesteuert automatisch vom System machen lassen, auch das Löschen von alten Backups geschieht vollautomatisch.<br /><br />\r\nUnten haben sie die Möglichkeit ein oder mehrere MySQl-Querys direkt in die Datenbank einzugeben, um so zum Beispiel schnell Änderungen an mehreren Datensätzen gleichzeitig durchzuführen.<br />\r\n<strong><span style="color:red">ACHTUNG:</span> Machen Sie dies bitte nur, wenn Sie wirklich wissen, was Sie da tun! Es erfolgen keine Sicherheitsabfragen!</strong>'),
(1, 'content.admin.php', 'do_querys_in_db', 'Führen Sie hier ein oder mehrere SQL-Querys direkt in Ihrer Datenbank aus.'),
(1, 'content.admin.php', 'do_querys_in_db_desc', 'Beginnen Sie jedes Query in einer neuen Zeile und schliessen Sie alle Querys immer mit einem Semikolon (;) ab!'),
(1, 'content.admin.php', 'following_vars_available', 'Folgende Variablen stehen in jedem Query zur Verfügung:'),
(1, 'content.admin.php', 'following_vars_available_desc', '{$MYSQLSUFFIX} wird ersetzt durch das eingestellte Tabellen-Suffix<br />\r\n{$LANGUAGETABLE} wird ersetzt durch den Namen der Sprach-Tabelle<br />\r\n{$NAVBOXTABLE} wird ersetzt durch den Namen der Navigations-Boxen-Tabelle<br />\r\n{$NEWSTABLE} wird ersetzt durch den Namen der News-Tabelle<br />\r\n{$USERTABLE} wird ersetzt durch den Namen der User-Tabelle'),
(1, 'content.admin.php', 'DO_SQL', 'SQL ausführen...'),
(1, 'content.admin.php', 'empty_query_field', 'Queryfeld leeren');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_languagepacks`
#

DROP TABLE IF EXISTS `apcms_dev_languagepacks`;
CREATE TABLE `apcms_dev_languagepacks` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `browsercode` varchar(6) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `browsercode` (`browsercode`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Daten für Tabelle `apcms_dev_languagepacks`
#

INSERT INTO `apcms_dev_languagepacks` (`id`, `name`, `browsercode`) VALUES (1, 'Deutsch (Sie)', 'de_sie'),
(2, 'Deutsch (Du)', 'de_du');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_modules`
#

DROP TABLE IF EXISTS `apcms_dev_modules`;
CREATE TABLE `apcms_dev_modules` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `unique` varchar(30) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `opts` text NOT NULL,
  `tables` text NOT NULL,
  `groups` varchar(255) NOT NULL default 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}',
  `sortit` tinyint(3) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `active` (`active`),
  KEY `sortit` (`sortit`),
  KEY `unique` (`unique`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Daten für Tabelle `apcms_dev_modules`
#


# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_portal_boxsets`
#

DROP TABLE IF EXISTS `apcms_dev_portal_boxsets`;
CREATE TABLE `apcms_dev_portal_boxsets` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `site` varchar(60) NOT NULL default '',
  `boxarray` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `site` (`site`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Daten für Tabelle `apcms_dev_portal_boxsets`
#

INSERT INTO `apcms_dev_portal_boxsets` (`id`, `name`, `site`, `boxarray`) VALUES (1, 'DEFAULT', 'DEFAULT', 'a:3:{i:0;a:2:{s:2:"id";i:1;s:4:"side";i:1;}i:1;a:2:{s:2:"id";i:2;s:4:"side";i:2;}i:2;a:2:{s:2:"id";i:3;s:4:"side";i:1;}}');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_portal_navboxes`
#

DROP TABLE IF EXISTS `apcms_dev_portal_navboxes`;
CREATE TABLE `apcms_dev_portal_navboxes` (
  `id` int(11) NOT NULL auto_increment,
  `titel` varchar(200) NOT NULL default '',
  `inhalt` text NOT NULL,
  `groups` varchar(255) NOT NULL default 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `active` (`active`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Daten für Tabelle `apcms_dev_portal_navboxes`
#

INSERT INTO `apcms_dev_portal_navboxes` (`id`, `titel`, `inhalt`, `groups`, `active`) VALUES (1, 'Navigation', '<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">\r\n\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Startseite</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php?s=portal">Portal</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 1</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 2</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 3</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 4</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 5</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 6</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 7</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 8</a></td><tr>\r\n\r\n</table>\r\n', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1),
(2, 'Test-Navi 1', '<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">\r\n\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 1</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 2</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 3</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 4</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 5</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 6</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 7</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 8</a></td><tr>\r\n\r\n</table>\r\n', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1),
(3, 'Test-Navi 2', '<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">\r\n\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 1</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 2</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 3</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 4</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 5</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 6</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 7</a></td><tr>\r\n<tr valign="top"><td>&nbsp;&raquo;&nbsp;</td><td><a href="./index.php">Test-Link 8</a></td><tr>\r\n\r\n</table>\r\n', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1);

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_portal_news`
#

DROP TABLE IF EXISTS `apcms_dev_portal_news`;
CREATE TABLE `apcms_dev_portal_news` (
  `id` int(11) NOT NULL auto_increment,
  `katid` int(11) NOT NULL default '1',
  `userid` int(11) NOT NULL default '0',
  `publicname` varchar(60) NOT NULL default '',
  `time` int(15) NOT NULL default '0',
  `titel` varchar(200) NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `time` (`time`),
  KEY `katid` (`katid`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Daten für Tabelle `apcms_dev_portal_news`
#

INSERT INTO `apcms_dev_portal_news` (`id`, `katid`, `userid`, `publicname`, `time`, `titel`, `text`) VALUES (1, 2, 1, 'dma147', 1082882420, 'PHP 5 Release Candidate 2 Released!', 'The second Release Candidate of PHP 5 is now available! This mostly bug fix release improves PHP 5\'s stability and irons out some of the remaining issues before PHP 5 can be deemed release quality. Note that it is still not recommended for mission-critical use but people are encouraged to start playing with it and report any problems.'),
(2, 3, 1, 'dma147', 1082982420, 'Irgendwas über MySQL', 'Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. \r\nDies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. \r\nDies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. Dies soll irgendein toller und langer Text über ein MySQL-Tema sein. \r\nDies soll irgendein toller und langer Text über ein MySQL-Tema sein. '),
(3, 4, 1, 'dma147', 1082282420, 'Irgendwas über Apache', 'Dies soll irgendein toller und langer Text über ein Apache-Thema sein. \r\nDies soll irgendein toller und langer Text über ein Apache-Thema sein. \r\nDies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. \r\nDies soll irgendein toller und langer Text über ein Apache-Thema sein. \r\nDies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. \r\nDies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. \r\nDies soll irgendein toller und langer Text über ein Apache-Thema sein. Dies soll irgendein toller und langer Text über ein Apache-Thema sein. \r\nDies soll irgendein toller und langer Text über ein Apache-Thema sein. ');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_portal_newskats`
#

DROP TABLE IF EXISTS `apcms_dev_portal_newskats`;
CREATE TABLE `apcms_dev_portal_newskats` (
  `id` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '1',
  `titel` varchar(200) NOT NULL default '',
  `beschreibung` text NOT NULL,
  `katpic` varchar(150) NOT NULL default '',
  `groups` varchar(255) NOT NULL default 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `active` (`active`),
  KEY `parentid` (`parentid`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# Daten für Tabelle `apcms_dev_portal_newskats`
#

INSERT INTO `apcms_dev_portal_newskats` (`id`, `parentid`, `titel`, `beschreibung`, `katpic`, `groups`, `active`) VALUES (1, 0, 'Öffentlich (sichtbar für alle!)', 'Dies ist die öffentliche News-Kategorie.\r\nNews, die hier drin liegen, werden von allen User (auch Gäste!) gesehen.\r\n', '', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1),
(2, 1, 'PHP', 'News rund um PHP.', 'php_64x64', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1),
(3, 1, 'MySQL', 'News rund um MySQL.', 'mysql_64x64', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1),
(4, 1, 'Apache', 'News rund um den Apache Webserver.', 'apache_64x64', 'a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}', 1);

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_user_groups`
#

DROP TABLE IF EXISTS `apcms_dev_user_groups`;
CREATE TABLE `apcms_dev_user_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `status` varchar(60) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `active` (`active`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# Daten für Tabelle `apcms_dev_user_groups`
#

INSERT INTO `apcms_dev_user_groups` (`id`, `name`, `status`, `active`) VALUES (1, 'Administrator', 'ADMIN', 1),
(2, 'Moderator', 'MOD', 1),
(3, 'registrierter User', 'MEMBER', 1),
(4, 'Gast', 'GUEST', 1),
(5, 'gebannter User', 'BANNED', 1),
(6, 'gelöschter User', 'DELETED', 1);

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_user_online`
#

DROP TABLE IF EXISTS `apcms_dev_user_online`;
CREATE TABLE `apcms_dev_user_online` (
  `zeit` int(15) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '000.000.000.000',
  `publicname` varchar(50) NOT NULL default '',
  `userid` int(11) NOT NULL default '0',
  `hide_user` int(1) NOT NULL default '0',
  `onlineanzeige` text NOT NULL,
  `last_aktivity` int(15) NOT NULL default '0',
  `sessid` varchar(32) binary NOT NULL default '',
  KEY `userid` (`userid`),
  KEY `sessid` (`sessid`),
  KEY `zeit` (`zeit`),
  KEY `last_aktivity` (`last_aktivity`)
) TYPE=MyISAM;

#
# Daten für Tabelle `apcms_dev_user_online`
#


# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `apcms_dev_user_table`
#

DROP TABLE IF EXISTS `apcms_dev_user_table`;
CREATE TABLE `apcms_dev_user_table` (
  `userid` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `publicname` varchar(50) NOT NULL default '',
  `userpassword` varchar(40) binary NOT NULL default '',
  `useremail` varchar(200) binary NOT NULL default '',
  `userposts` int(11) NOT NULL default '0',
  `usergroup` varchar(255) NOT NULL default '3',
  `statusextra` varchar(25) NOT NULL default '',
  `regdate` int(15) NOT NULL default '0',
  `signatur` text NOT NULL,
  `infotext` text NOT NULL,
  `usericq` int(16) NOT NULL default '0',
  `useraim` varchar(64) NOT NULL default '',
  `useryim` varchar(64) NOT NULL default '',
  `usermsn` varchar(64) NOT NULL default '',
  `usertrilian` varchar(64) NOT NULL default '',
  `userjabber` varchar(64) NOT NULL default '',
  `userhp` varchar(200) NOT NULL default '',
  `userage` tinyint(3) NOT NULL default '0',
  `interests` varchar(200) NOT NULL default '',
  `gender` int(1) NOT NULL default '1',
  `birthday` date NOT NULL default '0000-00-00',
  `city` varchar(200) NOT NULL default '',
  `zipcode` varchar(10) NOT NULL default '',
  `timezone` decimal(3,2) NOT NULL default '1.00',
  `style` varchar(100) NOT NULL default 'app',
  `language` varchar(20) NOT NULL default '',
  `news_num` int(3) NOT NULL default '10',
  PRIMARY KEY  (`userid`),
  KEY `username` (`username`),
  KEY `userpassword` (`userpassword`),
  KEY `regdate` (`regdate`),
  KEY `birthday` (`birthday`),
  KEY `city` (`city`),
  KEY `zipcode` (`zipcode`)
) TYPE=MyISAM PACK_KEYS=1 AUTO_INCREMENT=1657 ;

#
# Daten für Tabelle `apcms_dev_user_table`
#

INSERT INTO `apcms_dev_user_table` (`userid`, `username`, `publicname`, `userpassword`, `useremail`, `userposts`, `usergroup`, `statusextra`, `regdate`, `signatur`, `infotext`, `usericq`, `useraim`, `useryim`, `usermsn`, `usertrilian`, `userjabber`, `userhp`, `userage`, `interests`, `gender`, `birthday`, `city`, `zipcode`, `timezone`, `style`, `language`, `news_num`) VALUES 
(1, 'dma147', 'dma147', 'c0937f90e17388a56852a109f3b7b565', 'dma147@web.de', 0, '1', 'APP-Cheffe', 982270358, '[url=http://www.php-programs.de][img]http://www.php-programs.de/images/signatur_transparent.gif[/img][/url]', '', 43293804, '', '', '', '', '', 'http://www.mieland-programming.de', 31, '', 1, '1972-07-14', 'Berlin', '10407', '1.00', 'app', '', 10);
