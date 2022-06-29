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

$rank_array = array("Thug", "Gangster", "Earner", "Wise Guy", "Made Man", "Caporegime", "Boss", "Don", "Godfather");
$rankWorth = 0;
$otherRankWorth = 0;

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
				if(isset($_POST['inviteperson'])) {
					$target_person = mysqli_real_escape_string($db, $_POST['invitename']);
					$target_isCriminal = isCriminal($db, $target_person);
					if($target_person != "") {
						$foundName = findVictimName($db, $target_person);
						if($foundName == $target_person) {
							if($target_isCriminal == true) {
								$target_isCrew = isInCrew($db, $target_person);
								if($target_isCrew == false ) {
									if(($cfMembers < 3 and $havePPCF == true) or ($cfMembers < 5 and $haveHotelCF == true) or ($cfMembers < 8 and $haveCasinoCF == true)) {
									
										$pulledRank = pullRank($db, $target_person);
									
										$rankWorth = 0;
										$otherRankWorth = 0;
										$eligibleForInvite = 0;

										foreach($rank_array as $value) {
										$rankWorth += 1;
										if($value == $rank) {
											$rankWorth += 1;
											break;
											}
										}
										foreach($rank_array as $value) {
											$otherRankWorth += 1;
											if($value == $pulledRank) {
												$otherRankWorth += 1;
												break;
											}
										}
									
										if($otherRankWorth < $rankWorth) {
											$eligibleForInvite = 1;
										} 
										
										if($eligibleForInvite == 1) {
												createCrewInvite($db, $target_person, $char_name, $char_crewid);
												echo("<div class='alert alert-success'>Invite sent!</div>");
											} else {
												echo("<div class='alert alert-danger'>You cannot invite someone of equal or greater rank!</div>");
											}
										} else {
											echo("<div class='alert alert-danger'>You cannot hold anymore members!</div>");
										}
								} else {
									echo("<div class='alert alert-danger'>This person already in a crew!</div>");
								}
							} else {
								echo("<div class='alert alert-danger'>This person is NOT a Criminal!</div>");
							}
						} else {
							echo("<div class='alert alert-danger'>This person doesn't exist!</div>");
						}
					} else {
						echo("<div class='alert alert-danger'>You have to enter a name!</div>");
					}
				}
			
			?>
    		<hr/>
   			<form action='crewfronts-management-invites.php' method="post">
  				<a href="crewfronts-management.php" class="btn btn-dark btn-sm">Manage</a>
  				<a href="crewfronts-management-members.php" class="btn btn-dark btn-sm">Members</a>
				<br>
				<br>
				<br>
  				<h5>Invite Person:</h5>
  				<input type="text" name="invitename">
  				<button type="submit" name="inviteperson" class="btn btn-dark btn-sm">Invite</button>
  				<br>
  				<br>
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