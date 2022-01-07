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

function getMessagesBetweenUsers($Conn, $UID, $UID_TWO)
{
	$sql = "SELECT * FROM messages WHERE (SenderID = ? AND RecipientID = ?) UNION SELECT * FROM messages WHERE (RecipientID = ? AND SenderID = ?) ORDER BY MessageID";
	$stmt = $Conn -> prepare($sql);	
	$stmt->bind_param("ssss", $UID, $UID_TWO, $UID, $UID_TWO);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	return $result;
}

$id = $_SESSION["UID"];	
$targetName = $_POST["targetName"];
$target = getUserByUsername($Conn, $targetName);
if($target == False)
{
	exit();
}
$targetID = $target["UID"];
$sql = "SELECT * FROM messages WHERE (SenderID = ? AND RecipientID = ?)";
$result = getMessagesBetweenUsers($Conn, $id, $targetID);


while($row = $result->fetch_assoc()) 
{
	$id = $row["MessageID"];
	$sid = $row["SenderID"];
	$rid = $row["RecipientID"];
	$content = $row["MessageContent"];
	$m = new message();
	$m -> set_ID($id);
	$m -> set_SID($sid);
	$m -> set_RID($rid);
	$m -> set_content($content);
	$data[] = $m->jsonSerialize();
}


$result ->close();

echo json_encode($data);

return;