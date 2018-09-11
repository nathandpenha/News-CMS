<?php
include("includes/header.php");
if(empty($_GET['node'])){
	header('Location: index.php');
}
$getID = $_GET['node'];
$getName = $db->query("SELECT * FROM ".DB_PREFIX."categories where id =".$getID)->fetch_assoc()['category_name'];
$getData = $db->query("SELECT p.title as title, p.id as pid FROM ".DB_PREFIX."posts p, ".DB_PREFIX."categories c where p.post_type = 'published' and p.category = c.id and c.id = ".$getID);
?>
<main role="main" class="container">
	<h4 class="pb-3 mb-4 mt-4 border-bottom">
		Posts Related to Categories : <?=$getName;?>
	</h4>
	<div class="row">
		<?php
		if($getData->num_rows <= 0){
			echo "<h4 class='font-italic'> No Posts Associated With this Category";
		}else{
			while($row = $getData->fetch_assoc()){
				?>
				<div class="row col-md-12">
					<p class="pb-3 mb-4 mt-4 border-bottom">
						<a href="article.php?node=<?=$row['pid'];?>"><?=$row['title'];?></a>
					</p>
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
