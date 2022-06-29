<?php
include('play.php');
?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Leaderboard</title>
	
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
    	<h1 class="mb-0">Leaderboard</h1>
    	<h5>Showing off the top ten of the world</h5>
    	<hr/>
    	<div style="margin-top: "
    	<br>
    	<table cellspacing=10 class='table'>
    	<tr style='background:gray; color: white;'>
    		<th>Place</th>
    		<th>Name</th>
    	</tr>
    	<?php
			$placeCount = 0;
		
			$query = "SELECT * FROM `characters` ORDER BY `characters`.`power` DESC LIMIT 10";
			$result = mysqli_query($db, $query);
			while($row = mysqli_fetch_array($result)) {
				$placeCount += 1;
				echo("<tr>");
				echo("<td><div style='font-size: xx-large; margin-top: 50px'><strong> #" . $placeCount . "</strong></div>");
				echo("<td><a href='profile.php?char_id=".$row['char_id']."'><img src='".$row['profilepic']."' class='position-relative' height='150px' width='150px'>" . "<div class='position-relative'></a><strong>" .$row['char_name'] . "</strong></div>");
			}
			
		
		?>
   		</table>
    	</div>
    </div>
    		

	<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>

</body>
</html>