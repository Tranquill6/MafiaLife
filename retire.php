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
    
	<title>MafiaLife: Retire</title>
	
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
	<script src="/ckeditor/ckeditor.js"></script>

</head>

<body style="background-image: url(img/mafialifebackground.jpg)">
    <div class="container p-0" style="background-color: white; border-style: solid">
    	
    	<div class="my-auto">
    	<h1 class="mb-0 text-center">Retire</h1>
    	<h3 class="mb-0 text-center">It is time to call it quits</h3>
    	<?php
		
			if(isset($_POST['retire'])) {
				$retire_words = mysqli_real_escape_string($db, $_POST['quoteditorretire']);
				$retiree = $char_name;
				retireSomeone($db, $retiree, $retire_words);
			}
		
		?>
    	<form action="retire.php" method="post">
			<div class="text-center">
			<br>
			<h6>Once you make the decision to leave this way of life, there's no returning...</h6>
			<br>
			<h6>Final words:</h6>
			<textarea name="quoteditorretire" id="quoteditor">
						<!-- Replaced by CKEditor -->
			</textarea>
			<script> CKEDITOR.replace('quoteditor'); </script>
			<br>
			<button type="submit" name="retire" class="btn btn-dark btn-med">Retire</button>
			<br>
			<br>
			</div>
		</form>
		
		
	<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>

</body>
</html>