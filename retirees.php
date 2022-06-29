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
    
	<title>MafiaLife: Retirees</title>
	
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
			<h1 class="mb-0 text-center">Retirees</h1>
			<h4 class="mb-0 text-center">Those of us who stepped away</h4>
				<br>
				<form action="retiree.php" method="post">
					<table width=75% cellspacing=1 class='table'> 
   						<tr style='background:gray; color: white;'>
							<th>Time</th> 
							<th>Name</th>
							<th>Final Words</th>
   						</tr>
   						<?php
							$query = "SELECT * FROM retired ORDER BY retired_timestamp DESC;";
							$result = mysqli_query($db, $query);
							while($row = mysqli_fetch_array($result)) {
								echo("<tr>");
								echo("<td class='border-bottom'>" . gmdate('F d, h:i A', $row['retired_timestamp']));
								echo("<td class='border-bottom'>" . $row['char_name']);
								echo("<td class='border-bottom'>" . $row['final_words']);
							}
						
						?>
   						</table>
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