<?php
if (file_exists("includes/base.php")){
	include("includes/base.php");
}else{
	header('Location: ../na-install.php');
}
$query = "Select * from ".DB_PREFIX."categories";
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
			<div class="col-12 text-center">
				<a class="blog-header-logo text-dark" href="index.php"><?=$siteName;?></a>
				<br>
				<small>
					<?php
					$day = date('w', strtotime(date('Y-m-d')));
					$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
					echo $days[$day].', ';
					echo date('F d, Y');
					?>
				</small>
			</div>
		</header>

		<div class="nav-scroller py-1 mb-2">
			<nav class="nav d-flex justify-content-between">
				<?php
				if($categories->num_rows>0) {
					while($row=$categories->fetch_assoc()){
						echo "<a class='p-2 text-muted' href='index.php?category=$row[id]'>$row[category_name]</a>";
					}
				}
				?>
			</nav>
		</div>
