<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../includes/base.php';

global $db;

$query = "SELECT * FROM ".DB_PREFIX."posts where `featured` = 1 and `post_type` = 'published' ORDER BY `date_created` DESC LIMIT 0,3";

$featured = $db->query($query);

$ret = array();

while($row = $featured->fetch_assoc()){
	$queryCategory = $db->query("SELECT * from ".DB_PREFIX."categories where id = ". $row['category']);
	$category = $queryCategory->fetch_assoc();
	$data = array();
	$data['title'] = $row['title'];
	$data['body'] = $row['body'];
	$data['id'] = $row['id'];
	$data['category_name'] = $category['category_name'];
	$data['category'] = $row['category'];
	$ret[] = $data;
}

echo json_encode($ret);
