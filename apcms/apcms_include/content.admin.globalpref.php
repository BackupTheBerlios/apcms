<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | APCMS v0.0.2                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-     APP - Another PHP Program                    |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2 of the GPL,                 |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// +----------------------------------------------------------------------+
// | Authors: Alexander Mieland <dma147 at linux-stats dot org>           |
// +----------------------------------------------------------------------+
// $Id $
// +----------------------------------------------------------------------+



$CONTENTTITEL       .=       '&nbsp; &raquo; &nbsp;Einstellungen';
require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_admintable.class.".$_SESSION['APCMS']['SUFFIX']);
$TITLE_LOCATION     =        $_LANGUAGE['admincenter'].' - Einstellungen';

$SELECTTIMEZONE = '<select name="NEW[timezone]" style="width:220px">';
$CONFIGTIMEZONE = 0;
if (ereg(".00", $_SESSION['APCMS']['CONFIG']['timezone']) || !ereg(".", $_SESSION['APCMS']['CONFIG']['timezone']))
    $CONFIGTIMEZONE = intval($_SESSION['APCMS']['CONFIG']['timezone']);
else 
    $CONFIGTIMEZONE = (float) $_SESSION['APCMS']['CONFIG']['timezone'];
foreach ($timezone_array as $key => $val)
    {
    if (isset($_SESSION['POSTDATA']['timezone']) && $_SESSION['POSTDATA']['timezone'] == $key)
        $SELECTTIMEZONE .= '<option value="'.$key.'" selected>'.$val.'</option>';
    elseif (!isset($_SESSION['POSTDATA']['timezone']) && "".$CONFIGTIMEZONE == $key)
        $SELECTTIMEZONE .= '<option value="'.$key.'" selected>'.$val.'</option>';
    else 
        $SELECTTIMEZONE .= '<option value="'.$key.'">'.$val.'</option>';
    }
$SELECTTIMEZONE .= '</select>';

$SELECTSTYLE = '<select name="NEW[style]" style="width:220px">';
$opendir = @opendir($_SESSION['APCMS']['STYLES_DIR']);
while ($thisstyle = @readdir($opendir))
    {
    if ((!is_file($thisstyle)) && ($thisstyle!="." && $thisstyle!=".." && $thisstyle!="index.".$_SESSION['APCMS']['SUFFIX'] && $thisstyle!="CVS" && $thisstyle!="cvs"))
        {
        include ($_SESSION['APCMS']['STYLES_DIR']."/".$thisstyle."/configs/style.config.".$_SESSION['APCMS']['SUFFIX']);
        if (isset($_SESSION['POSTDATA']['style']) && ($thisstyle == $_SESSION['POSTDATA']['style']))
            $SELECTSTYLE .= '<option value="'.$thisstyle.'" selected>'.$STYLE['NAME'].' v'.$STYLE['VERSION'].' ('.$STYLE['AUTHOR'].')</option>';
        elseif (!isset($_SESSION['POSTDATA']['style']) && ($thisstyle == $_SESSION['APCMS']['STYLE']))
            $SELECTSTYLE .= '<option value="'.$thisstyle.'" selected>'.$STYLE['NAME'].' v'.$STYLE['VERSION'].' ('.$STYLE['AUTHOR'].')</option>';
        else 
            $SELECTSTYLE .= '<option value="'.$thisstyle.'">'.$STYLE['NAME'].' v'.$STYLE['VERSION'].' ('.$STYLE['AUTHOR'].')</option>';
        }
    }
$SELECTSTYLE .= '</select>';

$SELECTLANG = '<select name="NEW[language]" style="width:220px">';
$query = "SELECT `name`, `browsercode` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_languagepacks` ";
$dblanguages = $db->unbuffered_getAll_row($query);
for ($a=0;$a<count($dblanguages);$a++)
    {
    if (isset($_SESSION['POSTDATA']['language']) && ($dblanguages[$a][1] == $_SESSION['POSTDATA']['language']))
        $SELECTLANG .= '<option value="'.$dblanguages[$a][1].'" selected>'.$dblanguages[$a][0].'</option>';
    elseif (!isset($_SESSION['POSTDATA']['language']) && ($dblanguages[$a][1] == $_SESSION['APCMS']['CONFIG']['language']))
        $SELECTLANG .= '<option value="'.$dblanguages[$a][1].'" selected>'.$dblanguages[$a][0].'</option>';
    else 
        $SELECTLANG .= '<option value="'.$dblanguages[$a][1].'">'.$dblanguages[$a][0].'</option>';
    }
$SELECTLANG .= '</select>';
$ADMINTABLE1 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
$ADMINTABLE1->AddRow('<strong>Allgemeine Einstellungen</strong>', '', 2);
$ADMINTABLE1->OpenForm('optform', $_SERVER['PHP_SELF']."?s=handler".$_SESSION['SID2']);
$ADMINTABLE1->AddRow('<strong>Titel der Seite</strong><br>Tragen Sie hier den Titel der Seite ein (max. 250 Zeichen)', '<input style="width:220px" type="text" name="NEW[title]" value="'.(isset($_SESSION['POSTDATA']['title'])&&trim($_SESSION['POSTDATA']['title'])!=""?_APCMS_trim($_SESSION['POSTDATA']['title']):_APCMS_trim($_SESSION['APCMS']['CONFIG']['title'])).'">');
$ADMINTABLE1->AddRow('<strong>Beschreibung der Seite</strong><br>Tragen Sie hier eine kurze Beschreibung der Seite ein (max. 250 Zeichen)', '<input style="width:220px" type="text" name="NEW[description]" value="'.(isset($_SESSION['POSTDATA']['description'])&&trim($_SESSION['POSTDATA']['description'])!=""?_APCMS_trim($_SESSION['POSTDATA']['description']):_APCMS_trim($_SESSION['APCMS']['CONFIG']['description'])).'">');
$ADMINTABLE1->AddRow('<strong>Zeitzone</strong><br>Wählen Sie hier die Zeitzone, in der der Server steht. Steht der Server bei einem Provider in Amerika, wählen Sie hier den Ort in Amerika, wo der Server steht.', $SELECTTIMEZONE);
$ADMINTABLE1->AddRow('<strong>Default-Style</strong><br>Wählen Sie hier das Default-Style (Design), das man zu sehen bekommt, wenn man nicht eingeloggt ist, oder sich als User noch kein Style selber ausgewählt hat.', $SELECTSTYLE);
$ADMINTABLE1->AddRow('<strong>Online-Timeout</strong><br>Stellen Sie hier ein, wie lange User als online gelten sollen, wenn sie keine Aktionen mehr ausführen. (in Minuten)', '<input style="width:220px" type="text" name="NEW[online_timeout]" value="'.(isset($_SESSION['POSTDATA']['online_timeout'])&&$_SESSION['POSTDATA']['online_timeout']>=1?$_SESSION['POSTDATA']['online_timeout']:round(($_SESSION['APCMS']['CONFIG']['online_timeout']/60), 0)).'">');
$ADMINTABLE1->AddRow('<strong>Anzahl der News im Portal</strong><br>Tragen Sie hier die ANzahl der News ein, die per default im Portal angezeigt werden sollen. Hat nur Effekt bei Usern, die sich das noch nicht selber im Profil eingestellt haben.', '<input style="width:220px" type="text" name="NEW[news_num]" value="'.(isset($_SESSION['POSTDATA']['news_num'])&&$_SESSION['POSTDATA']['news_num']>=1?$_SESSION['POSTDATA']['news_num']:$_SESSION['APCMS']['CONFIG']['news_num']).'">');
$ADMINTABLE1->AddRow('&nbsp;<input type="hidden" name="s" value="handler">
                            <input type="hidden" name="action" value="save_globalpref">
                            <input type="hidden" name="FROM[s]" value="admin">
                            <input type="hidden" name="FROM[ainclude]" value="globalpref">
                            <input type="hidden" name="'.session_name().'" value="'.session_id().'">', '', 2);
$ADMINTABLE1->AddRow('<input type="submit" name="saveopts" value="Einstellungen speichern...">&nbsp;&nbsp;<input type="reset" name="reset" value="Formular Zurücksetzen">&nbsp;&nbsp;<input type="button" name="zurueck" value="Zurück..." OnClick="JavaScript:history.back();">', '', 2);
$ADMINTABLE1->CloseForm();
$CONTENTINHALT .= $ADMINTABLE1->GetTable();

unset($_SESSION['POSTDATA']);

?>