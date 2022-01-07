<?php 


require_once "DBH.inc.php";
require_once "Helper.inc.php";

session_start();
if (!isset($_POST['ProfileNewPasswordSubmit']))
{
	header("Location:" . $WebsiteHost . "/Index.php?InvalidAccess");
	exit();
}
				
$oldPassword = $_POST['ProfileOldPassword'];
$newPassword = $_POST['ProfileNewPassword'];
$newPasswordConfirm = $_POST['ProfileNewPasswordConfirm'];

if($newPassword != $newPasswordConfirm)
{
	header("Location:" . $WebsiteHost . "/Index.php?error=PasswordMatch");
	exit();
}

$result = getUserByID($Conn, $_SESSION["UID"]);
if($oldPassword != password_ve	ify($oldPassword, $result["Password"]))
{
	header("Location:" . $WebsiteHost . "/Index.php?error=InvalidPassword" . $result);
	exit();
}

updatePassword($Conn, $_SESSION["UID"], $newPassword);
header("Location:" . $WebsiteHost . "/Index.php?=PasswordSuccessfullyChanged");
exit();