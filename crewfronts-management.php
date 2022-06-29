<?php
include('play.php');

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} if(doYouHaveCF($db, $char_name) == false) {
	echo("<script type='text/javascript'>location.href='play.php';</script>");
}

$query = "SELECT id FROM crew_fronts WHERE owner='$char_name'";
$result = mysqli_query($db, $query);
$row = $result->fetch_assoc();
$crewfront_id = $row['id'];

$crewMembers = eachMemberInCF($db, $crewfront_id);
$cfMembers = membersInACF($db, $char_crewid);

?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Crew Fronts Management</title>
	
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
    	<h1 class="mb-0">Crew Fronts Management</h1>
    		<?php
			
				if(isset($_POST['crewnamechange'])) {
					$crewname = mysqli_real_escape_string($db, $_POST['crewname']);
					
					if($crewname != "") {
						$query = "UPDATE crew_fronts SET crew_name='$crewname' WHERE owner='$char_name'";
						mysqli_query($db, $query);
						echo("<div class='alert alert-success'>Crew name changed!</div>");
					} else {
						echo("<div class='alert alert-danger'>You must have a crew name!</div>");
					}
				}
				if(isset($_POST['destroyCF'])) {
					$findOwner = findCrewOwner($db, $char_crewid);
					if($findOwner == $char_name) {
						foreach($crewMembers as $value) {
							leaveCrew($db, $value);
						}
						destroyCrewFront($db, $crewfront_id);
						echo("<div class='alert alert-success'>You have destroyed your crewfront!</div>");
					} else {
						echo("<div class='alert alert-danger'>You do not have permission for this!</div>");
					}
				}
			
			?>
    		<hr/>
   			<form action='crewfronts-management.php' method="post">
				<a href="crewfronts-management-invites.php" class="btn btn-dark btn-sm">Invites</a>
				<a href="crewfronts-management-members.php" class="btn btn-dark btn-sm">Members</a>
				<br>
				<br>
				<?php
					$findOwner = findCrewOwner($db, $char_crewid);
					$findType = findCFType($db, $findOwner);
					
					switch($findType) {
						case "pizzaplace":
							$crewFrontType = "Pizza Place";
							break;
						case "hotel":
							$crewFrontType = "Hotel";
							break;
						case "casino":
							$crewFrontType = "Casino";
							break;
						default:
							$crewFrontType = "ERROR!";
							break;
					}
				
				?>
				<h5>Type: <?php echo $crewFrontType ?></h5>
				<br>
				<h5>Crew Name:</h5>
  				<input type="text" name="crewname">
  				<button type="submit" name="crewnamechange" class="btn btn-dark btn-sm">Change</button>
  				<br>
  				<br>
  				<br>
  				<button type="submit" name="destroyCF" class="btn btn-dark btn-sm">Destroy Crewfront</button>
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