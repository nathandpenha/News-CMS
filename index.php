<?php
include("includes/header.php");
?>
<div class="row mb-2" id="featured_post">
	<!-- Ajax will load data -->
</div>
<main role="main" class="container">
	<div class="row">
		<div class="col-md-8 blog-main">
			<?php if($posts->num_rows > 0) {
				while($row = $posts->fetch_assoc()){
					?>
					<div class="blog-post">
						<h2 class="blog-post-title"><a href="single.php?post=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
						<p class="blog-post-meta"><?php echo $row['date']; ?> by <a href="#"><?php echo $row['author']; ?></a></p>
						<?php $body = $row['body'];
						echo substr($body,0,30)."...";
						?>
						<a href="single.php?post=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>
					</div><!-- /.blog-post -->
					<?php
				}
			}
			?>
			<nav class="blog-pagination">
				<a class="btn btn-outline-primary" href="#">Older</a>
				<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
			</nav>
		</div>
		<?php
		include("includes/sidebar.php");
		?>
	</div><!-- row ends -->
</main><!-- /.blog-main -->
</div><!-- container ends -->
<script src="js/index.js" charset="utf-8"></script>
<?php
include("includes/footer.php");
?>
