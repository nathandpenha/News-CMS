<?php include('includes/head.php');
$getArticleID = $_GET['id'];
if(empty($_SESSION['loggedIN']) && ($_SESSION['role'] == 1 || empty($_SESSION['role']))){
	echo '<script> window.location.href= "../index.php"; </script>';
}
if (empty($getArticleID)){
	echo '<script> location.href = "articles.php"; </script>';
}else{
	$getDetails = $db->query("SELECT * FROM ".DB_PREFIX."posts where id = ".$getArticleID)->fetch_assoc();
	$getArtCat = $db->query("SELECT category_name from ".DB_PREFIX."categories where id = ".$getDetails['category'])->fetch_assoc();
	$getPostTags = $db->query("SELECT t.tag_name, p.tag_id as TID FROM ".DB_PREFIX."post_tags p, ".DB_PREFIX."tags t where p.tag_id = t.id and p.post_id = ".$getArticleID);
	if($getDetails['featured'] == 1){
		$feat = "Yes";
	}else{
		$feat = "No";
	}
	if($getDetails['enable_comments'] == 1){
		$comm = "Yes";
	}else{
		$comm = "No";
	}
	if (isset($_POST['upd'])){
		$getTitle = mysqli_real_escape_string($db, strip_tags(trim($_POST['title'])));
		$getCategory = mysqli_real_escape_string($db, strip_tags(trim($_POST['category'])));
		$getFeatured = mysqli_real_escape_string($db, strip_tags(trim($_POST['featured'])));
		$getBody = stripslashes(trim($_POST['body']));
		$getEComments = mysqli_real_escape_string($db, strip_tags(trim($_POST['comments'])));
		$getPTags = $_POST['tags'];

		if(sizeof($getPTags) == 0 && mysqli_num_rows($getPostTags) > 0){
			$tagSQL = $db->query("DELETE FROM ".DB_PREFIX."post_tags where post_id = ".$getArticleID);
		}else if (sizeof($getPTags) == 0 && mysqli_num_rows($getPostTags) == 0){
			//do nothing
		}else{
			$tagSQL = $db->query("DELETE FROM ".DB_PREFIX."post_tags where post_id = ".$getArticleID);
			for($i = 0; $i < sizeof($getPTags); ++$i){
				$asd = "INSERT INTO ".DB_PREFIX."post_tags (`post_id`, `tag_id`) VALUES ( ".$getArticleID.", ".$getPTags[$i]." )";
				$db->query($asd);
			}
		}
		if($getCategory == ".."){
			$getCategory = $getDetails['category'];
		}
		if($getEComments == ".."){
			$getEComments = $getDetails['enable_comments'];
		}
		if($getFeatured == ".."){
			$getFeatured = $getDetails['featured'];
		}
		$sql = "UPDATE ".DB_PREFIX."posts SET `title`=?,`category`=?,`body`=?,`featured`=?,`post_type`='pending',`enable_comments`=? WHERE id = ".$getArticleID;
		$updateSQL = $db->prepare($sql);
		$updateSQL->bind_param('sisii', $getTitle, $getCategory, $getBody, $getFeatured, $getEComments);
		$updateSQL->execute();
		if($updateSQL){
			echo '<script> location.href= "edit_article.php?id='.$getArticleID.'&msg=suc"; </script>';
		}else{
			echo '<script> location.href= "edit_article.php?id='.$getArticleID.'&msg=fail"; </script>';
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
								<strong>Success!</strong> Successfully Updated.
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
								<h3>Edit Article</h3>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Details</h2>
										<span class="pull-right"> </b>Article Created On : </b><?=$getDetails['date_created'];?></span>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<form class="form-horizontal form-label-left" method="post">
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="title" id="title" value="<?=$getDetails['title'];?>" required="required" class="form-control col-md-7 col-xs-12">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Category : (<?=$getArtCat['category_name'];?>)</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select name="category" class="form-control">
														<option value="..">..</option>
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
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Featured : (<?=$feat;?>)</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select id="featued" name="featured" class="form-control">
														<option value="..">..</option>
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
													<textarea id="body" rows="5" name="body" class="form-control"><?=($getDetails['body']);?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Enable Comments : (<?=$comm;?>)</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select name="comments" class="form-control">
														<option value="..">..</option>
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
													<button type="submit" name="upd" class="btn btn-success">Submit</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="">
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Manage Comments</h2>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<table class="table table-striped" id="comTable">
											<thead>
												<tr>
													<th>Comment</th>
													<th>Posted By</th>
													<th>Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Comment</th>
													<th>Posted By</th>
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
				<script src="vendors/datatables.net/js/jquery.dataTables.js" charset="utf-8"></script>
				<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.js" charset="utf-8"></script>
				<script src="vendors/select2/dist/js/select2.min.js" charset="utf-8"></script>
				<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=mni3tl5bo86qzexraoutanzws167ov5cucrg4r1dol3wpjge"></script>
				<script>tinymce.init({ selector:'textarea' });</script>
				<script>
				$(document).ready(function() {
					var table = $('#comTable').DataTable();
					$('#tags').select2();
					<?php
					$ret = array();
					while($prow = $getPostTags->fetch_assoc()){
						array_push($ret, $prow['TID']);
					}
					echo '$("#tags").val('.json_encode($ret).');';
					echo "$('#tags').trigger('change');";
					?>
					$.ajax({
						url: 'lib/na_comments.php',
						type: 'post',
						data: {
							mode: 'list',
							pid : <?=$getArticleID;?>
						},
						success: function(success){
							console.log(success);
							for (i = 0 ; i<success.length ; ++i){
								var button = "<button value='"+success[i].id+"' class='btn btn-danger delCom'><i class='fa fa-trash'></i> Delete</button>";
								table.row.add([success[i].message, success[i].user_name, button]).draw(false);
							}
						}
					});
					$(document).on('click', '.delCom',function(){
						$.ajax({
							url: 'lib/na_comments.php',
							type: 'POST',
							data: {
								mode: 'del',
								val : $(this).val()
							},
							success: function(success){
								if(success.message == "success"){
									alert("Commend Deleted!");
									location.reload();
								}else{
									alert("Some Error Occured! Please Try Again!\n"+success.message);
								}
							}
						});
					});
				});
				</script>
				<?php include('includes/footer.php');
			}
			?>
