<?php
include("includes/header.php");
if(empty($_GET['node'])){
	header('Location: index.php');
}
$getID = $_GET['node'];
$getPost = $db->query("SELECT * FROM ".DB_PREFIX."posts where id = ".$getID)->fetch_assoc();
$getTags = $db->query("SELECT t.tag_name as tn, t.id as TID FROM ".DB_PREFIX."post_tags p, ".DB_PREFIX."tags t where t.id = p.tag_id and p.post_id = ".$getID);
$getComments = $db->query("SELECT * FROM ".DB_PREFIX."comments where post_id = ".$getID);
$getCategory = $db->query("SELECT category_name from ".DB_PREFIX."categories where id = ".$getPost['category']);
$getAuthor = $db->query("SELECT concat(first_name,' ',last_name) as fname from ".DB_PREFIX."users where id = ".$getPost['author'])->fetch_assoc()['fname'];
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
			<div class="blog-post">
				<?=$getPost['body'];?>
				<br>
				Tags :
				<ul class="tags1">
					<?php
					while($tag = $getTags->fetch_assoc()){
						echo '<li><a href="tags.php?node='.$tag['TID'].'" class="tag1">'.$tag['tn'].'</a></li>';
					}
					?>
				</ul>
			</div>
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
