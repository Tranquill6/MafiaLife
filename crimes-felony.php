<?php
include('play.php');

$clinc_loottable = array(8003, 8004, 8005, 8006);

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
    
	<title>MafiaLife: Felony Crimes</title>
	
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
    	
    	<div class="my-auto">
    	<h1 class="mb-0 text-center">Felony Crimes</h1>
    	<form action="crimes-felony.php" method="post">
    	<div class="text-center">
    	<br>
    	<?php
		
				if(isset($_POST["gasstation"])) {
					if($char_nextcrime <= time()) {
						if($char_gexp >= 1250) {
							$crime_chance = 1;
						} else {
							if($luckCategory == 1) {
								$crime_chance = rand(1,9);
							} elseif($luckCategory == 2) {
								$crime_chance = rand(1,16);
							} elseif($luckCategory == 3) {
								$crime_chance = rand(1,25);
							}
						}

						$crime_gexp = 8 * $gexp_multiplier;
						$crime_money = rand(200,400);

						if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
							echo("You ran off after the clerk pulled a gun!");
							addCrimeTime($db, $char_id, 60);
						} else {
							echo("You have successfully ran off with " . $crime_money . " dollars after the clerk handed over the cash!");
							successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
							increaseStatsForCrimes($db, $char_id, "Felony", $luckCategory);
							calculatePower($db, $char_id);
							addCrimeTime($db, $char_id, 60);
						}
						exit();
					} else {
						echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
					}
					
				} 
				if(isset($_POST["clinc"])) {
					if($char_nextcrime <= time()) {
						if($char_gexp >= 1400) {
							$crime_chance = 1;
						} else {
							if($luckCategory == 1) {
								$crime_chance = rand(1,9);
							} elseif($luckCategory == 2) {
								$crime_chance = rand(1,16);
							} elseif($luckCategory == 3) {
								$crime_chance = rand(1,25);
							}
						}

						$crime_gexp = 10 * $gexp_multiplier;
						$crime_money = rand(320,550);

						if($luckCategory == 1) {
							$itemdrop_chance = rand(1,75);
						} elseif($luckCategory == 2) {
							$itemdrop_chance = rand(1,50);
						} elseif($luckCategory == 3) {
							$itemdrop_chance = rand(1,35);
						}

						if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
							echo("You have failed to break into the clinc before the cops came!");
							addCrimeTime($db, $char_id, 60);
						} else {
							echo("You have successfully robbed the clinc, you stole " . $crime_money . " dollars worth of medical supplies!");
							successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
							increaseStatsForCrimes($db, $char_id, "Felony", $luckCategory);
							calculatePower($db, $char_id);
							addCrimeTime($db, $char_id, 60);
							if($itemdrop_chance == 4 or $itemdrop_chance == 17 or $itemdrop_chance == 10 or $itemdrop_chance == 2 or $itemdrop_chance == 6) {
								$itemdrop = rand(0,3);
								$func_execute = findItemName($db, $clinc_loottable[$itemdrop]);
								$event_text = "You have picked up a $func_execute!";

								echo("<br>You have picked up a " . $func_execute . "!");

								event_add($char_id, $event_text);
								giveItem($db, $char_id, $clinc_loottable[$itemdrop], 1);
							}
						}
						exit();
					} else {
						echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
					}
					
				} 
				if(isset($_POST["jewelery"])) {
					if($char_nextcrime <= time()) {
						if($char_gexp >= 1800) {
							$crime_chance = 1;
						} else {
							if($luckCategory == 1) {
								$crime_chance = rand(1,9);
							} elseif($luckCategory == 2) {
								$crime_chance = rand(1,16);
							} elseif($luckCategory == 3) {
								$crime_chance = rand(1,25);
							}
						}

						$crime_gexp = 12 * $gexp_multiplier;
						$crime_money = rand(350,850);

						if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
							echo("You have failed to rob the jewelery store!");
							addCrimeTime($db, $char_id, 60);
						} else {
							echo("You held the store at gun point and made off with " . $crime_money . " dollars worth of jewelery!");
							successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
							increaseStatsForCrimes($db, $char_id, "Felony", $luckCategory);
							calculatePower($db, $char_id);
							addCrimeTime($db, $char_id, 60);
						}
						exit();
					} else {
						echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
					}
					
				}
				
		
		?>
    		<div class="subheading mb-5 text-center"><br>Stick up the local gas station.
    		<button type="submit" name="gasstation" id="gasstation" class="btn btn-dark center-block">Submit</button>
    		<?php if($char_gexp >= 550) : ?>
    			<div class="subheading mb-5 text-center"><br>Knocking over a clinc.
    			<button type="submit" name="clinc" id="clinc" class="btn btn-dark center-block">Submit</button>
    		<?php endif ?>
    		<?php if($char_gexp >= 700) : ?>
    			<div class="subheading mb-5 text-center"><br>Rob the jewelery store.
    			<button type="submit" name="jewelery" id="jewelery" class="btn btn-dark center-block">Submit</button>
    		<?php endif ?>
    	</form>
    			</div>
    		</div>
    	</div>
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