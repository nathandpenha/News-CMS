<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$getMode = $_POST['mode'];

if($getMode == "list"){
	$query = "SELECT * FROM ".DB_PREFIX."tags";
	$tag = $db->query($query);
	$ret = array();
	while($row = $tag->fetch_assoc()){
		$countTag = $db->query("SELECT COUNT(*) as ans from ".DB_PREFIX."post_tags where tag_id = ".$row['id']);
		$count = $countTag->fetch_assoc();
		$row['count'] = $count;
		array_push($ret, $row);
	}
	echo json_encode($ret);
}else if ($getMode == "add"){
	$getNewTag = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	$ret = array();
	if ($getNewTag != ""){
		$addTagSQL = $db->prepare("INSERT INTO ".DB_PREFIX."tags (`tag_name`) VALUES (?)");
		$addTagSQL->bind_param("s", $getNewTag);
		$addTagSQL->execute();
		if ($addTagSQL){
			$ret['message'] = "success";
		}else{
			$ret['message'] = "failed";
		}
		echo json_encode($ret);
	}else{
		$ret['message'] = "Please Don't Leave the Field Blank!";
		echo json_encode($ret);
	}
}else if ($getMode == "del"){
	$getTagId = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	$ret = array();
	$delCategorySQL = $db->prepare("DELETE FROM ".DB_PREFIX."tags where id = ?");
	$delCategorySQL->bind_param("i", $getTagId);
	$delCategorySQL->execute();
	if ($delCategorySQL){
		$deletePostTags = $db->query("DELETE FROM ".DB_PREFIX."post_tags where tag_id = ".$getTagId);
		$ret['message'] = "success";
	}else{
		$ret['message'] = "failed";
	}
	echo json_encode($ret);
}
