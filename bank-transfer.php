<?php
include('play.php');

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
    
	<title>MafiaLife: Bank Transfer</title>
	
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
    <div class="container p-0 text-center" style="background-color: white; border-style: solid">  	
    	<div class="my-auto text-center">
    	<h1 class="mb-0">Wire Transfer</h1>
    	<h3 class="mb-0">You are in the bank of <?php echo $char_currentcity ?></h3>
    	<br>
    	<?php
		
			if(isset($_POST['moneytransfersubmit'])) {
				$transferAmount = mysqli_real_escape_string($db, $_POST['moneytransfer']);
				$transferTarget = mysqli_real_escape_string($db, $_POST['moneytransfertarget']);
				if($transferAmount <= $moneystored) {
					$foundName = findVictimName($db, $_POST['moneytransfertarget']);
					if($foundName == $transferTarget) {
						if($foundName != $char_name) {
							$foundID = findVictimID($db, $foundName);
							echo("<div class='alert alert-success'><strong>Your wire transfer was successful!</strong></div>");
							transferMoney($db, $char_id, $foundName, $moneystored, $transferAmount);
							event_add($foundID, "You have gotten a wire transfer from " . $char_name . "!");
						} else {
							echo("<div class='alert alert-danger'><strong>You cannot wire transfer to yourself!</strong></div>");
						}
					} else {
						echo("<div class='alert alert-danger'><strong>This person does not exist!</strong></div>");
					}
				} else {
					echo("<div class='alert alert-danger'><strong>You do not have enough money for that wire transfer!</strong></div>");
				}
			}
		
		?>
    	<br>
    	<form action="bank-transfer.php" method="post">
    		To who:
			<input type="text" name="moneytransfertarget">
    		<br>
    		<br>
    		Amount:
			<input type="number" name="moneytransfer">
			<br>
			<br>
			<button type="submit" name="moneytransfersubmit" class="btn btn-dark btn-sm">Transfer</button>
		</form>
    	<br>
    	<br>
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