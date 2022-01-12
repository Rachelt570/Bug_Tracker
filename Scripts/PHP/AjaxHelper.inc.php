<?php


require_once "DBH.inc.php";
require_once "Helper.inc.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_POST['function']))
{
	exit();
}

//probably should sanitize this data
driver($Conn, $_POST['function'], $_POST['parameters']);
function driver($Conn, $functionName, $parameters)
{
	if($functionName == 'echoUsernameFromUID')
	{
		echoUsernameFromUID($Conn, $parameters);
	}
	if($functionName == 'echoEmailFromUID')
	{
		echoEmailFromUID($Conn, $parameters);
	}
	if($functionName == 'echoUIDFromUsername')
	{
		echoUIDFromUsername($Conn, $parameters);
	}
	if($functionName == 'echoUIDFromEmail')
	{
		echoUIDFromEmail($Conn, $parameters);
	}
	if($functionName == 'echoSessionData')
	{
		echoSessionData();
	}
	if($functionName == 'echoSessionUID')
	{
		echoSessionUID();
	}
	if($functionName == 'echoSessionUsername')
	{
		echoSessionUsername();
	}
	if($functionName == 'echoSessionEmail')
	{
		echoSessionEmail();
	}
	if($functionName == 'echoFriendRequests')
	{
		echoFriendRequests($Conn, $parameters);
	}
}

//Session Variable Access
	function echoSessionData()
	{
		$sessionArray = array($_SESSION['UID'], $_SESSION['Username'], $_SESSION['Email']);
		echo json_encode($sessionArray);
		return;
	}
	function echoSessionUID()
	{
		echo json_encode($_SESSION['UID']);
		return;
	}
	function echoSessionUsername()
	{
		echo json_encode($_SESSION['Username']);
	}
	function echoSessionEmail()
	{
		echo json_encode($_SESSION['Email']);
	}

// Convert User Data

	function echoUsernameFromUID($Conn, $UID)
	{
		$userName = getUsernameFromUID($Conn, $UID);
		echo json_encode($userName['Username']);
		return;
	}
	function echoEmailFromUID($Conn, $UID)
	{
		$email = getEmailFromUID($Conn, $UID);
		echo json_encode($email['Email']);
		return;
	}
	function echoUIDFromUsername($Conn, $Username)
	{
		$UID = getUIDFromUsername($Conn, $Username);
		echo json_encode($UID);
	}
	function echoUIDFromEmail($Conn, $Email)
	{
		$UID = getUIDFromEmail($Conn, $Email);
		echo json_encode($UID);
		return;
	}

// Friend Management 

	function echoFriendRequests($Conn, $UID)
	{	
		echo json_encode(getFriendRequests($Conn, $UID));
	}

	function getFriendRequests($Conn, $UID) 
	{
		$sql = "SELECT outgoingUserID FROM friend_requests WHERE incomingUserID = ?;";
		$stmt = $Conn->prepare($sql);
		if(!$stmt) 
		{
			exit();
		}
		$stmt->bind_param("i", $UID);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$data = [];
		while($row = mysqli_fetch_array($result))
		{
			$data[] = $row['outgoingUserID'];
		}
		return $data;
	}