<?php
if (file_exists("includes/base.php")){
	include("includes/base.php");
}else{
	header('Location: ../na-install.php');
}
$query = "Select * from ".DB_PREFIX."categories limit 0,8";
$categories = $db->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="<?=$siteDescription;?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="../../favicon.ico">
	<title><?=$siteName;?></title>
	<script src="js/bootstrap.js" ></script>
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
	<link href="css/blog.css" rel="stylesheet">
	<script src="js/jquery.js" charset="utf-8"></script>
</head>

<body>
	<!-- container begins -->
	<div class="container">
		<header class="blog-header py-3">
			<div class="row flex-nowrap justify-content-between align-items-center">
				<?php
				if(empty($_SESSION['loggedIN']) || $_SESSION['loggedIN'] == null){
				?>
				<div class="col-4 offset-4 text-center">
				<?php }else{ ?>
					<div class="col-4">
						<?="Welcome, ".$_SESSION['first_name']." ".$_SESSION['last_name'];?>
					</div>
					<div class="col-4 text-center">
				<?php } ?>
					<a class="blog-header-logo text-dark" href="index.php"><?=$siteName;?></a>
					<br>
					<small>
						<?php
						$day = date('w', strtotime(date('Y-m-d')));
						$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
						echo $days[$day].', ';
						echo date('F d, Y');
						echo $_SESSION['loggedIN'];
						?>
					</small>
				</div>
				<div class="col-4 d-flex justify-content-end align-items-center">
					<?php
					$checkOpen = $db->query("SELECT meta_value from ".DB_PREFIX."site_meta where meta_name = 'UserAccount' ")->fetch_assoc()['meta_value'];
					if(empty($_SESSION['loggedIN']) || $_SESSION['loggedIN'] == null){
						if($checkOpen == "Open"){
							?>
							<a class="btn btn-sm btn-outline-secondary mr-3" href="signup.php">Sign up</a>
							<?php
						}
						?>
						<a class="btn btn-sm btn-outline-secondary" href="login.php">Log In</a>
					<?php }else{
						echo '<a class="btn btn-sm btn-outline-secondary" href="logout.php">Log Out</a>';
						 } ?>
				</div>
			</div>
		</header>

		<div class="nav-scroller py-1 mb-2">
			<nav class="nav d-flex justify-content-between">
				<?php
				if($categories->num_rows>0) {
					while($row=$categories->fetch_assoc()){
						echo "<a class='p-2 text-muted' href='category.php?node=$row[id]'>$row[category_name]</a>";
					}
				}
				?>
			</nav>
		</div>
