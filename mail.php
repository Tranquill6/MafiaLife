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

$query = "SELECT * FROM mail WHERE receiver='$char_name'";
$result = mysqli_query($db, $query);
$num = 0;
while($row = mysqli_fetch_array($result)) {
	$num += 1;
}

$amountToShow = 15;
$pages = ceil($num/$amountToShow);
if(!isset($_GET['page'])) {
	$page = 1;
} else {
	$page = $_GET['page'];
}
$limitOffset = ($page-1) * $amountToShow;

$limit = "LIMIT $amountToShow OFFSET $limitOffset";

?>
<!doctype html>
<html>
<head>
   	
   	<style>
	
		border-bottom, border-left, border-right {
			color: black;
			border-style: solid;
		}
	
	</style>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Mail</title>
	
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
    	<h1 class="mb-0 text-center">Mail</h1>
    	<div style="text-align: center">
    	<?php
			if(isset($_GET['delete'])) {
				$mail_id = $_GET['delete'];
				$properMailOwner = findMailOwnerName($db, $mail_id);
				if($char_name == $properMailOwner) {
					delete_mail($mail_id);
					echo("<div class='alert alert-success'><strong>Successfully deleted message!</strong></div>");
				} else {
					echo("<div class='alert alert-danger'><strong>This is not your message!</strong></div>");
				}
			}
		?>
   		</div>
    	<form action="mail.php" method="post">
    	<div class="text-center">
    	<?php
					if($page == 1) {
						if($pages > 1) {
							if($pages > 5) {
								for($pageCounter = 0; $pageCounter < 5; $pageCounter++) {
									echo("<a href='events.php?page=".($pageCounter+1)."' class='btn btn-dark btn-sm'>".($pageCounter+1)."</a> ");
								}
							} else {
								for($pageCounter = 0; $pageCounter < $pages; $pageCounter++) {
									echo("<a href='events.php?page=".($pageCounter+1)."' class='btn btn-dark btn-sm'>".($pageCounter+1)."</a> ");
								}
							}
						}
					} else {
						if($pages > 1) {
							if($pages > 5) {
								for($pageCounter = 0; $pageCounter < 5; $pageCounter++) {
									$displayPage = (($pageCounter+1)+($page-2));
									echo("<a href='events.php?page=".$displayPage."' class='btn btn-dark btn-sm'>".$displayPage."</a> ");
									if($displayPage == $pages) {
										break;
									}
								}
							} else {
								for($pageCounter = 0; $pageCounter < $pages; $pageCounter++) {
									echo("<a href='events.php?page=".($pageCounter+1)."' class='btn btn-dark btn-sm'>".($pageCounter+1)."</a> ");
								}
							}
						}
					}
					
					?>
   		<br>
   		<br>
    	<a href="mail-send.php" class="btn btn-block btn-dark" role="button">Compose</a>
    	<table width=75% cellspacing=1 class='table'> 
   						<tr style='background:gray; color: white;'>
							<th>Time</th> 
							<th>Sender</th>
  							<th>Subject</th>
  							<th>Actions</th>
   						</tr>
    					<?php
							$query = "SELECT * FROM mail WHERE receiver='$char_name' ORDER BY time DESC $limit;";
							$result = mysqli_query($db, $query) or die(mysqli_error($db));
							while($row = mysqli_fetch_array($result)) {
								echo("<tr>");
								echo("<td class='border-bottom'>" . date("F j, Y, g:i a", $row['time']));
								echo("<td class='border-bottom'>" . $row['sender']);
								echo("<td class='border-bottom'>" . $row['subject']);
								echo("<td class='border-bottom'><a href='mail-read.php?mail_id=" . $row['mail_id']. "' class='btn btn-sm btn-dark'>Read</a>");
								echo(" ");
								echo("<a href='mail.php?delete=" . $row['mail_id']. "' class='btn btn-sm btn-danger'>Delete</a>");
										
							}
						?>
						</table>
    			</div>
    			</div>
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
<?php include("footerbottom.php"); ?>
</body>
</html>