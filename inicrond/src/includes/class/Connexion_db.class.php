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
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
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

if(isset($_OPTIONS["INCLUDED"]))
{

	class Connexion_db
	{
	var $requetes;//nombre de requetes
	
	
	var $SGBD;//tyype de gestionnaire
	// "mysql"
	
	var $id_connexion;//l'identifiant de connexion
	
	var $queries_list;
	
		//constructeur
		function Connexion_db()
		{
		$this->requetes = array(
		"SELECT" => 0,
		"DELETE" => 0,
		"UPDATE" => 0,
		"INSERT" => 0,
		"TOTAL" => 0
		);
		
		$queries_list = array();
		}
		
	//liste des mm�hodes
	/*
	choisir persistence x
	choisir serveur x
	choisir password x
	choisir user x
	choisir database x
	connection au serveur x
	
	choix de la db x
	
	free result x
	insert_id x
	
	query x
	
	fetch_Assoc x
	*/
		function set_SGBD($string)
		{
			if($string == "mysql")//type mysql
			{
			$this->SGBD = $string;
			}
		}
		
		function connect($serveur, $user, $password, $persistance)
		{
			if($this->SGBD == "mysql")//mysql
			{
				if($persistance == TRUE)//connexion persistante
				{
				$this->id_connexion = mysql_pconnect($serveur, $user, $password);
				}
				else
				{
				$this->id_connexion = mysql_connect($serveur, $user, $password);
				}
			}
		
		}//fin de connect
		
		function query($sql)
		{
			if($this->SGBD == "mysql")//mysql
			{
			
			$this->queries_list []=  $sql;
			
				 if($query_result = mysql_query($sql, $this->id_connexion))
				 {
				 $debut = "^([ ]{0,}[\t]{0,}[\n]{0,}){0,}";
					if(preg_match("/".$debut."SELECT/Dm", $sql))
					{
					$this->requetes["SELECT"]++;
					}
					elseif(preg_match("/".$debut."INSERT/Dm", $sql))
					{
					$this->requetes["INSERT"]++;
					}
					elseif(preg_match("/".$debut."DELETE/Dm", $sql))
					{
					$this->requetes["DELETE"]++;
					}
					elseif(preg_match("/".$debut."UPDATE/Dm", $sql))
					{
					$this->requetes["UPDATE"]++;
					}
					{
					$this->requetes["TOTAL"]++;
					}
					return $query_result;
				 }
				 else
				 {
				// die(__LINE__);
				die("line #:".__LINE__."sql= ".$sql." : ".$this->error());
				// return $query_result;
				 }
			
			}
		}
		function insert_id()
		{
			if($this->SGBD == "mysql")//mysql
			{
			
			return mysql_insert_id();
			
			}
		}
		
		function select_db($database)
		{
			if($this->SGBD == "mysql")//mysql
			{
			
			return mysql_select_db($database);
			
			}
		}
		function free_result($query_result)
		{
			if($this->SGBD == "mysql")//mysql
			{
			
			return mysql_free_result($query_result);
			
			}
		}
		
		function fetch_assoc($query_result)
		{
			if($this->SGBD == "mysql")//mysql
			{
				
				return mysql_fetch_assoc($query_result);
				/*
				if(!($fetch_result = mysql_fetch_assoc($query_result)))
				{
			die(__LINE__." : ".$this->error());	
				}
				 else
				 {
				return $fetch_result;
				 }
		*/
			
			}
		}
		function fetch_row($query_result)
		{
			if($this->SGBD == "mysql")//mysql
			{
			
			return mysql_fetch_row($query_result);
			
			}
		}
		function stats()
		{
		return $this->requetes;
		}
		

		function sql_file($sql_file)
		{


		$fichier = $sql_file ;

		$taille = fileSize($fichier) ;

		$fp = fopen($fichier, "r");

		$sql = fread($fp, $taille) ;
		fclose($fp);

		$sql = sql_parser_remove_remarks($sql);

		$sql = sql_parser_split_queries($sql);

		$count_sql = count($sql);

			for($i=0;$i<$count_sql;$i++)
			{

			$query = $sql[$i];

				if(!mysql_query($query))
				{
				die($this->error());
				}

			}


		return TRUE;
		}
		
		function num_rows($query_result)
		{
			if($this->SGBD == "mysql")//mysql
			{
			
			return mysql_num_rows($query_result);
			
			}
		}
		
		function error()
		{
			if($this->SGBD == "mysql")//mysql
			{
		
			return $this->last_query()." ".mysql_error();
			
			}
		}
		function last_query()
		{
			if($this->SGBD == "mysql")//mysql
			{
		
			$indice = count($this->queries_list) -1;
			
			return $this->queries_list[$indice];
			
			}
		}

	}	
}

?>
