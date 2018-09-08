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
							<h3>Articles</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>All Articles</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<table class="table table-striped" id="articleTable">
										<thead>
											<tr>
												<th>Title</th>
												<th>Author</th>
												<th>Category</th>
												<th>Status</th>
												<th>Date Created</th>
												<th>Action</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Title</th>
												<th>Author</th>
												<th>Category</th>
												<th>Status</th>
												<th>Date Created</th>
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
			<script>
			$(document).ready(function() {
				var table = $('#articleTable').DataTable();
				$.ajax({
					url: 'lib/na_articles.php',
					type: 'POST',
					data: {
						mode: 'list',
						type : '<?=$_SESSION['admin'];?>',
						uid : '<?=$getUserID;?>'
					},
					success: function(data){
						console.log(data);
						for (i = 0; i < data.length; ++i){
							var star = "";
							if (data[i].featured == 1){
								star = "<i class='fa fa-star'></i> &nbsp;&nbsp;";
							}
							var button = "<button value='"+data[i].id+"' data-toggle='tooltip' data-placement='top' title='Delete' class='btn btn-danger delArt'><i class='fa fa-trash'></i></button>";
							button += "<a href='edit_article.php?id="+data[i].id+"'><button value='"+data[i].id+"' data-toggle='tooltip' data-placement='top' title='Edit' class='btn btn-primary editArt'><i class='fa fa-pencil'></i></button></a>";
							table.row.add([star + data[i].title, data[i].author_name, data[i].category_name, data[i].post_type, data[i].date_created, button]).draw(false);
						}
					}
				});
				$(document).on('click', '.delArt',function(){
					if (confirm("Are You Sure ?")) {
						$.ajax({
							url: 'lib/na_articles.php',
							type: 'POST',
							data: {
								mode: 'del',
								val : $(this).val()
							},
							success: function(success){
								if(success.message == "success"){
									alert("Article Deleted!");
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
