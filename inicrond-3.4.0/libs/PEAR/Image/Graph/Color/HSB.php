<?php
// +--------------------------------------------------------------------------+
// | Image_Graph aka GraPHPite                                                |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2003, 2004 Jesper Veggerby Hansen                          |
// | Email         pear.nosey@veggerby.dk                                |
// | Web           http://graphpite.sourceforge.net                           |
// | PEAR          http://pear.php.net/pepr/pepr-proposal-show.php?id=145     |
// +--------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU Lesser General Public               |
// | License as published by the Free Software Foundation; either             |
// | version 2.1 of the License, or (at your option) any later version.       |
// |                                                                          |
// | This library is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU        |
// | Lesser General Public License for more details.                          |
// |                                                                          |
// | You should have received a copy of the GNU Lesser General Public         |
// | License along with this library; if not, write to the Free Software      |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA |
// +--------------------------------------------------------------------------+

/**
 * Image_Graph aka GraPHPite - PEAR PHP OO Graph Rendering Utility.
 * @package color
 * @copyright Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 * @author Jesper Veggerby Hansen <pear.nosey@veggerby.dk>
 * @version $Id: HSB.php 8 2005-09-13 17:44:21Z sebhtml $
 */ 

/**
 * Include file Graph/Color.php
 */
require_once(IMAGE_GRAPH_PATH . "/Graph/Color.php");

/**
 * HSB (Hue, Saturation and Brightness) Color representation used for advanced
 * manipulation, such as setting alpha channel and/or calculating RGB values. 
 */
class Image_Graph_Color_HSB extends Image_Graph_Color 
{

    /** Allocate the color
     * @param int Hue The hue of the HSB color
     * @param int Saturation The saturation of the HSB color
     * @param int Brightness The brightness of the HSB color	 
     */
    function &Image_Graph_Color_HSB($hue, $saturation, $brightness)
    {
        parent::Image_Graph_Common();
        $this->_hue = $hue * 255 / 360;
        $this->_saturation = $saturation / 100;
        $this->_brightness = $brightness / 100;
        $this->_rGB();
    }

}
?>