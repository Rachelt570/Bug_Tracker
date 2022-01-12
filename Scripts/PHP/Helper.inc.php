<?php


//Get User

	function getUsernameFromUID($Conn, $UID)
	{
		$sql = "SELECT Username FROM users WHERE UID = ?;";
		$stmt = $Conn->prepare($sql);
		if(!$stmt)
		{
			return false;
			exit();
		}
		$stmt -> bind_param('i', $UID);
		$stmt -> execute();
		$result = $stmt-> get_result();
		$stmt->close();
		if($result->num_rows == 0)
		{
			return false;
			exit();
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	function getEmailFromUID($Conn, $UID)
	{
		$sql = "SELECT Email FROM users WHERE UID = ?;";
		$stmt = $Conn->prepare($sql);
		if(!$stmt)
		{
			return false;
			exit();
		}
		$stmt -> bind_param('i', $UID);
		$stmt -> execute();
		$result = $stmt -> get_result();
		$stmt->close();
		if($result->num_rows == 0)
		{
			return false;
			exit();
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	function getUserFromUID($Conn, $UID)
	{
		$sql = "SELECT UID Username Password Email FROM users WHERE UID = ?;";
		$stmt = $Conn->prepare($sql);
		if(!$stmt)
		{
			return false;
			exit();
		}
		$stmt->bind_param('i', $UID);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if($result->num_rows == 0)
		{
			return false;
			exit();
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	function getUserFromUsername($Conn, $Username)
	{
		$sql = "SELECT UID, Username, Email, Password FROM users WHERE Username = ?;";
		$stmt = $Conn->prepare($sql);
		if(!$stmt)
		{
			return false;
			exit();
		}
		$stmt->bind_param('s', $Username);
		$stmt->execute();
		$result = $stmt -> get_result();
		$stmt->close();
		if($result->num_rows == 0)
		{
			return false;
			exit();
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}

	function getUIDFromUsername($Conn, $Username)
	{
		$sql = "SELECT UID FROM users WHERE Username = ?;";
		$stmt = $Conn->prepare($sql);
		if(!$stmt)
		{
			return false;
			exit();
		}
		$stmt -> bind_param('s', $Username);
		$stmt -> execute();
		$result = $stmt -> get_result();
		$stmt -> close();
		if($result->num_rows == 0)
		{
			return false;
			exit();
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	function getUIDFromEmail($Conn, $Email)
	{
		$sql = "SELECT UID FROM users WHERE Email = ?;";
		$stmt = $Conn->prepare($sql);
		if(!$stmt)
		{
			return false;
			exit();
		}
		$stmt -> bind_param('s', $Email);
		$stmt -> execute();
		$result = $stmt -> get_result();
		$stmt -> close();
		if($result -> num_rows == 0)
		{
			return false;
			exit();
		}
		$row = $result -> fetch_array(MYSQLI_ASSOC);
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