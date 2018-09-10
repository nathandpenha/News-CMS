<?php
include("includes/header.php");
if(empty($_GET['node'])){
	header('Location: index.php');
}
$getID = $_GET['node'];
$getPost = $db->query("SELECT * FROM ".DB_PREFIX."posts where id = ".$getID)->fetch_assoc();
$getTags = $db->query("SELECT t.tag_name as tn, t.id as TID FROM ".DB_PREFIX."post_tags p, ".DB_PREFIX."tags t where t.id = p.tag_id and p.post_id = ".$getID);
$getComments = $db->query("SELECT c.message msg, concat(u.first_name, ' ', u.last_name) fname FROM ".DB_PREFIX."comments c, ".DB_PREFIX."users u where c.post_id = ".$getID." and c.user_id = u.id order by c.date_created desc limit 0,5");
$getCategory = $db->query("SELECT category_name from ".DB_PREFIX."categories where id = ".$getPost['category']);
$getAuthor = $db->query("SELECT concat(first_name,' ',last_name) as fname from ".DB_PREFIX."users where id = ".$getPost['author'])->fetch_assoc()['fname'];
if(isset($_POST['addComment'])){
	if(!empty($_SESSION['loggedIN'] || $_SESSION['loggedIN'] != 0)){
		$getMessage = mysqli_real_escape_string($db, strip_tags(trim($_POST['msg'])));
		if($getMessage != ""){
			$s = "INSERT INTO ".DB_PREFIX."comments (`post_id`, `user_id`,`message`) VALUES (?,?,?)";
			$insertSQL = $db->prepare($s);
			$insertSQL->bind_param("iis",$getID, $_SESSION['uid'], $getMessage);
			if($insertSQL->execute()){
				echo '<script> window.location.href= "article.php?msg=suc&node='.$getID.'"</script>';
			}else{
				echo '<script> window.location.href= "article.php?msg=fail&node='.$getID.'" </script>';
			}
		}
	}else{
		echo '<script> window.location.href = "login.php?msg=log&pid='.$getID.'" </script>';
	}
}
?>
<main role="main" class="container">
	<div class="row">
		<div class="col-md-8 blog-main">
			<h3 class="pb-3 mb-4 border-bottom">
				<?=$getPost['title'];?>
				<br>
				<small class="smaller">By : <?=$getAuthor;?></small>
			</h3>
			<small><?=date('F d, Y', strtotime($getPost['date_created']));?></small>
			<div class="blog-post border-bottom">
				<?=$getPost['body'];?>
				<br>
				Tags :
				<?php
				if($getTags->num_rows == 0){
					echo "<p class='my-3'>No Tags Associated with Post</p>";
				}else{ ?>
					<ul class="tags1">
						<?php
						while($tag = $getTags->fetch_assoc()){
							echo '<li><a href="tags.php?node='.$tag['TID'].'" class="tag1">'.$tag['tn'].'</a></li>';
						}
						?>
					</ul>
				<?php } ?>
			</div>
			<?php if($getPost['enable_comments'] == 1){ ?>
				<div class="blog-post border-bottom">
					<h4 class="border-bottom">Comments</h4>
					<!-- start comments -->
					<?php
					if($getComments->num_rows == 0){
						echo "<p class='my-3'> No Comments Yet!";
					}else{ ?>
						<ul class="messages mt-3">
							<?php
							while($comment = $getComments->fetch_assoc()){
								?>
								<li>
									<div class="message_wrapper">
										<h5 class="heading"><?=$comment['fname'];?></h5>
										<blockquote class="message"><?=$comment['msg'];?></blockquote>
										<br />
									</div>
								</li>
								<?php
							}
							?>
						</ul>
					<?php } ?>
					<!-- end comments -->
				</div>
				<div class="blog-post border-bottom pb-3">
					<form method="post">
						<h4>Add a comment</h4>
						<label>Message: <span class="required">*</span>
						</label>
						<input type="text" name="msg" id="msg" style="width: 100%"  required="required" class="form-control col-md-7 col-xs-12">
						<div class="ln_solid"></div>
						<br>
						<button type="submit" name="addComment" class="btn btn-success" >Submit</button>
					</form>
				</div>
			<?php } ?>
		</div>
		<?php
		include('includes/sidebar.php');
		?>
	</div>
</main>
</div>
<?php
include("includes/footer.php");
?>
