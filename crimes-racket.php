<?php
include('play.php');

$armory_loottable = array(8001, 8007);

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
    
	<title>MafiaLife: Rackets</title>
	
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
    	<h1 class="mb-0 text-center">Rackets</h1>
    	<form action="crimes-racket.php" method="post">
    	<div class="text-center">
    	<br>
    	<?php
		
				if(isset($_POST["policearmory"])) {
					if($char_nextcrime <= time()) {
						if($char_gexp >= 2100) {
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

						$crime_gexp = 13 * $gexp_multiplier;
						$crime_money = rand(430,950);

						if($luckCategory == 1) {
							$itemdrop_chance = rand(1,75);
						} elseif($luckCategory == 2) {
							$itemdrop_chance = rand(1,50);
						} elseif($luckCategory == 3) {
							$itemdrop_chance = rand(1,35);
						}

						if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
							echo("You took down a few cops, but you had to get out of there!");
							addCrimeTime($db, $char_id, 60);
						} else {
							echo("You have successfully ran off with " . $crime_money . " dollars after you stole a bunch of police-grade guns!");
							successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
							increaseStatsForCrimes($db, $char_id, "Racket", $luckCategory);
							calculatePower($db, $char_id);
							addCrimeTime($db, $char_id, 60);
							if($itemdrop_chance == 4 or $itemdrop_chance == 17 or $itemdrop_chance == 10 or $itemdrop_chance == 2 or $itemdrop_chance == 6) {
								$itemdrop = rand(0,1);
								$func_execute = findItemName($db, $armory_loottable[$itemdrop]);
								$event_text = "You have picked up a $func_execute!";

								echo("<br>You have picked up a " . $func_execute . "!");

								if($armory_loottable[$itemdrop] == 8001) {
									if($luckCategory == 1) {
										$itemdrop_quantity = rand(1,3);
									} elseif($luckCategory == 2) {
										$itemdrop_quantity = rand(1,5);
									} elseif($luckCategory == 3) {
										$itemdrop_quantity = rand(1,9);
									}
								}

								event_add($char_id, $event_text);
								giveItem($db, $char_id, $armory_loottable[$itemdrop], $itemdrop_quantity);
							}
						}
						exit();
					} else {
						echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
					}
					
				} 
				if(isset($_POST["casino"])) {
					if($char_nextcrime <= time()) {
						if($char_gexp >= 3000) {
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

						$crime_gexp = 15 * $gexp_multiplier;
						$crime_money = rand(500, 1050);

						if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
							echo("You had everything under control until someone pulled a gun and shot your partner!");
							addCrimeTime($db, $char_id, 60);
						} else {
							echo("You have successfully robbed the casino and made off with " . $crime_money . " dollars!");
							successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
							increaseStatsForCrimes($db, $char_id, "Racket", $luckCategory);
							calculatePower($db, $char_id);
							addCrimeTime($db, $char_id, 60);
						}
						exit();
					} else {
						echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
					}
					
				} 
				if(isset($_POST["bankvault"])) {
					if($char_nextcrime <= time()) {
						if($char_gexp >= 4050) {
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

						$crime_gexp = 17 * $gexp_multiplier;
						$crime_money = rand(800,1600);

						if($crime_chance == 2 or $crime_chance == 6 or $crime_chance == 7 or $crime_chance == 4) {
							echo("You forgot to bring the drill to open the vault!");
							addCrimeTime($db, $char_id, 60);
						} else {
							echo("You successfully drilled open the bank vault and found " . $crime_money . " dollars in it!");
							successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp);
							increaseStatsForCrimes($db, $char_id, "Racket", $luckCategory);
							calculatePower($db, $char_id);
							addCrimeTime($db, $char_id, 60);
						}
						exit();
					} else {
						echo("<div class='alert alert-danger'>You must wait 60 seconds between crimes!</div>");
					}
					
				}
		
		?>
   			<?php if($char_gexp >= 850) : ?>
    		<div class="subheading mb-5 text-center"><br>Breaking into Police armory.
    		<button type="submit" name="policearmory" id="policearmory" class="btn btn-dark center-block">Submit</button>
    		<?php endif ?>
    		<?php if($char_gexp >= 1500) : ?>
    			<div class="subheading mb-5 text-center"><br>Sticking up the big fancy casino.
    			<button type="submit" name="casino" id="casino" class="btn btn-dark center-block">Submit</button>
    		<?php endif ?>
    		<?php if($char_gexp >= 2000) : ?>
    			<div class="subheading mb-5 text-center"><br>Raiding a bank vault.
    			<button type="submit" name="bankvault" id="bankvault" class="btn btn-dark center-block">Submit</button>
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