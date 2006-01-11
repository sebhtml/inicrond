/*
    $Id$

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

/*
    the method that is called is init () and paint () and stop I think when the applet is stoped

    First parse the xml file

    Then show the title

    foreach label
        show the label and the target...
*/

/*

from : http://www.ictp.trieste.it/~manuals/programming/Java/tutorial/uiswing/overview/hierarchy.html

Tip:  To view the containment hierarchy for any frame or dialog, click its border to select it, and then press Control-Shift-F1. A list of the containment hierarchy will be written to the standard output stream.
*/
/*
TODO
    place the buttons source
        they are placed, but they seems to disappear ... lol [fixed]
    place the buttons destinations
        done

    show the title
        accepted 20050108 -- sebhtml

    add the path for the edit menu
        accepted 20050108 -- sebhtml

    background color
        rejected 20050108 -- sebhtml

    find an image and add it to the jar file to represent the arrow
    find a way to get the image is background ..
        Use Layers..

    auto set the dimensions of the button source
        done 20050108

    place the arrows over the image ...
*/

/*
    There is three layers :

    layer 1
        contains the image and the title

    layer 2
        contains the source and destination buttons
*/

/*
    Imports
*/


import java.io.InputStream ;
import javax.xml.parsers.DocumentBuilder ;
import javax.xml.parsers.DocumentBuilderFactory ;

import java.util.Vector ;

import org.w3c.dom.Document ;
import org.w3c.dom.Element ;
import org.w3c.dom.NodeList ;
import org.w3c.dom.Node ;

import java.net.URL ;
import java.net.MalformedURLException ;

import javax.swing.JLabel ;
import javax.swing.JButton ;
import javax.swing.JApplet ;
import javax.swing.JPanel ;
import javax.swing.ImageIcon ;
import javax.swing.JLayeredPane ;
import javax.swing.BorderFactory ;
import javax.swing.BoxLayout ;

import java.awt.Dimension ;
import java.awt.Graphics ;
import java.awt.Image ;
import java.awt.Container ;
import java.awt.Color ;
import java.awt.Insets ;
import java.awt.GridBagLayout ;

import java.awt.FlowLayout ;
import java.awt.BorderLayout ;
import java.awt.GridLayout ;

public class
JavaIdentificationsOnAFigure
extends JApplet
{
    private Image the_figure ;

    private Container container ;

    private JLayeredPane layers ;

    private String image_file_url ;
    private String title ;
    private int image_width ;
    private int image_height ;
    private String xml_file ;

    private ImageIcon imageIcon ;

    private int width ;
    private int height ;

    private JPanel rowPanel;

    private Vector java_identifications_on_a_figure_label ;

    private JPanel buttons_source_panel_north ;

    private JPanel buttons_source_panel_south ;

    private JLayeredPane myJLayeredPane ;

    private JLabel imageLabel ;

    public void
    init
    ()
    {
        java_identifications_on_a_figure_label = new Vector () ;

        /*
            the order of the methods call is very important!!
        */


        parse_html_parameters () ;

        try
        {
            parse_xml_file () ;
        }
        catch (Exception e)
        {
            System.out.println ("doh") ;
        }

        setSize(width, height);

        init_container () ;


        //place_the_title () ; // uncomment to see the title in the JApplet

        //debug_xml_parser_activities () ; // uncomment to see the debug ouput for xml parsing

        // to this point, I have parsed the xml file correctly!!!
        // plus, java seems to like utf-8 or maybe iso-8859-15 or even iso-8859-1
        // because the xml file is in utf-8 of course...

        place_the_source_buttons () ;

        showTheFigure () ;

        placeDestinationButtons () ;

    }

    private void
    parse_xml_file
    ()
    {
        URL xml_file_url  ;
        InputStream docFile  ;
        Document doc = null;

        try
        {
            xml_file_url = new URL (xml_file) ;
            docFile = xml_file_url.openStream () ;

            DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
            DocumentBuilder db = dbf.newDocumentBuilder();
            doc = db.parse(docFile);
        }
        catch (java.io.IOException e)
        {
            System.out.println("Can't find the file");
            System.out.println (e.getMessage ()) ;
        }
        catch (Exception e)
        {
            System.out.println("Problem parsing the file.");
        }

        // get the title

        NodeList title_node_list = doc.getElementsByTagName ("title") ;

        NodeList title_node_list_child_nodes = title_node_list.item (0).getChildNodes () ;

        System.out.println ("title_node_list_child_nodes.getLength () : " +title_node_list_child_nodes.getLength ()) ;

        System.out.println ("title_node_list_child_nodes.item (0).getNodeValue () : " +title_node_list_child_nodes.item (0).getNodeValue ()) ;

        title = title_node_list_child_nodes.item (0).getNodeValue () ;

        System.out.println("title_node_list.item (0).getNodeValue () : " + title_node_list.item (0).getNodeValue ());
        System.out.println("title : " + title);

        NodeList image_file_url_node_list = doc.getElementsByTagName ("image_file_url") ;

        NodeList image_file_url_node_list_child_nodes = image_file_url_node_list.item (0).getChildNodes () ;

        image_file_url = image_file_url_node_list_child_nodes.item (0).getNodeValue () ;

        System.out.println("image_file_url : " + image_file_url);

        NodeList java_identifications_on_a_figure_label_node_list = doc.getElementsByTagName ("java_identifications_on_a_figure_label") ;

        int node_list_lenght = java_identifications_on_a_figure_label_node_list.getLength () ;

        System.out.println("node_list_lenght : " + node_list_lenght);

        NodeList label_properties ;

        JavaIdentificationsOnAFigureLabel new_label ;

        int java_identifications_on_a_figure_label_id ;

        System.out.println("just before the loop man") ;

        for (int i = 0 ; i <= node_list_lenght - 1 ; i ++)
        {
            new_label = new JavaIdentificationsOnAFigureLabel () ; // reset it...

            label_properties = java_identifications_on_a_figure_label_node_list.item (i).getChildNodes () ;

            System.out.println("Whoa!, I am in the loop!!, i= "+i) ;

            System.out.println ("label_properties.getLength () : " +label_properties.getLength ()) ;

            for (int j = 0 ; j <= label_properties.getLength () -1 ; j ++)
            {
                System.out.println ("j = " + j) ;

                try
                {
                    System.out.println ("label_properties.item (j).getNodeName () = " + label_properties.item (j).getNodeName ()) ;
                }
                catch (Exception e)
                {
                    System.out.println (e.getMessage ()) ;
                }

                if (label_properties.item (j).getNodeName () == "#text")
                {
                    // do nothing dude ...
                    System.out.println ("I found a #text") ;
                }
                else if (label_properties.item (j).getNodeName () == "label_name")
                {
                    System.out.println ("I found a label_name") ;

                    System.out.println ("label_properties.item (0).getNodeName () : " +label_properties.item (j).getNodeName ()) ;

                    new_label.set_label_name (label_properties.item (j).getChildNodes ().item(0).getNodeValue ().trim ()) ;
                }
                else if (label_properties.item (j).getNodeName () == "java_identifications_on_a_figure_label_id")
                {
                    System.out.println ("label_properties.item (j).getChildNodes ().item(0).getNodeValue () :" + label_properties.item (j).getChildNodes ().item(0).getNodeValue ()) ;

                    System.out.println ("Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ()) : " + Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ().trim ())) ;

                    new_label.set_java_identifications_on_a_figure_label_id (Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ().trim ())) ;
                }
                else if (label_properties.item (j).getNodeName () == "x_position")
                {
                    System.out.println ("I found a x_position") ;

                    System.out.println ("label_properties.item (0).getNodeName () : " +label_properties.item (j).getNodeName ()) ;

                    new_label.set_x_position (Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ().trim ())) ;
                }
                else if (label_properties.item (j).getNodeName () == "y_position")
                {
                    System.out.println ("I found a y_position") ;

                    System.out.println ("label_properties.item (0).getNodeName () : " +label_properties.item (j).getNodeName ()) ;

                    new_label.set_y_position (Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ().trim ())) ;
                }
            }

            new_label.print_debug () ;

            java_identifications_on_a_figure_label.addElement (new_label) ;

            System.out.println ("end of for the i = " + i) ;
        }
    }

    /*
        from : http://forum.java.sun.com/thread.jspa?threadID=691177&tstart=30

        Hello,
        I built a JApplet with J-components (JButton, JTextField, JList...). When I don't write any paint method, there is no problem, but as soon as I add a paint method, my components appear only when the mouse comes over them ! Here is a simplified class which illustrate my problem, to try with and without paint method...

        In your paint method, make a call to :
        super.paint( Graphics g );
    */

    public void
    paint
    (Graphics g)
    {
        super.paint(g);

        /*
        int image_left_x ;
        int image_top_y ;

        image_left_x = width / 2 - the_figure.getWidth (this) / 2;
        image_top_y = height / 2 - the_figure.getHeight (this) / 2;


        g.drawImage (the_figure, image_left_x, image_top_y, this);
        */
    }

    private void
    place_the_source_buttons
    ()
    {
        System.out.println ("place_the_source_buttons call!!") ;

        int number_of_button_on_the_left ;
        int number_of_button_on_the_right ;

        int total_amount_of_buttons ;

        total_amount_of_buttons = java_identifications_on_a_figure_label.size () ;

        number_of_button_on_the_left = total_amount_of_buttons / 2 ;

        number_of_button_on_the_right = total_amount_of_buttons - number_of_button_on_the_left ;

        System.out.println ("total_amount_of_buttons : " + total_amount_of_buttons) ;
        System.out.println ("number_of_button_on_the_left : " + number_of_button_on_the_left) ;
        System.out.println ("number_of_button_on_the_right : " + number_of_button_on_the_right) ;

        /*
            we have the width and the height already ...
            let's say that we place button with a constant height and width...
            so if there is 8 buttons on each side
        */

        // set the size of all buttons ...

        for (int i = 0 ; i <= number_of_button_on_the_left -1 ; i ++)
        {
            JavaIdentificationsOnAFigureLabel button_tmp ;

            System.out.println ("i : " + i) ;

            button_tmp = (JavaIdentificationsOnAFigureLabel)java_identifications_on_a_figure_label.elementAt (i) ;

            // set the width, height, x and y of the button ...
            // set the  label too ...

            button_tmp.get_button_source ().setText (button_tmp.get_label_name ());

            button_tmp.print_debug () ;

            buttons_source_panel_south.add (button_tmp.get_button_source ()) ;
        }

        for (int i = number_of_button_on_the_left ; i <= total_amount_of_buttons - 1 ; i ++)
        {
            JavaIdentificationsOnAFigureLabel button_tmp ;

            System.out.println ("i : " + i) ;

            button_tmp = (JavaIdentificationsOnAFigureLabel)java_identifications_on_a_figure_label.elementAt (i) ;

            // set the width, height, x and y of the button ...
            // set the  label too ...

            button_tmp.get_button_source ().setText (button_tmp.get_label_name ());

            button_tmp.print_debug () ;

            buttons_source_panel_north.add (button_tmp.get_button_source ()) ;
        }

        System.out.println ("container.getComponentCount () " + container.getComponentCount ()) ;
    }

    private void
    placeDestinationButtons
    ()
    {
        int delta_from_top ;
        int delta_from_left ;

        final int DESTINATION_Z_INDEX = 400 ;
        final int DEFAULT_MARGIN = 0 ;
        final int BUTTON_WIDTH = 10 ;
        final int BUTTON_HEIGHT = 10 ;

        delta_from_left = (width - the_figure.getWidth (this)) / 2;

        delta_from_top = (height - the_figure.getHeight (this)) / 2;

        int total_amount_of_buttons ;

        total_amount_of_buttons = java_identifications_on_a_figure_label.size () ;

        for (int i = 0 ; i <= total_amount_of_buttons - 1 ; i ++)
        {
            JavaIdentificationsOnAFigureLabel button_tmp ;

            button_tmp = (JavaIdentificationsOnAFigureLabel)java_identifications_on_a_figure_label.elementAt (i) ;

            button_tmp.get_button_destination ().setLocation (button_tmp.get_x_position () + delta_from_left, button_tmp.get_y_position () + delta_from_top);

            button_tmp.get_button_destination ().setSize (new Dimension (BUTTON_WIDTH, BUTTON_HEIGHT));
            button_tmp.get_button_destination ().setMinimumSize (new Dimension (BUTTON_WIDTH, BUTTON_HEIGHT));
            button_tmp.get_button_destination ().setMaximumSize (new Dimension (BUTTON_WIDTH, BUTTON_HEIGHT));
            button_tmp.get_button_destination ().setPreferredSize (new Dimension (BUTTON_WIDTH, BUTTON_HEIGHT));

            //button_tmp.setBound (button_tmp.get_x_position () + delta_from_left, button_tmp.get_y_position () + delta_from_top, BUTTON_WIDTH, BUTTON_HEIGHT) ;

            Insets noInsets = new Insets (DEFAULT_MARGIN, DEFAULT_MARGIN, DEFAULT_MARGIN, DEFAULT_MARGIN) ;

            System.out.println ("button_tmp.get_x_position () + delta_from_left : " + (button_tmp.get_x_position () + delta_from_left)) ;

            System.out.println ("button_tmp.get_y_position () + delta_from_top : " + (button_tmp.get_y_position () + delta_from_top)) ;

            System.out.println ("BUTTON_WIDTH : " + BUTTON_WIDTH) ;

            System.out.println ("BUTTON_HEIGHT : " + BUTTON_HEIGHT) ;

            // store the icon you want to display in imageIcon

            button_tmp.get_button_destination ().setMargin(noInsets);
            button_tmp.get_button_destination ().setBorder(null);
            button_tmp.get_button_destination ().setContentAreaFilled(false);

            myJLayeredPane.add (button_tmp.get_button_destination (), DESTINATION_Z_INDEX + i) ;
        }
    }

    private void
    showTheFigure
    ()
    {
        URL the_figure_url ;

        final int IMAGE_ICON_Z_INDEX = 1 ;

        try
        {
            the_figure_url = new URL (image_file_url) ;

            the_figure = getImage (the_figure_url) ;
        }
        catch (Exception e)
        {
            System.out.println (e.getMessage ()) ;
        }

        imageIcon = new ImageIcon( the_figure );
        imageLabel = new JLabel(imageIcon);
        imageLabel.setBounds((width - imageIcon.getIconWidth ())/ 2, ((height ) / 2  - imageIcon.getIconHeight () / 2 -30)  , imageIcon.getIconWidth (), imageIcon.getIconHeight ());


        //debugShowTheFigure () ;

        myJLayeredPane.add (imageLabel, IMAGE_ICON_Z_INDEX) ;

    }

    private void
    debugShowTheFigure
    ()
    {
        JLabel label = new JLabel("2122");
        label.setVerticalAlignment(JLabel.TOP);
        label.setHorizontalAlignment(JLabel.CENTER);
        label.setOpaque(true);
        label.setBackground(new Color (44, 55, 66));
        label.setForeground(Color.black);
        label.setBorder(BorderFactory.createLineBorder(Color.black));
        label.setBounds(30, 40, 140, 140);

        System.out.println ("imageLabel.getY () + imageIcon.getIconHeight () / 2 : " + (imageLabel.getY () + imageIcon.getIconHeight () / 2)) ;
        System.out.println ("imageIcon.getIconHeight () / 2 : " + imageIcon.getIconHeight () / 2) ;
        System.out.println ("imageLabel.getY (): " + imageLabel.getY () ) ;

        JLabel label2 = new JLabel(""+imageLabel.getY ());
        label2.setVerticalAlignment(JLabel.TOP);
        label2.setHorizontalAlignment(JLabel.CENTER);
        label2.setOpaque(true);
        label2.setBackground(new Color (44, 55, 66));
        label2.setForeground(Color.black);
        label2.setBorder(BorderFactory.createLineBorder(Color.black));
        label2.setBounds(40, 50, 140, 140);


        myJLayeredPane.add (label, 20022) ;

        myJLayeredPane.add (label2, 20330) ;
    }

    private void
    place_the_title
    ()
    {
        JLabel label = new JLabel(title);

        container.add (label, BorderLayout.CENTER) ;
    }

    private void
    debug_xml_parser_activities
    ()
    {
        System.out.println (xml_file) ;

        int size_of_vector = java_identifications_on_a_figure_label.size () ;

        JavaIdentificationsOnAFigureLabel tmp_label ;

        for (int i = 0 ; i <= size_of_vector - 1 ; i ++)
        {
            System.out.println ("java_identifications_on_a_figure_label.elementAt (i).getClass ().getName () : " +java_identifications_on_a_figure_label.elementAt (i).getClass ().getName ()) ;

            System.out.println ("i = " + i) ;

            tmp_label = (JavaIdentificationsOnAFigureLabel)java_identifications_on_a_figure_label.elementAt (i) ;

            tmp_label.print_debug () ;
        }
    }

    private void
    parse_html_parameters
    ()
    {
        width = Integer.parseInt (getParameter ("width"));
        height = Integer.parseInt (getParameter ("height"));

        System.out.println ("getParameter (\"height\") : " + getParameter ("height")) ;

        xml_file = getParameter ("xml_file") ;
    }

    private void
    init_container
    ()
    {
        buttons_source_panel_north = new JPanel () ;
        buttons_source_panel_north.setLayout (new FlowLayout ()) ;

        buttons_source_panel_north.setBorder(BorderFactory.createLineBorder(Color.black));

        buttons_source_panel_south = new JPanel () ;
        buttons_source_panel_south.setLayout (new FlowLayout ()) ;

        buttons_source_panel_south.setBorder(BorderFactory.createLineBorder(Color.black));

        container = getContentPane () ;

        container.add (buttons_source_panel_north, BorderLayout.NORTH) ;
        container.add (buttons_source_panel_south, BorderLayout.SOUTH) ;

        myJLayeredPane = new JLayeredPane () ;

        myJLayeredPane.setBorder(BorderFactory.createLineBorder(Color.black));

        getContentPane ().add (myJLayeredPane) ;
    }
}
