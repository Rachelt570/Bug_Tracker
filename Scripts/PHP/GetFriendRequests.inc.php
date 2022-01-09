<?php

require_once "DBH.inc.php";
require_once "Helper.inc.php";

	if(isset($_POST['function'])) 
	{
		$functionRequest = $_POST['function'];	
		if($functionRequest == "getFriendRequests")
		{
			$result = getFriendRequests($Conn, $_SESSION['UID']);
			$resultArray = [];
			while ($row = $result-> fetch_assoc())
			{
				array_push($resultArray, $row['outgoingUserID']);
			}
			echo(json_encode($resultArray));
		}
	}

function getFriendRequests($Conn, $UID) 
{
	$sql = "SELECT * FROM friend_requests WHERE incomingUserID = ?;";
	$stmt = $Conn ->prepare($sql);
	if($stmt == False) 
	{
		exit();
	}
	$stmt->bind_param("i", $UID);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	return $result;
}

