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
function inicrond_mail($to, $subject, $message)
{
	global $_OPTIONS, $_RUN_TIME, $inicrond_db;
	
	if(!isset($_RUN_TIME['inicrond_mail']['usr_email']))//arent in cache yet.
	{
	
		if(isset($_SESSION['usr_id']))//get this email and this signature for sending tghe email.
		{
			$usr_id = $_SESSION['usr_id'];
		}
		else// get the admin paremeter from options.
		{
			$usr_id = $_OPTIONS['admin_usr_id'];
		}
	
		$query = "SELECT
		usr_email,
		usr_signature
		FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
		WHERE 
		usr_id=$usr_id";
		
		$rs = $inicrond_db->Execute($query);
		
		$fetch_result = $rs->FetchRow();
		
		$_RUN_TIME['inicrond_mail']['usr_email'] = $fetch_result['usr_email'];
		$_RUN_TIME['inicrond_mail']['usr_signature'] = BBcode_parser($fetch_result['usr_signature']);
	}
	
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "X-Mailer: PHP/" . phpversion().""."\r\n";
	
	/* D'autres en-t�es */
	$headers .= "To: ".$to."\r\n";
	$headers .= "From: ".$_RUN_TIME["inicrond_mail"]['usr_email']."\r\n";
	$headers .= "Reply-To: ".$_RUN_TIME["inicrond_mail"]['usr_email']."\r\n";
	$headers .= "Return-Path: ".$_RUN_TIME["inicrond_mail"]['usr_email']."\r\n";
	
	$message = $message."<br />".$_RUN_TIME['inicrond_mail']['usr_signature'];
	
	//echo $message;
	mail($to, $subject, $message, $headers);
	
	//echo $to."\r\n".$subject."\r\n".$message."\r\n".$headers."\r\n";
}

?>