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



/**
 * Klasse zur Erstellung eines Menues
 *
 * @since          0.0.1
 * @version        0.0.2
 * @access         public
 * @return         void
 * @author         Alexander Mieland
 * @copyright      2000-2004 by APP - Another PHP Program
 */
class APCMS_ADMINMENUE
    {
    
    var $table_bg_color     =   '';
    
    var $cell_bg_color      =   '';
    
    var $cell_bg_hover      =   '';
    
    var $ADMINMENUE         =   '';
    
    function APCMS_ADMINMENUE($tablebg="", $cellbg="", $cellhover="")
        {
        if ($tablebg!="")
            $this->table_bg_color = $tablebg;
        if ($cellbg!="")
            $this->cell_bg_color = $cellbg;
        if ($cellhover!="")
            $this->cell_bg_hover = $cellhover;
        $this->ADMINMENUE = '<table bgcolor="'.$this->table_bg_color.'" border="0" width="100%" cellspacing="1" cellpadding="1">';
        }
    
    function AddEntry($name, $link, $marked=0)
        {
        if ($marked!=0)
            $cellbg = $this->cell_bg_hover;
        else 
            $cellbg = $this->cell_bg_color;
        $this->ADMINMENUE .= '<tr><td bgcolor="'.$cellbg.'" onMouseOver="this.bgColor=\''.$this->cell_bg_hover.'\'" onMouseOut="this.bgColor=\''.$cellbg.'\'" onClick="window.location.href=\''.$link.'\'"> <b>&raquo;</b> '._APCMS_MakeHref($link, $name).'</td></tr>';
        }
    
    function AddSubEntry($name, $link, $marked=0)
        {
        if ($marked!=0)
            $cellbg = $this->cell_bg_hover;
        else 
            $cellbg = $this->cell_bg_color;
        $this->ADMINMENUE .= '<tr><td bgcolor="'.$cellbg.'" onMouseOver="this.bgColor=\''.$this->cell_bg_hover.'\'" onMouseOut="this.bgColor=\''.$cellbg.'\'" onClick="window.location.href=\''.$link.'\'"> <b>&nbsp;&nbsp;&nbsp;  &raquo;</b> '._APCMS_MakeHref($link, $name).'</td></tr>';
        }
    
    function GetMenue()
        {
        $this->ADMINMENUE .= '</table>';
        return $this->ADMINMENUE;
        }
    
    }



?>