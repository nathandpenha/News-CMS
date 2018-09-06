<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$getMode = $_POST['mode'];

if($getMode == "list"){
	$users = $db->query("SELECT * FROM ".DB_PREFIX."users");
	$ret = array();
	while($row = $users->fetch_assoc()){
		array_push($ret, $row);
	}
	echo json_encode($ret);
}else if ($getMode == "del"){
	$getUserId = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	$ret = array();
	$delCategorySQL = $db->prepare("DELETE FROM ".DB_PREFIX."tags where id = ?");
	$delCategorySQL->bind_param("i", $getUserId);
	$delCategorySQL->execute();
	if ($delCategorySQL){
		$deletePostUsers = $db->query("DELETE FROM ".DB_PREFIX."post_tags where tag_id = ".$getUserId);
		$ret['message'] = "success";
	}else{
		$ret['message'] = "failed";
	}
	echo json_encode($ret);
}
