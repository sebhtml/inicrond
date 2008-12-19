/*
    Code de Francis
*/c


import javax.swing.*;
import javax.swing.event.*;

import java.awt.*;
import java.awt.event.*;

import java.net.URL;

public class Test
    extends JFrame
    implements ActionListener
{
    private JButton pied;
    private JButton main;

    private JButton jambon;

    private JPanel rowPanel;

    public Test()
    {
        super();

        initUI();

        setSize( 640,480);
        show();
    }

    private void initUI()
    {
        Container c = getContentPane();

        JPanel west = new JPanel( new GridLayout( 0,1 ));
        c.add( west, BorderLayout.WEST );

        pied = newButton( west, "pied" );
        main = newButton( west, "main" );

        JPanel east = new JPanel( new GridLayout( 0,1 ));
        c.add( east, BorderLayout.EAST );


        jambon = newButton( east, "jambon" );


        ImageIcon imageIcon = new ImageIcon( the_image );
        JLabel imageLabel = new JLabel( imageIcon );
        c.add( imageLabel, BorderLayout.CENTER );
    }

    private JButton newButton( JPanel c, String label )
    {
        rowPanel = new JPanel( new FlowLayout() );

        JButton button = new JButton( label );
        button.addActionListener( this );

        rowPanel.add( button );
        c.add( rowPanel );

        return button;
    }

    public void actionPerformed( ActionEvent e )
    {
        if( e.getSource() == pied )
        {
            // bouton pied enfoncé
        }
        else if( e.getSource() == main )
        {
            // bouton main enfoncé
        }
    }

    public static void main (String args[])
    {
        Test t = new Test();
    }
}
