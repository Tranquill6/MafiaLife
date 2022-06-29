<?php
include('play.php');

$cities = array("Detroit", "Chicago");

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
}

$traveltime_seconds = abs(time()-$char_traveltime) % 60;
$traveltime_minutes = floor(abs(time()-$char_traveltime)/60);
$traveltime_hours = floor($traveltime_minutes/60);
?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: City</title>
	
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
    <div class="container p-0" style="background-color: white; border-style: solid;">
    	
    	<div class="my-auto text-center">
    	<h1 class="mb-0">City</h1>
    		<?php
				echo("<h3>You are currently in " . $char_currentcity . "</h3>");
			?>
 			<hr/>
  			<?php
					$query = "SELECT * FROM business WHERE city='$char_currentcity'";
					$result = mysqli_query($db, $query);
					while($row = mysqli_fetch_array($result)) {
						$picturename = $row['picturename'];
						$businesslink = $row['link'];
						echo("<div class='container'>");
						echo("<div class='card border-dark'>");
						echo("<div class='card-body text-center' style='background-image:url(img/$picturename);'>");
						echo("<a href='$businesslink'>");
						echo("<h4 class='mb-0'><strong><font color='white'>" . $row['name'] . "</font></strong></h4>");
						echo("</a>");
						echo("</div>");
						echo("</div>");
						echo("</div>");
						echo("<br>");
					}
					
			?>
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