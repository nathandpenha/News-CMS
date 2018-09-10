<?php
include('includes/head.php');
include("captcha/simple-php-captcha.php");
if(isset($_POST['submit']))
{
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
	$firstName=mysqli_real_escape_string($db, strip_tags(trim($_POST['firstName'])));
	$lastName=mysqli_real_escape_string($db, strip_tags(trim($_POST['lastName'])));
	$email = mysqli_real_escape_string($db, strip_tags(trim($_POST["email"])));
	$password = mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["password"]))));
	$admin=mysqli_real_escape_string($db, strip_tags(trim($_POST['admin'])));
	$sql = "insert into ".DB_PREFIX."users ( first_name , last_name , email , password , role ) values (?,?,?,?,?)";
	$stmt = $db->prepare($sql);
	$stmt->bind_param("ssssi", $firstName, $lastName, $email, $password, $admin);
	if($stmt->execute()){
		echo "<script> location.href= 'addUser.php?&msg=suc'; </script>";
	}else{
		echo "<script> location.href= 'addUser.php?&msg=fail'; </script>";
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
					<?php
					if($_GET['msg'] == "suc"){
						?>
						<div class="alert alert-success alert-dismissible fade in msg" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							</button>
							<strong>Success!</strong> Successfully Added New User.
						</div>
						<?php
					}
					if($_GET['msg'] == "fail"){
						?>
						<div class="alert alert-danger alert-dismissible fade in msg" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							</button>
							<strong>Failed!</strong> Some Error Occured. Please Try Again!
						</div>
						<?php
					}
					?>
					<div class="page-title">
						<div class="title_left">
							<h3>Add New User</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Enter Details</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<form class="form-horizontal form-label-left" method="post">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" class="form-control col-md-7 col-xs-12" name="firstName" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" class="form-control col-md-7 col-xs-12" name="lastName" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="email" class="form-control col-md-7 col-xs-12" name="email" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="password" class="form-control col-md-7 col-xs-12" name="password" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Confirm Password<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="password" class="form-control col-md-7 col-xs-12" name="confirm_password" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Role</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="admin" class="form-control">
													<option value="3">Admin</option>
													<option value="2">Editor</option>
													<option value="1">Normal User</option>
												</select>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group">
											<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
												<button type="submit" name="submit" class="btn btn-success">Submit!</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page content -->
			<?php include('includes/footer.php'); ?>
