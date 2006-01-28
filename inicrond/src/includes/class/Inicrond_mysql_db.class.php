<?php
/*
    $Id$

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005  Sébastien Boisvert

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
Changes :

december 15, 2005
        I formated the code correctly.

                --sebhtml

    */
/*
this file contains the definition of the following classes :

Inicrond_mysql_results_set
FetchRow()

Inicrond_mysql_db
PConnect($server_name, $user_name, $password, $database_name)
Connect($server_name, $user_name, $password, $database_name)
Execute($query)
Insert_ID()
*/

class Inicrond_mysql_results_set//class of result set.
{//start of class.

        var $result_id;//the ressource

        function FetchRow()//fetch the row.
        {
                if($return = mysql_fetch_assoc($this->result_id))//if it return row
                {
                        return $return;//then return the row and continue
                }
                else//no more rows.
                {
                        mysql_free_result($this->result_id);//free_the_result.

                        return FALSE;//no more row.
                }
        }
}//end of class

class Inicrond_mysql_db//a abstration class, mysql only, call it like adodb.
{//start of class

        var $connexion_ressource;//the ressource id
        //all the information rrelative to the connexion are not kept for security reason.

        //persistency connexion
        function PConnect($server_name, $user_name, $password, $database_name)
        {
                $this->connexion_ressource=mysql_pconnect($server_name, $user_name, $password);//connect
                mysql_select_db($database_name, $this->connexion_ressource);//select the db
        }

        //normal connexion
        function Connect($server_name, $user_name, $password, $database_name)
        {
                $this->connexion_ressource=mysql_connect($server_name, $user_name, $password);//connect
                mysql_select_db($database_name, $this->connexion_ressource);//select the db
        }


        function Execute($query)//execute a query and return a result set if it has rows.
        {
                //get the result ressource identifier.
                $result_id = mysql_query($query, $this->connexion_ressource);

                //echo $query."<hr />";

                if(!$result_id)//false, mean an error.
                {
                        //output an red error message that is big and ugly.
                        echo "<table bgcolor=\"black\"><tr><td><span style=\"color: red; \">
                        <i>Query</i> : <br />".nl2br($query)."<br /><br /><i>Error message</i> : <br /> ".mysql_error()."</span></td></tr></table><br />";

                        return FALSE;//an error occured.
                }
                //if the ressource is a ressource and not a boolean
                elseif(is_resource($result_id))
                {
                        //return an object
                        $rs = new Inicrond_mysql_results_set;
                        $rs->result_id= $result_id;

                        return $rs;
                }
                else//return nothing because this query dont generate rows.
                {
                        return NULL;//dont return anything, the user dont ask anything...
                }
        }//end of Execute()

        function Insert_ID()//get the least insert id in the database...
        {
                return mysql_insert_id($this->connexion_ressource);
        }//end of Insert_ID()
}//end of class

?>