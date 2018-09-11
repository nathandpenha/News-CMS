<?php
$getArchives = $db->query("SELECT DISTINCT(monthname(date_created)) mnt, YEAR(date_created) yr FROM ".DB_PREFIX."posts GROUP by monthname(date_created), year(date_created) LIMIT 0,10");
$getLatest = $db->query("SELECT * from ".DB_PREFIX."posts where post_type = 'published' and id != ".$getID." order by date_created desc limit 0,5");
?>
<aside class="col-md-4 blog-sidebar">
	<div class="p-3">
		<h4 class="font-italic">In Other News</h4>
		<ol class="list-unstyled mb-0">
			<?php
			while($latest = $getLatest->fetch_assoc()){
				echo '<li><a href="article.php?node='.$latest['id'].'">'.$latest['title'].'</a></li>';
			}
			?>
		</ol>
	</div>
	<div class="p-3">
		<h4 class="font-italic">Archives</h4>
		<ol class="list-unstyled mb-0" style="">
			<?php
			while($archive = $getArchives->fetch_assoc()){
				echo '<li><a href="archive.php?month='.$archive['mnt'].'&year='.$archive['yr'].'">'.($archive['mnt'].' '.$archive['yr']).'</a></li>';
			}
			?>
		</ol>
	</div>
</aside>
<!-- /.blog-sidebar -->
