<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$getMode = $_POST['mode'];
$getValue = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));

$ret = array();

$sql = $db->prepare("UPDATE ".DB_PREFIX."site_meta SET `meta_value`=? WHERE `meta_name`=?");
$sql->bind_param('ss',$getValue, $getMode);
$sql->execute();

if($sql){
	$ret['message'] = "success";
}else{
	$ret['message'] = "failed";
}
echo json_encode($ret);
