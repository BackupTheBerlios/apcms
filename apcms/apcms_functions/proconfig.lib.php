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
// | Authors: Alexander Mieland <dma147 at mieland-programming dot de>    |
// +----------------------------------------------------------------------+
// $Id $
// +----------------------------------------------------------------------+



/** Kontrollieren ob Array $_SESSION['APCMS']['CONFIG'] vorhanden, wenn nicht, dann Konfiguration starten */ 
if(!isset($_SESSION['APCMS']['CONFIG'])) 
    { 
    $query = "SELECT * FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_config`";   
    $cthis = $db->unbuffered_query_first($query, 'assoc'); 
    foreach ($cthis as $key => $val) 
        { 
        $_SESSION['APCMS']['CONFIG'][$key] = stripslashes($val); 
        } 
    } 
 
/** Kontrollieren ob Cookie vorhanden, wenn ja, dann UserKonfiguration starten */ 
unset($_SESSION['LOGGEDIN']); 
$_SESSION['USERGROUPS'] = array(); 
if(isset($_COOKIE['APCMS']['USERDATA']) && trim($_COOKIE['APCMS']['USERDATA']) != "") 
    { 
    $COOKIEDATA = explode("|", trim($_COOKIE['APCMS']['USERDATA'])); 
    if(!isset($_SESSION['APCMS']['USER'])) 
        { 
        $query = "SELECT * FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_user_table` WHERE `userid`='".$COOKIEDATA[0]."' AND `userpassword`='".$COOKIEDATA[1]."'";   
        $getuser_return = $db->unbuffered_query_first($query, 'assoc'); 
        unset($_SESSION['APCMS']['USER']); 
        if (isset($getuser_return) && count($getuser_return) >= 1) 
            { 
            foreach($getuser_return as $key => $val) 
                { 
                $_SESSION['APCMS']['USER'][$key] = stripslashes($val); 
                } 
            $_SESSION['LOGGEDIN'] = 1; 
            if (ereg(",", $_SESSION['APCMS']['USER']['usergroup'])) 
                { 
                $mygroups = explode(",", trim($_SESSION['APCMS']['USER']['usergroup'])); 
                $mgcc=0; 
                for ($mgc=0;$mgc<count($mygroups);$mgc++) 
                    { 
                    if (trim($mygroups[$mgc]) != "") 
                        { 
                        $_SESSION['USERGROUPS'][$mgcc] = intval(trim($mygroups[$mgc])); 
                        $mgcc++; 
                        } 
                    } 
                } 
            else  
                { 
                $_SESSION['USERGROUPS'][0] = intval(trim($_SESSION['APCMS']['USER']['usergroup'])); 
                } 
            } 
        else  
            { 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL']."/".$_SESSION['SID1']; 
            $REDIRECT_TIME = 3; 
            $LOGIN->assign("STATUSMSG", _APCMS_MsgBox("Daten im Cookie sind nicht korrekt!", "<b>Ein User mit diesen Daten ist uns leider nicht bekannt!</b>", $REDIRECT_URL, $REDIRECT_TIME, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            unset($_SESSION['APCMS']['USER']); 
            unset($_SESSION['LOGGEDIN']); 
            $_SESSION['USERGROUPS'][0] = 4; 
            } 
        } 
    else  
        { 
        /** Passwort im Cookie mit Passort in Session vergleichen! */ 
        if ($_SESSION['APCMS']['USER']['userid'] != $COOKIEDATA[0] || $_SESSION['APCMS']['USER']['userpassword'] != $COOKIEDATA[1]) 
            { 
            $REDIRECT_URL = $_SESSION['APCMS']['REL_URL']."/".$_SESSION['SID1']; 
            $REDIRECT_TIME = 3; 
            $LOGIN->assign("STATUSMSG", _APCMS_MsgBox("Daten im Cookie sind nicht korrekt!", "<b>Ein User mit diesen Daten ist uns leider nicht bekannt!</b>", $REDIRECT_URL, $REDIRECT_TIME, 1, $_SESSION['APCMS']['TABLE']['WIDTH'])); 
            unset($_SESSION['APCMS']['USER']); 
            unset($_SESSION['LOGGEDIN']); 
            $_SESSION['USERGROUPS'][0] = 4; 
            } 
        else  
            { 
            $_SESSION['LOGGEDIN'] = 1; 
            if (ereg(",", $_SESSION['APCMS']['USER']['usergroup'])) 
                { 
                $mygroups = explode(",", trim($_SESSION['APCMS']['USER']['usergroup'])); 
                $mgcc=0; 
                for ($mgc=0;$mgc<count($mygroups);$mgc++) 
                    { 
                    if (trim($mygroups[$mgc]) != "") 
                        { 
                        $_SESSION['USERGROUPS'][$mgcc] = intval(trim($mygroups[$mgc])); 
                        $mgcc++; 
                        } 
                    } 
                } 
            else  
                { 
                $_SESSION['USERGROUPS'][0] = intval(trim($_SESSION['APCMS']['USER']['usergroup'])); 
                } 
            } 
        } 
    } 
else  
    { 
    unset($_SESSION['APCMS']['USER']); 
    unset($_SESSION['LOGGEDIN']); 
    $_SESSION['USERGROUPS'][0] = 4; 
    } 
 
/** Kontrollieren ob Array $_SESSION['ACTIONRIGHTS'] vorhanden, wenn nicht, dann Actions aus DB holen */ 
if(!isset($_SESSION['ACTIONRIGHTS']) || count($_SESSION['ACTIONRIGHTS']) <= 0) 
    { 
    $query = "SELECT `action`,`groups` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_action_rights` WHERE `active`='1'";   
    $getactions_return = $db->unbuffered_getAll_row($query); 
    for ($dbcount=0;$dbcount<count($getactions_return);$dbcount++) 
        { 
        $_SESSION['ACTIONRIGHTS'][$getactions_return[$dbcount][0]] = unserialize(stripslashes(trim($getactions_return[$dbcount][1]))); 
        } 
    }

if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
	$CLIENT_LANG = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
if (isset($CLIENT_LANG) && trim($CLIENT_LANG)!="") 
    { 
    if (ereg("-", $CLIENT_LANG)) 
        { 
        $SETLOCALE_LANG = $CLIENT_LANG[0].$CLIENT_LANG[1]."_".ucfirst($CLIENT_LANG[3]).ucfirst($CLIENT_LANG[4]); 
        } 
    else 
        { 
        $SETLOCALE_LANG = $CLIENT_LANG[0].$CLIENT_LANG[1]."_".ucfirst($CLIENT_LANG[0]).ucfirst($CLIENT_LANG[1]); 
        } 
    $CLIENT_LANG = substr($CLIENT_LANG, 0, 2); 
    } 
else  
    { 
    $CLIENT_LANG = substr($_SESSION['APCMS']['CONFIG']['language'], 0, 2); 
    $SETLOCALE_LANG = $CLIENT_LANG[0].$CLIENT_LANG[1]."_".ucfirst($CLIENT_LANG[0]).ucfirst($CLIENT_LANG[1]); 
    } 
 
 
if(isset($_SESSION['LOGGEDIN']) && $_SESSION['LOGGEDIN'] == 1) 
    { 
    $timezone = $_SESSION['APCMS']['USER']['timezone']; 
    $_SESSION['APCMS']['STYLE'] = $_SESSION['APCMS']['USER']['style']; 
    $_SESSION['APCMS']['news_num'] = $_SESSION['APCMS']['USER']['news_num']; 
    if (!isset($_SESSION['APCMS']['USER']['language']) || trim($_SESSION['APCMS']['USER']['language']) == "") 
        { 
        $_SESSION['APCMS']['LANG'] = $CLIENT_LANG; 
        } 
    else  
        { 
        $_SESSION['APCMS']['LANG'] = $_SESSION['APCMS']['USER']['language']; 
        $SETLOCALE_LANG = $_SESSION['APCMS']['USER']['language'][0].$_SESSION['APCMS']['USER']['language'][1]."_".ucfirst($_SESSION['APCMS']['USER']['language'][0]).ucfirst($_SESSION['APCMS']['USER']['language'][1]); 
        } 
    } 
else 
    { 
    $timezone = $_SESSION['APCMS']['CONFIG']['timezone']; 
    $_SESSION['APCMS']['STYLE'] = $_SESSION['APCMS']['CONFIG']['style']; 
    $_SESSION['APCMS']['news_num'] = $_SESSION['APCMS']['CONFIG']['news_num']; 
    $_SESSION['APCMS']['LANG'] = $CLIENT_LANG; 
    } 



/** Farben */
$_COLOR['aliceblue'] = "#f0f8ff";
$_COLOR['antiquewhite'] = "#faebd7";
$_COLOR['aqua'] = "#00ffff";
$_COLOR['aquamarine'] = "#7fffd4";
$_COLOR['azure'] = "#f0ffff";
$_COLOR['beige'] = "#f5f5dc";
$_COLOR['bisque'] = "#ffe4c4";
$_COLOR['black'] = "#000000";
$_COLOR['blanchedalmond'] = "#ffebcd";
$_COLOR['blue'] = "#0000ff";
$_COLOR['bluevoilet'] = "#8a2be2";
$_COLOR['brown'] = "#a52a2a";
$_COLOR['burlywood'] = "#deb887";
$_COLOR['cadetblue'] = "#5f9ea0";
$_COLOR['chartreuse'] = "#7fff00";
$_COLOR['chocolate'] = "#d2691e";
$_COLOR['coral'] = "#ff7f50";
$_COLOR['cornflowerblue'] = "#6495ed";
$_COLOR['cornsilk'] = "#fff8dc";
$_COLOR['crimson'] = "#dc143c";
$_COLOR['cyan'] = "#00ffff";
$_COLOR['darkblue'] = "#00008b";
$_COLOR['darkcyan'] = "#008b8b";
$_COLOR['darkgoldenrod'] = "#b8860b";
$_COLOR['darkgray'] = "#a9a9a9";
$_COLOR['darkgreen'] = "#006400";
$_COLOR['darkkhaki'] = "#bdb76b";
$_COLOR['darkmagenta'] = "#8b008b";
$_COLOR['darkolivegreen'] = "#556b2f";
$_COLOR['darkorange'] = "#ff8c00";
$_COLOR['darkorchid'] = "#9932cc";
$_COLOR['darkred'] = "#8b0000";
$_COLOR['darksalmon'] = "#e9967a";
$_COLOR['darkseagreen'] = "#8fbc8f";
$_COLOR['darkslateblue'] = "#483d8b";
$_COLOR['darkslategray'] = "#2f4f4f";
$_COLOR['darkturquoise'] = "#00ced1";
$_COLOR['darkviolet'] = "#9400d3";
$_COLOR['deeppink'] = "#ff1493";
$_COLOR['deepskyblue'] = "#00bfff";
$_COLOR['dimgray'] = "#696969";
$_COLOR['dodgerblue'] = "#1e90ff";
$_COLOR['firebrick'] = "#b22222";
$_COLOR['floralwhite'] = "#fffaf0";
$_COLOR['forestgreen'] = "#228b22";
$_COLOR['fuchsia'] = "#ff00ff";
$_COLOR['gainsboro'] = "#dcdcdc";
$_COLOR['ghostwhite'] = "#f8f8ff";
$_COLOR['gold'] = "#ffd700";
$_COLOR['goldenrod'] = "#daa520";
$_COLOR['gray'] = "#808080";
$_COLOR['green'] = "#008000";
$_COLOR['greenyellow'] = "#adff2f";
$_COLOR['honeydew'] = "#f0fff0";
$_COLOR['hotpink'] = "#ff69b4";
$_COLOR['indianred'] = "#cd5c5c";
$_COLOR['indigo'] = "#4b0082";
$_COLOR['ivory'] = "#fffff0";
$_COLOR['khaki'] = "#f0e68c";
$_COLOR['lavender'] = "#e6e6fa";
$_COLOR['lavenderblush'] = "#fff0f5";
$_COLOR['lawngreen'] = "#7cfc00";
$_COLOR['lemonchiffon'] = "#fffacd";
$_COLOR['lightblue'] = "#add8e6";
$_COLOR['lightcoral'] = "#f08080";
$_COLOR['lightcyan'] = "#e0ffff";
$_COLOR['lightgoldenrodyellow'] = "#fafad2";
$_COLOR['lightgreen'] = "#90ee90";
$_COLOR['lightgrey'] = "#d3d3d3";
$_COLOR['lightpink'] = "#ffb6c1";
$_COLOR['lightsalmon'] = "#ffa07a";
$_COLOR['lightseagreen'] = "#20b2aa";
$_COLOR['lightskyblue'] = "#87cefa";
$_COLOR['lightslategray'] = "#778899";
$_COLOR['lightsteelblue'] = "#b0c4de";
$_COLOR['lightyellow'] = "#ffffe0";
$_COLOR['lime'] = "#00ff00";
$_COLOR['limegreen'] = "#32cd32";
$_COLOR['linen'] = "#faf0e6";
$_COLOR['magenta'] = "#ff00ff";
$_COLOR['maroon'] = "#800000";
$_COLOR['mediumaquamarine'] = "#66cdaa";
$_COLOR['mediumblue'] = "#0000cd";
$_COLOR['mediumorchid'] = "#ba55d3";
$_COLOR['mediumpurple'] = "#9370d8";
$_COLOR['mediumseagreen'] = "#3cb371";
$_COLOR['mediumslateblue'] = "#7b68ee";
$_COLOR['mediumspringgreen'] = "#00fa9a";
$_COLOR['mediumturquoise'] = "#48d1cc";
$_COLOR['mediumvioletred'] = "#c71585";
$_COLOR['midnightblue'] = "#191970";
$_COLOR['mintcream'] = "#f5fffa";
$_COLOR['mistyrose'] = "#ffe4e1";
$_COLOR['moccasin'] = "#ffe4b5";
$_COLOR['navajowhite'] = "#ffdead";
$_COLOR['navy'] = "#000080";
$_COLOR['oldlace'] = "#fdf5e6";
$_COLOR['olive'] = "#808000";
$_COLOR['olivedrab'] = "#688e23";
$_COLOR['orange'] = "#ffa500";
$_COLOR['orangered'] = "#ff4500";
$_COLOR['orchid'] = "#da70d6";
$_COLOR['palegoldenrod'] = "#eee8aa";
$_COLOR['palegreen'] = "#98fb98";
$_COLOR['paleturquoise'] = "#afeeee";
$_COLOR['palevioletred'] = "#d87093";
$_COLOR['papayawhip'] = "#ffefd5";
$_COLOR['peachpuff'] = "#ffdab9";
$_COLOR['peru'] = "#cd853f";
$_COLOR['pink'] = "#ffc0cb";
$_COLOR['plum'] = "#dda0dd";
$_COLOR['powderblue'] = "#b0e0e6";
$_COLOR['purple'] = "#800080";
$_COLOR['red'] = "#ff0000";
$_COLOR['rosybrown'] = "#bc8f8f";
$_COLOR['royalblue'] = "#4169e1";
$_COLOR['saddlebrown'] = "#8b4513";
$_COLOR['salmon'] = "#fa8072";
$_COLOR['sandybrown'] = "#f4a460";
$_COLOR['seagreen'] = "#2e8b57";
$_COLOR['seashell'] = "#fff5ee";
$_COLOR['sienna'] = "#a0522d";
$_COLOR['silver'] = "#c0c0c0";
$_COLOR['skyblue'] = "#87ceeb";
$_COLOR['slateblue'] = "#6a5acd";
$_COLOR['slategray'] = "#708090";
$_COLOR['snow'] = "#fffafa";
$_COLOR['springgreen'] = "#00ff7f";
$_COLOR['steelblue'] = "#4682b4";
$_COLOR['tan'] = "#d2b48c";
$_COLOR['teal'] = "#008080";
$_COLOR['thistle'] = "#d8bfd8";
$_COLOR['tomato'] = "#ff6347";
$_COLOR['turquoise'] = "#40e0d0";
$_COLOR['violet'] = "#ee82ee";
$_COLOR['wheat'] = "#f5deb3";
$_COLOR['white'] = "#ffffff";
$_COLOR['whitesmoke'] = "#f5f5f5";
$_COLOR['yellow'] = "#ffff00";
$_COLOR['yellowgreen'] = "#9acd32";






/** Include der Style-Konfiguration */ 
if (!isset($_SESSION['APCMS']['NAVBUTTONS']) || trim($_SESSION['APCMS']['NAVBUTTONS']['COLOR']) == "") 
    { 
    include($_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/configs/style.config.".$_SESSION['APCMS']['SUFFIX']); 
    /** Globale Rahmenfarbe der aeusseren Tabellen */ 
    $_SESSION['APCMS']['TABLE']['BGCOLOR']        =   $TABLE['BGCOLOR']; 
    /** Globale Tabellenbreite der aeusseren Tabellen */ 
    $_SESSION['APCMS']['TABLE']['WIDTH']          =   $TABLE['WIDTH']; 
    /** Style-Farben für HelpSystem (overlib) */ 
    $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']   =   $HELPSYSTEM['FGCOLOR']; 
    $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR']   =   $HELPSYSTEM['BGCOLOR']; 
    $_SESSION['APCMS']['HELPSYSTEM']['TEXTCOLOR'] =   $HELPSYSTEM['TEXTCOLOR']; 
    $_SESSION['APCMS']['HELPSYSTEM']['CAPCOLOR']  =   $HELPSYSTEM['CAPCOLOR']; 
    $_SESSION['APCMS']['NAVBUTTONS']['COLOR']     =   $NAVBUTTONS['COLOR']; 
    } 
 
 
 
 
if ($_SESSION['APCMS']['LANG'] == "de" || $_SESSION['APCMS']['LANG'] == "de_DE") 
    { 
    $_SESSION['APCMS']['LANG'] = "de_sie"; 
    } 
 
 
if (!isset($_SESSION['APCMS']['LANGPACK']) || trim($_SESSION['APCMS']['LANGPACK']['name']) == "") 
    { 
    $query = "SELECT `id`, `name` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_languagepacks` WHERE `browsercode`='".$_SESSION['APCMS']['LANG']."'"; 
    $sellangpack = $db->unbuffered_query_first($query); 
    if (!isset($sellangpack) || $sellangpack[0] == "" || $sellangpack[0] <= 0)
        {
        $CLIENT_LANG = substr($_SESSION['APCMS']['CONFIG']['language'], 0, 2); 
        if ($CLIENT_LANG == "de" || $CLIENT_LANG == "de_DE") 
            { 
            $_SESSION['APCMS']['LANG'] = "de_sie";
            }
        else 
            {
            $_SESSION['APCMS']['LANG'] = $CLIENT_LANG; 
            }
        $SETLOCALE_LANG = $CLIENT_LANG[0].$CLIENT_LANG[1]."_".ucfirst($CLIENT_LANG[0]).ucfirst($CLIENT_LANG[1]); 
        $query = "SELECT `id`, `name` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_languagepacks` WHERE `browsercode`='".$_SESSION['APCMS']['LANG']."'"; 
        $sellangpack = $db->unbuffered_query_first($query); 
        }
    $_SESSION['APCMS']['LANGPACK']['id'] = $sellangpack[0]; 
    $_SESSION['APCMS']['LANGPACK']['name'] = $sellangpack[1]; 
    }

$whichlang = setlocale (LC_ALL, $SETLOCALE_LANG); 
if (!isset($whichlang) || trim($whichlang) == "") 
    { 
    $SETLOCALE_LANG = substr($SETLOCALE_LANG, 0, 2); 
    $SETLOCALE_LANG = strtolower($SETLOCALE_LANG); 
    $whichlang = setlocale (LC_ALL, $SETLOCALE_LANG); 
    } 

if ($langfile=="content.index.php") 
    $WHERESTRING = "(`file`='content.index.php' OR `file`='header.full.php' OR `file`='footer.full.php' OR `file`='apcms_general.func.php') "; 
else 
    $WHERESTRING = "(`file`='".$langfile."' OR `file`='content.index.php' OR `file`='header.full.php' OR `file`='footer.full.php' OR `file`='apcms_general.func.php') "; 
$query = "SELECT `variable`, `text` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_language` WHERE `packid`='".$_SESSION['APCMS']['LANGPACK']['id']."' AND ".$WHERESTRING; 
$sellang = $db->unbuffered_getAll_row($query); 
for ($lc=0;$lc<count($sellang);$lc++) 
    { 
    $_LANGUAGE[$sellang[$lc][0]] = stripslashes($sellang[$lc][1]); 
    } 
 
 
 
/** Array der Zeitzonen */ 
$timezone_array = array 
    ( 
    '-12'   => " (GMT -12:00) Eniwetok|Kwajalein", 
    '-11'   => " (GMT -11:00) Midway-Island|Samoa", 
    '-10'   => " (GMT -10:00) Hawaii", 
    '-9'    => " (GMT -09:00) Alaska", 
    '-8'    => " (GMT -08:00) Tijuana|Pacific Time (US & Canada)", 
    '-7'    => " (GMT -07:00) Arizona|Mountain Time (US & Canada)", 
    '-6'    => " (GMT -06:00) Saskatchewan|Mexico City|Central Time (US & Canada)", 
    '-5'    => " (GMT -05:00) Bogot&aacute;|Lima|Quito|Eastern Time (US & Canada)", 
    '-4'    => " (GMT -04:00) Caracas|La Paz|Atlantic Time (Canada)", 
    '-3.5'  => " (GMT -03:30) Newfoundland", 
    '-3'    => " (GMT -03:00) Brasilia|Buenos Aires|Georgetown|Gr&ouml;nland", 
    '-2'    => " (GMT -02:00) Mid-Atlantic", 
    '-1'    => " (GMT -01:00) Azores|Cape Verde Is.", 
    '0'     => " (GMT &plusmn;00:00) Casablanca|Monrovia|Dublin|Edinburgh|Lisbon|London", 
    '1'     => " (GMT +01:00) Amsterdam|Berlin|Bern|Rom|Stockholm|Wien|Paris", 
    '2'     => " (GMT +02:00) Athens|Istanbul|Minsk|Cairo|Jerusalem|Pretoria|Harare", 
    '3'     => " (GMT +03:00) Baghdad|Moscow|St. Petersburg|Nairobi|Kuwait", 
    '3.5'   => " (GMT +03:30) Teheran", 
    '4'     => " (GMT +04:00) Abu Dhabi|Muscat|Tbilisi", 
    '4.5'   => " (GMT +04:30) Kabul", 
    '5'     => " (GMT +05:00) Islamabad|Ekaterinburg|Karachi", 
    '5.5'   => " (GMT +05:30) Bombay|Kalkutta|New Delhi", 
    '5.75'  => " (GMT +05:45) Catmandu", 
    '6'     => " (GMT +06:00) Almaty|Colombo|Nowosibirsk|Dhaka", 
    '6.5'   => " (GMT +06:30) Rangun", 
    '7'     => " (GMT +07:00) Bangkok|Hanoi|Jakarta", 
    '8'     => " (GMT +08:00) Ulan Bator|Singapur|Taipei|Peking|Hongkong|Perth", 
    '9'     => " (GMT +09:00) Yakutsk|Osaka|Sapporo|Tokyo|Seoul", 
    '9.5'   => " (GMT +09:30) Adelaide|Darwin", 
    '10'    => " (GMT +10:00) Guam|Moresby|Hobart|Brisbane|Sydney|Vladivostok", 
    '11'    => " (GMT +11:00) Salomones|New Caledonian|Magadan", 
    '12'    => " (GMT +12:00) Auckland|Wellington|Fiji|Kamchatka|Marshall Is." 
    ); 
 
/** Zeitzone des Servers (vergl. mit $timezone_array) */ 
$server_zeit_unterschied = 1; 

/** 1. Tag der Woche (0: Sonntag, 1: Montag, etc... 6: Samstag) */ 
$first_day_of_the_week = 1; 
 
/** Aktueller Timestamp des Servers (ohne Beachtung der Zeitzonen!) */ 
$servertime=time(); 

/** Aktueller Timestamp des Servers (ohne Beachtung der Zeitzonen!) */ 
$now = $servertime; 

/** Aktueller Timestamp des Servers (ohne Beachtung der Zeitzonen!) */ 
$serverzeit = $servertime; 
 
/** Sommer- (1) oder Winterzeit (0) */ 
$summertime = (date("I", $serverzeit))-1; 
$server_zeit_unterschied = round(3600 * ($server_zeit_unterschied - $timezone + $summertime) * -1); 

/** Aktueller Timestamp (MIT Beachtung der Zeitzonen!) */ 
$date = $servertime + $server_zeit_unterschied; 

/** Aktueller Timestamp (MIT Beachtung der Zeitzonen!) */ 
$akt_zeit = $date; 

/** Aktueller Timestamp (MIT Beachtung der Zeitzonen!) */ 
$akt_time = $date; 

/** Aktueller Timestamp (MIT Beachtung der Zeitzonen!) */ 
$akt_date = $date; 

/** Timestamp der Installation (MIT Beachtung der Zeitzonen!) */ 
$akt_installdate = $_SESSION['APCMS']['CONFIG']['installdate']; 
$akt_year = intval(date("Y", $date)); 
$akt_month = intval(date("n", $date)); 
$akt_day = intval(date("j", $date)); 
$akt_hour = intval(date("G", $date)); 
$akt_minute= intval(date("i", $date)); 
$akt_second= intval(date("s", $date)); 
 
/** Jahr des getrigen Tages */ 
$yesterday_year = intval(date("Y", ($date-86400))); 
/** Monat des getrigen Tages */ 
$yesterday_month = intval(date("n", ($date-86400))); 
/** Tageszahl des getrigen Tages */ 
$yesterday_day = intval(date("j", ($date-86400))); 
/** Letzter Timestamp des getrigen Tages (23:59:59 Uhr) */ 
$yesterday_lasttstamp = mktime(23,59,59,$yesterday_month,$yesterday_day,$yesterday_year); 
/** Erster Timestamp des getrigen Tages (00:00:00 Uhr) */ 
$yesterday_firsttstamp = mktime(0,0,0,$yesterday_month,$yesterday_day,$yesterday_year); 
 
/** Jahr vor zwei Tagen */ 
$last2days_year = intval(date("Y", ($date-(86400*2)))); 
/** Monat vor zwei Tagen */ 
$last2days_month = intval(date("n", ($date-(86400*2)))); 
/** Tageszahl vor zwei Tagen */ 
$last2days_day = intval(date("j", ($date-(86400*2)))); 
/** Letzter Timestamp vor zwei Tagen (23:59:59 Uhr) */ 
$last2days_lasttstamp = mktime(23,59,59,$last2days_month,$last2days_day,$last2days_year); 
/** Erster Timestamp vor zwei Tagen (00:00:00 Uhr) */ 
$last2days_firsttstamp = mktime(0,0,0,$last2days_month,$last2days_day,$last2days_year); 
 
$last3days_year = intval(date("Y", ($date-(86400*3)))); 
$last3days_month = intval(date("n", ($date-(86400*3)))); 
$last3days_day = intval(date("j", ($date-(86400*3)))); 
$last3days_lasttstamp = mktime(23,59,59,$last3days_month,$last3days_day,$last3days_year); 
$last3days_firsttstamp = mktime(0,0,0,$last3days_month,$last3days_day,$last3days_year); 
 
$last4days_year = intval(date("Y", ($date-(86400*4)))); 
$last4days_month = intval(date("n", ($date-(86400*4)))); 
$last4days_day = intval(date("j", ($date-(86400*4)))); 
$last4days_lasttstamp = mktime(23,59,59,$last4days_month,$last4days_day,$last4days_year); 
$last4days_firsttstamp = mktime(0,0,0,$last4days_month,$last4days_day,$last4days_year); 
 
$last5days_year = intval(date("Y", ($date-(86400*5)))); 
$last5days_month = intval(date("n", ($date-(86400*5)))); 
$last5days_day = intval(date("j", ($date-(86400*5)))); 
$last5days_lasttstamp = mktime(23,59,59,$last5days_month,$last5days_day,$last5days_year); 
$last5days_firsttstamp = mktime(0,0,0,$last5days_month,$last5days_day,$last5days_year); 
 
$last6days_year = intval(date("Y", ($date-(86400*6)))); 
$last6days_month = intval(date("n", ($date-(86400*6)))); 
$last6days_day = intval(date("j", ($date-(86400*6)))); 
$last6days_lasttstamp = mktime(23,59,59,$last6days_month,$last6days_day,$last6days_year); 
$last6days_firsttstamp = mktime(0,0,0,$last6days_month,$last6days_day,$last6days_year); 
 
$last7days_year = intval(date("Y", ($date-(86400*7)))); 
$last7days_month = intval(date("n", ($date-(86400*7)))); 
$last7days_day = intval(date("j", ($date-(86400*7)))); 
$last7days_lasttstamp = mktime(23,59,59,$last7days_month,$last7days_day,$last7days_year); 
$last7days_firsttstamp = mktime(0,0,0,$last7days_month,$last7days_day,$last7days_year); 
 
$last14days_year = intval(date("Y", ($date-(86400*14)))); 
$last14days_month = intval(date("n", ($date-(86400*14)))); 
$last14days_day = intval(date("j", ($date-(86400*14)))); 
$last14days_lasttstamp = mktime(23,59,59,$last14days_month,$last14days_day,$last14days_year); 
$last14days_firsttstamp = mktime(0,0,0,$last14days_month,$last14days_day,$last14days_year); 
 
$last4weeks_year = intval(date("Y", ($date-(86400*28)))); 
$last4weeks_month = intval(date("n", ($date-(86400*28)))); 
$last4weeks_day = intval(date("j", ($date-(86400*28)))); 
$last4weeks_lasttstamp = mktime(23,59,59,$last4weeks_month,$last4weeks_day,$last4weeks_year); 
$last4weeks_firsttstamp = mktime(0,0,0,$last4weeks_month,$last4weeks_day,$last4weeks_year); 
 
$tsfdow = mktime(0, 0, 0, date("m",$akt_zeit), date("d",$akt_zeit), date("Y",$akt_zeit) ); 
$day_of_week = date('w',$tsfdow); 
while ($day_of_week != "$first_day_of_the_week") 
    { 
    $tsfdow -= 86400; 
    $day_of_week = date('w',$tsfdow); 
    } 

/** Erster Timestamp von dieser aktuellen Woche ($first_day_of_the_week 00:00:00 Uhr) */ 
$tstamp_firstdayofweek = intval($tsfdow); 
$onlinetimeout_minutes = round($_SESSION['APCMS']['CONFIG']['online_timeout']/60, 2); 
$dateformat = "d.m.Y"; 
$timeformat = "H:i:s"; 
$datetime_formatted = "%A, %e. %B %Y, %H:%M:%S"; 
if (preg_match("`^en`", $_SESSION['APCMS']['LANG'])) 
    { 
    $dateformat = "m/d/Y"; 
    $timeformat = "h:i:s a"; 
    $datetime_formatted = "%A, %e. %B %Y, %I:%M:%S %p"; 
    } 
$ACTUALTIME_FORMATTED = strftime ($datetime_formatted, mktime ($akt_hour, $akt_minute, $akt_second, $akt_month, $akt_day, $akt_year)); 



/* Eventuelles Aktualisieren einer gecachten Datei */
$querystring = str_replace("s=".$contentinclude, "", preg_replace("`([\&\?]*?".session_name()."=[a-z0-9]*?)`iU", "", $_SERVER['QUERY_STRING'])); 
$querystring = str_replace("=", "", $querystring); 
$querystring = str_replace("&", "", $querystring); 
$querystring = str_replace("ainclude", "", $querystring); 
$querystring = str_replace("uinclude", "", $querystring); 
$querystring = htmlspecialchars((trim($querystring)!=""?$querystring:"")); 
$cachedinclude = md5(crypt($contentinclude, "CRYPT_MD5")); 
$cachedquery = md5(crypt($querystring, "CRYPT_MD5")); 
$cachedfile = $cachedinclude.$cachedquery; 
$cachedir = $_SESSION['APCMS']['STYLES_DIR']."/".$_SESSION['APCMS']['STYLE']."/cache"; 
$CACHEDFILE = array(); 
$query = "SELECT `filesize`,`lastupdate`,`mustupdate` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_cache` WHERE `filename`='".$cachedfile."'"; 
$retc = $db->unbuffered_query_first($query, 'row'); 
if (!isset($retc) || $retc[0] <= 0) 
    { 
    $CACHEDFILE['filesize'] = 0; 
    $CACHEDFILE['lastupdate'] = 0; 
    $CACHEDFILE['mustupdate'] = 1; 
    $must_update_cached_file = 1; 
    } 
else  
    { 
    $CACHEDFILE['filesize'] = $retc[0]; 
    $CACHEDFILE['lastupdate'] = $retc[1]; 
    $CACHEDFILE['mustupdate'] = $retc[2]; 
    $must_update_cached_file = $retc[2]; 
    } 












?>