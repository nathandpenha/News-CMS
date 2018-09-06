<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Install | News On the GO!</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<script src="js/jquery.js" charset="utf-8"></script>
	<script src="js/bootstrap.js" charset="utf-8"></script>
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
	<link href="css/install.css" rel="stylesheet">
</head>
<body>
	<div class="row">
		<div class="col-md-12">
			<div class="container">
				<div class="form-box align-items-center">
					<img src="img/NA.png" class="logo">
					<hr>
					<?php
					if (file_exists("includes/base.php") ){
						if ($_GET['suc']=="install"){
							?>
							<form action="installation/setupSite.php" method="post">
								<h5>Enter Details</h5>
								<div class="col-md-6 offset-md-3 pt-3">
									<label for="fist_name" class="sr-only">First Name</label>
									<input type="text" name="first_name" class="form-control" placeholder="First Name" required>
								</div>
								<div class="col-md-6 offset-md-3 pt-3">
									<label for="last_name" class="sr-only">Last Name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
								</div>
								<div class="col-md-6 offset-md-3 pt-3">
									<label for="email" class="sr-only">Email</label>
									<input type="email" name="email" class="form-control" placeholder="Email" required>
								</div>
								<div class="col-md-6 offset-md-3 pt-3">
									<label for="password" class="sr-only">Password</label>
									<input type="password" name="password" class="form-control" placeholder="Password" >
								</div>
								<hr>
								<div class="col-md-6 offset-md-3 pt-1">
									<label for="website_name" class="sr-only">WebSite Name</label>
									<input type="text" name="website_name" class="form-control" placeholder="WebSite Name" required>
								</div>
								<div class="col-md-6 offset-md-3 pt-1">
									<label for="website_description" class="sr-only">WebSite Description</label>
									<input type="text" name="website_description" class="form-control" placeholder="WebSite Description" required>
								</div>
								<div class="col-md-6 offset-md-3 pt-3">
									<button class="btn btn-success" type="submit" name="db_btn">Continue</button>
								</div>
							</form>
							<?php
						}else{
							header('Location: index.php');
						}
					}else{
						?>
						<form action="installation/createBase.php" method="post">
							<h5>Enter Details</h5>
							<div class="col-md-6 offset-md-3 pt-3">
								<label for="db_name" class="sr-only">Database Name</label>
								<input placeholder="Database Name" type="text" name="db_name" id="db_name" class="form-control" required>
							</div>
							<div class="col-md-6 offset-md-3 pt-3">
								<label for="db_user_name" class="sr-only">Database User Name</label>
								<input placeholder="Database User Name" type="text" name="db_user_name" id="db_user_name" class="form-control" required>
							</div>
							<div class="col-md-6 offset-md-3 pt-3">
								<label for="db_host_name" class="sr-only">Database Host Name</label>
								<input placeholder="Database Host Name (Default : localhost)" type="text" name="db_host_name" id="db_host_name" class="form-control" required>
							</div>
							<div class="col-md-6 offset-md-3 pt-3">
								<label for="db_password" class="sr-only">Database Password</label>
								<input placeholder="Database Password" type="password" name="db_password" id="db_password" class="form-control" >
							</div>
							<div class="col-md-6 offset-md-3 pt-3">
								<label for="db_prefix" class="sr-only">Table Prefix</label>
								<input type="text" name="db_prefix" id="db_prefix" class="form-control" value="na" placeholder="Table Prefix (Default : na_)" required>
							</div>
							<div class="col-md-6 offset-md-3 pt-3">
								<button class="btn btn-primary" type="submit" name="db_btn">Continue</button>
							</div>
						</form>
						<br><br>
						<p class="text-muted" id="prefix">
						</p>
						<script>
						$(document).ready(function() {
							$("#db_prefix").keyup(function(){
								if ($("#db_prefix").val() == "") {
									var text = "na";
								}else{
									var text = $("#db_prefix").val();
								}
								$("#prefix").html("Sample Table Name : " + text + "_users");
							});
						});
						</script>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
