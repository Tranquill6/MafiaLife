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
    
	<title>MafiaLife: Read</title>
	
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
    	
    	<div class="my-auto">
    	<h1 class="mb-0 text-center">Message</h1>
    	<br>
    	<div style="text-align: center; justify-content: center">
    	<?php
			if(isset($_GET['mail_id'])) {
				$specific_mailID = $_GET['mail_id'];
				$query = "SELECT * FROM mail WHERE mail_id='$specific_mailID'";
				$result = mysqli_query($db, $query);
				if($result == False) {
				 // Nothing
				} else {
					$findOwner = findMailOwnerName($db, $specific_mailID);
					if($findOwner == $char_name) {
						$row = $result->fetch_assoc();
						$mail_sender = $row['sender'];
						$mail_time = $row['time'];
						$mail_subject = $row['subject'];
						$mail_receiver = $row['receiver'];
						$mail_message = $row['message'];

						$message = nl2br($mail_message);

						echo("<div><label>From: " . $mail_sender . "</label></div>");
						echo("<div><label>To: " . $mail_receiver . "</label></div>");
						echo("<div><label>Subject: " . $mail_subject . "</label></div>");
						echo("<hr />");
						echo("<div><label><br>". $message ."</label></div>");
						echo("<hr />");
						echo("<br>");
						echo("<a href='mail-send.php?to=$mail_sender' class='btn btn-sm btn-outline-dark'>Reply</a>");
						echo("<a href='mail.php' class='btn btn-sm btn-outline-dark'>Back to Mailbox</a>");
						echo("<br>");
						echo("<br>");
					} else {
						echo("<div class='alert alert-danger'>This is not your message to read!</div>");
					}
				}
			}
		
		?>
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
<?php include("footerbottom.php"); ?>
</body>
</html>