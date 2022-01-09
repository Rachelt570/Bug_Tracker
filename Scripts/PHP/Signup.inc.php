<?php


if(!isset($_POST['SubmitSignup']))
{
	header("location: ../../Signup.php?invalid");
	exit();
}

$Username = $_POST['Username'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
$PasswordConfirm = $_POST['PasswordConfirm'];

require_once "DBH.inc.php";
require_once "Helper.inc.php";

if(emptyInput($Username, $Email, $Password, $PasswordConfirm) !== False) 
{
	header("location: ../../Signup.php?error=emptyInput");
	exit();
}
if(invalidUsername($Username) !== False)
{
	header("location: ../../Signup.php?error=invalidUsername");
	exit();
}
if(invalidEmail($Email) !== False)
{
	header("location: ../../Signup.php?error=invalidEmail");
	exit();
}
if(invalidPassword($Password) !== False)
{
	header("location: ../../Signup.php?error=invalidPassword");
	exit();
}
if($Password !== $PasswordConfirm)
{
	header("location: ../../Signup.php?error=PasswordMismatch");
	exit();
}
if(usernameExists($Conn, $Username) !== False)
{
	header("location: ../../Signup.php?error=UsernameInUse");
	exit();
}
if(emailExists($Conn, $Email) !== False)
{
	header("location: ../../Signup.php?error=EmailInUse");
	exit();
}

createUser($Conn, $Username, $Email, $Password);
session_start();
$User = getUserByUsername($Conn, $Username);
$_SESSION['UID'] = $User['UID'];
$_SESSION['Username']  = $User['Username'];
$_SESSION["Email"] = $User["Email"];

header("location: ../../Index.php?signup=SUCCESS");
exit();