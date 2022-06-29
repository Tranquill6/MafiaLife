<?php
include('play.php');

$purse_loottable = array(8003);

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} 

$attackScore =  0;
$defenseScore = 0;
$damageDone = 0;
?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Whack</title>
	
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
    	<h1 class="mb-0">Whack!</h1>
    		<br>
    		<br>
    		<?php
			
					if(isset($_POST['vbutton'])) {
						$vname = mysqli_real_escape_string($db, $_POST['vname']);
						$foundGun = checkForGun($db, $char_id);
						if($foundGun == true) {
							//findVictimName($db, $vname);
							$foundName = findVictimName($db, $vname);
							if($foundName == $vname) {
								$vCurrentcity = findVictimCity($db, $vname);
								if($char_currentcity == $vCurrentcity) {
									$result = findVictimStats($db, $vname);
									$row = $result->fetch_assoc();
									
									$vgun = $row['gunstat'];
									$vdef = $row['defstat'];
									$vsight = $row['sightstat'];
									$vluck = $row['luckstat'];
									$vStartingcity = $row['starting_city'];
									$vcrewID = $row['crewfront_id'];
									$vID = $row['char_id'];
									
									$yourBoss = findCrewOwner($db, $char_crewid);
									$theirBoss = findCrewOwner($db, $vcrewID);
									
									if($char_currentcity == $char_startingcity) {
										if($yourBoss == $char_name) {
											$homecity_bonus = 2;
										} else {
											$homecity_bonus = 1;
										}
									} else {
										$homecity_bonus = 0;
									}
									
									if($vCurrentcity == $vStartingcity) {
										if($theirBoss == $vname) {
											$v_homecity_bonus = 2;
										} else {
											$v_homecity_bonus = 1;
										}
									} else {
										$v_homecity_bonus = 0;
									}
									
									$attackScore =  $gunstat+($luckstat*rand(0.2,0.5))+($visionstat * 0.4)+$homecity_bonus;
									$defenseScore = $vdef+($vluck*rand(0.2,0.5))+($vsight * 0.4)+$v_homecity_bonus;
									$damageDone = $gunstat * 0.25;
									
									# Suicide
									if($vname == $char_name) {
										killSomeone($db, $vname);
										echo("You shot yourself to death!");
									}
									
									# The actual damage calculations
									if(($attackScore-60) > $defenseScore) {
										subtractHealth($db, $vname, 100);
										event_add($vID, "You were shot by " . $char_name . " and lost 100 points of health!");
										echo("Your target has been shot dead!");
									}
									elseif($attackScore > $defenseScore) { 
										$damageDone *= rand(2, 3);
										if($damageDone < 1) { 
											$damageDone = 1;
										}
										$damageDone = round($damageDone);
										subtractHealth($db, $vname, $damageDone);
										event_add($vID, "You were shot by " . $char_name . " and lost " . $damageDone . " points of health!");
										if(findHealth($db, $vname) <= 0) {
											echo("Your target has been shot dead!");
										} else {
											echo("You had the advantage over your attacker and did a lot of damage!");
										}

									} elseif ($attackScore < $defenseScore) {
										$damageDone *= rand(0.2, 0.5);
										if($damageDone < 1) { 
											$damageDone = 1;
										}
										$damageDone = round($damageDone);
										subtractHealth($db, $vname, $damageDone);
										event_add($vID, "You were shot by " . $char_name . " and lost " . $damageDone . " points of health!");
										if(findHealth($db, $vname) <= 0) {
											echo("Your target has been shot dead!");
										} else {
											echo("It doesn't seem you were strong enough to kill them, but harmed them!");
										}
									} elseif($attackScore == $defenseScore) {
										if($damageDone < 1) { 
											$damageDone = 1;
										}
										$damageDone = round($damageDone);
										subtractHealth($db, $vname, $damageDone);
										event_add($vID, "You were shot by " . $char_name . " and lost " . $damageDone . " points of health!");
										if(findHealth($db, $vname) <= 0) {
											echo("Your target has been shot dead!");
										} else {
											echo("It was a pretty even fight and you harmed them decently!");
										}
									} else {
										echo("Nothing.");
									}
								} else {
									echo("You are not in their city!");
								}
							} else {
								echo("This user doesn't exist!");
							}
						} else {
							echo("You don't have a gun.");
						}
					}
			
			?>
   		<form action="crimes-whack.php" method="post">
    		<div class="subheading mb-5 text-center">
				<input type="text" style="text-align: center" name="vname">   
    			<button type="submit" class="btn btn-med btn-dark center-block" name="vbutton">Shoot</button>
    			</div>
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