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
    
	<title>MafiaLife: Edit Profile</title>
	
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

<body>
    <div class="container p-0" style="background-color: white; border-style: solid">
    	
    	<div class="my-auto text-center">
    	<h1 class="mb-0">Edit Profile</h1>
    	<?php
		
			if(isset($_POST['quoteUpdateSubmit'])) {
				$char_quote = mysqli_real_escape_string($db, $_POST['quoteditor']);
				updateQuote($db, $char_id, $char_quote);
				echo("<div class='alert alert-success'>You have successfully updated your quote!</div>");
			}
			
		?>
    	<form action="profile-edit.php" method="post" enctype="multipart/form-data">
			<div class="text-center">
  				<br>
  				<a href="profile-editpicture.php" class="btn btn-dark btn-sm">Edit Profile Picture</a>
  				<br>
  				<br>
   				<p><strong>Quote: </strong></p>
   				<textarea name="quoteditor" id="quoteditor" rows="10" cols="30">
   					<!-- Replaced by CKEditor -->
   				</textarea>
   				<script> CKEDITOR.replace('quoteditor'); </script>
   				<br>
   				<br>
   				<h6>Click <a href="retire.php" style="color: royalblue">here</a> to retire.</h6>
   				<br>
   				<br>
   				<button type="submit" name="quoteUpdateSubmit" class="btn btn-dark btn-sm">Submit</button>
   				<br>
   				<br>
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
</body>
</html>