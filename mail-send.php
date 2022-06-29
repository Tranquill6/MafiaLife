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
    
	<title>MafiaLife: Compose</title>
	
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
    	<h1 class="mb-0 text-center">Compose Message</h1>
    	<form action="mail-send.php" method="post" style="text-align: center">
    		<br>
			<?php
				if(isset($_POST['mailsubmit']))
				{
					$mail_sender = mysqli_real_escape_string($db, $char_name);
					$mail_receiver = mysqli_real_escape_string($db, $_POST['mailreceiver']);
					$mail_message = mysqli_real_escape_string($db, $_POST['mailmessage']);
					$mail_subject = mysqli_real_escape_string($db, $_POST['mailsubject']);
					
					$query = "SELECT char_name FROM characters";
					$result = mysqli_query($db, $query);
					$storageArray = array();
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
						$storageArray[] = $row['char_name'];
					}
					
						if($mail_receiver == "") {
							echo("Please enter someone to send this to!");
						} elseif($mail_message == "") {
							echo("Please enter a message!");
						} elseif (in_array($mail_receiver, $storageArray)) {
							send_mail($db, $mail_subject, $mail_message, $mail_receiver, $mail_sender);
							echo("<div class='alert alert-success'><strong>Successfully sent message!</strong></div>");
							
						} else {
							echo("That user doesn't exist!");
						}
				}
			?>
			<strong>To</strong>
			<div class="input-group" style="justify-content: center">
				<?php if(isset($_GET['to'])) : ?>
					<?php $sendTo = mysqli_real_escape_string($db, $_GET['to']); ?>
					<input type="text" value="<?php echo $sendTo ?>" name="mailreceiver">
				<?php else : ?>
					<input type="text" name="mailreceiver">
				<?php endif; ?>
			</div>
			<br>
			<strong>Subject</strong>
			<div class="input-group" style="justify-content: center">
				<input type="text" name="mailsubject">
			</div>
			<br>
			<strong>Message</strong>
			<div class="input-group" style="justify-content: center">
				<textarea rows="4" cols="50" name="mailmessage"></textarea>
			</div>
			<br>
			<button type="submit" class="btn btn-sm btn-outline-dark" name="mailsubmit">Send</button>
			<a href="mail.php" class="btn btn-sm btn-outline-dark">Back to Mailbox</a>
			<br>
			<br>
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