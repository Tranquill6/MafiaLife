<?php
include('play.php');

$obitID = (int)$_GET['visit'];

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} if (!isset($_GET['visit'])) {
	echo("<script type='text/javascript'>location.href='obituaries.php';</script>");
} elseif((is_int($obitID)) == false) {
	echo("<script type='text/javascript'>location.href='obituaries.php';</script>");
}

?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Obituaries</title>
	
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
			<h1 class="mb-0 text-center">Obituaries</h1>
			<h4 class="mb-0 text-center">Rest In Peace To The Fallen</h4>
				<br>
				<form action="obituaries-visit.php?visit=<?php echo $obitID ?>" method="post">
   						<?php
							if(isset($_GET['visit'])) {
								$query = "SELECT * FROM obituaries WHERE obit_id='$obitID'";
								$result = mysqli_query($db, $query);
								$row = $result->fetch_assoc();
								
								$obitName = $row['char_name'];
								$obitDeathTime = $row['death_timestamp'];
								$obitRank = $row['rank'];
								$obitJob = $row['job'];
							}
							if(isset($_POST['funeralreplysubmit'])) {
								$obit_reply = mysqli_real_escape_string($db, $_POST['quoteditorobit']);
								$obit_replysender = $char_name;
								
								addForumReply($db, $obitID, "obit", $obit_replysender, $obit_reply);
								echo("<div class='alert alert-success'>Replied!</div>");
							}
							
						
						?>
   			<h5 class="mb-0">We have gathered here today to the mourn the loss of <?php echo $obitName ?>, he was taken too early by the mean streets. 
   			<br>He carried his head high and tried to make the most of his life as a <?php echo $obitJob ?><?php if($obitRank == "") echo(".") ?> <?php if($obitRank != "") echo("obtaining the rank of " . $obitRank . ".") ?> <br>may the lord have mercy upon his soul as he descends on his next journey into the afterlife.</h5>
   			<br>
   			<hr/>
   			<div style="max-width: 700px; margin-left: 220px">
   			<textarea name="quoteditorobit" id="quoteditor">
   					<!-- Replaced by CKEditor -->
   				</textarea>
   				<script> CKEDITOR.replace('quoteditor'); </script>
   				</div>
   				<br>
   				<button type="submit" name="funeralreplysubmit" class="btn btn-dark btn-sm w-50">Reply</button>
   				<br>
   				<br>
   				</form>
    		</div>
    	</div>
    <div class="container p-0" style="background-color: white; border-style: solid">
    	<div class="text-center"><h5>Replies:</h5></div>
    	<hr/>
    	<?php
			$query = "SELECT * FROM forum_replies WHERE forum_type='obit' AND forum_id='$obitID' ORDER BY time DESC;";
			$result = mysqli_query($db, $query);
			if(mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_array($result)) {
					echo("<div class='container'>");
					echo("<div class='card'>");
					echo("<div class='card-header'>");
					echo("<h4 class='mb-0'><strong>" . $row['sender'] . "</h4></strong>");
					echo("</div>");
					echo("<div class='card-body text-center'><p class='card-text'>" . $row['reply'] . "</p></div>");
					echo("<div class='card-footer'>".gmdate('F d Y, h:i A', $row['time']-21600)."</div>");
					echo("</div>");
					echo("</div>");
					echo("<br>");
				}
			} else {
				echo("<div class='alert alert-info text-center'>No replies yet!</div>");
			}
		
		?>
    </div>
    <br>
    
	<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>

</body>
</html>