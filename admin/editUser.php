<?php
include("./captcha/simple-php-captcha.php");

include('../includes/base.php');

$selectedemail=$_POST['selectedemail'];


if((isset($_POST['submit']))){}else{
$_SESSION['captcha'] = simple_php_captcha();
}
$code=trim($_SESSION['captcha']['code']);
$image_src=trim($_SESSION['captcha']['image_src']);


if(isset($_POST['submit']))
{ 
 if($_POST['captcha']==$code){
	foreach($_POST as $key=>$value) {
		if(empty($_POST[$key])) {
			$error_message = "All Fields are required";
			break;exit;
		}
	}
	/* Password Matching Validation */
	if($_POST['password'] != $_POST['confirm_password']){
		$error_message = 'Passwords should be same<br>'; exit;
	}

	/* Email Validation */
	if(!isset($error_message)) {
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$error_message = "Invalid Email Address";
			exit;
		}
	}


	/* Validation to check if Terms and Conditions are accepted */
	if(!isset($error_message)) {
		if(!isset($_POST["terms"])) {
			$error_message = "Accept Terms and Conditions to Register";
			exit;
		}
	}

	$firstName=mysqli_real_escape_string($db, strip_tags(trim($_POST['firstName'])));
	$lastName=mysqli_real_escape_string($db, strip_tags(trim($_POST['lastName'])));
	$email = mysqli_real_escape_string($db, strip_tags(trim($_POST["email"])));
	$password = mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["password"]))));
	$admin=mysqli_real_escape_string($db, strip_tags(trim($_POST['admin'])));
	
	
	
	
	global $db;

	$stmt = $db->prepare ("update ".DB_PREFIX."users set  first_name=? , last_name=? , email=? , password=? , admin=?  where email=?");
	$stmt->bind_param("ssssss", $firstName, $lastName, $email,$password,$admin,$selectedemail);

	
	if($stmt->execute())
	{
		echo "user added";
	}else
	{
		echo "user add failed".mysqli_error($db);
	}
	
	
}else{
	echo"Incorrect Captcha";
		
}
 }
?>
<?php
	include('../includes/base.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="production/images/favicon.ico" type="image/ico" />

	<title> Admin | <?=$siteName;?></title>

	<!-- Bootstrap -->
	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<link rel="stylesheet" href="vendors/datatables.net-bs/css/dataTables.bootstrap.css">
	<!-- Custom Theme Style -->
	<link href="build/css/custom.min.css" rel="stylesheet">
	<!-- jQuery -->
	<script src="vendors/jquery/dist/jquery.min.js"></script>
	<link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<style>
	.msg{margin-top: 60px;}
	p{font-size: 125%;}
	</style>
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<?php include('includes/sidebar.php'); ?>
			<?php include('includes/topbar.php'); ?>
			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Plain Page</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Plain Page</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
								
								Edit Details for User <?php echo $selectedemail; ?>
								
									<form class="form-horizontal form-label-left" name="frmRegistration" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
										<table border="0" width="500" align="center" class="demo-table">
											<?php if(!empty($success_message)) { ?>
												<div class="success-message"><?php if(isset($success_message)) echo $success_message; ?></div>
											<?php } ?>
											<?php if(!empty($error_message)) { ?>
												<div class="error-message"><?php if(isset($error_message)) echo $error_message; ?></div>
											<?php } ?>
											<tr>
												<td>First Name</td>
												<td><input type="text" class="form-control col-md-7 col-xs-12" name="firstName" value=""></td>
											</tr>
											<tr>
												<td>Last Name</td>
												<td><input type="text" class="form-control col-md-7 col-xs-12" name="lastName" value=""></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><input type="text" class="form-control col-md-7 col-xs-12" name="email" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>"></td>
											</tr>
											
											<tr>
												<td>Password</td>
												<td><input type="password" class="form-control col-md-7 col-xs-12" name="password" value=""></td>
											</tr>
											<tr>
												<td>Confirm Password</td>
												<td><input type="password" class="form-control col-md-7 col-xs-12" name="confirm_password" value=""></td>
											</tr>
											<tr>
												<td>User Type<select name="admin">
													<option  value="3" > Admin</option>
													<option  value="2" > Editor</option>
												</select>
												</td>
											</tr>
											<tr>
												<td colspan=2>
													<input type="checkbox" name="terms"> I accept Terms and Conditions 
											</tr>
											<tr>
												<td>Enter the text you see</td>
												<td><img src="<?php echo $image_src;?>"></td>
												<td><input type="text class="form-control col-md-7 col-xs-12" name="captcha"  ></td>
											</tr>
												<tr>	
												<td>	<input type="submit" name="submit" value="Register" class="btnRegister"></td>
												</tr>
												<input type="hidden" name="selectedemail" value="<?php echo $selectedemail;?>" class="btnRegister">
											</table>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /page content -->
				<?php include('includes/footer.php'); ?>
