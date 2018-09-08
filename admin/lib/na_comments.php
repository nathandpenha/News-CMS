<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$getMode = $_POST['mode'];
$getArticleID = mysqli_real_escape_string($db, strip_tags(trim($_POST['pid'])));

if($getMode == "list"){
	$query = "SELECT * FROM ".DB_PREFIX."comments where post_id = ".$getArticleID;
	$comments = $db->query($query);
	$ret = array();
	while($row = $comments->fetch_assoc()){
		$userName = $db->query("SELECT CONCAT(first_name, ' ', last_name) as user_name from ".DB_PREFIX."users where id = ".$row['user_id'])->fetch_assoc();
		$row['user_name'] = $userName['user_name'];
		array_push($ret, $row);
	}
	echo json_encode($ret);
}else if ($getMode == "del"){
	$getComId = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	$ret = array();
	$delCommentSQL = $db->prepare("DELETE FROM ".DB_PREFIX."comments where id = ?");
	$delCommentSQL->bind_param("i", $getComId);
	$delCommentSQL->execute();
	if ($delCommentSQL){
		$ret['message'] = "success";
	}else{
		$ret['message'] = "failed";
	}
	echo json_encode($ret);
}
