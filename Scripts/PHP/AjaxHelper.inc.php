<?php

session_start();
require_once "DBH.inc.php";
require_once "Helper.inc.php";

if(!isset($_POST['function']))
{
	exit();
}
if($_POST['function'] == 'echoSessionUID')
{
	echoSessionUID();
}
elseif($_POST['function'] == 'echoSessionUsername')
{
	echoSessionUsername();
}
elseif($_POST['function'] == 'echoSessionEmail')
{
	echoSessionEmail();	
}
//Session Variable Access
	function echoSessionData()
	{
		echoSessionUID();
		echoSessionUsername();
		echoSessionEmail();
		return;
	}
	function echoSessionUID()
	{
		echo $_SESSION['UID'];
	}
	function echoSessionUsername()
	{
		echo $_SESSION['Username'];
	}
	function echoSessionEmail()
	{
		echo $_SESSION['Email'];
	}

// get users

	function echoUserFromUID($UID)
	{
		$user = getUserFromUID($Conn, $UID);
		echo json_encode($user);
	}

	function echoUserFromEmail($Email)
	{
		$user = getUserFromEmail($Conn, $Email);
		echo json_encode($user);
	}

	function echoUserFromUsername($Conn, $Username)
	{
		$user = getUserFromUsername($Conn, $Username);
		echo json_encode($user);
	}