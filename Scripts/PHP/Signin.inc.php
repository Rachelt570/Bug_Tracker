<?php
require_once "Globals.inc.php";

if(!isset($_POST["LoginSubmit"]))
{
	header("Location:".$WEBSITE_HOST."/Index.php");;
	exit();
}
require_once "Helper.inc.php";
require_once "DBH.inc.php";

$loginName = $_POST["LoginUsername"];
$LoginPassword = $_POST["LoginPassword"];
$result = getUserByUsername($Conn, $loginName);
if(empty($result))
{
	header("Location:".$WEBSITE_HOST."/Index.php?error=fafsaddf");
	exit();
}
if(password_verify($LoginPassword, $result["Password"]))
{
	session_start();
	$_SESSION["Username"] = $result["Username"];
	$_SESSION["UID"] = $result["UID"];
	$_SESSION["Email"] = $result["Email"];
	header("Location:".$WEBSITE_HOST."?login=Success");
	exit();
}
else
{
	header("Location:".$WEBSITE_HOST."/Index.php?loginFafasdfafadfafadsfdasfiled");
	exit();
}



