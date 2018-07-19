<?php
include("includes/header.php");

	if(isset($_GET['category'])){
		$category=mysqli_real_escape_string($db, $_GET['category']);
		$query = "select * from posts where category='$category'";	
	}
	else{

	$query = "select * from posts";
	
	}
	$posts = $db->query($query);
?>
<div class="blog-header">
      <div class="container">
        <h1 class="blog-title">News On The GO!</h1>
        <p class="lead blog-description">The news for you and by you!</p>
      </div>
    </div>

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
	<?php } } ?>
          

          <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
          </nav>
</div><!-- /.blog-main -->
<?php
include("includes/sidebar.php");

?><?php
include("includes/footer.php");

?>
      
