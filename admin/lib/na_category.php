<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$query = "SELECT * FROM ".DB_PREFIX."categories";

$category = $db->query($query);

$ret = array();

while($row = $category->fetch_assoc()){
	$countCat = $db->query("SELECT COUNT(*) as ans from ".DB_PREFIX."posts where category = ".$row['id']." and post_type = 'post'");
	$count = $countCat->fetch_assoc();
	$row['count'] = $count;
	array_push($ret, $row);
}

echo json_encode($ret);
