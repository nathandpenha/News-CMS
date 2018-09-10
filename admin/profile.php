<?php
include('includes/head.php');

if(isset($_POST['firstnamechanged'])){
	$firstname=mysqli_real_escape_string($db, strip_tags(trim($_POST['firstname'])));
	$stmt = $db->prepare("update ".DB_PREFIX."users set  first_name=? where id=?");
	$stmt->bind_param("si", $firstname, $_SESSION['uid']);
	if($stmt->execute()){
		session_destroy();
		echo "<script> location.href='login.php?&msg=fname';</script>";
	}else{
		echo "<script> location.href='site_settings.php?&msg=fail'; </script>";
	}
}

if(isset($_POST['lastnamechanged'])){
	$lastname=mysqli_real_escape_string($db, strip_tags(trim($_POST['lastname'])));
	$stmt = $db->prepare ("update ".DB_PREFIX."users set  last_name=?   where email=?");
	$stmt->bind_param("ss", $lastname, $_SESSION['email']);
	if($stmt->execute()){
		session_destroy();
		echo "<script> location.href= 'login.php?&msg=lname'; </script>";
	}else{
		echo "<script> location.href= 'profile.php?&msg=fail'; </script>";
	}
}

if(isset($_POST['passwordchanged'])){
	$oldpassword=mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["oldpassword"]))));
	$newpassword=mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["newpassword"]))));
	$confirnewpassword=mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["confirnewpassword"]))));

	$stmt = $db->prepare ("update ".DB_PREFIX."users set  password=?   where email=? and password=? ");
	$stmt->bind_param("sss", $newpassword, $_SESSION['email'],$oldpassword);

	if($confirnewpassword==$newpassword){
		if($stmt->execute()){
			session_destroy();
			echo "<script> location.href= 'login.php?&msg=suc'; </script>";
		}else{
			echo "<script> location.href= 'profile.php?&msg=fail'; </script>";
		}
	}else{
		echo "<script> location.href= 'profile.php?&msg=mis'; </script>";
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
					if($_GET['msg'] == "mis"){
						?>
						<div class="alert alert-warning alert-dismissible fade in msg" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							</button>
							<strong>Error!</strong> Passwords Did Not Match!
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
					<!-- page content -->
					<div class="page-title">
						<div class="title_left">
							<h3>User Profile</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_content">
									<div class="col-md-12 col-sm-9 col-xs-12">
										<div class="" role="tabpanel">
											<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
												<li role="presentation" class="active"><a href="#" aria-expanded="true"><b><?=$_SESSION['first_name'];?> <?=$_SESSION['last_name'];?>'s Profile</b></a>
												</li>
											</ul>
											<form class="form-horizontal form-label-left" method="post">
												<div class="form-group">
													<label class="col-sm-3 control-label">Change First Name</label>
													<div class="col-sm-9 col-md-6">
														<div class="input-group">
															<input type="text" name="firstname" class="form-control" value=<?=$_SESSION['first_name']?> >
															<span class="input-group-btn">
																<input type="submit" value="Change First Name" name="firstnamechanged" class="btn btn-primary">
															</span>
														</div>
													</div>
												</div>
											</form>
											<div class="ln_solid"></div>
											<form class="form-horizontal form-label-left" method="post">
												<div class="form-group">
													<label class="col-sm-3 control-label">Change Last Name</label>
													<div class="col-sm-9 col-md-6">
														<div class="input-group">
															<input type="text" name="lastname" class="form-control" value=<?=$_SESSION['last_name']?> >
															<span class="input-group-btn">
																<input type="submit" value="Change Last Name" name="lastnamechanged" class="btn btn-primary">
															</span>
														</div>
													</div>
												</div>
											</form>
											<div class="ln_solid"></div>
											<form class="form-horizontal form-label-left" method="post">
												<div class="form-group">
													<label class="col-md-3 control-label">Old Password</label>
													<div class="col-sm-6 col-md-6">
														<input type="password" name="oldpassword" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">New Password</label>
													<div class="col-sm-6 col-md-6">
														<input type="password" name="newpassword" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Confirm Password</label>
													<div class="col-sm-6 col-md-6">
														<input type="password" name="confirnewpassword" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
														<input type="submit" value="Change Password" name="passwordchanged" class="btn  btn-primary">
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page content -->

			<?php include('includes/footer.php'); ?>
