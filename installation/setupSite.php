<?php

include '../includes/base.php';

global $db;

$getFirstName = mysqli_real_escape_string($db, strip_tags(trim($_POST['first_name'])));
$getLastName = mysqli_real_escape_string($db, strip_tags(trim($_POST['last_name'])));
$getEmail = mysqli_real_escape_string($db, strip_tags(trim($_POST['email'])));
$getPassword = mysqli_real_escape_string($db, strip_tags(trim($_POST['password'])));
$getWebSiteName = mysqli_real_escape_string($db, strip_tags(trim($_POST['website_name'])));
$getWebSiteDescription = mysqli_real_escape_string($db, strip_tags(trim($_POST['website_description'])));

//setup admin
try{
	$userSql = "INSERT INTO ".DB_PREFIX."users (`first_name`, `last_name`, `email`, `password`, `role`) VALUES ('".$getFirstName."', '".$getLastName."',
	'".$getEmail."', md5('".$getPassword."'), 3)";
	$db->query($userSql);
	$sql = "INSERT INTO ".DB_PREFIX."site_meta(`meta_name`, `meta_value`) VALUES ('AdminFName','".$getFirstName."'), ('AdminLName','".$getLastName."'),
	('AdminEmail','".$getEmail."'), ('WebSiteName','".$getWebSiteName."'),('WebSiteDescription','".$getWebSiteDescription."'), ('UserAccount','Closed')";
	$db->query($sql);
	$handle = fopen("../includes/base.php", 'a');
	$data = '
	$siteName = $db->query("SELECT meta_value FROM ".DB_PREFIX."site_meta WHERE `meta_name` = \'WebSiteName\'")->fetch_assoc()[\'meta_value\'];
	$siteDescription = $db->query("SELECT meta_value FROM ".DB_PREFIX."site_meta WHERE `meta_name` = \'WebSiteDescription\'")->fetch_assoc()[\'meta_value\'];
	$userAccess = $db->query("SELECT meta_value FROM ".DB_PREFIX."site_meta WHERE `meta_name` = \'UserAccount\'")->fetch_assoc()[\'meta_value\'];
	if ($_SERVER[\'REQUEST_URI\'] == "/admin/"){
		if($_SESSION[\'loggedIN\'] != 1){
			header(\'Location: ../admin/index.php\');
		}else{
			header(\'Location: ../admin/login.php\');
		}
	}
	';
	fwrite($handle, $data);
	fclose($handle);
	?>
	<script type="text/javascript">
		window.location.href = "../index.php";
	</script>
	<?php
}catch(Exception $e){
	error_log($e);
}
