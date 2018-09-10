<?php
include('includes/head.php');

include("./captcha/simple-php-captcha.php");


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

	$stmt = $db->prepare ("insert into  ".DB_PREFIX."users ( first_name , last_name , email , password , admin ) values (?,?,?,?,?)");
	$stmt->bind_param("sssss", $firstName, $lastName, $email,$password,$admin);

	
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
									<form name="frmRegistration" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
										<table border="0" width="500" align="center" class="demo-table">
											<?php if(!empty($success_message)) { ?>
												<div class="success-message"><?php if(isset($success_message)) echo $success_message; ?></div>
											<?php } ?>
											<?php if(!empty($error_message)) { ?>
												<div class="error-message"><?php if(isset($error_message)) echo $error_message; ?></div>
											<?php } ?>
											<tr>
												<td>First Name</td>
												<td><input type="text" class="form-control col-md-7 col-xs-12" name="firstName" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>"></td>
											</tr>
											<tr>
												<td>Last Name</td>
												<td><input type="text" class="form-control col-md-7 col-xs-12" name="lastName" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>"></td>
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
