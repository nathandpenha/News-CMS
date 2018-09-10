<?php include('includes/head.php');
if(empty($_SESSION['loggedIN']) && ($_SESSION['role'] == 1 || empty($_SESSION['role']))){
	echo '<script> window.location.href= "../index.php"; </script>';
}
if (isset($_POST['ins'])){
	$getTitle = mysqli_real_escape_string($db, strip_tags(trim($_POST['title'])));
	$getCategory = mysqli_real_escape_string($db, strip_tags(trim($_POST['category'])));
	$getFeatured = mysqli_real_escape_string($db, strip_tags(trim($_POST['featured'])));
	$getBody = stripslashes(trim($_POST['body']));
	$getEComments = mysqli_real_escape_string($db, strip_tags(trim($_POST['comments'])));
	$getPTags = $_POST['tags'];

	$sql = "INSERT INTO ".DB_PREFIX."posts( `title`, `author`, `category`,  `body`, `featured`, `post_type`, `enable_comments`) VALUES (?,?,?,?,?,'pending',?)";
	$insertSQL = $db->prepare($sql);
	$insertSQL->bind_param('siisii', $getTitle, $_SESSION['uid'], $getCategory, $getBody, $getFeatured, $getEComments);
	$insertSQL->execute();
	if($insertSQL){
		if(sizeof($getPTags) > 0){
			$getArticleID = $db->insert_id;
			for($i = 0; $i < sizeof($getPTags); ++$i){
				$asd = "INSERT INTO ".DB_PREFIX."post_tags (`post_id`, `tag_id`) VALUES ( ".$getArticleID.", ".$getPTags[$i]." )";
				error_log($asd);
				$db->query($asd);
			}
		}
		echo '<script> location.href= "articles.php?msg=suc"; </script>';
	}else{
		echo '<script> location.href= "add_article.php?msg=fail"; </script>';
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
					if($_GET['msg'] == "suc"){
						?>
						<div class="alert alert-success alert-dismissible fade in msg" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							</button>
							<strong>Success!</strong> Successfully Added.
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
					<div class="page-title">
						<div class="title_left">
							<h3>Add an Article</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Details</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<form class="form-horizontal form-label-left" method="post">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="title" id="title" required="required" class="form-control col-md-7 col-xs-12" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Category : </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="category" class="form-control" required>
													<?php
													$getCategories = $db->query("SELECT * from ".DB_PREFIX."categories");
													while($crow = $getCategories->fetch_assoc()){
														echo '<option value="'.$crow['id'].'">'.$crow['category_name'].'</option>';
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Featured : </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select id="featued" name="featured" class="form-control" required>
													<option value="1">Yes</option>
													<option value="0">No</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Body <span class="required">*</span>
											</label>
											<br>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<textarea id="body" rows="5" name="body" class="form-control"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Enable Comments :</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="comments" class="form-control" required>
													<option value="1">Yes</option>
													<option value="0">No</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Tags</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select class="form-control" id="tags" name="tags[]" multiple="multiple">
													<?php
													$getAllTags = $db->query("SELECT * FROM ".DB_PREFIX."tags");
													while($trow = $getAllTags->fetch_assoc()){
														echo '<option value="'.$trow['id'].'">'.$trow['tag_name'].'</option>';
													}
													?>
												</select>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group">
											<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
												<button type="submit" name="ins" class="btn btn-success">Submit</button>
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
			<script src="vendors/datatables.net/js/jquery.dataTables.js" charset="utf-8"></script>
			<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.js" charset="utf-8"></script>
			<script src="vendors/select2/dist/js/select2.min.js" charset="utf-8"></script>
			<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=mni3tl5bo86qzexraoutanzws167ov5cucrg4r1dol3wpjge"></script>
			<script>tinymce.init({ selector:'textarea' });</script>
			<script>
			var table = $('#comTable').DataTable();
			$('#tags').select2();
			</script>
			<?php include('includes/footer.php');
			?>
