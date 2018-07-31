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
	$sql = "INSERT INTO ".DB_PREFIX."site_meta(`meta_name`, `meta_value`) VALUES ('AdminFName','".$getFirstName."'), ('AdminLName','".$getLastName."'),
	('AdminEmail','".$getEmail."'), ('AdminPassword',md5(".$getPassword.")), ('WebSiteName','".$getWebSiteName."'),
	('WebSiteDescription','".$getWebSiteDescription."')";
	$db->query($sql);
	$handle = fopen("../includes/base.php", 'a');
	$data = '
	$siteName = $db->query("SELECT meta_value FROM weed_site_meta WHERE `meta_name` = \'WebSiteName\'")->fetch_assoc()[\'meta_value\'];
	$siteDescription = $db->query("SELECT meta_value FROM weed_site_meta WHERE `meta_name` = \'WebSiteDescription\'")->fetch_assoc()[\'meta_value\'];
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
