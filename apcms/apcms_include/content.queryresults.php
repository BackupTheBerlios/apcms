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



/** Include der Smarty-Klassen */
require_once ($_SESSION['APCMS']['LIB_DIR']."/smarty-libs/Smarty.class.".$_SESSION['APCMS']['SUFFIX']);

/** Neues Template starten */
$QUERYRESULTS = _APCMS_StartNewTemplate();

/////////////////////////////////////////////////////////////////////////////////
//  
//  Die eigentliche Abarbeitung von Funktionen und Variablen, beginnt hier
//  

$CONTENTTITEL = 'Query-Ergebnis';
$CONTENTINHALT = '';

$ROWNUM = (isset($_SESSION['POSTDATA'])&&count($_SESSION['POSTDATA']['queryreturn'])>=1?count($_SESSION['POSTDATA']['queryreturn']):0);
$COLNUM = (isset($_SESSION['POSTDATA'])&&count($_SESSION['POSTDATA']['queryreturn'][0])>=1?count($_SESSION['POSTDATA']['queryreturn'][0]):0);


require_once($_SESSION['APCMS']['CLASS_DIR']."/apcms_admintable.class.".$_SESSION['APCMS']['SUFFIX']);
$ADMINTABLE1 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
if (isset($_SESSION['POSTDATA']) && is_array($_SESSION['POSTDATA']['queryreturn']) && $ROWNUM >= 1 && $COLNUM >= 1)
    {
    $ADMINTABLE1->AddRow('
    <strong>Query: </strong>'._APCMS_SpecialChars($_SESSION['POSTDATA']['QUERYSTRING']).'<br />
    <strong>Zeit: </strong>'.$_SESSION['POSTDATA']['runtime'].' Sekunden<br />
    <strong>Spalten: </strong>'.$COLNUM.' '.($COLNUM>=2?"Spalten":"Spalte").' (Tabellen-Felder)<br />
    <strong>Zeilen: </strong>'.$ROWNUM.' '.($ROWNUM>=2?"Zeilen":"Zeile").' (Datensätze)', '', 2);
    }
elseif(!isset($_SESSION['POSTDATA'])) 
    {
    $ADMINTABLE1->AddRow('
    <strong>Ein Reload ist aus Sicherheitsgründen nicht möglich!</strong><br />
    Die Ergebnismenge ist leer.    
    ', '', 2);
    }
else 
    {
    $ADMINTABLE1->AddRow('
    <strong>Query: </strong>'.(isset($_SESSION['POSTDATA'])?_APCMS_SpecialChars($_SESSION['POSTDATA']['QUERYSTRING']):0).'<br />
    <strong>Zeit: </strong>'.(isset($_SESSION['POSTDATA'])?$_SESSION['POSTDATA']['runtime']:0).' Sekunden<br />
    <strong>Anzahl veränderter Datensätze: </strong>'.$ROWNUM, '', 2);
    }
$CONTENTINHALT .= $ADMINTABLE1->GetTable().($ROWNUM >= 1 && $COLNUM >= 1?"<br />":"");

if (isset($_SESSION['POSTDATA']) && is_array($_SESSION['POSTDATA']['queryreturn']) && $ROWNUM >= 1 && $COLNUM >= 1)
    {
    $ADMINTABLE2 = new APCMS_ADMINTABLE($_SESSION['APCMS']['TABLE']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'], $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR']);
    $color1 = $_SESSION['APCMS']['HELPSYSTEM']['BGCOLOR'];
    $color2 = $_SESSION['APCMS']['HELPSYSTEM']['FGCOLOR'];
    $color = $color2;
    $RESULTTABLE = "\n\n<table width=\"100%\" border=\"1\" cellspacing=\"1\" cellpadding=\"2\">\n";
    $color = ($color==$color1?$color2:$color1);
    $RESULTTABLE .= "   <tr>\n";
    foreach($_SESSION['POSTDATA']['queryreturn'][0] as $key => $val)
        {
        $RESULTTABLE .= "       <td bgcolor=\"".$color."\"><strong>"._APCMS_SpecialChars($key)."</strong></td>\n";
        }
    $RESULTTABLE .= "   </tr>\n";
    for ($a=0;$a<$ROWNUM;$a++)
        {
        $color = ($color==$color1?$color2:$color1);
        $RESULTTABLE .= "   <tr>\n";
        foreach($_SESSION['POSTDATA']['queryreturn'][$a] as $key => $val)
            {
            $RESULTTABLE .= "       <td bgcolor=\"".$color."\">".(trim($val)==""?"&nbsp;":_APCMS_SpecialChars(_APCMS_Truncate($val, 60, '...')))."</td>\n";
            }
        $RESULTTABLE .= "   </tr>\n";
        }
    $RESULTTABLE .= "</table>\n\n";
    $ADMINTABLE2->AddRow($RESULTTABLE, '', 2);
    $CONTENTINHALT .= $ADMINTABLE2->GetTable();
    }

$QUERYRESULTS->assign("CONTENTTITEL", $CONTENTTITEL);
$QUERYRESULTS->assign("CONTENTINHALT", $CONTENTINHALT);

//  
//  Die eigentliche Abarbeitung von Funktionen und Variablen, endet hier
//  
/////////////////////////////////////////////////////////////////////////////////
//  
//  Die eigentliche Ausgabe startet hier
//  

/* Ausgabe der HTML-Daten an den Browser */
$CONTENT = $QUERYRESULTS->fetch('content.'.$contentinclude.'.html');


//  
//  Die eigentliche Ausgabe endet hier
//  
/////////////////////////////////////////////////////////////////////////////////



?>