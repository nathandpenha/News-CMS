<?php
include('includes/head.php');


if(isset($_POST['firstnamechanged'])){
	
	$firstname=mysqli_real_escape_string($db, strip_tags(trim($_POST['firstname'])));
	$stmt = $db->prepare ("update ".DB_PREFIX."users set  first_name=?   where email=?");
	$stmt->bind_param("ss", $firstname, $_SESSION['email']);

	
	if($stmt->execute())
	{
		echo "<script> location.href= './login.php?&msg=suc'; </script>";
	}else
	{
		echo "<script> location.href= './site_settings.php?&msg=fail'; </script>";
	}
	
	
}

if(isset($_POST['lastnamechanged'])){
	
	$lastname=mysqli_real_escape_string($db, strip_tags(trim($_POST['lastname'])));
	
	$stmt = $db->prepare ("update ".DB_PREFIX."users set  last_name=?   where email=?");
	$stmt->bind_param("ss", $lastname, $_SESSION['email']);

	
	if($stmt->execute())
	{
		echo "<script> location.href= './login.php?&msg=suc'; </script>";
	}else
	{
		echo "<script> location.href= './profile.php?&msg=fail'; </script>";
	}
	
	

	
	}

if(isset($_POST['passwordchanged'])){
	
	
	$oldpassword=mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["oldpassword"]))));
	$newpassword=mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["newpassword"]))));
	$confirnewpassword=mysqli_real_escape_string($db, strip_tags(trim(md5($_POST["confirnewpassword"]))));
	
	$stmt = $db->prepare ("update ".DB_PREFIX."users set  password=?   where email=? and password=? ");
	$stmt->bind_param("sss", $newpassword, $_SESSION['email'],$oldpassword);

	if($confirnewpassword==$newpassword){
	if($stmt->execute())
	{
		echo "<script> location.href= './login.php?&msg=suc'; </script>";
	}else
	{
		echo "<script> location.href= './profile.php?&msg=fail'; </script>";
	}
	}else{
		echo "<script> location.href= './profile.php?&msg=fail'; </script>";
	}
	

	
	}



?>


<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<?php include('includes/sidebar.php'); ?>
			<?php include('includes/topbar.php'); ?>
			<!-- page content -->
									<div class="">
						<?php
						if($_GET['msg'] == "suc"){
							?>
							<div class="alert alert-success alert-dismissible fade in msg" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Success!</strong> Successfully Updated.
							</div>
							<?php
						}
						if($_GET['msg'] == "fail"){
							?>
							<div class="alert alert-danger alert-dismissible fade in msg" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Failed!</strong> Some Error Occured. Please Try Again!
							</div>
							<?php
						}
						?>
		
	
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>User Profile</h3>
              </div>

              </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <h3><?=$_SESSION['first_name']?></h3>

                      <br />

                      <!-- end of skills -->

                    </div>
                    <div class="col-md-12 col-sm-9 col-xs-12">

                      <!-- end of user-activity-graph -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><?=$_SESSION['first_name'];?> <?=$_SESSION['last_name'];?>'s Profile</a>
                          </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
									<form class="form-horizontal form-label-left" method="post">
									<div class="form-group">
											<label class="col-sm-3 control-label">Change First Name</label>
											<div class="col-sm-9 col-md-6">
												<div class="input-group" >
													<input type="text" name="firstname" class="form-control" value=<?=$_SESSION['first_name']?> > 
													<span class="input-group-btn">
														<input type="submit" value="change first name" name="firstnamechanged" class="btn btn-primary">
													</span>
												</div>
											</div>
										</div>
									</form>
									<form class="form-horizontal form-label-left" method="post">
									<div class="form-group">
											<label class="col-sm-3 control-label">Change Last Name</label>
											<div class="col-sm-9 col-md-6">
												<div class="input-group" >
													<input type="text" name="lastname" class="form-control" value=<?=$_SESSION['last_name']?> > 
													<span class="input-group-btn">
														<input type="submit" value="change last name" name="lastnamechanged" class="btn  btn-primary">
													</span>
												</div>
											</div>
										</div>
									</form>
									
									<form class="form-horizontal form-label-left" method="post">
									<div class="form-group">
									<table><tr>
											<label class="col-sm-3 control-label">Old Password</label>
											<div class="col-sm-9 col-md-6">
												<div class="input-group" >
													<input type="password" name="oldpassword" class="form-control" > 
													<span class="input-group-btn">
													
													<input type="submit" value="Change Password" name="passwordchanged" class="btn  btn-primary">
														
													</span>
												</div>
											</div>
											</tr>
											
											<tr>
											<br>
											<div class="col-sm-9 col-md-6">
											<label class="col-sm-3 control-label">New Password</label>
											
												<div class="input-group" >
													<input type="password" name="newpassword" class="form-control"  > 
													<span class="input-group-btn">
														</span>
												</div>
											
										</div>
										</tr>
										<tr>
											<label class="col-sm-3 control-label">Confirm Password</label>
											<div class="col-sm-9 col-md-6">
												<div class="input-group" >
													<input type="password" name="confirnewpassword" class="form-control" > 
													<span class="input-group-btn">
														<input type="submit" value="Change Password" name="passwordchanged" class="btn  btn-primary">
													
													</span>
												</div>
											</div>
											</tr>
											
										</table>
									</form>
									 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
             
            </div>
          
        </div>
        <!-- /page content -->

       			<?php include('includes/footer.php'); ?>
