<?php

$getDBName = strip_tags(trim($_POST['db_name']));
$getDBUserName = strip_tags(trim($_POST['db_user_name']));
$getDBHostName = strip_tags(trim($_POST['db_host_name']));
$getPassword = strip_tags(trim($_POST['db_password']));
$getPrefix = strip_tags(trim($_POST['db_prefix']));

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
		$handle = fopen($checkDirectoryExists.$fileName, 'w') or die(echo "<script>location.href ='../na-install.php?err=file';</script>");
		$data = '<?php
		session_start();
		define("DB_HOST","'.$getDBHostName.'");
		define("DB_USER","'.$getDBUserName.'");
		define("DB_PASS","'.$getPassword.'");
		define("DB_NAME","'.$getDBName.'");
		$db = new mysqli(DB_HOST , DB_USER , DB_PASS);
		';
		fwrite($handle, $data);
		fclose($handle);
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
