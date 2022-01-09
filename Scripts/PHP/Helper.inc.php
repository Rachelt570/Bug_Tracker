<?php

$WebsiteHost = "http://localhost/Bug-Tracker";
session_start();


if (isset($_POST['function']))
{

	if($_POST['function'] == "echoSessionUID")
	{
		echoSessionUID();
	}
	if($_POST['function'] == "echoSessionUsername")
	{
		echoSessionUsername();
	}
	if($_POST['function'] == "echoSessionEmail")
	{
		echoSessionEmail();
	}
}

function echoSessionUID() 
{
	echo ($_SESSION['UID']);
	return;
}
function echoSessionUsername()
{
	echo ($_SESSION['Username']);
	return;
}
function echoSessionEmail()
{
	echo ($_SESSION['Email']);
	return;
}

function UIDToUsername($UID)
{
	$User = getUserByID($UID);
	return $User['UID'];
}
function UsernameToUID($Username)
{
	$User = getUserByUsername($Username)
}
function emptyInput($Username, $Email, $Password, $PasswordConfirm) 
{
	return (empty($Username) || empty($Email) || empty($Password) || empty($PasswordConfirm));
}

function invalidUsername($Username)
{
	return !preg_match("/^[a-zA-Z0-9]*$/", $Username);
}

function invalidEmail($Email)
{
	return !filter_var($Email, FILTER_VALIDATE_EMAIL);
}

function invalidPassword($Password)
{
	return False;
}

function usernameExists($Conn, $Username)
{
	$sql = "SELECT * FROM users where Username = ?";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("location: ../../Signup.php?error=stmtFailed");
		exit();
	}	
	$stmt->bind_param("s", $Username);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$stmt->close();
	return !empty($row);
}

function emailExists($Conn, $Email)
{
	$sql = "SELECT * FROM users where Email = ?";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("location: ../../Signup.php?error=stmtFailed");
		exit();
	}	
	$stmt->bind_param("s", $Email);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$stmt->close();
	return !empty($row);
}

function getUserByID($Conn, $ID)
{
	$sql = "SELECT * FROM users where UID = ?"; 
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("location: ../../Signup.php?error=stmtFailed");
		exit();
	}
	$stmt->bind_param("s", $ID);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$stmt->close();
	return $row;
}

function getUserByUsername($Conn, $Username)
{
	$sql = "SELECT * FROM users where Username = ?"; 
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("location: ../../Signup.php?error=stmtFailed");
		exit();
	}
	$stmt->bind_param("s", $Username);
	$stmt->execute();
	$result = $stmt->get_result();
	if(mysqli_num_rows($result) == 0)
	{
		$stmt->close();
		return false;
	}
	$row = $result->fetch_array();
	$stmt->close();
	return $row;
}

function getUsernameByEmail($Conn, $Email)
{
	$sql = "SELECT * FROM users where Email = ?"; 
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("location: ../../Signup.php?error=stmtFailed");
		exit();
	}
	$stmt->bind_param("s", $Email);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$stmt->close();
	return $row;
}
function createUser($Conn, $Username, $Email, $Password)
{
	$sql = "INSERT INTO users (Username, Email, Password) VALUES (?, ?, ?);";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{	
		header("location: ../../Signup.php?error=stmtFailed");
		exit();
	}
	$HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
	$stmt->bind_param("sss", $Username, $Email, $HashedPassword);
	$stmt->execute();
	$stmt->close();
	return;
}

function updatePassword($Conn, $UID, $NewPassword)
{
	$sql = "UPDATE users SET Password = ? WHERE UID = ?;";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		exit();
	}
	$HashedPassword = password_hash($NewPassword, PASSWORD_DEFAULT);
	$stmt->bind_param("ss", $HashedPassword, $UID);
	$stmt->execute();
	$stmt->close();
	return;
}

function updateEmail($Conn, $UID, $newEmail)
{
	$sql = "UPDATE users SET Email = ? WHERE UID = ?;";
	$stmt -> $Conn -> prepare($sql);
	if($stmt == False) 
	{
		exit();
	} 
	$stmt->bind_param("ss",  $newEmail, $UID);
	$stmt->execute();
	$stmt->close();
	return;
}

