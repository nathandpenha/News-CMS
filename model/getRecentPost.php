<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../includes/base.php';

global $db;

$query = "SELECT * FROM ".DB_PREFIX."posts where featured = 0 and reviewer = 1 ORDER BY `date_created` DESC LIMIT 0,10";

$featured = $db->query($query);

$ret = array();

while($row = $featured->fetch_assoc()){
	$queryCategory = $db->query("SELECT * from `categories` where id = ". $row['category']);
	$category = $queryCategory->fetch_assoc();
	$data = array();
	$data['title'] = $row['title'];
	$data['body'] = substr($row['body'],0,140);
	$data['id'] = $row['id'];
	$data['category_name'] = $category['category_name'];
	$ret[] = $data;
}

echo json_encode($ret);
