<?php include('includes/head.php'); ?>
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
							<h3>All Users</h3>
						</div>
					</div>
					<button class="btn btn-success pull-right" data-toggle="modal" data-target=".addUserModal"><i class="fa fa-plus"></i> Add New User</i></button>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>List</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<table class="table table-striped" id="tagTable">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Email</th>
												<th>Role</th>
												<th>Action</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Email</th>
												<th>Role</th>
												<th>Action</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page content -->
			<?php include('includes/footer.php'); ?>
			<script src="vendors/datatables.net/js/jquery.dataTables.js" charset="utf-8"></script>
			<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.js" charset="utf-8"></script>
			<script type="text/javascript">
			$(document).ready(function() {
				var table = $('#tagTable').DataTable();
				$.ajax({
					url: 'lib/na_users.php',
					type: 'post',
					data: {
						mode: 'list'
					},
					success: function(success){
						console.log(success);
						for (i = 0 ; i<success.length ; ++i){
							var button = "<button value='"+success[i].id+"' class='btn btn-danger delTag'><i class='fa fa-trash'></i> Delete</button>";
							var getRole = success[i].role;
							if (getRole == 1){
								var role = "User";
							}else if (getRole == 2){
								var role = "Editor";
							}else{
								var role = "Admin";
							}
							table.row.add([i+1, success[i].first_name +" "+ success[i].last_name, success[i].email , role, button]).draw(false);
						}
					}
				});
				$(document).on('click', '.delTag',function(){
					$.ajax({
						url: 'lib/na_users.php',
						type: 'POST',
						data: {
							mode: 'del',
							val : $(this).val()
						},
						success: function(success){
							if(success.message == "success"){
								alert("Tag Deleted");
								location.reload();
							}else{
								alert("Some Error Occured! Please Try Again!\n"+success.message);
							}
						}
					});
				});
			});
			</script>
