<?php

	include("includes/config.php");

	include("includes/db.php");

	$query = "Select * from categories";

	$categories = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../../favicon.ico">

    <title>New For You By You</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
	<script src="js/bootstrap.js" ></script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

   
  </head>

  <body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="nav blog-nav">
		<?php	if(isset($_GET['category']))	{	?>
		
          <a class="nav-link" href="index.php">Home</a>
	<?php
	}
	else {
	 ?>
<a class="nav-link active" href="index.php">Home</a>
	<?php
		}
	if($categories->num_rows>0) {
		while($row=$categories->fetch_assoc()){
			if(isset($_GET['category'])&& $row['id'] == $_GET['category']) { 
	?>			
	
 <a class="nav-link active" href="index.php?category=<?php echo $row['id']; ?> "> <?php echo $row['text']; ?>   </a>
	<?php }

	else { echo "<a class='nav-link ' href='index.php?category=$row[id]'> $row[text]    </a>";
 }} } ?>  
      </nav>
      </div>
    </div>

    <div class="container">

      <div class="row">

        <div class="col-sm-8 blog-main">
