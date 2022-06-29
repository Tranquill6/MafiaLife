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
$postedUsername = $_SESSION['username'];

$query = "SELECT owner FROM accounts WHERE username='$postedUsername'";
$result = mysqli_query($db, $query);
$row = $result->fetch_assoc();
$isOwner = $row['owner'];

if(!($isOwner == 1)) {
	$_SESSION['msg'] = "INVALID ACCESS!";
	header('location: index.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>MafiaLife: Alpha Key Generation</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom fonts for this template -->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
	
	<!-- Custom styles for this template -->
    <link href="css/resume.css" rel="stylesheet">
	
</head>
<body>

<body style="background-image: url(img/mafialifebackground.jpg)">

<body>
   	<br>
    <div class="container" style="margin-left: 170px">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center mb-0">Generate Alpha Keys</h4>
            </div>
            <div class="card-body text-center">
            <?php
			
				if(isset($_POST['generatealphakey'])) {
					generateAlphaKey($db);
					echo("<div class='alert alert-success'>Alpha Key Generated!</div>");
				}
			
			?>
           	<form action="generate_alphakeys.php" method="post">
            	<button type="submit" name="generatealphakey" class="btn btn-dark btn-med">Generate Key</button>
            </form>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
	

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	
</body>
</html>