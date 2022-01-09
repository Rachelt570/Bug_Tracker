<?php
session_start();

if (!isset($_POST['AddFriendSearchValue']))
{
	Header("Location: ../../Friends.php");
	exit();
}

require_once "DBH.inc.php";
require_once "Helper.inc.php";
$RequestedUsername = $_POST['AddFriendSearchValue'];

$userID = $_SESSION['UID'];
$targetUser = getUserByUsername($Conn, $RequestedUsername);
if(!$targetUser)
{
	Header("Location: ../../Friends.php?error=UserNotFound");
	exit();
}
$targetID = $targetUser['UID'];

if(isFriendRequestPending($Conn, $userID, $targetID))
	{
		Header("Location: ../../Friends.php?error=PendingRequest");
		exit();
	}

createFriendRequest($Conn, $userID, $targetID);

Header("Location: ../../Friends.php?requestSent=Success");

function createFriendRequest($Conn, $userID, $targetID)
{
	$sql = "INSERT INTO friend_requests (outgoingUserID, incomingUserID) VALUES (?,?);";
	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		header("Location: ../../Friends.php?error=MessageFailed");
		exit();
	}
	$stmt->bind_param("ii", $userID, $targetID);
	$stmt->execute();
	$stmt->close();
	return;
}

function isFriendRequestPending($Conn, $userID, $targetID)
{
	$sql = "SELECT 1 FROM friend_requests WHERE (outgoingUserID = ? AND incomingUserID = ?) OR (outgoingUserID = ? AND incomingUserID = ?);";

	$stmt = $Conn -> prepare($sql);
	if($stmt == False)
	{
		printf($Conn -> error);
		exit();
	}
	$stmt->bind_param("iiii", $userID, $targetID, $targetID, $userID);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
	$stmt->close();
	return !empty($row);
}