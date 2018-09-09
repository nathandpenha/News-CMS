<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$getMode = $_POST['mode'];

if($getMode == "list"){
	$getUserType = $_POST['type'];
	if ($getUserType){
		$postSQL = "SELECT * FROM ".DB_PREFIX."posts order by date_created desc";
	}else{
		$getUserID = $_POST['uid'];
		$postSQL = "SELECT * FROM ".DB_PREFIX."posts where author = ".$getUserID." order by date_created desc";
	}
	$posts = $db->query($postSQL);
	$ret = array();
	while($row = $posts->fetch_assoc()){
		$authorName = $db->query("SELECT CONCAT(first_name,' ',last_name) as author from ".DB_PREFIX."users where id = ".$row['author'])->fetch_assoc();
		$categoryName = $db->query("SELECT category_name from ".DB_PREFIX."categories where id = ".$row['category'])->fetch_assoc();
		$row['author_name'] = $authorName['author'];
		$row['category_name'] = $categoryName['category_name'];
		$row['post_type'] = ucfirst($row['post_type']);
		array_push($ret, $row);
	}
	echo json_encode($ret);
}else if ($getMode == "del"){
	$getArtId = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	$ret = array();
	$delArticleSQL = $db->prepare("DELETE FROM ".DB_PREFIX."posts where id = ?");
	$delArticleSQL->bind_param("i", $getArtId);
	$delArticleSQL->execute();
	if ($delArticleSQL){
		$deleteArticleTags = $db->query("DELETE FROM ".DB_PREFIX."post_tags where post_id = ".$getArtId);
		$ret['message'] = "success";
	}else{
		$ret['message'] = "failed";
	}
	echo json_encode($ret);
}else if($getMode == "pub" || $getMode == "unpub"){
	$ret = array();
	$getArtId = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	if($getMode == "pub"){
		$val = "published";
	}else{
		$val = "draft";
	}
	$publishArticle = $db->query("UPDATE ".DB_PREFIX."posts SET post_type = '".$val."' where id = ".$getArtId);
	if($publishArticle){
		$ret['message'] = "success";
	}else{
		$ret['message'] = "failed";
	}
	echo json_encode($ret);
}
