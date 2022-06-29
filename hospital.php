<?php
include('play.php');
?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Hospital</title>
	
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
    	<form action="hospital.php" method="post">
    	<div class="my-auto text-center">
    	<h1 class="mb-0">Hospital</h1>
    	<h3 class="mb-1">Get well soon...</h3>
    	<br>
    	
    	<?php
		
		if(isset($_POST['healbutton'])) {
			$nextUse = findNextHospitalUse($db, $char_name);
			if(($now - $nextUse) >= 0) { 
				$moneyFound = findMoney($db, $char_id);
				$healthFound = findHealth($db, $char_name);
				if($moneyFound < 500) {
					echo("<div class='alert alert-danger'>You do not have enough money for any medical treatment.</div>");
				} else {
					$moneyFound -= 500;
					$healthFound += rand(40, 60);
					if($healthFound > 100) {
						$healthFound = 100;
					}

					$nextHospitalUse = $now + 1800;

					$query = "UPDATE characters SET health='$healthFound', hospital_timestamp='$nextHospitalUse' WHERE char_name='$char_name'";
					mysqli_query($db, $query);

					echo("<div class='alert alert-success'>You have been successfully healed at the hospital!</div>");
				}
			} else {
				echo("<div class='alert alert-danger'>You have not waited a half an hour before your last visit!</div>");
			}
		}
		
		?>
    	
    	<?php if(findHealth($db, $char_name) == 100) : ?>
    		<strong><p>Hello, welcome to the hospital of <?php echo($char_currentcity); ?>. You currently do not need to seek medical attention at this time. </p></strong>
    	<?php else: ?>
    		<strong><p>Hello, welcome to the hospital of <?php echo($char_currentcity); ?>. If you wish to see a doctor, you will need to pay $500 to cover your extensive medical bill in advance.</p></strong>
    		<button type="submit" name="healbutton" class="btn-sm btn btn-dark">Heal</button>
    		<br>
    	<?php endif; ?>
    	<br>
    	</div>
    	</form>
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