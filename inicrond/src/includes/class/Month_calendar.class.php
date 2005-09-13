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
        
	class Month_calendar
	{
                
                
                var $year;//the year
                var $month;//the month
                var $_LANG;
                var $type;
                var $_RUN_TIME;
                var $nombre_de_jour;
                /**
                * set the column you want
                *
                * @param        integer  $month    month 1-12
                * @param        integer  $year    year 1970-~3000
                * @param        string  $type    "small OR "big"
                * @param        array  $week_days    $_LANG week days
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */
		function output()
		{
                        
                        $_LANG=$this->_LANG;
                        $month=$this->month;
                        $year=$this->year;
                        $type=$this->type;
                        $_RUN_TIME=$this->_RUN_TIME;
                        
                        $week_days = array(0,1,2,3,4,5,6);	
                        
                        
                        $this->nombre_de_jour = date("t", mktime(0, 0, 0, 1, $month, $year));//nombre de jours.
                        //cal_days_in_month(CAL_GREGORIAN,  $month, $year);
                        
                        //$this->contenu .= $nombre_de_jour;//debug
                        
                        $tableau = array();
                        $first = array();
                        
                        if($type == "small")
                        {
                                foreach($week_days AS $number )
                                {
                                        $first []= substr($_LANG["week_day_$number"], 0, 2);
                                }
                        }
                        elseif($type == "big")
                        {
                                foreach($week_days AS $number )
                                {
                                        $first [] = $_LANG["week_day_$number"];
                                }
                        }
                        
                        $tableau []= $first;
                        
                        $time_stamp = mktime( 0, 0,0,$month, 1, $year );//buig ici...
                        
                        //echo format_time_stamp(inicrond_mktime());
                        
                        $start_at = gmdate("w", $time_stamp);
                        
                        
                        
                        
                        //-----------
                        //le numéro d'aujourd'hui
                        //----------
                        
                        $aujour = date("j", inicrond_mktime()+$_SESSION['usr_time_decal']*60*60);
                        
                        
                        
                        $ligne = array();
                        
                        while($start_at != 0)
                        {
                                $ligne []= "&nbsp;";
                                $start_at--;
                        }
                        
                        if(count($ligne) == 7)
                        {
                                $tableau []= $ligne;
                                $ligne = array();
                        }
                        
                        
                        
                        for($i = 1;$i < $this->nombre_de_jour; $i++)
                        {
                                $bold_1 = $bold_2 = "";
                                
                                /*if($aujour == $i)
                                {
                                        $bold_1 = "<b>";
                                        $bold_2 = "</b>";
                                }	*/
                                
                                $ligne []= retournerHref(
                                "../../modules/calendar/main_inc.php?year=".$year."&month=".$month."&day=$i&cours_id=".$_GET['cours_id']."",
                                "$bold_1".$i."$bold_2");
                                
                                if(count($ligne) == 7)
                                {
                                        $tableau []= $ligne;
                                        $ligne = array();
                                }
                                
                        }
                        
                        if(count($ligne) != 0)
                        {
                                while(count($ligne) != 7)
                                {
                                        $ligne []= "&nbsp;";
                                }
                                $tableau []= $ligne;
                        }
                        
                        return $tableau;
                        
		}
                
                
                
	}	
}

?>
