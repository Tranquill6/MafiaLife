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

</head>

<body>
    <div class="container p-0" style="background-color: white; border-style: solid">
    	
    	<div class="my-auto text-center">
    	<h1 class="mb-0">Edit Profile</h1>
    	<?php
		
			if(isset($_POST["imageUploadSubmit"])) {

				if(is_array($_FILES)) {
					
					$file = $_FILES['imageUploaded']['tmp_name'];
					if(!empty($file)) {
						$sourceProperties = getimagesize($file);
						$fileNewName = time();
						$folderPath = "img/";
						$ext = pathinfo($_FILES['imageUploaded']['name'], PATHINFO_EXTENSION);
						$imageType = $sourceProperties[2];

						switch ($imageType) {

							case IMAGETYPE_PNG:

								$imageResourceId = imagecreatefrompng($file); 
								$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
								imagepng($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
								break;

							case IMAGETYPE_GIF:

								$imageResourceId = imagecreatefromgif($file); 
								$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
								imagegif($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
								break;

							case IMAGETYPE_JPEG:

								$imageResourceId = imagecreatefromjpeg($file); 
								$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
								imagejpeg($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
								break;

							default:
								echo "<div class='alert alert-danger'>Invalid Image type.</div>";
								exit;
								break;

						}

						move_uploaded_file($file, $folderPath. $fileNewName . "." . $ext);
						changeProfilePic($db, $char_id, $fileNewName . "_thump." . $ext);
						echo "<div class='alert alert-success'>Profile Picture Updated!</div>";
					} else {
						echo("<div class='alert alert-danger'>You can't upload nothing!</div>");
					}
				}
			}

			function imageResize($imageResourceId,$width,$height) {

				$targetWidth = 350;
				$targetHeight = 400;

				$targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
				imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);

				return $targetLayer;
			}
		?>
    	<form action="profile-editpicture.php" method="post" enctype="multipart/form-data">
			<div class="text-center">
  				<br>
   				<p><strong>Change Your Profile Picture: </strong></p>
   				<input type="file" name="imageUploaded" id="imageUploaded">
   				<br>
   				<br>
   				<button type="submit" name="imageUploadSubmit" class="btn btn-dark btn-sm">Submit</button>
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