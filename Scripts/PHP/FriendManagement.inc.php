<?php


require_once "Globals.inc.php";
require_once "DBH.inc.php";
require_once "Helper.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['AddFriendSearchValue']))
{
	createFriendRequest($Conn);
	exit();
}
elseif(isset($_POST['GetFriendRequests']))
{
	$result = getFriendRequests($Conn, $_SESSION['UID']);
	$resultArray = [];
	while ($row = $result -> fetch_assoc())
	{
		array_push($resultArray, $row['outgoingUserID']);
	}
	echo(json_encode($resultArray));
	exit();
}
else
{
	header("Location".$WEBSITE_HOST."/Friends.php?error=InvalidAccess");
	exit();
}


$RequestedUsername = $_POST['AddFriendSearchValue'];
function createFriendRequest($Conn)
{
	$RequestedUsername = $_POST['AddFriendSearchValue'];
	$userID = $_SESSION['UID'];
	$targetUser = getUserFromUsername($Conn, $RequestedUsername);
	if(!$targetUser)
	{
		Header("Location:".$WEBSITE_HOST."/Friends.php?error=UserNotFound");
		exit();
	}
	$targetID = $targetUser['UID'];
	if(isFriendRequestPending($Conn, $userID, $targetID))
	{
		Header("Location:".$WEBSITE_HOST."/Friends.php?error=PendingRequest");
		exit();
	}
	sendFriendRequest($Conn, $userID, $targetID);
	Header("Location:".$WEBSITE_HOST."/Friends.php?requestSent=Success");
	exit();
}
function sendFriendRequest($Conn, $userID, $targetID)
{
	$sql = "INSERT INTO friend_requests (outgoingUserID, incomingUserID) VALUES (?,?);";
	$stmt = $Conn -> prepare($sql);
	if(!$stmt)
	{
		header("Location:".$WEBSITE_HOST."/Friends.php?error=MessageFailed");
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
	if(!$stmt)
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
function getFriendRequests($Conn, $UID) 
{
	$sql = "SELECT * FROM friend_requests WHERE incomingUserID = ?;";
	$stmt = $Conn ->prepare($sql);
	if(!$stmt) 
	{
		exit();
	}
	$stmt->bind_param("i", $UID);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	$row = $stmt->fetch_array(MYSQLI_NUM);
	return $result;
}
function acceptRequest($Conn, $UID, $TargetID)
{

}
function declineRequest($Conn, $UID, $TargetID)
{
	
}