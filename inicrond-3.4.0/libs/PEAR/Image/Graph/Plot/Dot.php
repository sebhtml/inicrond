<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - PEAR PHP OO Graph Rendering Utility.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or (at your
 * option) any later version. This library is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details. You should have received a copy of
 * the GNU Lesser General Public License along with this library; if not, write
 * to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Dot.php 8 2005-09-13 17:44:21Z sebhtml $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once  PEAR_PATH.'Image/Graph/Plot.php';

/**
 * Dot / scatter chart (only marker).
 *
 * This plot type only displays a {@link Image_Graph_Marker} for the datapoints.
 * The marker must explicitly be defined using {@link Image_Graph_Plot::
 * setMarker()}.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Plot_Dot extends Image_Graph_Plot
{

    /**
     * Perform the actual drawing on the legend.
     *
     * @param int $x0 The top-left x-coordinate
     * @param int $y0 The top-left y-coordinate
     * @param int $x1 The bottom-right x-coordinate
     * @param int $y1 The bottom-right y-coordinate
     * @access private
     */
    function _drawLegendSample($x0, $y0, $x1, $y1)
    {
    }

    /**
     * Output the plot
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (Image_Graph_Plot::_done() === false) {
            return false;
        }

        $this->_driver->startGroup(get_class($this) . '_' . $this->_title);
        
        $this->_drawMarker();
        
        $this->_driver->endGroup();
        
        return true;
    }
}

?>