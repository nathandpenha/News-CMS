<?php

$getDBName = strip_tags(trim($_POST['db_name']));
$getDBUserName = strip_tags(trim($_POST['db_user_name']));
$getDBHostName = strip_tags(trim($_POST['db_host_name']));
$getPassword = strip_tags(trim($_POST['db_password']));
$getPrefix = strip_tags(trim($_POST['db_prefix']))."_";

$checkDirectoryExists = "../includes/";

//check mysql connection before running script
$con = mysqli_connect($getDBHostName,$getDBUserName,$getPassword,$getDBName);
// Check connection
if (mysqli_connect_errno()){
	error_log("Failed to connect to DB");
	?>
	<script type="text/javascript">
	location.href="../na-install.php?err=dbConnectFail";
	</script>
	<?php
}else{
	try{
		if (!file_exists($checkDirectoryExists)){
			mkdir($checkDirectoryExists, 0775, true);
		}
		$fileName = "base.php";
		$handle = fopen($checkDirectoryExists.$fileName, 'w');
		$data = '<?php
		session_start();
		define("DB_HOST","'.$getDBHostName.'");
		define("DB_USER","'.$getDBUserName.'");
		define("DB_PASS","'.$getPassword.'");
		define("DB_NAME","'.$getDBName.'");
		$db = new mysqli(DB_HOST , DB_USER , DB_PASS, DB_NAME);
		';
		fwrite($handle, $data);
		fclose($handle);
		//create table
		$tables = array("CREATE TABLE ".$getPrefix."reviewers (`id` int(11) NOT NULL AUTO_INCREMENT,`first_name` varchar(60) NOT NULL,`last_name` varchar(60) NOT NULL,`email` varchar(100) NOT NULL,`password` varchar(255) NOT NULL, PRIMARY KEY (id))",
		"CREATE TABLE ".$getPrefix."categories (`id` int(11) NOT NULL AUTO_INCREMENT,`category_name` varchar(50), PRIMARY KEY (id))",
		"CREATE TABLE ".$getPrefix."comments (`id` int(11) NOT NULL AUTO_INCREMENT,`post_id` int(11) NOT NULL,`user_id` int(11) NOT NULL,`message` text NOT NULL,`date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id))",
		"CREATE TABLE ".$getPrefix."comment_votes (`id` int(11) NOT NULL AUTO_INCREMENT,`comment_id` int(11) NOT NULL,`user_id` int(11) NOT NULL,`direction` tinyint(1) NOT NULL, PRIMARY KEY (id))",
		"CREATE TABLE ".$getPrefix."keywords (`id` int(11) NOT NULL AUTO_INCREMENT,`post_id` int(11) NOT NULL,`tag` varchar(255) NOT NULL, PRIMARY KEY (id))",
		"CREATE TABLE ".$getPrefix."posts (`id` int(11) NOT NULL AUTO_INCREMENT,`title` varchar(200) DEFAULT NULL,`category` int(11) DEFAULT NULL,`date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,`body` longtext,`reviewer` varchar(100) DEFAULT '0',`featured` tinyint(1) NOT NULL, PRIMARY KEY (id)) ",
		"CREATE TABLE ".$getPrefix."users (`id` int(11) NOT NULL AUTO_INCREMENT,`first_name` varchar(60) NOT NULL,`last_name` varchar(60) NOT NULL,`email` varchar(100) NOT NULL,`password` varchar(255) NOT NULL, PRIMARY KEY (id)) "
	);
	for($i=0; $i<sizeof($tables); ++$i){
		$con->query($tables[$i]);
	}
	?>
	<script type="text/javascript">
	location.href = "../na-install.php?suc=install";
	</script>
<?php
}catch(Exception $e){
	error_log($e); // debug
	?>
	<script type="text/javascript">
	location.href =  "../na-install.php?err=fail";
	</script>
	<?php
}
}

?>
