<?php
include("includes/header.php");
if(empty($_GET['node'])){
	header('Location: index.php');
}
$getID = $_GET['node'];
$getData = $db->query("select  p.id as pid, p.title as title from ".DB_PREFIX."post_tags tp, ".DB_PREFIX."tags t, ".DB_PREFIX."posts p where p.id = tp.post_id and tp.tag_id = t.id and t.id = ".$getID);
?>
<main role="main" class="container">
	<div class="row">
		<?php
		while($row = $getData->fetch_assoc()){
			?>
			<h3 class="pb-3 mb-4 mt-4  border-bottom">
				<a href="article.php?node=<?=$row['pid'];?>"><?=$row['title'];?></a>
			</h3>
			<?php
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
