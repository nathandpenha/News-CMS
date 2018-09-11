<?php
include("includes/header.php");
?>
<div class="row mb-2" id="featured_post">
	<!-- Ajax will load data -->
</div>
<main role="main" class="container">
	<div class="row">
		<?php
		$query = "SELECT * FROM ".DB_PREFIX."posts where featured = 0 and post_type = 'published' ORDER BY `date_created` DESC LIMIT 0,10";
		$posts = $db->query($query);
		if($posts->num_rows > 0) {
			while($row = $posts->fetch_assoc()){
				$getAuthor = $db->query("SELECT CONCAT(`first_name`,' ',`last_name`) as author, id from ".DB_PREFIX."users where `id` = ".$row['author']);
				$author = $getAuthor->fetch_assoc();
				?>
				<div class="col-md-6 blog-main">
					<div class="blog-post">
						<h4><a href="article.php?node=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h4>
						<p class="blog-post-meta"><?php echo $row['date']; ?> by <?=$author['author'];?></p>
						<?php $body = $row['body'];
						echo substr($body,0,40)."...";
						?>
						<a href="article.php?node=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>
					</div><!-- /.blog-post -->
				</div>
				<?php
			}
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
