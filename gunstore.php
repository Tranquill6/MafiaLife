<?php
include('play.php');

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} 

?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Gun Store</title>
	
	<!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/resume.css" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>

<body>
    <div class="container p-0" style="background-color: white; border-style: solid">
    	<div class="my-auto text-center">
			<h1 class="mb-0 text-center">Gun Store</h1>
			<h3 class="mb-0 text-center">You never know when you will need one</h3>
				<?php

					if(isset($_POST['gunbuysubmit'])) {
						$gunCheck = checkForGun($db, $char_id);
						if($gunCheck == true) {
							echo("<div class='alert alert-danger'>You already have a gun!</div>");
						} else {
							removeMoney($db, $char_id, 1000);
							giveItem($db, $char_id, 8000, 1);
							echo("<div class='alert alert-success'>You have successfully bought a gun!</div>");
						}
					}
					if(isset($_POST['bulletbuysubmit'])) {
						removeMoney($db, $char_id, 250);
						giveItem($db, $char_id, 8001, 1);
						echo("<div class='alert alert-success'>You have successfully bought a bullet!</div>");
					}

				?>
				<form action="gunstore.php" method="post">
					<div class="text-center">
					<br>  			
					<br>
					<img src="/img/beretta.png" height="200" width="400">
					<br>
					<br>
					<h4 class="mb-0">$1000</h4><button type="submit" class="btn btn-dark btn-sm" name="gunbuysubmit">Buy</button>
					<br>
					<br>
					<hr/>
					<br>		
					<img src="/img/9mm_long_in_a_box.png" height="200" width="400">		
					<br>
					<h4 class="mb-0">$250 per</h4><button type="submit" class="btn btn-dark btn-sm" name="bulletbuysubmit">Buy</button>
					<br>
					<br>
				</form>
    		</div>
    	</div>
    </div>
	<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>
<?php include("footerbottom.php"); ?>
</body>
</html>