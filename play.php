<?php
ob_start();
include('server.php');

date_default_timezone_set("America/Chicago");
$mnumber = (int)date("M");
$dateObj = DateTime::createFromFormat('!m', $mnumber);
$monthName = $dateObj->format('F');

setlocale(LC_MONETARY, 'en-US');
$convertedMoney = number_format($char_money, 2);

// Handles logging out and redirecting users who aren't logged in.
if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} else {
	if($char_status == 0) {
		$query = "UPDATE characters SET lastactive=NOW() WHERE acc_username='$username_proc' AND char_name='$char_name'";
		mysqli_query($db, $query);

		$timestamp = time() - (6 * 60 * 60);

		$query = "UPDATE characters SET lastactive_timestamp='$timestamp' WHERE acc_username='$username_proc' AND char_name='$char_name'";
		mysqli_query($db, $query);
	}
}

if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} 
//

// Misc. Game Variables
$cfMembers = membersInACF($db, $char_crewid);
$findCFOwner = findCrewOwner($db, $char_crewid);

$havePPCF = doYouHaveTypeCF($db, $char_name, "pizzaplace");
$haveHotelCF = doYouHaveTypeCF($db, $char_name, "hotel");
$haveCasinoCF = doYouHaveTypeCF($db, $char_name, "casino");

$anyCrews = isThereCrews($db, $char_id);
if($anyCrews == true) {
	$numberCrews = numberOfCrews($db, $char_id);
}
//

// Checks to see if you're dead
if (!($char_status == 0)) {
	header("location: graveyard.php");
}
//

// Checks to see if you are suppposed to be in jail
if ($char_jailtime > 0) {
	header("location: jail.php");
}
//

// Clears your travel time if your travel timer is up
if($now >= $char_traveltime) {
	clearTravelTime($db, $char_id);
}
//

// Checks for Gangster promotions
if($char_gexp < 200) {
	$job = "Civilian";
	$rank = "";
	$query = "UPDATE characters SET job='$job', rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 200 and $job == "Civilian" and $thugpromo == 0) {
	$job = "Criminal";
	$rank = "Thug";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
	event_add($char_id, "You have decided to pursue a life of crime, there's no turning back now!");
}
if($char_gexp >= 500 and $gangsterpromo == 0) {
	$rank = "Gangster";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
}
if($char_gexp >= 1000 and $earnerpromo == 0) {
	$rank = "Earner";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
}
if($char_gexp >= 2000 and $wgpromo == 0) {
	$rank = "Wise Guy";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
}
if($char_gexp >= 3500 and $mmpromo == 0 and $anyCrews == false) {
	$rank = "Made Man";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
}
if($char_gexp >= 5500 and $capopromo == 0 and (doYouHaveCF($db, $char_name) == true and $havePPCF == true)) {
	$rank = "Caporegime";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
}
if($bosspromo == 0 and $haveHotelCF == true) {
	$rank = "Boss";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
}
if($donpromo == 0 and $haveCasinoCF == true) {
	$rank = "Don";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
}
if($char_gexp >= 18000 and $godfatherpromo == 0 and (haveTwoBosses($db, $char_name) >= 2 and $rank == "Don" and $haveCasinoCF == true and $cfMembers >= 4 and godfatherCheck($db, $char_startingcity == false))) {
	$rank = "Godfather";
	tickPromo($db, $char_name, $rank);
	gangsterPromote($db, $char_name, $rank, $job);
	increaseStatsForRanking($db, $char_id, $rank, $luckstat);
	calculatePower($db, $char_id);
	event_add($char_id, "You have been promoted to " . $rank . ".");
	event_add($char_id, "You are the king of " . $char_startingcity . " for now.");
}
// End of Gangster Promotions

?>
<!doctype html>
<html>
<head> 	
 	
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="css/jquery.countdown.css"> 
	<script type="text/javascript" src="js/jquery.plugin.js"></script> 
	<script type="text/javascript" src="js/jquery.countdown.js"></script>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife</title>
	
	<!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/resume.css" rel="stylesheet">
    
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>
    
	<script>
		$(document).ready(function(){
			var count = <?php echo(abs($char_nextcrime-time())); ?>

			var counter = setInterval(timer, 1000);

				function timer() {
					count = count - 1;
					if (count <= -1) {
						clearInterval(counter);
						$("#crimetimer").fadeOut().empty();
						return;
					}

					var time = document.getElementById("crimetimer");
					time.innerHTML = "Crime: " + count + "s "; // watch for spelling
				}
		});
	</script>
	<style>
		.brightness img:hover {
			opacity: .5;
		}
	</style>

</head>

<body style="background-image: url(img/mafialifebackground.jpg)">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
       <div class="brightness">
       	<a href="leaderboard.php">
       	<img src="img/trophy-512.png" width="25" height="25" style="margin-left: 230px; display: inline-block">
       	</a>
       </div>
       <a class="navbar-brand js-scroll-trigger" href="profile.php" style="margin-top: 30px">
        <span class="d-none d-lg-block">
          <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="<?php echo($profilepic); ?>" alt="">
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
        <div class="text-white-50">
         <?php echo("Hello, " . $char_name . "!"); ?>
         <br>
         <?php echo("Health: ". $char_hp); ?>
         <br>
         <br>
         <?php echo(date("F") . " " . date("d,") . " " . date("h:ia")); ?>
         <br>
         <?php echo("Money: $" . $convertedMoney); ?>
         <br>
         <?php echo("Current location: " . $char_currentcity); ?>
         <br>
         <?php echo("<br>Job: " . $job); ?>
         <br>
         <?php 
		 if($job == "Civilian") {
		 	# Something...
		 } else {
		 	echo("Rank: " . $rank);
		 }
		 ?>
         <?php
		 	
			if($char_nextcrime > time()) {
				echo("<br>");
				echo("<span id='crimetimer'></span>");
			}
			
			
		 ?>
         </div>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="play.php"><br>Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="events.php">Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="inventory.php">Inventory</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Crimes</a>
            <div class="dropdown-menu">
            	<a class="dropdown-item" href="crimes-petty.php">Petty Crimes</a>
            	<a class="dropdown-item" href="crimes-felony.php">Felony Crimes</a>
            	<?php if($char_gexp >= 850) : ?>
				<a class="dropdown-item" href="crimes-racket.php">Rackets</a> 
           		<?php endif; ?>
            	<a class="dropdown-item" href="crimes-heist.php">Bank Heist</a>
            	<a class="dropdown-item" href="crimes-whack.php">Whack</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="mail.php">Mail</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="trade.php">Trade</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="jail.php">Jail</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="bank.php">Bank</a>
          </li>
          <?php if(doYouHaveCF($db, $char_name) == false) : ?>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="city.php">City</a>
            <?php if(isInCrew($db, $char_name) == true) : ?>
            	<a class="nav-link js-scroll-trigger" href="crew.php">Crew</a>
            <?php endif; ?>
          </li>
          <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">City</a>
            <div class="dropdown-menu">
            	<a class="dropdown-item" href="city.php">City</a>
            	<a class="dropdown-item" href="crewfronts-management.php">Crew Front Management</a>
            </div>
          <?php endif; ?>
          <?php if(($rank == "Made Man" or $rank == "Caporegime" or $rank == "Boss" or $rank == "Don" or $rank == "Godfather") and $char_gexp >= 5500 and isInCrew($db, $char_name) == false) : ?>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="crew-fronts.php">Crew Fronts</a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="profile-edit.php">Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="logout.php">Log Out</a>
          </li>
        </ul>
      </div>
    </nav>
    <br>
</body>
</html>