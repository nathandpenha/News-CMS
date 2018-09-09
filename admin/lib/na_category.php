<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../../includes/base.php';

global $db;

$getMode = $_POST['mode'];

if($getMode == "list"){
	$query = "SELECT * FROM ".DB_PREFIX."categories";
	$category = $db->query($query);
	$ret = array();
	while($row = $category->fetch_assoc()){
		$countCat = $db->query("SELECT COUNT(*) as ans from ".DB_PREFIX."posts where category = ".$row['id']." and post_type = 'published'");
		$count = $countCat->fetch_assoc();
		$row['count'] = $count;
		array_push($ret, $row);
	}
	echo json_encode($ret);
}else if ($getMode == "add"){
	$getNewCategory = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	$ret = array();
	if ($getNewCategory != ""){
		$addCategorySQL = $db->prepare("INSERT INTO ".DB_PREFIX."categories(`category_name`) VALUES (?)");
		$addCategorySQL->bind_param("s", $getNewCategory);
		$addCategorySQL->execute();
		if ($addCategorySQL){
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
	$getCatId = mysqli_real_escape_string($db, strip_tags(trim($_POST['val'])));
	$ret = array();
	$delCategorySQL = $db->prepare("DELETE FROM ".DB_PREFIX."categories where id = ?");
	$delCategorySQL->bind_param("i", $getCatId);
	$delCategorySQL->execute();
	if ($delCategorySQL){
		$ret['message'] = "success";
	}else{
		$ret['message'] = "failed";
	}
	echo json_encode($ret);
}
