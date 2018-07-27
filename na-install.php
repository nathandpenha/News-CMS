<?php
if (file_exists("includes/base.php")){
	echo "Installed Script";
}else{
	?>
	<!DOCTYPE html>
	<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Install | News On the GO!</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<script src="js/bootstrap.js" charset="utf-8"></script>
		<script src="js/jquery.js" charset="utf-8"></script>
		<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
		<style>
		body{
			font-family: Helvetica;
			padding-top: 40px;
			padding-bottom: 40px;
			text-align: center !important;
		}
		.form-box{
			padding : 15px;
			border-radius: 5px;
		}
		.logo{
			height : 150px;
		}
		hr{
			width: 60%;
		}
		</style>
	</head>
	<body>
		<div class="row">
			<div class="col-md-12">
				<div class="container">
					<div class="form-box align-items-center">
						<img src="img/NA.png" class="logo">
						<hr>
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
								<input placeholder="Database Password" type="password" name="db_password" id="db_password" class="form-control" required>
							</div>
							<div class="col-md-6 offset-md-3 pt-3">
								<label for="db_prefix" class="sr-only">Table Prefix</label>
								<input type="text" name="db_prefix" id="db_prefix" class="form-control" placeholder="Table Prefix (Default : na_)" required>
							</div>
							<div class="col-md-6 offset-md-3 pt-3">
								<button class="btn btn-primary" name="db_btn">Continue</button>
							</div>
						</form>
						<br><br>
						<p class="text-muted" id="prefix">
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
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
	</html>
	<?php
}
?>
