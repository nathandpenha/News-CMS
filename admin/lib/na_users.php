<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$getMode = $_POST['mode'];

if($getMode == "list"){
	if($_SESSION['super_admin']){
		$userSQL = "SELECT * FROM ".DB_PREFIX."users";
	}else{
		$userSQL = "SELECT * FROM ".DB_PREFIX."users where email not in (select meta_value from ".DB_PREFIX."site_meta where meta_name = 'AdminEmail')";
	}
	$users = $db->query($userSQL);
	$ret = array();
	while($row = $users->fetch_assoc()){
		array_push($ret, $row);
	}
	echo json_encode($ret);
}else if ($getMode == "del"){
	$getUserId = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	$ret = array();
	$delSQL = $db->prepare("DELETE FROM ".DB_PREFIX."users where id = ?");
	$delSQL->bind_param("i", $getUserId);
	$delSQL->execute();
	if ($delSQL){
		$ret['message'] = "success";
	}else{
		$ret['message'] = "failed";
	}
	echo json_encode($ret);
}else if($getMode == "change"){
	$getUserId = mysqli_real_escape_string($db, strip_tags(trim($_POST['uid'])));
	$getNewRole = mysqli_real_escape_string($db, strip_tags(trim($_POST['role'])));
	if($getNewRole != ''){
		$ret = array();
		$roleSQL = $db->prepare("UPDATE ".DB_PREFIX."users SET role = ? WHERE id = ?");
		$roleSQL->bind_param("ss", $getNewRole, $getUserId);
		$roleSQL->execute();
		if ($roleSQL){
			$ret['message'] = "success";
		}else{
			$ret['message'] = "failed";
		}
	}else{
		$ret['message'] = "Empty New Value";
	}
	echo json_encode($ret);
}
