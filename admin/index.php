<?php
include('includes/head.php');
if(empty($_SESSION['loggedIN']) && ($_SESSION['role'] == 1 || empty($_SESSION['role']))){
	echo '<script> window.location.href= "../index.php"; </script>';
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
							<strong>Success!</strong> Welcome <?=($_SESSION['first_name'].' '.$_SESSION['last_name']);?>.
						</div>
						<?php
					}
					?>
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
									Add content to the page ...
									<?php var_dump($_SESSION);?>
									<br>
									<?php var_dump($_SERVER); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page content -->
			<?php include('includes/footer.php'); ?>
