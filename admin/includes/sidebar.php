<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="index.php" class="site_title"><?=$siteName;?></a>
		</div>

		<div class="clearfix"></div>

		<!-- menu profile quick info -->
		<div class="profile clearfix">
			<div class="profile_pic">
				<img src="production/images/img.jpg" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Welcome,</span>
				<h2>John Doe</h2>
			</div>
		</div>
		<!-- /menu profile quick info -->

		<br />

		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
				<h3>General</h3>
				<ul class="nav side-menu">
					<li><a href="index.php"><i class="fa fa-home"></i> Home</a>
					</li>
					<li><a href="category.php"><i class="fa fa-edit"></i> Categories </a>
					</li>
					<li><a href="tags.php"><i class="fa fa-tags"></i> Tags </a>
					</li>
					<?php if($_SESSION['admin']){  ?>
						<li><a href="users.php"><i class="fa fa-user"></i> Users </a>
						</li>
					<?php } ?>
					<li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="chartjs.html">Chart JS</a></li>
							<li><a href="chartjs2.html">Chart JS2</a></li>
							<li><a href="morisjs.html">Moris JS</a></li>
							<li><a href="echarts.html">ECharts</a></li>
							<li><a href="other_charts.html">Other Charts</a></li>
						</ul>
					</li>
					<li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>
							<li><a href="fixed_footer.html">Fixed Footer</a></li>
						</ul>
					</li>
				</ul>
			</div>

			</div>
			<!-- /sidebar menu -->

			<!-- /menu footer buttons -->
			<div class="sidebar-footer hidden-small">
				<a data-toggle="tooltip" data-placement="top" title="Logout" href="#" style="width:100%">
					<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
				</a>
			</div>
			<!-- /menu footer buttons -->
		</div>
	</div>
