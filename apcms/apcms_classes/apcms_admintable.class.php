<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | APCMS v0.0.2                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2004 APP - Another PHP Program                    |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2 of the GPL,                 |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// | If you did not receive a copy of the GPL license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | <dma147 at mieland-programming dot de> so we can mail you a copy     |
// | immediately.                                                         |
// +----------------------------------------------------------------------+
// | Authors: Alexander Mieland <dma147 at mieland-programming dot de>    |
// |          Eric Appelt <lacritima at php-lexikon dot de>               |
// +----------------------------------------------------------------------+
//
// +----------------------------------------------------------------------+
// $Id: apcms_admintable.class.php,v 1.1 2005/10/24 21:22:08 dma147 Exp $
// +----------------------------------------------------------------------+
// $RCSfile: apcms_admintable.class.php,v $
// $Revision: 1.1 $
// $Date: 2005/10/24 21:22:08 $
// $Author: dma147 $
// +----------------------------------------------------------------------+





/**
 * Klasse zur Erstellung einer zwei-spaltigen Tabelle
 *
 * @since          0.0.1
 * @version        0.0.2
 * @access         public
 * @return         void
 * @author         Alexander Mieland
 * @copyright      2000-2004 by APP - Another PHP Program
 */
class APCMS_ADMINTABLE
    {
    
    var $table_bg_color     =   '';
    
    var $color              =   '';
    
    var $color1             =   '';
    
    var $color2             =   '';
    
    var $ADMINTABLE         =   '';
    
    function APCMS_ADMINTABLE($tablebg="", $color1="", $color2="")
        {
        if ($tablebg!="")
            $this->table_bg_color = $tablebg;
        if ($color1!="")
            $this->color1 = $color1;
        if ($color2!="")
            $this->color2 = $color2;
        $this->color = $this->color1;
        $this->ADMINTABLE .= "\n".'<table bgcolor="'.$this->table_bg_color.'" align="center" border="0" cellpadding="3" cellspacing="1" width="100%">'."\n";
        $this->ADMINTABLE .= '    <tr>'."\n";
        $this->ADMINTABLE .= '      	<td valign="top" class="tB1L">'."\n";
        $this->ADMINTABLE .= '             <table bgcolor="'.$this->color2.'" width="100%" border="0" align="center" cellspacing="1" cellpadding="2">'."\n";
        }
    
    function OpenForm($name="", $action="")
        {
        $this->ADMINTABLE .= '                     <form name="'.$name.'" action="'.$action.'" method="POST" enctype="mutlipart/form-data">'."\n";
        }
    
    function AddRow($text1="", $text2="", $colspan=1)
        {
        $this->color = ($this->color==$this->color1?$this->color2:$this->color1);
        if ($colspan>=2)
            $this->ADMINTABLE .= '                     <tr><td colspan="2" align="left" valign="top"> '.$text1.' </td></tr>'."\n";
        else 
            {
            $this->ADMINTABLE .= '                     <tr><td width="60%" align="left" bgcolor="'.$this->color.'" valign="top"> '.$text1.' </td>'."\n";
            $this->ADMINTABLE .= '                     <td align="right" bgcolor="'.$this->color.'" valign="top"> '.$text2.' </td></tr>'."\n";
            }
        }
    
    function CloseForm()
        {
        $this->ADMINTABLE .= '                     </form>'."\n";
        }
    
    function GetTable()
        {
        $this->ADMINTABLE .= '</table></td></tr></table>'."\n";
        return $this->ADMINTABLE;
        }
    
    }



?>