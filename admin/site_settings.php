<?php
include('includes/head.php');
if ($_SESSION['super_admin'] != 1){
	echo '<script> window.location.href = "index.php"; </script>';
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
							<h3>Site Configuration</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Settings</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<form class="form-horizontal form-label-left">
										<div class="form-group">
											<label class="col-sm-3 control-label">Site Name</label>
											<div class="col-sm-9 col-md-6">
												<div class="input-group">
													<input type="text" value="<?=$siteName;?>" id="site_name" class="form-control col-md-7 col-xs-12">
													<span class="input-group-btn">
														<button type="button" value="sNameBtn" class="btn act btn-primary">Change!</button>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Site Description</label>
											<div class="col-sm-9 col-md-6">
												<div class="input-group">
													<input type="text" value="<?=$siteDescription;?>" id="site_desc" class="form-control col-md-7 col-xs-12">
													<span class="input-group-btn">
														<button type="button" value="sDescBtn" class="btn act btn-primary">Change!</button>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Users can create account :</label>
											<div class="col-sm-9 col-md-6">
												<div class="input-group" >
													<select id="userAcc" class="form-control" style="border-radius : 0px;">
														<option value="Open">Open</option>
														<option value="Closed">Closed</option>
													</select>
													<span class="input-group-btn">
														<button type="button" value="userAccBtn" class="btn act btn-primary">Change!</button>
													</span>
												</div>
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
			<script>
			$(document).ready(function() {
				$("select").val("<?=$userAccess;?>");
				$(document).on('click', '.act', function(event) {
					event.preventDefault();
					if($(this).val() == "userAccBtn"){
						var mode = 'UserAccount';
						var val = $("#userAcc").val();
					}else if ($(this).val() == "sDescBtn"){
						var mode ='WebSiteDescription';
						var val =$("#site_desc").val();
					}else if($(this).val()== "sNameBtn"){
						var mode = 'WebSiteName';
						var val = $("#site_name").val();
					}
					$.ajax({
						url: 'lib/na_site_config.php',
						type: 'POST',
						data: {
							mode: mode,
							val : val
						},
						success: function(data){
							if (data.message == "success"){
								alert("Successfully Changed!");
								location.reload();
							}else{
								alert("Some Error Occured");
							}
						}
					});
				});
			});
			</script>
			<?php include('includes/footer.php'); ?>
