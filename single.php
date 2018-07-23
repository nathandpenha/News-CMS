<?php
include("includes/header.php");
	
	if(isset($_GET['post'])){
		$id=mysqli_real_escape_string($db, $_GET['post']);
		$query = "select * from posts where id='$id'";	
	}
	
	$posts = $db->query($query);
?>
<br>
    <div class="blog-header">
      <div class="container">
        <h1 class="blog-title">News On The GO!</h1>
        <p class="lead blog-description">An example blog template built with Bootstrap.</p>
      </div>
    </div>
             <?php if($posts->num_rows > 0) { 

	while($row = $posts->fetch_assoc()){

	?>
          <div class="blog-post">
            <h2 class="blog-post-title"><?php echo $row['title']; ?></h2>
            <p class="blog-post-meta"><?php echo $row['date']; ?> by <a href="#"><?php echo $row['author']; ?></a></p>

         <?php $body = $row['body']; 
		echo $body;
	?>

          </div><!-- /.blog-post -->
	<?php } } ?>
	<blockquote>2 Comments</blockquote>
	<div class="comment-area">
		<form>
		  <div class="form-group">
		    <label for="exampleInputEmail1">Name</label>
		    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Name">
		  </div>
		 <div class="form-group">
		    <label for="exampleInputEmail1">Website</label>
		    <input type="text" name="website" class="form-control" id="exampleInputEmail1" placeholder="Website(optional)">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Comment</label>
		    <textarea cols="60" rows="10" name="comment" class="form-control" > </textarea>
		  </div>
		
		  <button type="submit" name="post_comment" class="btn btn-primary">Post Comment</button>
		</form>
<br><br><hr>
<div class="comment">
	<div class="comment-head">
	<a href="#">Basit Altaf</a>
	<img width="50" height="50" src="img/noimg.jpg"/>
	
	</div>
</div></div>
This is a comment by me.
</div><!-- /.blog-main -->
<?php
include("includes/sidebar.php");

?>
<?php
include("includes/footer.php");

?>
      
