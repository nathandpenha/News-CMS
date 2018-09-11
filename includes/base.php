<?php
		session_start();
		define("DB_HOST","localhost");
		define("DB_USER","root");
		define("DB_PASS","");
		define("DB_NAME","demo");
		define("DB_PREFIX", "na_");
		$db = new mysqli(DB_HOST , DB_USER , DB_PASS, DB_NAME);
		
	$siteName = $db->query("SELECT meta_value FROM ".DB_PREFIX."site_meta WHERE `meta_name` = 'WebSiteName'")->fetch_assoc()['meta_value'];
	$siteDescription = $db->query("SELECT meta_value FROM ".DB_PREFIX."site_meta WHERE `meta_name` = 'WebSiteDescription'")->fetch_assoc()['meta_value'];
	$userAccess = $db->query("SELECT meta_value FROM ".DB_PREFIX."site_meta WHERE `meta_name` = 'UserAccount'")->fetch_assoc()['meta_value'];
	if ($_SERVER['REQUEST_URI'] == "/admin/"){
		if($_SESSION['loggedIN'] != 1){
			header('Location: ../admin/index.php');
		}else{
			header('Location: ../admin/login.php');
		}
	}
	