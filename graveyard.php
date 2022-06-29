<?php
include('server.php');

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
    
	<title>MafiaLife: Graveyard</title>
	
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

<body style="background-image: url(img/mafialifebackground.jpg)">
   	<br>
    <div class="container" style="margin-left: 250px">
        <div class="card">
            <div class="card-header text-center">
                <h2 class="mb-0">
					<?php
						if(!($char_status == 0)) {
							echo("You are DEAD!");
						} else {
							echo("You are NOT DEAD!");
						}
					?>
    			</h2>
           		<h4 class="mb-1">
					<?php
						if(!($char_status == 0)) {
							echo("You have fallen like the many before you.");
						} else {
							echo("It is not your time yet.");
						}
					?>
    			</h4>
            </div>
            <div class="card-body text-center">
            	<?php
				
					if($char_status == 0) {
						echo("<div class='text-center'>");
						echo("<h5>You are still alive, live out the life you already have.</h5>");
						echo("</div>");
					} else {
						echo("<div class='text-center'>");
						echo("<h5>This way of life bested you. You made an attempt to seek glory, money, and power.");
						echo("<br>");
						echo("Whether or not you succeeded is up to you, but it is time to jump back into it and start over.</h5>");
						echo("</div>");
					}
				
				?>
            </div>
            <div class="card-footer text-center">
            	<?php
    			if(!($char_status == 0)) {
    				echo("<div class='text-center'>");
					echo("<a href='charactercreation.php' class='btn btn-sm btn-dark' role='button'>Create A New Character</a>  ");
					echo("<a href='characters.php' class='btn btn-sm btn-dark' role='button'>Go Back</a>");
					echo("</div>");
				} else {
					echo("<div class='text-center'>");
					echo("<a href='play.php' class='btn btn-sm btn-dark' role='button'>Go back</a>");
					echo("</div>");
				}
			?>
            </div>
        </div>
    </div>
</body>
	

	<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>

</body>
</html>