<footer class="blog-footer">
	<div class="row">
		<div class="col-md-4">
			<?=$siteDescription;?>
		</div>
		<div class="col-md-4">
			Archives
			<?php
			$getArchives = $db->query("SELECT DISTINCT(monthname(date_created)) mnt, YEAR(date_created) yr FROM ".DB_PREFIX."posts GROUP by monthname(date_created), year(date_created) LIMIT 0,3");
			?>
			<ol class="list-unstyled">
				<?php
				while($archive = $getArchives->fetch_assoc()){
					echo '<li><a href="archive.php?month='.$archive['mnt'].'&year='.$archive['yr'].'">'.($archive['mnt'].' '.$archive['yr']).'</a></li>';
				}
				?>
			</ol>
		</div>
		<div class="col-md-4">
			<?php
			if($_SESSION['role'] > 1){
				?>
				<a href="admin/index.php">Admin Panel</a>
				<?php
			}
			?>
		</div>
	</div>
	<p>
	</footer>


	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/tether.js" charset="utf-8"></script>
</body>
</html>
