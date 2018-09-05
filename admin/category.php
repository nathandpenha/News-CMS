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
							<h3>All Categories</h3>
						</div>
					</div>
					<button class="btn btn-success pull-right" data-toggle="modal" data-target=".addCatModal"><i class="fa fa-plus"></i> Add New Cateogry</i></button>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>List</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<table class="table table-striped" id="catTable">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>No. of Posts</th>
												<?php if ($_SESSION['admin']){ ?>
													<th>Action</th>
												<?php } ?>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>No. of Posts</th>
												<?php if ($_SESSION['admin']){ ?>
													<th>Action</th>
												<?php } ?>
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
			<div class="modal fade addCatModal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
							</button>
							<h4 class="modal-title" id="myModalLabel2">Enter Category Details</h4>
						</div>
						<div class="modal-body">
							<label>Enter Category Name : </label>
							<br>
							<input type="text" class="form-control" id="newCatVal" required pattern="[a-zA-Z]*">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type="button" id="addNewCat" value="Submit!" class="btn btn-primary">
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
				var table = $('#catTable').DataTable();
				$.ajax({
					url: 'lib/na_category.php',
					type: 'post',
					data: {
						mode: 'list'
					},
					success: function(success){
						for (i = 0 ; i<success.length ; ++i){
							<?php
							if ($_SESSION['admin']){
								?>
								var button = "<button value='"+success[i].id+"' class='btn btn-danger delCat'><i class='fa fa-trash'></i> Delete</button>";
								table.row.add([i+1, success[i].category_name, success[i].count.ans ,button]).draw(false);
								<?php
							}else{
								?>
								table.row.add([i+1, success[i].category_name, success[i].count.ans]).draw(false);
								<?php
							}
							?>
						}
					}
				});
				$("#addNewCat").on('click', function(){
					$.ajax({
						url: 'lib/na_category.php',
						type: 'POST',
						data: {
							mode: 'add',
							val : $("#newCatVal").val()
						},
						success: function(success){
							if(success.message == "success"){
								alert("New Category Added!");
								location.reload();
							}else{
								alert("Some Error Occured! Please Try Again!\n"+success.message);
							}
						}
					});
				});
				$(document).on('click', '.delCat',function(){
					$.ajax({
						url: 'lib/na_category.php',
						type: 'POST',
						data: {
							mode: 'del',
							val : $(this).val()
						},
						success: function(success){
							if(success.message == "success"){
								alert("New Category Added!");
								location.reload();
							}else{
								alert("Some Error Occured! Please Try Again!\n"+success.message);
							}
						}
					});
				});
			});
			</script>
