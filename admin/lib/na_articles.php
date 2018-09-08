<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$getMode = $_POST['mode'];

if($getMode == "list"){
	$category = $db->query("SELECT * FROM ".DB_PREFIX."posts order by date_created desc");
	$ret = array();
	while($row = $category->fetch_assoc()){
		$authorName = $db->query("SELECT CONCAT(first_name,' ',last_name) as author from ".DB_PREFIX."users where id = ".$row['author'])->fetch_assoc();
		$categoryName = $db->query("SELECT category_name from ".DB_PREFIX."categories where id = ".$row['category'])->fetch_assoc();
		$row['author_name'] = $authorName['author'];
		$row['category_name'] = $categoryName['category_name'];
		$row['post_type'] = ucfirst($row['post_type']);
		$row['date_created'] = date('F d, Y', strtotime($row['date_created']));
		array_push($ret, $row);
	}
	echo json_encode($ret);
}
