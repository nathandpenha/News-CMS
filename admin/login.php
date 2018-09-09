<?php
include('../includes/base.php');
if($_SESSION['loggedIN'] == 1 && $_SESSION['role'] != 1){
	echo '<script> window.location.href = "index.php"; </script>';
}
if (isset($_POST['loginBtn'])) {
	$email = mysqli_real_escape_string($db, strip_tags(trim($_POST["email"])));
	$password = mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["password"]))));
	if ($email != '' && $password != '') {
		$s = "SELECT * FROM ".DB_PREFIX."users WHERE email = ? and role != 1";
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
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gentelella Alela! | </title>
	<!-- Bootstrap -->
	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- Animate.css -->
	<link href="vendors/animate.css/animate.min.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="build/css/custom.min.css" rel="stylesheet">
</head>
<body class="login">
	<div>
		<a class="hiddenanchor" id="signup"></a>
		<a class="hiddenanchor" id="signin"></a>
		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<form method="post">
						<h1>Login Form</h1>
						<div>
							<input type="email" name="email" class="form-control" placeholder="Username" required />
						</div>
						<div>
							<input type="password" name="password" class="form-control" placeholder="Password" required />
						</div>
						<div class="col-md-offset-3">
							<input type="submit" class="btn btn-default submit" name="loginBtn" value="Log In">
						</div>
						<div class="clearfix"></div>
						<div class="separator"></div>
						<div class="clearfix"></div>
						<br />
						<div>
							<h1> <?=$siteName;?> </h1>
						</div>
					</form>
				</section>
			</div>
		</div>
	</div>
</body>
</html>
