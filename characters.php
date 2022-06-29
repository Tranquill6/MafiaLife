<?php
include('server.php');

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} 

$query = "SELECT has_char FROM accounts WHERE username='$username_proc'";
$result = mysqli_query($db, $query);
$row = $result->fetch_assoc();
$id =  intval($row['has_char']);

$char_query = "SELECT * FROM characters WHERE acc_username='$username_proc' ORDER BY lastactive_timestamp DESC LIMIT 1;";
$result = mysqli_query($db, $char_query);
$row = $result->fetch_assoc();
$pulled_charname = $row['char_name'];
$char_status = $row['char_status'];

if($char_status == 0) {
	$char_deadalive = "Alive";
} elseif ($char_status == 1) {
	$char_deadalive = "Dead";
} elseif ($char_status == 2) {
	$char_deadalive = "Retired";
} else {
	$char_deadalive = "Undetermined";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>MafiaLife: Character Screen</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	
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

<body style="background-image: url(img/mafialifebackground.jpg)">
   	<br>
    <div class="container" style="margin-left: 250px">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-0">Character</h2>
            </div>
            <div class="card-body text-center">
					<?php echo("Welcome," . " ". $username_proc . "!"); ?>
					<?php if($id == 0) : ?>
						<div class="no character">
							<?php echo "You do not have a character." ?>
						</div>
					<?php endif ?>
					<br>
				<?php
				if($id == 1) {
					echo("Your character is" . " " . $pulled_charname . ".");
					echo("<br>");
					echo("Status: " . $char_deadalive);
					echo("<br>");
					}
				?>
            </div>
            <div class="card-footer text-center">
            	<?php if($id == 1) : ?>
            		<a href='play.php' class='btn btn-med btn-dark'>Play</a>
            	<?php else : ?>
            		<a href='charactercreation.php' class='btn btn-med btn-dark'>Create A Character</a>
            	<?php endif; ?>
            	<?php if($char_deadalive == "Dead") : ?>
            		<a href='charactercreation.php' class='btn btn-med btn-dark'>Create A Character</a>
            	<?php endif; ?>
            	<a href="logout.php" class="btn btn-med btn-dark">Log Out</a>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
	

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	
</html>