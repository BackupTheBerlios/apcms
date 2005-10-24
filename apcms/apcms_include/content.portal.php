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



$HEADER_LOCATION_STRING .= '&nbsp; &nbsp;&raquo;&nbsp; <a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX']."?s=portal".$_SESSION['SID2'].'"'._APCMS_HelpSystem($_LANGUAGE['portal_desc']).'>'.$_LANGUAGE['portal'].'</a>'; 
 
/** Anzeige des Standortes auf UserOnline */ 
$ONLINE_ANZEIGE = $_LANGUAGE['is_on_the'].' <a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=portal"{#if#enable_helpsys#}'._APCMS_HelpSystem($_LANGUAGE['portal_desc1']).'{#endif#enable_helpsys#}>'.$_LANGUAGE['portal'].'</a>.'; 
/** Alle User-Online-Updates durchzühren (den User betreffend) */ 
_APCMS_UpdateOnlineUser($ONLINE_ANZEIGE); 
$TITLE_LOCATION = $_LANGUAGE['portal'];

/** Prüfen ob Aktion active, also eingeschalten ist */ 
if (!_APCMS_ActionIsActive('portal')) 
    { 
    _APCMS_MsgBox($_LANGUAGE['portal_is_deactivated'], $_LANGUAGE['portal_is_deactivated_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH']); 
    } 
 
 
/** Prüfen ob der User die Aktion ausführen darf */ 
if (!_APCMS_UserAccess('portal')) 
    { 
    _APCMS_MsgBox($_LANGUAGE['no_access'], $_LANGUAGE['no_access_desc'], $_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].$_SESSION['SID1'], 3, 1, $_SESSION['APCMS']['TABLE']['WIDTH']); 
    } 
 
/** Include der Smarty-Klassen */ 
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']); 
 
/** Neues Template starten */ 
$PORTAL = _APCMS_StartNewTemplate(); 
 
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, beginnt hier 
//   
$NAV_TITEL = ''; 
$NAV_CONTENT = ''; 
$NAV_BOXES_LEFT     =   ''; 
$NAV_BOXES_RIGHT    =   ''; 
 
$PORTAL->assign("NAV_TITEL", $NAV_TITEL); 
$PORTAL->assign("NAV_CONTENT", $NAV_CONTENT); 
 
$query = "SELECT `id`,`boxarray` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_portal_boxsets` WHERE `site`='".$contentinclude."'"; 
$thisBoxSet = $db->unbuffered_query_first($query); 
if (intval($thisBoxSet[0]) <= 0 || $thisBoxSet[0] == "") 
    { 
    unset($thisBoxSet); 
    $query = "SELECT `id`,`boxarray` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_portal_boxsets` WHERE `site`='DEFAULT'"; 
    $thisBoxSet = $db->unbuffered_query_first($query); 
    } 
$BOXARRAY = unserialize(stripslashes($thisBoxSet[1])); 
$BOXARRAY_cnt = count($BOXARRAY); 
 
$WHERE = ""; 
for ($bcount=0;$bcount<$BOXARRAY_cnt;$bcount++) 
	{ 
	$WHERE .= ($WHERE!=""?" OR ":""); 
	$WHERE .= "`id`='".$BOXARRAY[$bcount]['id']."'"; 
	} 
 
unset($thisBoxes); 
unset($boxGroups); 
$query = "SELECT `id`,`titel`,`inhalt`,`groups` FROM `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_portal_navboxes` WHERE `active`='1' AND (".$WHERE.")"; 
$thisBoxes = $db->unbuffered_getAll_row($query); 
for ($bcount=0;$bcount<$BOXARRAY_cnt;$bcount++) 
	{ 
	unset($thisBox); 
	unset($boxGroups); 
	for ($tBc=0;$tBc<count($thisBoxes);$tBc++) 
	   { 
	   if ($thisBoxes[$tBc][0] == $BOXARRAY[$bcount]['id']) 
	       { 
	       $thisBox[0] = $thisBoxes[$tBc][0]; 
	       $thisBox[1] = $thisBoxes[$tBc][1]; 
	       $thisBox[2] = $thisBoxes[$tBc][2]; 
	       $thisBox[3] = $thisBoxes[$tBc][3]; 
	       break; 
	       } 
	   } 
	$boxGroups = unserialize(stripslashes($thisBox[3])); 
    if (!_APCMS_CanAccess($boxGroups)) break; 
	switch($thisBox[2]) 
		{ 
		case '{personality}': 
			$erg = fkt_personality(); 
			break; 
		case '{search}': 
			$erg = fkt_search(); 
			break; 
		case '{links}': 
			$erg = fkt_links(); 
			break; 
		case '{cats}': 
			$erg = fkt_cats(); 
			break; 
		case '{last_threads}': 
			$erg = fkt_last_threads(); 
			break; 
		case '{useronline}': 
			$erg = fkt_useronline(); 
			break; 
		case '{top5}': 
			$erg = fkt_top5(); 
			break; 
		case '{top5dlcnt}': 
			$erg = dl_top_count(); 
			break; 
		case '{top5dlvote}': 
			$erg = dl_top_vote(); 
			break;					 
		case '{staff}': 
			$erg = fkt_staff(); 
			break; 
		case '{stylestop}': 
			$erg = fkt_stylestop(); 
			break; 
		case '{quizz}': 
			unset($buffer); 
			ob_start(); 
			$oldlevel = error_reporting(0); 
			$isnavbox = 1; 
			$guestscanquizz = 1; 
			include("./quizz.php"); 
			error_reporting($oldlevel); 
			$buffer = ob_get_contents(); 
			ob_end_clean(); 
			$erg = $buffer; 
			break; 
		case '{formel1_wm_stand}': 
			unset($buffer); 
			ob_start(); 
			$oldlevel = error_reporting(0); 
			include("./formel1.info.php"); 
			error_reporting($oldlevel); 
			$buffer = ob_get_contents(); 
			ob_end_clean(); 
			$erg = $buffer; 
			break; 
		case '{formel1_last_race}': 
			unset($buffer); 
			ob_start(); 
			$oldlevel = error_reporting(0); 
			include("./formel1.service.php"); 
			error_reporting($oldlevel); 
			$buffer = ob_get_contents(); 
			ob_end_clean(); 
			$erg = $buffer; 
			break; 
		case '{soccer_playday}': 
			unset($buffer); 
			$soccer_typ = 1; 
			ob_start(); 
			$oldlevel = error_reporting(0); 
			include("./_soccer.inc"); 
			error_reporting($oldlevel); 
			$buffer = ob_get_contents(); 
			ob_end_clean(); 
			$erg = $buffer; 
			break; 
		case '{soccer_tables}': 
			unset($buffer); 
			$soccer_typ = 2; 
			ob_start(); 
			$oldlevel = error_reporting(0); 
			include("./_soccer.inc"); 
			error_reporting($oldlevel); 
			$buffer = ob_get_contents(); 
			ob_end_clean(); 
			$erg = $buffer; 
			break;	   
		default: 
			unset($matches); 
			preg_match_all ("/(\[)(php)(])(.*)(\[\/php\])/siU", $thisBox[2], $matches); 
			for ($countthis=0; $countthis<count($matches[0]); $countthis++) 
				{ 
				unset($buffer); 
				ob_start(); 
				$oldlevel = error_reporting(0); 
				eval($matches[4][$countthis]); 
				error_reporting($oldlevel); 
				$buffer = ob_get_contents(); 
				ob_end_clean(); 
				$thisBox[2] = str_replace($matches[0][$countthis], $buffer, $thisBox[2]); 
				} 
			$erg = $thisBox[2]; 
			break; 
		} 
	if($erg) 
		{ 
        $BOX = _APCMS_StartNewTemplate(); 
        $BOX->assign("NAV_TITEL", htmlspecialchars(stripslashes(chop(trim($thisBox[1]))))); 
        $BOX->assign("NAV_CONTENT", stripslashes(chop(trim($erg)))); 
        $BOX_C = $BOX->fetch('content.portal.navbox.html'); 
		if($BOXARRAY[$bcount]['side']==1)  
			$NAV_BOXES_LEFT .= $BOX_C; 
		else 
			$NAV_BOXES_RIGHT .= $BOX_C; 
		} 
	} 
 
 
/** News-Boxen auslesen und anzeigen */ 
$query = "SELECT  
                        news.`id` AS newsid, 
                        news.`userid` AS userid, 
                        news.`publicname` AS publicname, 
                        news.`time` AS time, 
                        news.`titel` AS titel, 
                        news.`text` AS text, 
                        newskats.`katpic` AS katpic, 
                        newskats.`groups` AS newsgroups, 
                        kats.`groups` AS katgroups 
        FROM  
                        `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_portal_news` AS news, 
                        `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_portal_newskats` AS newskats, 
                        `apcms_".$_SESSION['MYSQLDATA']['SUFFIX']."_portal_newskats` AS kats 
        WHERE  
                        news.`katid`=newskats.`id` 
                AND 
                        newskats.`parentid`=kats.`id`  
                AND  
                        newskats.`active`='1' 
        ORDER BY         
                        news.`time` DESC 
        LIMIT 
                        0,".$_SESSION['APCMS']['news_num']." 
        "; 
$newsselect = $db->unbuffered_getAll_row($query); 
$NEWSBOX_C = ""; 
for ($ncount=0;$ncount<count($newsselect);$ncount++) 
    { 
    if (_APCMS_CanAccess(stripslashes(chop(trim($newsselect[$ncount][7])))) && _APCMS_CanAccess(stripslashes(chop(trim($newsselect[$ncount][8]))))) 
        { 
        $NEWSBOX = _APCMS_StartNewTemplate(); 
        $NEWS_INFOS = 'written by '.(_APCMS_ActionIsActive('show_userdetails')&&_APCMS_UserAccess('show_userdetails')?'<a href="'.$_SESSION['APCMS']['REL_URL'].'/index.'.$_SESSION['APCMS']['SUFFIX'].'?s=userdetails&userid='.$newsselect[$ncount][1].$_SESSION['SID2'].'"'._APCMS_HelpSystem("<b>UserDetails</b><br />Klicken Sie hier, um sich Einzelheiten über diesen User anzusehen..").'>':'').htmlspecialchars(stripslashes(chop(trim($newsselect[$ncount][2])))).(_APCMS_ActionIsActive('show_userdetails')&&_APCMS_UserAccess('show_userdetails')?'</a>':'').' @ '.date("d.m.Y, H:i", $newsselect[$ncount][3]).''; 
        $NEWSBOX->assign("NEWS_TITEL", stripslashes(chop(trim($newsselect[$ncount][4])))); 
        $NEWSBOX->assign("NEWS_TEXT", nl2br(stripslashes(chop(trim($newsselect[$ncount][5]))))); 
        $NEWSBOX->assign("NEWS_INFOS", $NEWS_INFOS); 
        $NEWSBOX->assign("shownewskatpic", (chop(trim($newsselect[$ncount][6]))!=""?"1":"")); 
        $NEWSBOX->assign("ICON_NEWS_KAT", stripslashes(chop(trim($newsselect[$ncount][6])))); 
        $NEWSBOX_C .= $NEWSBOX->fetch('content.portal.newsbox.html'); 
        } 
    } 
 
 
 
 
 
 
/** Linke Navigation */ 
$PORTAL->assign("NAV_BOXES_LEFT", $NAV_BOXES_LEFT); 
/** Mittlerer Inhalt */ 
$PORTAL->assign("MIDDLE_BOXES", $NEWSBOX_C); 
/** Rechte Navigation */ 
$PORTAL->assign("NAV_BOXES_RIGHT", $NAV_BOXES_RIGHT); 
 
 
//   
//  Die eigentliche Abarbeitung von Funktionen und Variablen, endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
//   
//  Die eigentliche Ausgabe startet hier 
//   
 
/* Ausgabe der HTML-Daten an den Browser */ 
$CONTENT = $PORTAL->fetch('content.'.$contentinclude.'.html'); 
 
 
//   
//  Die eigentliche Ausgabe endet hier 
//   
///////////////////////////////////////////////////////////////////////////////// 
 
 
 
?>