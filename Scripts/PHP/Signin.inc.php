<?php

if(!isset($_POST["LoginSubmit"]))
{
	header("Location: ../../Index.php");
	exit();
}


require_once "Helper.inc.php";
require_once "DBH.inc.php";

$loginName = $_POST["LoginUsername"];
$LoginPassword = $_POST["LoginPassword"];

$result = getUserByUsername($Conn, $loginName);
if(empty($result))
{
	header("Location: ../../Index.php?error=loginFailed");
	exit();
}

if(password_verify($LoginPassword, $result["Password"]))
{
	session_start();
	$_SESSION["Username"] = $result["Username"];
	$_SESSION["UID"] = $result["UID"];
	$_SESSION["Email"] = $result["Email"];
	header("Location: ../../Index.php?login=Success");
	exit();
}
else
{
	header("Location: ../../Index.php?loginFailed");
	exit();
}



