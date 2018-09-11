<?php
include('./includes/base.php');
if($_SESSION['loggedIN'] == 1 ){
	echo '<script> window.location.href = "./index.php"; </script>';
}
if(isset($_POST['signupBtn'])){
	$getFirstName = mysqli_real_escape_string($db, strip_tags(trim($_POST['fname'])));
	$getLastName = mysqli_real_escape_string($db, strip_tags(trim($_POST['lname'])));
	$getEmail = mysqli_real_escape_string($db, strip_tags(trim($_POST['email'])));
	$getPassword = mysqli_real_escape_string($db, strip_tags(trim($_POST['password'])));
	if($getFirstName != '' && $getLastName != '' && $getEmail != '' && $getPassword != ''){
		$addUser = $db->prepare("INSERT INTO ".DB_PREFIX."users( `first_name`, `last_name`, `email`, `password`, `role`) VALUES (?,?,?,?,1)");
		$addUser->bind_param("ssss",$getFirstName, $getLastName, $getEmail, md5($getPassword));
		if($addUser->execute()){
			header('Location: login.php?msg=acsuc');
		}else{
			header('Location: signup.php?msg=err');
		}
	}else{
		header('Location: signup.php?msg=emp');
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
	<?php
	if($_GET['msg'] == "err"){
		?>
		<div class="alert alert-danger alert-dismissible fade in msg" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error!</strong> Some Error Occured. Please Try Again!
		</div>
		<?php
	}
	if($_GET['msg'] == "emp"){
		?>
		<div class="alert alert-danger alert-dismissible fade in msg" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error!</strong> One or more Fields Left blank!!
		</div>
		<?php
	}
	?>
	<form class="form-signin" method="post">
		<img class="mb-4" src="img/NA.png" alt="" width="72" height="72">
		<h1 class="h3 mb-3 font-weight-normal">Please Enter Details</h1>
		<label for="inputEmail" class="sr-only">First Name</label>
		<input type="text" name="fname" class="form-control" placeholder="First Name" required autofocus>
		<label for="inputEmail" class="sr-only">Last Name</label>
		<input type="text" name="lname" class="form-control" placeholder="Last Name" required autofocus>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" name="email" class="form-control" placeholder="Email address" required >
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="password" class="form-control" placeholder="Password" required>
		<button class="btn btn-lg btn-primary btn-block" name="signupBtn" type="submit">Sign in</button>
		<p class="mt-5 mb-3 text-muted">&copy; SICSR </p>
	</form>
</body>
</html>
