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
define ('__INICROND_INCLUDED__', TRUE);
define ('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if (isset ($_SESSION['usr_id']))	//profs seulement
  {
    /*
       si pas de cours_id : new
       si cours_id : edit
     */

    if (!isset ($_GET['cours_id']) AND $_SESSION['SUID'])
      {


	//-----------------------
	// titre
	//---------------------

	$module_title = $_LANG['add_course'];


	if (!isset ($_POST["envoi"]))
	  {




	    include "includes/forms/course.form.php";
	  }
	else
	  {





	    // filtrage des donn�s
	    //              include "includes/fonctions/fonctions_validation_inc.php";
	    include __INICROND_INCLUDE_PATH__.
	      "includes/functions/fonctions_validation.function.php";

	    $cours_code = filter ($_POST['cours_code']);
	    $cours_name = filter ($_POST['cours_name']);
	    $cours_description = filter ($_POST['cours_description']);
	    //$usr_id = $_SESSION['usr_id'];

	    $query = "INSERT INTO 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
                        (
                        cours_code,
                        cours_name,
                        cours_description
                        )
                        VALUES
                        (
                        '$cours_code',
                        '$cours_name',
                        '$cours_description'
                        )";

	    $inicrond_db->Execute ($query);
	    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";	//javascript redirection
	    js_redir (__INICROND_INCLUDE_PATH__.
		      "modules/courses/courses.php");



	  }
      }
    //
    //Only a course administrator can edit a course.
    //
    elseif (isset ($_GET['cours_id']) &&
	    $_GET['cours_id'] != "" &&
	    (int) $_GET['cours_id'] AND
	    is_teacher_of_cours ($_SESSION['usr_id'], $_GET['cours_id']))
    {



      //-----------------------
      // titre
      //---------------------
      $query = "SELECT
                cours_name
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
                WHERE
                cours_id=".$_GET['cours_id']."
                ;";

      $rs = $inicrond_db->Execute ($query);
      $fetch_result = $rs->FetchRow ();


      $module_title = $fetch_result['cours_name'];

      //--------------
      // existe-il ??
      //-------------

      $cours_id = $_GET['cours_id'];

      $query = "SELECT 
		cours_code,
		cours_name,
		cours_description
		FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
                WHERE
                cours_id=".$_GET['cours_id']."
                ";

      $rs = $inicrond_db->Execute ($query);
      $fetch_result = $rs->FetchRow ();

      if (isset ($fetch_result['cours_code']))	//est-ce qu'elle existe ?
	{

	  if (!isset ($_POST["envoi"]))
	    {


	      include "includes/forms/course.form.php";
	    }
	  else			// on apporte les chagements
	    {

	      // filtrage des donn�s
	      //              include "includes/fonctions/fonctions_validation_inc.php";
	      include __INICROND_INCLUDE_PATH__.
		"includes/functions/fonctions_validation.function.php";
	      $cours_code = filter ($_POST['cours_code']);
	      $cours_name = filter ($_POST['cours_name']);
	      $cours_description = filter ($_POST['cours_description']);


	      $query = "			UPDATE 
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
                                SET
                                cours_code='$cours_code',
                                cours_name='$cours_name',
                                cours_description='$cours_description'
                                
                                WHERE
                                cours_id=".$_GET['cours_id']."
                                ";

	      $inicrond_db->Execute ($query);
	      include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";	//javascript redirection                   
	      js_redir (__INICROND_INCLUDE_PATH__.
			"modules/courses/inode.php?&cours_id=".
			$_GET['cours_id']."");

	    }

	}

    }

  }
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>
