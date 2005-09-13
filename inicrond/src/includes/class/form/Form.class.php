<?php
//$Id$



/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : classe de connexion database
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond
//
//---------------------------------------------------------------------
*/
/*


http://www.gnu.org/copyleft/gpl.html

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


*/

if(__INICROND_INCLUDED__)
{
        
	class Form
	{
                
                
                var $myarray;//the obect list
                var $method;//POST OR GET
                var $enctype;//to send file via forms
                var $action;//to which file do I send the infos
                var $type;//2 colonne ou une
                /**
                * constructor
                *
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */
                function Form()
		{
                        $this->method = "";
                        $this->myarray = array();
                        $this->enctype = "";
                        $this->action = "";
                        $this->type = 2;
		}
                /**
                * add a base
                *
                * @param        object  $base  an html form object
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */		
                function add_base($base)
		{
                        $this->myarray []= array($base->get_text(), $base->get_form_o());
		}
                /**
                * set form method
                *
                * @param        string  $method  POST OR GET
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */			
                function set_method($method)
		{
                        $this->method = $method;
		}
                /**
                * set form type
                *
                * @param        string  $type  1 or 2 columns
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */
                function set_type($type)
		{
                        $this->type = $type;
		}
		
                /**
                * set action
                *
                * @param        string  $action  dynamic script to whom I send infos
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */
		function set_action($action)
		{
                        $this->action = "action=\"$action\"";
		}
		
                /**
                * set enctype for file sharing
                *
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */
                function enctype()
		{
                        $this->enctype = "enctype=\"multipart/form-data\"";
		}
                /**
                * html output
                *
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */
                function output()
		{
			if($this->type == 2)
			{
                                $contenu = "<form method=\"".$this->method."\" ".$this->enctype." ".$this->action." >";
                                
                                $contenu .= retournerTableauXY($this->myarray);
                                
                                $contenu .= "</form>";
			}
			elseif($this->type == 1)
			{
                                $tableau = array();
                                foreach($this->myarray AS $row)
				{
                                        $tableau []= array($row[0]."<br />".$row[1]);
                                        
				}
				
                                $contenu = "<form method=\"".$this->method."\" ".$this->enctype." ".$this->action." >";
                                $contenu .= retournerTableauXY($tableau);
                                $contenu .= "</form>";
			}
                        return $contenu;
			
		}
		
                
	}
}

?>
