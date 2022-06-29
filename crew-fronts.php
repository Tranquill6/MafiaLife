<?php
include('play.php');

$cities = array("Detroit", "Chicago");

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
}

$ownerOfCF = doYouHaveCF($db, $char_name);

if($ownerOfCF == true) {
	$query = "SELECT id FROM crew_fronts WHERE owner='$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$crewfront_id = $row['id'];
}

$ableToBuy = false;

$inCrew = isInCrew($db, $char_name);

?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Crew Fronts</title>
	
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
    	<h1 class="mb-0">Crew Fronts</h1>
    		<?php
			
				if(isset($_POST['pizzaplacebuy'])) {
					if($havePPCF == false) {
						if($char_money >= 500000) {
							$type = "pizzaplace";
							buyCF($db, $char_name, $char_id, $char_currentcity, $type);
							event_add($char_id, "You have bought a Pizza Place!");
							echo("<div class='alert alert-success'>You have successfully bought a crewfront!</div>");
						} else {
							echo("<div class='alert alert-danger'>You do not have enough money!</div>");
						}
					} else {
						echo("<div class='alert alert-danger'>You already have this crew front!</div>");
					}
				}
				if(isset($_POST['hotelbuy'])) {
					if($haveHotelCF == false) {
						if($char_money >= 1000000) {
							$type = "hotel";
							buyCF($db, $char_name, $char_id, $char_currentcity, $type);
							event_add($char_id, "You have bought a Hotel!");
							echo("<div class='alert alert-success'>You have successfully upgraded your crewfront!</div>");
						} else {
							echo("<div class='alert alert-danger'>You do not have enough money!</div>");
						}
					} else {
						echo("<div class='alert alert-danger'>You already have this crew front!</div>");
					}
				}
				if(isset($_POST['casinobuy'])) {
					if($haveCasinoCF == false) {
						if($char_money >= 2000000) {
							$type = "casino";
							buyCF($db, $char_name, $char_id, $char_currentcity, $type);
							event_add($char_id, "You have bought a Casino!");
							echo("<div class='alert alert-success'>You have successfully upgraded your crewfront!</div>");
						} else {
							echo("<div class='alert alert-danger'>You do not have enough money!</div>");
						}
					} else {
						echo("<div class='alert alert-danger'>You already have this crew front!</div>");
					}
				}
			
			?>
    		<hr/>
   			<form action='crew-fronts.php' method="post">
				<?php if(($rank == "Made Man" and $char_gexp >= 5500 and $ownerOfCF == false and $inCrew == false) or ($char_authed == 1 and $ownerOfCF == false and $inCrew == false)): ?>
 					<?php $ableToBuy = true; ?>
 					<h5>Pizza Place - 500k</h5>
 					<h5>2 member limit</h5>
 					<button type="submit" name="pizzaplacebuy" class="btn btn-dark btn-sm">Buy</button>
 					<br>
 					<br>
  				<?php endif; ?>
  				<?php if(($rank == "Caporegime" and $char_gexp >= 8000 and $bosspromo == 0 and ($cfMembers >= 2 and $findCFOwner == $char_name and $havePPCF == true)) or ($char_authed == 1 and $bosspromo == 0 and ($cfMembers >= 2 and $findCFOwner == $char_name and $havePPCF == true) and $inCrew == false)): ?>
  				<?php $ableToBuy = true; ?>
  				<br>
 				<h5>Hotel - 1m</h5>
 				<h5>5 member limit</h5>
 				<button type="submit" name="hotelbuy" class="btn btn-dark btn-sm">Buy</button>
 				<br>
 				<br>
  				<?php endif; ?>
  				<?php if(($rank == "Boss" and $char_gexp >= 13000 and $donpromo == 0 and ($cfMembers >= 3 and $findCFOwner == $char_name and $haveHotelCF == true)) or ($char_authed == 1 and $donpromo == 0 and ($cfMembers >= 3 and $findCFOwner == $char_name and $haveHotelCF == true) and $inCrew == false)): ?>
  				<?php $ableToBuy = true; ?>
  				<br>
 				<h5>Casino - 2m</h5>
 				<h5>8 member limit</h5>
 				<button type="submit" name="casinobuy" class="btn btn-dark btn-sm">Buy</button>
 				<br>
 				<br>
  				<?php endif; ?>
  				<?php if($ableToBuy == false) : ?>
  					<div class="alert alert-info">You can not buy or upgrade a crew front right now!</div>
  					<br>
  					<br>
  				<?php endif; ?>
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