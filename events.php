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

$query = "SELECT * FROM events WHERE char_id='$char_id' ORDER BY event_timestamps DESC;";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$row = $result->fetch_assoc();
$targetID = $row['char_id'];

$query = "SELECT * FROM events WHERE char_id='$char_id'";
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
		tr, td {
			border: 1px solid black;
		}
	</style>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Events</title>
	
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
    	<h1 class="mb-0 text-center">Events</h1>
 			<div class="text-center">
 					<div class="text-dark">
  					<?php
					
							if(isset($_GET['delete'])) {
								$targetEventID = $_GET['delete'];
								$targetID = findEventOwnerID($db, $targetEventID);
								if($char_id == $targetID) {
									deleteEvent($db, $targetEventID);
									echo("<div class='alert alert-success'><strong>Successfully deleted event!</strong></div>");
								} else {
									echo("<div class='alert alert-danger'><strong>This is not your event!</strong></div>");
								}
							}
							if(isset($_GET['acceptinvite'])) {
								$invite_ID = mysqli_real_escape_string($db, $_GET['acceptinvite']);
								
								$query = "SELECT * FROM crew_invites WHERE id='$invite_ID'";
								$result = mysqli_query($db, $query);
								$row = $result->fetch_assoc();
								
								$invite_target = $row['name'];
								$invite_crewID = $row['crew_id'];
								
								if($char_name == $invite_target) {
									$findOwner = findCrewOwner($db, $invite_crewID);
									$findinviteeID = findVictimID($db, $findOwner);
									event_add($findinviteeID, $char_name . " has accepted your invite!");
									changeCrew($db, $invite_target, $invite_crewID);
									deleteCrewInvite($db, $invite_ID);
									deleteAllCrewInvites($db, $char_id);
									echo("<div class='alert alert-success'>You have accepted a crew invite!</div>");
								} else {
									echo("<div class='alert alert-danger'>This is not your invite!</div>");
								}
								
							}
					
					?>
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
   					<table width=75% cellspacing=1 class='table'> 
   						<tr style='background:gray; color: white;'>
							<th>Time</th> 
							<th>Event</th>
							<th>Actions</th>
   						</tr>
    					<?php
						$query = "SELECT * FROM events WHERE char_id='$char_id' ORDER BY event_timestamps DESC $limit;";
						$result = mysqli_query($db, $query) or die(mysqli_error($db));
						echo("<br>");
						while($row = mysqli_fetch_array($result)) {
							echo("<tr>");
							echo("<td>" . date("F j, Y, g:i a", $row['event_timestamps']));
							echo("<td>" . $row['event']);
							echo("<td><a href='events.php?delete=" . $row['event_db_id']. "' class='btn btn-sm btn-danger btn-outline-light'>Delete</a></tr></td>");
							if(strpos($row['event'], 'received a crew invite') == true) {
								markEventInvite($db, $row['event_db_id']);
							}
						}
						?>
						</table>
					</div>
    			</div>
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