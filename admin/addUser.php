<?php
include('includes/head.php');


if(isset($_POST['submit']))
{
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

	$firstName=$_POST['firstName'];
	$lastName=$_POST['lastName'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$admin=$_POST['admin'];
	global $db;

	$query = "insert into  ".DB_PREFIX."users ( 'first_name' , 'last_name' , 'email' , 'password' , 'admin' ) values ($firstName,$lastName,$email,$password,$admin)";
	if($db->query($query))
	{
		echo "user added";
	}else
	{
		echo "user add failed".mysqli_error($db);
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
												<td><input type="text" class="demoInputBox" name="firstName" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>"></td>
											</tr>
											<tr>
												<td>Last Name</td>
												<td><input type="text" class="demoInputBox" name="lastName" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>"></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><input type="text" class="demoInputBox" name="email" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>"></td>
											</tr>
											<tr>
												<td>Password</td>
												<td><input type="password" class="demoInputBox" name="password" value=""></td>
											</tr>
											<tr>
												<td>Confirm Password</td>
												<td><input type="password" class="demoInputBox" name="confirm_password" value=""></td>
											</tr>
											<tr>
												<td>User Type</td>
												<td><input type="radio" name="admin" value="admin" <?php if(isset($_POST['admin']) && $_POST['admin']=="admin") { ?>checked<?php  } ?>> Admin
													<input type="radio" name="admin" value="editor" <?php if(isset($_POST['admin']) && $_POST['admin']=="editor") { ?>checked<?php  } ?>> Editor
												</td>
											</tr>
											<tr>
												<td colspan=2>
													<input type="checkbox" name="terms"> I accept Terms and Conditions <input type="submit" name="submit" value="Register" class="btnRegister"></td>
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
