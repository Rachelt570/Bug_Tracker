<?php 


require_once "DBH.inc.php";
require_once "Helper.inc.php";
session_start();



class message implements JsonSerializable
{
	public $ID;
	public $SID;
	public $RID;
	public $content;
	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
	public function set_ID($id)
	{
		$this->ID = $id;
	}
	public function set_SID($id)
	{
		$this->SID = $id;
	}
	public function set_RID($id)
	{
		$this->RID = $id;
	}
	public function set_content($val)
	{
		$this->content = $val;
	}
	public function get_ID()
	{
		return $this->ID;
	}
	public function get_SID()
	{
		return $this->SID;
	}
	public function get_RID()
	{
		return $this->RID;
	}
	public function get_content()
	{
		return $this->content;
	}
};

function sendMessage($Conn, $UID, $TargetID, $MessageContent)
{
	$sql = "INSERT INTO messages(MessageContent, RecipientID, SenderID) values (?, ?, ?);";
	$stmt = $Conn -> prepare($sql);
	if(!$stmt)
	{
		exit();
	}
	$stmt -> bind_param("sii", $MessageContent, $TargetID, $UID);
	$stmt->execute();
	$stmt->close();
	return;
}
function getMessagesBetweenUsers($Conn, $UID, $UID_TWO)
{
	$sql = "SELECT * FROM messages WHERE (SenderID = ? AND RecipientID = ?) OR (SenderID = ? AND RecipientID = ?);";
	$stmt->bind_param("iiii", $UID, $UID_TWO, $UID_TWO, $UID);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	return $result;
}