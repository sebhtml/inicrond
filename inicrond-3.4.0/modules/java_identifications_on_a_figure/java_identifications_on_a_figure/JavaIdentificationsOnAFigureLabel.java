/*
    $Id: JavaIdentificationsOnAFigureLabel.java 103 2006-01-11 14:46:59Z sebhtml $

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005, 2006  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

import javax.swing.JButton ;
// import java.awt.* ;
import javax.swing.plaf.basic.BasicArrowButton ;

import java.awt.Font ;
import java.awt.Insets ;

// import javax.swing.plaf.basic.BasicArrowButton ;

public class
JavaIdentificationsOnAFigureLabel
/* extends nothind dude */
{
    private static final int BUTTON_MARGIN = 1 ;

    private String label_name ;

    // for the destination :
    private int x_position ;
    private int y_position ;

    private int java_identifications_on_a_figure_label_id ;

    private int java_identifications_on_a_figure_label_id_destination ;

    private JButton button_source ;
    private JButton button_destination ;

    public
    JavaIdentificationsOnAFigureLabel
    ()
    {
        button_source = new JButton () ;

        //button_source.setVisible (true) ;

        button_source.setMargin (new Insets (BUTTON_MARGIN, BUTTON_MARGIN, BUTTON_MARGIN, BUTTON_MARGIN)) ;


        Font myFont = new Font ("", 0, 11) ;

        button_source.setFont (myFont) ;

        //button_source.setModel () ;

        button_destination = new BasicArrowButton (0) ;
    }

    public JButton
    get_button_source
    ()
    {
        return button_source ;
    }

    public JButton
    get_button_destination
    ()
    {
        return button_destination ;
    }

    public int
    get_java_identifications_on_a_figure_label_id_destination
    ()
    {
        return java_identifications_on_a_figure_label_id_destination ;
    }

    public void
    set_java_identifications_on_a_figure_label_id_destination
    (int new_java_identifications_on_a_figure_label_id_destination)
    {
        java_identifications_on_a_figure_label_id_destination = new_java_identifications_on_a_figure_label_id_destination ;
    }

    public int
    get_java_identifications_on_a_figure_label_id
    ()
    {
        return java_identifications_on_a_figure_label_id ;
    }

    public void
    set_java_identifications_on_a_figure_label_id
    (int new_java_identifications_on_a_figure_label_id)
    {
        java_identifications_on_a_figure_label_id = new_java_identifications_on_a_figure_label_id ;
    }

    public int
    get_x_position
    ()
    {
        return x_position ;
    }

    public void
    set_x_position
    (int new_x_position)
    {
        x_position = new_x_position ;
    }

    public int
    get_y_position
    ()
    {
        return y_position ;
    }

    public void
    set_y_position
    (int new_y_position)
    {
        y_position = new_y_position ;
    }

    public String
    get_label_name
    ()
    {
        return label_name ;
    }

    public void
    set_label_name
    (String new_label_name)
    {
        label_name = new_label_name ;
    }

    public void
    print_debug
    ()
    {
        /*
            String label_name ;
            int x_position ;
            int y_position ;
            int java_identifications_on_a_figure_label_id ;

            int java_identifications_on_a_figure_label_id_destination ;

        */

        System.out.println ("java_identifications_on_a_figure_label_id_destination : " + java_identifications_on_a_figure_label_id_destination) ;
        System.out.println ("label_name : " + label_name) ;
        System.out.println ("x_position : " + x_position) ;
        System.out.println ("y_position : " + y_position) ;
        System.out.println ("java_identifications_on_a_figure_label_id : " + java_identifications_on_a_figure_label_id) ;


        System.out.println ("button_source.getX () : " + button_source.getX ()) ;
        System.out.println ("button_source.getY () : " + button_source.getY ()) ;

        System.out.println ("button_source.getWidth () : " + button_source.getWidth ()) ;
        System.out.println ("button_source.getHeight () : " + button_source.getHeight ()) ;
        System.out.println ("button_source.getText () : " + button_source.getText ()) ;


        System.out.println ("--") ;
    }
}