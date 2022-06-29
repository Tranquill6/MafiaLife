<?php
include("play.php");

$purse_loottable = array(8003);

?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Petty Crimes</title>
	
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
    	<h1 class="mb-0 text-center">Petty Crimes</h1>
    	<h3 class="mb-0 text-center">Not the best, but it pays the bills</h3>
    	<div class="text-center">
    	<br>
    		 <?php
				if(isset($_POST['purse'])) {
						if($char_nextcrime <= time()) {
							if($char_gexp >= 400) {
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

							$crime_gexp = 2 * $gexp_multiplier;
							$crime_money = rand(20,100);
							$crime_jailchance = rand(1, 30);

							if($luckCategory == 1) {
								$itemdrop_chance = rand(1,75);
							} elseif($luckCategory == 2) {
								$itemdrop_chance = rand(1,50);
							} elseif($luckCategory == 3) {
								$itemdrop_chance = rand(1,35);
							}

							if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
								echo("You have failed to snatch any purses today!");
								addCrimeTime($db, $char_id, 60);
								if($crime_jailchance == 23) {
									echo("\nThe cops busted you for this one!");
									$char_jailtimestarted = time();
									addJailTime($db, $char_id, time() + $crime_jailchance, $char_jailtimestarted);
								}
							} else {
								echo("<div class='alert alert-success'>You have successfully ran off with " . $crime_money . " dollars after a hard day of snagging purses!</div>");
								successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
								increaseStatsForCrimes($db, $char_id, "Petty", $luckCategory);
								calculatePower($db, $char_id);
								addCrimeTime($db, $char_id, 60);
								if($itemdrop_chance == 4 or $itemdrop_chance == 17 or $itemdrop_chance == 10 or $itemdrop_chance == 2 or $itemdrop_chance == 6) {
									$func_execute = findItemName($db, $purse_loottable[0]);
									$event_text = "You have picked up a $func_execute!";

									echo("<br>You have picked up a " . $func_execute . "!");

									event_add($char_id, $event_text);
									giveItem($db, $char_id, $purse_loottable[0], 1);
								}
							}
						} else {
							echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
						}

				 }
				 if(isset($_POST["checks"])) {
					if($char_nextcrime <= time()) {
						if($char_gexp >= 800) {
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

						$crime_gexp = 4 * $gexp_multiplier;
						$crime_money = rand(50,250);

						if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
							echo("You have failed to forge checks today!");
							addCrimeTime($db, $char_id, 60);
						} else {
							echo("You have successfully forged a few checks, they are worth about " . $crime_money . " dollars!");
							successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
							increaseStatsForCrimes($db, $char_id, "Petty", $luckCategory);
							calculatePower($db, $char_id);
							addCrimeTime($db, $char_id, 60);
						}
					} else {
						echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
					}
				} 
				if(isset($_POST["cars"])) {
					if($char_nextcrime <= time()) {
						if($char_gexp >= 1000) {
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

						$crime_gexp = 5 * $gexp_multiplier;
						$crime_money = rand(120,300);

						if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
							echo("You have failed to sell any stolen cars!");
							addCrimeTime($db, $char_id, 60);
						} else {
							successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
							increaseStatsForCrimes($db, $char_id, "Petty", $luckCategory);
							calculatePower($db, $char_id);
							addCrimeTime($db, $char_id, 60);
							echo("<div class='alert alert-success'>You have successfully sold a few cars to the local chop shop for about " . $crime_money . " dollars!</div>");
						}
					} else {
						echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
					}
					
				}
		
		?>
   			<form method="post" action="crimes-petty.php">
    		<div class="subheading mb-5 text-center"><br>Steal a few purses.
    		<button type="submit" name="purse" id="purse" class="btn btn-dark center-block">Submit</button>
    		<?php if($char_gexp >= 200) : ?>
    			<div class="subheading mb-5 text-center"><br>Forge checks.
    			<button type="submit" name="checks" id="checks" class="btn btn-dark center-block">Submit</button>
    		<?php endif ?>
    		<?php if($char_gexp >= 400) : ?>
    			<div class="subheading mb-5 text-center"><br>Steal cars.
    			<button type="submit" name="cars" id="cars" class="btn btn-dark center-block">Submit</button>
    		<?php endif ?>
    			</div>
    			</div>
    			</div>
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