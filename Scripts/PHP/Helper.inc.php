<?php


//Get User
	function getUserByUID($Conn, $UID)
	{
		return getUserByData($Conn, $UID, "UID");
	}
	function getUserByUsername($Conn, $Username)
	{
		return getUserByData($Conn, $Username, "Username");
	}
	function getUserByEmail($Conn, $Email)
	{
		return getUserByData($Conn, $Email, "Email");
	}
	function getUsernameByUID($Conn, $UID)
	{
		$sql = "SELECT Username FROM users WHERE UID = ?;";
		$stmt = $Conn ->prepare($sql);
		if(!$stmt)
		{
			exit();
		}
		$stmt->bind_param("s", $UID);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if($result->num_rows == 0)
		{
			return false;
			exit();
		}
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		return $row;
	}
	function getUserByData($Conn, $Data, $SearchType)
	{
		if($SearchType != "UID" && $SearchType != "Username" && $SearchType != "Email")
		{
			exit();
		}
		$sql = "Select * FROM users WHERE ". $SearchType ." = ?;";
		$stmt = $Conn -> prepare($sql);
		if(!$stmt)
		{
			exit();
		}
		if($SearchType == "UID")
		{
			$stmt->bind_param("i", $Data);
		}
		else
		{
			$stmt->bind_param("s", $Data);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if($result->num_rows == 0)
		{
			return false;	
		}

		$row = $result->fetch_array(MYSQLI_BOTH);
		return $row;
	}

//Update User Data
	function updatePassword($Conn, $UID, $NewPassword)
	{
		$sql = "UPDATE users SET Password = ? WHERE UID = ?;";
		$stmt = $Conn -> prepare($sql);
		if(!$stmt)
		{
			exit();	
		}
		$HashedPassword = password_hash($NewPassword, PASSWORD_DEFAULT);
		$stmt->bind_param("si", $HashedPassword, $UID);
		$stmt->execute();
		$stmt->close();
	}
	function updateEmail($Conn, $UID, $newEmail)
	{
		$sql = "UPDATE users SET Email = ? Where UID = ?;";
		$stmt = $Conn -> prepare($sql);
		if(!$stmt) 
		{
			exit();
		}
		$stmt->bind_param("si", $newEmail, $UID);
		$stmt->execute();
		$stmt->close();
		return;
	}