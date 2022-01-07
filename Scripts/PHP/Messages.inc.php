<?php



require_once "DBH.inc.php";
require_once "Helper.inc.php";
session_start();


	$targetName = $_POST["MessageTargetName"];
	$MessageContent = $_POST["MessageInput"];
	if(!isset($_SESSION["UID"]))
	{
		exit();
	}
	if(strlen($MessageContent) > 255 || strlen($MessageContent) == 0)
	{
		exit();
	}
	if(!usernameExists($Conn, $targetName))
	{
		exit();
	}
	$user = getUserByUsername($Conn, $targetName);
	$id = $user["UID"];
	$myID = $_SESSION["UID"];
	sendMessage($Conn, $myID, $id, $MessageContent);





function sendMessage($Conn, $UID, $TargetID, $MessageContent) 
{
	$sql = "INSERT INTO messages(MessageContent, RecipientID, SenderID) values (?, ?, ?);";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		exit();
	}
	$stmt -> bind_param("sss", $MessageContent, $TargetID, $UID);
	$stmt->execute();
	$stmt->close();
	return;
}

function getMessageFromUser($Conn, $UID)
{
	$sql = "SELECT * FROM messages WHERE SenderID = ?";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("Location: ../../Signup.php?error=stmtFailed");
		exit();
	}
	$stmt->bind_param("s", $UID);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$stmt->close();
	return $row;
}

function getMessagesToUser($Conn, $UID)
{
	$sql = "SELECT * FROM messages WHERE RecipientID = ?";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("Location: ../../Signup.php?error=stmtFailed");
		exit();
	}
	$stmt->bind_param("S", $UID);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$stmt->close();
	return $row;
}

function getMessagesBetweenUsers($Conn, $UID, $UID_TWO)
{
	$sql = "SELECT * FROM messages WHERE (SenderID = ? AND RecipientID = ?);";
	$stmt = $Conn -> prepare($sql);	
	$stmt->bind_param("SS", $UID, $UID_TWO);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	return $result;
}

function getMessagesInvolvingUser($Conn, $UID)
{
	$sql = "SELECT * FROM messages WHERE SenderID = ? OR RecipientID = ?;";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("Location: ../../Signup.php?error=stmtFailed");
		exit();
	}
	$stmt->bind_param("s", $UID);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$stmt->close();
	return $row;
}