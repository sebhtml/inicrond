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

    First parse the xml file

    Then show the title

    foreach label
        show the label and the target...

*/

/* for xml parser */

import java.io.*;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import java.io.File;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NodeList;
import org.w3c.dom.Node;
import java.net.URL;

import java.net.MalformedURLException;

import java.applet.*;
import javax.swing.*;
import java.awt.Graphics;
import java.awt.Color;

public class
JavaIdentificationsOnAFigure extends JApplet
{
    String image_file_url ;
    String title ;
    int image_width ;
    int image_height ;
    String xml_file ;

    int width ;
    int height ;

    JavaIdentificationsOnAFigureLabel [] java_identifications_on_a_figure_label ;

    int count_label ;

    public void
    init ()
    {
        width = Integer.parseInt (getParameter ("width"));
        height = Integer.parseInt (getParameter ("height"));
        xml_file = getParameter ("xml_file") ;

        count_label = 0 ;

        try
        {
            parse_xml_file () ;
        }
        catch (Exception e)
        {
            System.out.println ("doh") ;
        }

        Color bg_color = new Color (255, 255, 250);

        JLabel title_label = new JLabel ("222") ;

        getContentPane ().add (title_label) ;

        System.out.println (xml_file) ;

        setBackground (bg_color);

        System.out.println ("count_label : " + count_label) ;

        for (int i = 0 ; i <= count_label - 1 ; i ++)
        {
            java_identifications_on_a_figure_label[i].print_debug () ;
        }
    }

    private void
    parse_xml_file ()
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

        JavaIdentificationsOnAFigureLabel new_label = new JavaIdentificationsOnAFigureLabel ();

        System.out.println("just before the loop man") ;

        for (int i = 0 ; i <= node_list_lenght - 1 ; i ++)
        {
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
                }
                else if (label_properties.item (j).getNodeName () == "label_name")
                {
                    System.out.println ("label_properties.item (0).getNodeName () : " +label_properties.item (j).getNodeName ()) ;

                    new_label.set_label_name (label_properties.item (j).getChildNodes ().item(0).getNodeValue ()) ;
                }
                else if (label_properties.item (j).getNodeName () == "java_identifications_on_a_figure_label_id")
                {
                    System.out.println ("Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ()) : " + Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ())) ;

                    try
                    {
                        System.out.println ("label_properties.item (0).getNodeName () : " +label_properties.item (j).getNodeName ()) ;
                    }
                    catch (Exception e)
                    {
                        System.out.println (e.getMessage ()) ;
                    }

                    new_label.set_java_identifications_on_a_figure_label_id (Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ())) ;
                }
                else if (label_properties.item (j).getNodeName () == "x_position")
                {
                    System.out.println ("label_properties.item (0).getNodeName () : " +label_properties.item (j).getNodeName ()) ;

                    new_label.set_x_position (Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ())) ;
                }
                else if (label_properties.item (j).getNodeName () == "y_position")
                {
                    System.out.println ("label_properties.item (0).getNodeName () : " +label_properties.item (j).getNodeName ()) ;

                    new_label.set_y_position (Integer.parseInt (label_properties.item (j).getChildNodes ().item(0).getNodeValue ())) ;
                }
            }

            new_label.print_debug () ;

            java_identifications_on_a_figure_label[i] = new_label ;

            count_label ++ ;
        }
    }

    public void
    stop ()
    {

    }

    public void
    paint (Graphics g)
    {

    }
}
