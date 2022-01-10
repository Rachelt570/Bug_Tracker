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
elseif($_POST['function'] == 'echoUsernameFromUID')
{
	$parameter = $_POST['parameters'];
	echoUsernameFromUID($Conn, $parameter);
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

	function echoUsernameFromUID($Conn, $UID)
	{
		$user = getUsernameByUID($Conn, $UID);
		echo json_encode($user);
	}

	function echoUsernameFromEmail($Conn, $Email)
	{
		$user = getUsernameByEmail($Conn, $Email);
		echo json_encode($user);
	}

	function echoUsernameFromUsername($Conn, $Username)
	{
		$user = getUsernameByUsername($Conn, $Username);
		echo json_encode($user);
	}