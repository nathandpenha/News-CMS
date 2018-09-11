<?php
include("includes/header.php");
if(empty($_GET['month']) || empty($_GET['year'])){
	echo '<script>window.location.href="index.php";';
}
$getMonth = $_GET['month'];
$getYear = $_GET['year'];
$getData = $db->query("SELECT * from ".DB_PREFIX."posts where monthname(date_created) = '".$getMonth."' and year(date_created) = ".$getYear);
?>
<main role="main" class="container">
	<h4 class="pb-3 mb-4 mt-4 border-bottom">
		Articles | <?=($_GET['month'].' '.$_GET['year']);?>
	</h4>
	<div class="row">
		<?php
		if($getData->num_rows > 0) {
			while($row = $getData->fetch_assoc()){
				?>
				<div class="col-md-6 blog-main">
					<div class="blog-post">
						<h4><a href="article.php?node=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h4>
						<p class="blog-post-meta"><?php echo $row['date']; ?></p>
						<a href="article.php?node=<?php echo $row['id']; ?>" class="btn btn-primary">Read Article </a>
					</div><!-- /.blog-post -->
				</div>
				<?php
			}
		}else{
			echo "No Articles in this Period";
		}
		?>
	</div><!-- row ends -->
</main><!-- /.blog-main -->
</div><!-- container ends -->
<center><a href="#">Back to top</a></center>
<br>
<script src="js/index.js" charset="utf-8"></script>
<?php
include("includes/footer.php");
?>
