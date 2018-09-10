<?php
include('./includes/base.php');
if($_SESSION['loggedIN'] == 1 ){
	echo '<script> window.location.href = "./index.php"; </script>';
}
if (isset($_POST['loginBtn'])) {
	$email = mysqli_real_escape_string($db, strip_tags(trim($_POST["email"])));
	$password = mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["password"]))));
	if ($email != '' && $password != '') {
		$s = "SELECT * FROM ".DB_PREFIX."users WHERE email = ?";
		$sql = $db->prepare($s);
		$sql->bind_param("s", $email);
		$sql->execute();
		$result = $sql->get_result();
		$flag = 0;
		while($row = $result->fetch_assoc()){
			$flag = 1;
			if($row['password'] = $password){
				$getAdminEmail = $db->query("SELECT meta_value FROM ".DB_PREFIX."site_meta where meta_name = 'AdminEmail'")->fetch_assoc()['meta_value'];
				$_SESSION['loggedIN'] = 1;
				if ($row['role'] == 2){
					$_SESSION['admin'] = 0;
				}else{
					$_SESSION['admin'] = 1;
				}
				if($getAdminEmail == $email){
					$_SESSION['super_admin'] = 1;
				}else{
					$_SESSION['super_admin'] = 0;
				}
				$_SESSION['uid'] = $row['id'];
				$_SESSION['first_name'] = $row['first_name'];
				$_SESSION['last_name'] = $row['last_name'];
				$_SESSION['role'] = $row['role'];
				$_SESSION['email']=$email;
				$_SESSION['img'] = 'https://gravatar.com/avatar/'.md5($loginSQL["email"]);
				header('Location: index.php?msg=suc');
			}else{
				header('Location: login.php?msg=mis');
			}
		}
		if($flag == 0){
			header('Location: login.php?msg=em');
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="<?=$siteDescription;?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?=$siteName;?></title>
	<script src="js/bootstrap.js" ></script>
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
	<link href="css/login.css" rel="stylesheet">
	<script src="js/jquery.js" charset="utf-8"></script>
</head>
<body class="text-center">
	<form class="form-signin" method="post">
		<img class="mb-4" src="img/NA.png" alt="" width="72" height="72">
		<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="password" class="form-control" placeholder="Password" required>
		<button class="btn btn-lg btn-primary btn-block" name="loginBtn" type="submit">Sign in</button>
		<p class="mt-5 mb-3 text-muted">&copy; SICSR </p>
	</form>
</body>
</html>
