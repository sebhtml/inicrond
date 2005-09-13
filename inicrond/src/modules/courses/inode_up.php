<?php
//$Id$
define ('__INICROND_INCLUDED__', TRUE);
define ('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include "includes/functions/access.fun.php";	//function for access...
include "includes/functions/transfert_cours.function.php";	//transfer IDs






if (is_teacher_of_cours
    ($_SESSION['usr_id'], inode_to_course ($_GET['inode_id'])))

  {
    //------------
    //Here I get the course in which the thing is...
    //----------



    //

    $query = "
        SELECT
        cours_id, inode_id_location, order_id, content_type
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        inode_id=".$_GET['inode_id']."
        ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    //print_R($fetch_result);

    $cours_id = $fetch_result['cours_id'];
    $inode_id_location = $fetch_result['inode_id_location'];
    $order_id_present = $fetch_result["order_id"];
    $content_type = $fetch_result["content_type"];
    //Get the one just before this one.
    $query = "
        SELECT
        MAX(order_id) AS order_id_other
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        order_id<$order_id_present
        AND
        inode_id_location=$inode_id_location
        AND
        cours_id=$cours_id
        AND
        content_type= '$content_type'
        ";



    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    /*
       echo $query;
       print_R($fetch_result);
       exit();
     */
    if (isset ($fetch_result["order_id_other"]))	//est-ce qu'il y a quelque chose avant.
      {

	$order_id_avant = $fetch_result["order_id_other"];
	//on va chercher la discussion avant.
	$query = "
                SELECT
                inode_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE
                order_id=".$fetch_result["order_id_other"].	//celui qui est avant
	  "
                ";


	$rs = $inicrond_db->Execute ($query);
	$fetch_result = $rs->FetchRow ();


	$inode_id_before = $fetch_result['inode_id'];


	$query =		//on met le order id du présent à celui avant.
	  "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                SET
                order_id=".$order_id_avant."
                WHERE
                inode_id=".$_GET['inode_id'].	//celui qui est avant
	  "
                ";

	$inicrond_db->Execute ($query);




	$query =		//celui qui est en haut descend
	  "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                SET
                order_id=".$order_id_present."
                WHERE
                inode_id=".$inode_id_before."
                
                ";

	$inicrond_db->Execute ($query);

      }

    $query = "
        SELECT
        cours_id,
        inode_id_location
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        inode_id=".$_GET['inode_id']."";


    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";	//javascript redirection
    js_redir ("inode.php?cours_id=".$fetch_result['cours_id'].
	      "&inode_id_location=".$fetch_result['inode_id_location']."");

  }
?>
