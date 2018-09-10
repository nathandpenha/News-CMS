<?php include('includes/head.php');
if(empty($_SESSION['loggedIN']) && ($_SESSION['role'] != 3 || empty($_SESSION['role']))){
	echo '<script> window.location.href= "index.php"; </script>';
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
							<h3>All Users</h3>
						</div>
					</div>
					<a href="addUser.php"><button class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New User</i></button></a>
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
			<!-- Small modal -->
			<div class="modal fade roleUser" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
							</button>
							<h4 class="modal-title" id="myModalLabel2">Select New Role</h4>
						</div>
						<div class="modal-body">
							<input type="hidden" id="getUID" value="">
							<label>Role : </label>
							<br>
							<select id="newRole" class="form-control">
								<option value=""></option>
								<option value="1">User</option>
								<option value="2">Editor</option>
								<option value="3">Admin</option>
							</select>
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type="button" id="changeRole" value="Submit!" class="btn btn-primary">
						</div>
					</div>
				</div>
			</div>
			<!-- /modals -->
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
							var button = "<button value='"+success[i].id+"' class='btn btn-danger delUser'><i class='fa fa-trash'></i> Delete</button>";
							button += "<button data-id='"+success[i].id+"' class='btn btn-warning openChange' data-toggle='modal' data-target='.roleUser'><i class='fa fa-random'></i> Change Role</button>";
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
				$(document).on("click", ".openChange", function () {
					var uID = $(this).data('id');
					$(".modal-body #getUID").val( uID );
				});
				$(document).on('click', '#changeRole', function(){
					$.ajax({
						url: 'lib/na_users.php',
						type: 'POST',
						data: {
							mode: 'change',
							uid : $("#getUID").val(),
							role : $("#newRole").val()
						},
						success: function(success){
							if(success.message == "success"){
								alert("User Role Changed");
								location.reload();
							}else{
								alert("Some Error Occured! Please Try Again!\n"+success.message);
							}
						}
					});
				});
				$(document).on('click', '.delUser',function(){
					if(confirm("Are You Sure You Want To Delete ?")){
						$.ajax({
							url: 'lib/na_users.php',
							type: 'POST',
							data: {
								mode: 'del',
								val : $(this).val()
							},
							success: function(success){
								if(success.message == "success"){
									alert("User Deleted");
									location.reload();
								}else{
									alert("Some Error Occured! Please Try Again!\n"+success.message);
								}
							}
						});
					}
				});
			});
			</script>
