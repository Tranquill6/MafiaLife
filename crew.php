<?php
include('play.php');

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} if(isInCrew($db, $char_name) == false or doYouHaveCF($db, $char_name) == true) {
	echo("<script type='text/javascript'>location.href='play.php';</script>");
}

$query = "SELECT crew_name FROM crew_fronts WHERE id='$char_crewid'";
$result = mysqli_query($db, $query);
$row = $result->fetch_assoc();
$crew_name = $row['crew_name'];

?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Crew</title>
	
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
    	<h1 class="mb-0">Crew</h1>
    		<?php
			
					$findOwner = findCrewOwner($db, $char_crewid);
					$findType = findCFType($db, $findOwner);
					
					if(isset($_POST['leavecrew'])) {
						if(isInCrew($db, $char_name) == true) {
							$findOwnerID = findVictimID($db, $findOwner);
							leaveCrew($db, $char_name);
							event_add($char_id, "You have left your crew!");
							event_add($findOwnerID, $char_name . " has left your crew!");
							echo("<div class='alert alert-success'>You have successfully left your crew!</div>");
						} else {
							echo("<div class='alert alert-danger'>You are not in a crew!</div>");
						}
					}
			
			?>
    		<hr/>
   			<form action='crew.php' method="post">
				<h5>Leader: <?php echo $findOwner ?></h5>
				<h5>Crew Name: <?php echo $crew_name ?></h5>
				<h5>Type: <?php echo $findType ?></h5>
				<br>
				<button type="submit" name="leavecrew" class="btn btn-dark btn-sm">Leave Crew</button>
				<br>
				<br>
   			</form>
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