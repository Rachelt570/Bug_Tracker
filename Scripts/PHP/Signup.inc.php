<?php
require_once "Globals.inc.php";


function createUser($Conn, $Username, $Email, $Password)
{
	$sql = "INSERT INTO users (Username, Email, Password) VALUES (?, ?, ?);";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{	
		header("location:".$WEBSITE_HOST."/Signup.php?error=stmtFailed");
		exit();
	}
	$HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
	$stmt->bind_param("sss", $Username, $Email, $HashedPassword);
	$stmt->execute();
	$stmt->close();
	return;
}


if(!isset($_POST['SubmitSignup']))
{
	header("location:".$WEBSITE_HOST."/Signup.php?invalid");
	exit();
}
$Username = $_POST['Username'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
$PasswordConfirm = $_POST['PasswordConfirm'];

require_once "DBH.inc.php";
require_once "SignupErrorHandling.inc.php";

if(emptyInput($Username, $Email, $Password, $PasswordConfirm) !== False) 
{
	header("location:".$WEBSITE_HOST."/Signup.php?error=emptyInput");
	exit();
}
if(invalidUsername($Username) !== False)
{
	header("location:".$WEBSITE_HOST."/Signup.php?error=invalidUsername");
	exit();
}
if(invalidEmail($Email) !== False)
{
	header("location:".$WEBSITE_HOST."/Signup.php?error=invalidEmail");
	exit();
}
if(invalidPassword($Password) !== False)
{
	header("location:".$WEBSITE_HOST."/Signup.php?error=invalidPassword");
	exit();
}
if($Password !== $PasswordConfirm)
{
	header("location:".$WEBSITE_HOST."/Signup.php?error=PasswordMismatch");
	exit();
}
if(usernameExists($Conn, $Username) !== False)
{
	header("location:".$WEBSITE_HOST."/Signup.php?error=UsernameInUse");
	exit();
}
if(emailExists($Conn, $Email) !== False)
{
	header("location:".$WEBSITE_HOST."/Signup.php?error=EmailInUse");
	exit();
}

createUser($Conn, $Username, $Email, $Password);
session_start();
$User = getUserByUsername($Conn, $Username);
$_SESSION['UID'] = $User['UID'];
$_SESSION['Username']  = $User['Username'];
$_SESSION["Email"] = $User["Email"];

header("location:".$WEBSITE_HOST."/Signup.php?signup=SUCCESS");
exit();