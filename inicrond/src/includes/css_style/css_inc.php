<?php
//$Id$

 /*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : styles
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : inicrond
//
//---------------------------------------------------------------------
*/
 

$output .= "
BODY
{
font-size: 0.8em;
font-family: Trebuchet MS, Bitstream Vera Sans, Verdana, Arial, Helvetica, sans-serif;

background-color:  ".$_OPTIONS["colors"]["bg"] .";
margin-top: 5;
margin-left: 5;
}



/* p class */



p.title
{

font-weight : bold;
color : ". $_OPTIONS["colors"]["texte"] .";
font-size: large;
}

p.forum_section_name
{

text-align:left;
font-weight : bold;
color : ". $_OPTIONS["colors"]["texte"] .";
font-size: large;
}





/* a class */

a
{
COLOR: 	 ".  $_OPTIONS["colors"]["liens"] .";
TEXT-DECORATION: underline;
}



A:hover
{
COLOR: 	 ".  $_OPTIONS["colors"]["a_over"] .";
TEXT-DECORATION: none;
}


/* TABLE CLASS */




td.windows_content
{
border-width: 1;
border-style: solid;
border-color :  ".$_OPTIONS["colors"]["window_border"] .";
background-color: ".$_OPTIONS["colors"]["window_content_bg"] .";
}

td.windows_title
{
border-top-width: 1;
border-left-width: 1;
border-right-width: 1;
border-bottom-width: 0;

border-style : solid;

border-color :  ".$_OPTIONS["colors"]["window_border"] .";
background-color:".  $_OPTIONS["colors"]["window_title_bg"] .";
color:".  $_OPTIONS["colors"]["window_title"] .";
}

td.ligne_paire
{
background-color:  ".$_OPTIONS["colors"]["couleur_ligne_1"] ."
}

td.ligne_impaire
{
background-color: ". $_OPTIONS["colors"]["couleur_ligne_2"] ."
}



 //-->"; 
 
 ?>
