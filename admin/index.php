<?php
include('includes/head.php');
if(empty($_SESSION['loggedIN']) && ($_SESSION['role'] == 1 || empty($_SESSION['role']))){
	echo '<script> window.location.href= "../index.php"; </script>';
}
$totalUsers = $db->query("SELECT COUNT(*) ans FROM ".DB_PREFIX."users")->fetch_assoc()['ans'];
$totalPublishedPosts = $db->query("SELECT COUNT(*) ans FROM ".DB_PREFIX."posts where post_type = 'published'")->fetch_assoc()['ans'];
$totalTags = $db->query("SELECT COUNT(*) ans FROM ".DB_PREFIX."tags")->fetch_assoc()['ans'];
$totalCategories = $db->query("SELECT COUNT(*) ans FROM ".DB_PREFIX."categories")->fetch_assoc()['ans'];
$getRecentPost = $db->query("SELECT * FROM ".DB_PREFIX."posts order by date_created desc limit 0,1")->fetch_assoc();
$getRecentComment = $db->query("SELECT * FROM ".DB_PREFIX."comments order by date_created desc limit 0,1")->fetch_assoc();
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
					<!-- top tiles -->
					<div class="row tile_count">
						<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
							<span class="count_top"><i class="fa fa-user"></i> Total Users</span>
							<div class="count green"><?=$totalUsers;?></div>
						</div>
						<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
							<span class="count_top"><i class="fa fa-file-o"></i> Total Published Articles</span>
							<div class="count green"><?=$totalPublishedPosts;?></div>
						</div>
						<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
							<span class="count_top"><i class="fa fa-tags"></i> Total Tags</span>
							<div class="count green"><?=$totalTags;?></div>
						</div>
						<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
							<span class="count_top"><i class="fa fa-pencil"></i> Total Categories</span>
							<div class="count green"><?=$totalCategories;?></div>
						</div>
					</div>
					<!-- /top tiles -->
					<div class="page-title">
						<div class="title_left">
							<h3>Dashboard</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Welcome to NA Dashboard </h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<h2>Get Started..</h2>
									<a href="add_article.php"><button class="btn btn-primary"><i class="fa fa-plus"></i> Publish An Article </button></a>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Activity</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<h2>Post </h2>
									<h4> <?=$getRecentPost['title'];?>
										&nbsp; &nbsp; &nbsp;<small> <?=date('F d, Y', strtotime($getRecentPost['date_created']));?></small>
									</h4>
									<p><?=substr($getRecentPost['body'], 0,200);?></p>
								</div>
								<div class="clearfix"></div>
								<hr>
								<div class="clearfix"></div>
								<h2> Comments
									&nbsp; &nbsp; &nbsp;<small> <?=date('F d, Y', strtotime($getRecentComment['date_created']));?></small>
								</h2>
								<p><?=$getRecentComment['message'];?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /page content -->
			<?php include('includes/footer.php'); ?>
