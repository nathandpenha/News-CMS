<?php include('includes/head.php');
$getArticleID = $_GET['id'];
if (empty($getArticleID)){
	echo '<script> location.href = "articles.php"; </script>';
}else{
	$getDetails = $db->query("SELECT * FROM ".DB_PREFIX."posts where id = ".$getArticleID)->fetch_assoc();
	$getArtCat = $db->query("SELECT category_name from ".DB_PREFIX."categories where id = ".$getDetails['category'])->fetch_assoc();
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
		$getBody = mysqli_real_escape_string($db, strip_tags(trim($_POST['body'])));
		$getEComments = mysqli_real_escape_string($db, strip_tags(trim($_POST['comments'])));
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
			header('Location: edit_article.php?id='.$getArticleID.'&msg=suc');
		}else{
			header('Location: edit_article.php?id='.$getArticleID.'&msg=fail');
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
													<select id="category" class="form-control">
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
													<textarea id="body" rows="5" name="body" class="form-control"><?=$getDetails['body'];?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Enable Comments : (<?=$comm;?>)</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select id="comments" class="form-control">
														<option value="..">..</option>
														<option value="1">Yes</option>
														<option value="0">No</option>
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
				</div>
				<!-- /page content -->
				<?php include('includes/footer.php');
			}
			?>
