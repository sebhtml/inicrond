
// required when you create an applet
import java.applet.*;
// required to paint on screen
import java.awt.*;
// These classes are for Url's.
import java.net.*;
import java.util.*;
import java.io.*;


//x 0 is left
//y 0 is top
public class JavaIdenficicationsOnAFigure extends Applet
{
    //constantes
  static final int NB_BUTTON_ON_BOTH_SIDE = 8;

  static final int SPACE_BETWEEN_BUTTON_AND_BORDER = 5;
  static final int BUTTON_WIDTH = 120;
  static final int BUTTON_HEIGHT = 30;
  static final int ORIGIN_X = 0;
  static final int ORIGIN_Y = 0;

//parameters
  String title_file;
  String arrows_location_file;
  String image_file;
  String button_names_file;


  int width;
  int height;


  ///////////////////--------

  //public static final float DEMI = 0.5;
  // Your image name;
  Image my_image;
  int button_v_space;
  int button_x;
  int button_y;

  // The applet base URL
  URL base;

  // This object will allow you to control loading
  MediaTracker mt;

  Button button_1;
  Button button_2;
  Button button_3;
  Button button_4;
  Button button_5;
  Button button_6;
  Button button_7;
  Button button_8;
  Button button_9;
  Button button_10;
  Button button_11;
  Button button_12;
  Button button_13;
  Button button_14;
  Button button_15;
  Button button_16;

/*
  Vector vector = new Vector ();
    vector.put (new String ());
  String a = (String) vector.get (0);



  String button = new String[16];
  */

  String button_1_title;
  String button_2_title;
  String button_3_title;
  String button_4_title;
  String button_5_title;
  String button_6_title;
  String button_7_title;
  String button_8_title;
  String button_9_title;
  String button_10_title;
  String button_11_title;
  String button_12_title;
  String button_13_title;
  String button_14_title;
  String button_15_title;
  String button_16_title;

  Color bg_color;

  //for image positionning.

  int image_left_x;
  int image_top_y;
/*
  static Map test;

  static {
        test.put("test",
  }*/
       // Identification_img.SPACE;
       // Identification_img.test;
  //String button_names_file_content;
// The method that will be automatically called  when the applet is started
  public void init ()
  {

    //get the parameters.
    // (image name,x,y,observer);
    base = getDocumentBase ();


    width = Integer.parseInt (getParameter ("width"));
    height = Integer.parseInt (getParameter ("height"));

    title_file = getParameter ("title_file");
    arrows_location_file = getParameter ("arrows_location_file");
    image_file = getParameter ("image_file");
    button_names_file = getParameter ("button_names_file");



    int button_v_space =
      (height -
       2 * SPACE_BETWEEN_BUTTON_AND_BORDER) / (NB_BUTTON_ON_BOTH_SIDE + 1);

      bg_color = new Color (0, 255, 250);

    // this will set the backgroundcolor of the applet
      setBackground (bg_color);


//get the names of the buttons
// command line parameter






/*
      new StringTokenizer
           ("This is the string to be tokenized", "\n");

while(st.hasMoreTokens()){
  String s=st.nextToken();
  System.out.println(s);
  }
  */
      try
    {



      //BufferedReader in = new BufferedReader (new File (new URI(button_names_file)));

        button_1_title = in.readLine ();
        button_2_title = in.readLine ();
        button_3_title = in.readLine ();
        button_4_title = in.readLine ();
        button_5_title = in.readLine ();
        button_6_title = in.readLine ();
        button_7_title = in.readLine ();
        button_8_title = in.readLine ();
        button_9_title = in.readLine ();
        button_10_title = in.readLine ();
        button_11_title = in.readLine ();
        button_12_title = in.readLine ();
        button_13_title = in.readLine ();
        button_14_title = in.readLine ();
        button_15_title = in.readLine ();
        button_16_title = in.readLine ();
        in.close ();
    }
    catch (IOException ex)
    {
      ex.printStackTrace ();

    }
    // setLayout (null);
    button_1 = new Button (button_1_title);
    button_2 = new Button (button_2_title);
    button_3 = new Button (button_3_title);
    button_4 = new Button (button_4_title);
    button_5 = new Button (button_5_title);
    button_6 = new Button (button_6_title);
    button_7 = new Button (button_7_title);
    button_8 = new Button (button_8_title);
    button_9 = new Button (button_9_title);
    button_10 = new Button (button_10_title);
    button_11 = new Button (button_11_title);
    button_12 = new Button (button_12_title);
    button_13 = new Button (button_13_title);
    button_14 = new Button (button_14_title);
    button_15 = new Button (button_15_title);
    button_16 = new Button (button_16_title);
    //buttons on the left.





    button_x = ORIGIN_X + SPACE_BETWEEN_BUTTON_AND_BORDER;
    button_y = ORIGIN_Y - BUTTON_HEIGHT / 2 + button_v_space;

    //buttons on the left.
    //x, y, width, width
    button_1.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_2.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_3.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_4.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_5.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_6.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_7.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_8.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);

    //buttons on the right
    button_x =
      ORIGIN_X + width - BUTTON_WIDTH - SPACE_BETWEEN_BUTTON_AND_BORDER;
    button_y = ORIGIN_Y - BUTTON_HEIGHT / 2 + button_v_space;

    button_9.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_10.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_11.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_12.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_13.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_14.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_15.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);
    button_y += button_v_space;
    button_16.setBounds (button_x, button_y, BUTTON_WIDTH, BUTTON_HEIGHT);


    //add the buttons.
    add (button_1);
    add (button_2);
    add (button_3);
    add (button_4);
    add (button_5);
    add (button_6);
    add (button_7);
    add (button_8);
    add (button_9);
    add (button_10);
    add (button_11);
    add (button_12);
    add (button_13);
    add (button_14);
    add (button_15);
    add (button_16);




    my_image = getImage (base, image_file);

  }


// This method gets called when the applet is terminated
// That's when the user goes to another page or exits the browser.
  public void stop ()
  {
  }


// The standard method that you have to use to paint things on screen
// This overrides the empty Applet method, you can't called it "display" for example.

  public void paint (Graphics g)
  {
      //  super.paint(g);
    image_left_x = width / 2 - my_image.getWidth (this) / 2;
    image_top_y = height / 2 - my_image.getHeight (this) / 2;

    g.drawImage (my_image, image_left_x, image_top_y, this);



  }

}
