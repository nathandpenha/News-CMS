<?php
include('includes/head.php');

		
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
									<form name="select form" method="post" action="editUser.php">
										<table border="0" width="500" align="center" class="demo-table">
									
								<tr><td>
												Select User to Edit Details	Email <select name="selectedemail">
														<?php  $sql = "SELECT email from aka_users;";
																$result = $db->query($sql);
																while($row = $result->fetch_assoc()) {
																	$emailvalue=$row["email"];
													echo "<option value=$emailvalue>" .$emailvalue."</option>" ;
													}
														?>
														</select>
												</td>
												</tr>
												
												<tr><td>
													<input type=submit name="GetUser" value="Select User">
												</td>
												</tr>
											
								</table>
								</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /page content --><!-- /page content -->
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
