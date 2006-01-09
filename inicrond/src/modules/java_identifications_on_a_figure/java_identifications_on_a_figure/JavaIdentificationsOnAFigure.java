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
    auto set the dimensions of the button source
*/

/*
    Imports
*/

import java.io.InputStream ;
import javax.xml.parsers.DocumentBuilder ;
import javax.xml.parsers.DocumentBuilderFactory ;
import java.io.File ;
import org.w3c.dom.Document ;
import org.w3c.dom.Element ;
import org.w3c.dom.NodeList ;
import org.w3c.dom.Node ;
import java.net.URL ;

import java.util.Vector ;
import java.net.MalformedURLException ;

import java.applet.* ;
import javax.swing.* ;
// import java.awt.Graphics ;
// import java.awt.Color ;
import java.awt.Dimension ;
import java.awt.Graphics ;
import java.awt.Image ;
import java.awt.Container ;
import java.awt.Color ;

import java.awt.FlowLayout ;

import java.awt.Insets ;

public class
JavaIdentificationsOnAFigure
extends JApplet
{
    Image the_figure ;

    Container container ;

    String image_file_url ;
    String title ;
    int image_width ;
    int image_height ;
    String xml_file ;

    int width ;
    int height ;

    Vector java_identifications_on_a_figure_label = new Vector () ;

    public void
    init
    ()
    {
        /*
        Container content = getContentPane();
        content.setBackground(Color.white);
        content.setLayout(new FlowLayout());
        content.add(new JButton("Button 1"));
        content.add(new JButton("Button 2"));
        content.add(new JButton("Button 3"));
        */

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

        show_the_figure () ;
        set_background_color () ;
        place_the_title () ;
        debug_xml_parser_activities () ;

        // to this point, I have parsed the xml file correctly!!!
        // plus, java seems to like utf-8 or maybe iso-8859-15 or even iso-8859-1
        // because the xml file is in utf-8 of course...

        place_the_source_buttons () ;
        place_the_destination_buttons () ;

        //getContentPane ().add (new JButton ("popo34")) ;
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

        /*
        Element root = doc.getDocumentElement();

        System.out.println("The root element is " + root.getNodeName() + ".\n");
        */

        // get the title

        NodeList title_node_list = doc.getElementsByTagName ("title") ;

        //title = title_node_list.item (0).getNodeValue () ;

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
    public void
    stop
    ()
    {

    }
*/

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

        //g.drawString ("22", 50, 50) ;

        //getContentPane ().add (new JButton ("9")) ;

        int image_left_x ;
        int image_top_y ;

        image_left_x = width / 2 - the_figure.getWidth (this) / 2;
        image_top_y = height / 2 - the_figure.getHeight (this) / 2;

        //g.drawImage (the_figure, image_left_x, image_top_y, this);

    }

    private void
    place_the_source_buttons
    ()
    {

        System.out.println ("place_the_source_buttons call!!") ;

        int number_of_button_on_the_left ;
        int number_of_button_on_the_right ;

        int button_width ;
        int button_height ;

        int total_amount_of_buttons ;

        total_amount_of_buttons = java_identifications_on_a_figure_label.size () ;

        number_of_button_on_the_left = total_amount_of_buttons / 2 ;

        number_of_button_on_the_right = total_amount_of_buttons - number_of_button_on_the_left ;

        button_width = 120 ;
        button_height = 80 ;

        System.out.println ("total_amount_of_buttons : " + total_amount_of_buttons) ;
        System.out.println ("number_of_button_on_the_left : " + number_of_button_on_the_left) ;
        System.out.println ("number_of_button_on_the_right : " + number_of_button_on_the_right) ;

        /*
            we have the width and the height already ...
            let's say that we place button with a constant height and width...
            so if there is 8 buttons on each side
        */

        // set the size of all buttons ...
        JavaIdentificationsOnAFigureLabel button_tmp ;

        int button_on_the_left_x_location ;
        int button_on_the_left_y_location ;


        button_on_the_left_x_location = 10 ;
        button_on_the_left_y_location = 10 ;

       // JFrame jframe_that_holds_buttons = new JFrame () ;

        for (int i = 0 ; i <= number_of_button_on_the_left -1 ; i ++)
        {
            System.out.println ("i : " + i) ;

            button_tmp = (JavaIdentificationsOnAFigureLabel)java_identifications_on_a_figure_label.elementAt (i) ;

            // set the width, height, x and y of the button ...
            // set the  label too ...

            button_tmp.get_button_source ().setText (button_tmp.get_label_name ());

            button_tmp.get_button_source ().setLocation (button_on_the_left_x_location, button_on_the_left_y_location);

            button_tmp.get_button_source ().setSize (new Dimension (button_width, button_height));
            button_tmp.get_button_source ().setMinimumSize (new Dimension (button_width, button_height));
            button_tmp.get_button_source ().setMaximumSize (new Dimension (button_width, button_height));
            button_tmp.get_button_source ().setPreferredSize (new Dimension (button_width, button_height));

            //button_tmp.get_button_source ().setOpaque(false) ;

            //button_tmp.get_button_source ().setBounds (button_on_the_left_x_location, button_on_the_left_y_location, button_width, button_height) ;

            button_on_the_left_y_location += button_height + 10 ;

            button_tmp.print_debug () ;

            //jframe_that_holds_buttons.getContentPane ().add (button_tmp.get_button_source ()) ;

            container.add (button_tmp.get_button_source ()) ;
        }

        int button_on_the_right_x_location ;
        int button_on_the_right_y_location ;

        button_on_the_right_x_location = width - 10 - button_width; ;
        button_on_the_right_y_location = 10 ;


        for (int i = number_of_button_on_the_left ; i <= total_amount_of_buttons - 1 ; i ++)
        {
            System.out.println ("i : " + i) ;

            button_tmp = (JavaIdentificationsOnAFigureLabel)java_identifications_on_a_figure_label.elementAt (i) ;


            button_tmp.get_button_source ().setSize (new Dimension (button_width, button_height));
            button_tmp.get_button_source ().setMinimumSize (new Dimension (button_width, button_height));
            button_tmp.get_button_source ().setMaximumSize (new Dimension (button_width, button_height));
            button_tmp.get_button_source ().setPreferredSize (new Dimension (button_width, button_height));

            //button_tmp.get_button_source ().setOpaque(false) ;

            // set the width, height, x and y of the button ...
            // set the  label too ...

            button_tmp.get_button_source ().setText (button_tmp.get_label_name ());

            button_tmp.get_button_source ().setLocation (button_on_the_right_x_location, button_on_the_right_y_location);
            /*

            */

            //button_tmp.get_button_source ().setBounds (button_on_the_right_x_location, button_on_the_right_y_location, button_width, button_height) ;

            button_on_the_right_y_location += button_height + 10 ;

            button_tmp.print_debug () ;

            //jframe_that_holds_buttons.getContentPane ().add (button_tmp.get_button_source ()) ;

            container.add (button_tmp.get_button_source ()) ;
        }

        /*
        System.out.println ("adding the container_for_left_buttons in the main container") ;

        container.add (jframe_that_holds_buttons) ;

        System.out.println ("adding the container_for_right_buttons in the main container") ;

        container.add (container_for_right_buttons) ;
        */

        System.out.println ("container.getComponentCount () " + container.getComponentCount ()) ;

    }

    private void
    place_the_destination_buttons
    ()
    {
        int delta_from_top ;
        int delta_from_left ;


        int button_width = 10 ;
        int button_height = 10 ;

        delta_from_left = (width - the_figure.getWidth (this)) / 2;

        delta_from_top = (height - the_figure.getHeight (this)) / 2;

        JavaIdentificationsOnAFigureLabel button_tmp ;

        int total_amount_of_buttons ;

        total_amount_of_buttons = java_identifications_on_a_figure_label.size () ;

        for (int i = 0 ; i <= total_amount_of_buttons - 1 ; i ++)
        {
            button_tmp = (JavaIdentificationsOnAFigureLabel)java_identifications_on_a_figure_label.elementAt (i) ;

            button_tmp.get_button_destination ().setLocation (button_tmp.get_x_position () + delta_from_left, button_tmp.get_y_position () + delta_from_top);

            button_tmp.get_button_destination ().setSize (new Dimension (button_width, button_height));
            button_tmp.get_button_destination ().setMinimumSize (new Dimension (button_width, button_height));
            button_tmp.get_button_destination ().setMaximumSize (new Dimension (button_width, button_height));
            button_tmp.get_button_destination ().setPreferredSize (new Dimension (button_width, button_height));
            // button_tmp.get_button_destination ().setText ("2");

            //button_tmp.get_button_destination ().setOpaque(false) ;

            Insets noInsets = new Insets (0,0,0,0) ;
            // store the icon you want to display in imageIcon

            button_tmp.get_button_destination ().setMargin(noInsets);
            button_tmp.get_button_destination ().setBorder(null);
            button_tmp.get_button_destination ().setContentAreaFilled(false);

            container.add (button_tmp.get_button_destination ()) ;
        }
    }

    private void
    show_the_figure
    ()
    {
        URL the_figure_url ;

        try
        {
            the_figure_url = new URL (image_file_url) ;

            the_figure = getImage (the_figure_url) ;
        }
        catch (Exception e)
        {
            System.out.println (e.getMessage ()) ;
        }

    }

    private void
    place_the_title
    ()
    {
        JLabel title_label = new JLabel (title) ;

        title_label.setLocation (width / 2 - 15, 5) ;
        title_label.setSize (new Dimension (200, 20)) ;

        getContentPane ().add (title_label) ;
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
    set_background_color
    ()
    {
        // Color bg_color = new Color (0, 225, 250);

        // getContentPane ().setBackground (bg_color) ;
    }

    private void
    init_container
    ()
    {
        container = getContentPane () ;

        // set null if you want to..

        container.setLayout(null) ;

        //container.setBackground(Color.red) ;

        //container.setLayout(new FlowLayout ());
        //container.setLayout (new FlowLayout ()) ;
        //container.setLayout (new BorderLayout()) ;

        //container.setLayout (new GridBagLayout ()) ;
    }
}
