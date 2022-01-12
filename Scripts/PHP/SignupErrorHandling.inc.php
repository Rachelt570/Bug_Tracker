<?php
require_once "Globals.inc.php";

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
		$sql = "SELECT 1 FROM users WHERE Username = ?;";
		$stmt = $Conn -> prepare($sql);
		if(!$stmt)
		{
			header("Location: " .$WEBSITE_HOST. "/Signup.php?error=stmtFailed");
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
		$sql = "SELECT 1 FROM users WHERE Email = ?;";
		$stmt = $Conn -> prepare($sql);
		if(!$stmt)
		{
			header("Location: " .$WEBSITE_HOST. "/Signup.php?error=stmtFailed");
			exit();
		}
		$stmt->bind_param("s", $Email);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		$stmt->close();
		return !empty($row);
	}