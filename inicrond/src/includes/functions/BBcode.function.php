<?php
//$Id$



/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

//
//---------------------------------------------------------------------
*/

/**
 * Parse a input with BBcode
 *
 * @param        string  $bb2html       the BBcode
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function BBcode_parser($bb2html)
{
//php source.
//$bb2html = preg_replace("/&lt;\?php(.+)\?&gt;/mUse",
// "highlight_string('<?php$1
/*?>', TRUE)",*/

	/* $bb2html);*/
	 

	
	//$bb2html = ;
	
	  $bb2html = preg_replace(
	  "/((<br \/>|\t| ){1}((http|ftp):\/\/[^< ]+)(<br \/>|\t| ){1})/emU", 
	"'<a href=\"$3\" target=\"_blank\">'.chop('$3').'</a>'", 
	$bb2html);
	
	/* 
	$bb2html = preg_replace(//le php code source argh!
	"/php/", 
	"hgh",

	 $bb2html);
	 */
	 
	/*
		"highlight_string(\"<?php\".'$1'.\"?>\", TRUE)",
		*/
	// die($bb2html);
	 
	  /*
	$bb2html = preg_replace("/(&lt;\?php.+\?&gt;)/Ume",
	 "highlight_string('$1', TRUE)",
	  $bb2html );
	  */

	  
	//images
	$bb2html = str_replace("[img]", "<img border=\"0\"  src=\"", $bb2html);
	$bb2html = str_replace("[/img]", "\" />", $bb2html);
	($bb2html);
	
	//bold
	$bb2html = str_replace("[b]", "<b>", $bb2html);
	$bb2html = str_replace("[/b]", "</b>", $bb2html);
	
	//big
	$bb2html = str_replace("[big]", "<big>", $bb2html);
	$bb2html = str_replace("[/big]", "</big>", $bb2html);
	
	//underline
	$bb2html = str_replace("[u]", "<u>", $bb2html);
	$bb2html = str_replace("[/u]", "</u>", $bb2html);
	
	//italic
	$bb2html = str_replace("[i]", "<i>", $bb2html);
	$bb2html = str_replace("[/i]", "</i>", $bb2html);
	
	//center
	$bb2html = str_replace("[center]", "<p align=\"center\">", $bb2html);
	$bb2html = str_replace("[/center]", "</p>", $bb2html);
		
		
	//".$_OPTIONS['table_prefix'].$_OPTIONS['tables']["wiki"]."
	
	//die($replace);//debug
	//$replace = "'<a href=\"../../modules/mod_wiki/wikii_inc.php?wiki_title=$1\">$1</a>'";
	
	//U: ungreedy, e: execute.
//$bb2html = preg_replace("/\[wiki\](.+)\[\/wiki\]/emU",	$replace, $bb2html);
	
	//justify
	$bb2html = preg_replace(
	"/\[justify\](.+)\[\/justify\]/mU",
	"<p align=\"justify\">$1</p>",
	 $bb2html);

	//liens
	//le U pour ungreedy.
	$bb2html = preg_replace("/\[url=(.+)\](.+)\[\/url\]/mU",
	 "<a href=\"$1\" target=\"_blank\">$2</a>", $bb2html);
	

	
	//hr
	$bb2html = str_replace("[hr]", "<hr />", $bb2html);
	
	
	
	$bb2html = str_replace("\n", "<br />", $bb2html);
	$bb2html = str_replace("&quot;","\"", $bb2html);		
	return "<div>".$bb2html."</div>";

}

?>
