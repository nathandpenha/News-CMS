<?php

$getDBName = strip_tags(trim($_POST['db_name']));
$getDBUserName = strip_tags(trim($_POST['db_user_name']));
$getDBHostName = strip_tags(trim($_POST['db_host_name']));
$getPassword = strip_tags(trim($_POST['db_password']));
$getPrefix = strip_tags(trim($_POST['db_prefix']))."_";

$checkDirectoryExists = "../includes/";
echo $getDBHostName,$getDBUserName,$getPassword,$getDBName;
//check mysql connection before running script
$con = mysqli_connect($getDBHostName,$getDBUserName,$getPassword,$getDBName);
// Check connection
if (mysqli_connect_errno()){
	error_log("Failed to connect to DB");
	?>
	<script type="text/javascript">
	//location.href="../na-install.php?err=dbConnectFail";
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
		define("DB_PREFIX", "'.$getPrefix.'");
		$db = new mysqli(DB_HOST , DB_USER , DB_PASS, DB_NAME);
		';
		fwrite($handle, $data);
		fclose($handle);
		//create table
		$tables = array(
<<<<<<< HEAD
			"CREATE TABLE ".$getPrefix."site_meta (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `meta_name` varchar(255), `meta_value` varchar(255))",
			"CREATE TABLE ".$getPrefix."categories (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,`category_name` varchar(50))",
			"CREATE TABLE ".$getPrefix."comments (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,`post_id` int(11) NOT NULL,`user_id` int(11) NOT NULL,`message` text NOT NULL,`date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP)",
			"CREATE TABLE ".$getPrefix."users (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,`first_name` varchar(60) NOT NULL,`last_name` varchar(60) NOT NULL,`email` varchar(100) NOT NULL,`password` varchar(255) NOT NULL, `admin` int not null default 1)",
			"CREATE TABLE ".$getPrefix."posts (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `title` varchar(200) DEFAULT NULL, `author` int(11) NOT NULL,`category` int(11) DEFAULT NULL,`date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,`body` longtext, `reviewer` varchar(100) DEFAULT '0', `featured` tinyint(1) NOT NULL, `post_type` varchar(100) NOT NULL DEFAULT 'draft', `enable_comments` INT NOT NULL DEFAULT '0')",
			"CREATE TABLE ".$getPrefix."post_tags (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,`post_id` int(11) NOT NULL,`tag_id` int(11) NOT NULL)",
			"CREATE TABLE ".$getPrefix."tags (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,`tag_name` varchar(60) NOT NULL)"
=======
			"CREATE TABLE ".$getPrefix."site_meta (`id` int(11) NOT NULL AUTO_INCREMENT, `meta_name` varchar(255), `meta_value` varchar(255), PRIMARY KEY(id) )",
			"CREATE TABLE ".$getPrefix."categories (`id` int(11) NOT NULL AUTO_INCREMENT,`category_name` varchar(50), PRIMARY KEY (id))",
			"CREATE TABLE ".$getPrefix."comments (`id` int(11) NOT NULL AUTO_INCREMENT,`post_id` int(11) NOT NULL,`user_id` int(11) NOT NULL,`message` text NOT NULL,`date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id))",
			"CREATE TABLE ".$getPrefix."comment_votes (`id` int(11) NOT NULL AUTO_INCREMENT,`comment_id` int(11) NOT NULL,`user_id` int(11) NOT NULL,`direction` tinyint(1) NOT NULL, PRIMARY KEY (id))",
			"CREATE TABLE ".$getPrefix."keywords (`id` int(11) NOT NULL AUTO_INCREMENT,`post_id` int(11) NOT NULL,`tag` varchar(255) NOT NULL, PRIMARY KEY (id))",
			"CREATE TABLE ".$getPrefix."users (`id` int(11) NOT NULL AUTO_INCREMENT,`first_name` varchar(60) NOT NULL,`last_name` varchar(60) NOT NULL,`email` varchar(100) NOT NULL,`password` varchar(255) NOT NULL, `admin` int not null default 1, PRIMARY KEY (id)) "
>>>>>>> 558a770bde6b0811fd6ac82de4a9eaf3334b05c0
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
