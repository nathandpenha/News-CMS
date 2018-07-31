<?php
session_start();
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","root");
define("DB_NAME","demo");
define("DB_PREFIX", "weed_");

$db = new mysqli(DB_HOST , DB_USER , DB_PASS, DB_NAME);

$siteName = $db->query("SELECT meta_value FROM weed_site_meta WHERE `meta_name` = 'WebSiteName'")->fetch_assoc()['meta_value'];
$siteDescription = $db->query("SELECT meta_value FROM weed_site_meta WHERE `meta_name` = 'WebSiteDescription'")->fetch_assoc()['meta_value'];
