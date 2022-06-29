<?php
include('play.php');

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} if(doYouHaveCF($db, $char_name) == false) {
	echo("<script type='text/javascript'>location.href='play.php';</script>");
}

$rank_array = array("Thug", "Gangster", "Earner", "Wise Guy", "Made Man", "Caporegime", "Boss", "Don", "Godfather");
$rankWorth = 0;
$otherRankWorth = 0;


$query = "SELECT id FROM crew_fronts WHERE owner='$char_name'";
$result = mysqli_query($db, $query);
$row = $result->fetch_assoc();
$crewfront_id = $row['id'];

$crewMembers = eachMemberInCF($db, $crewfront_id);
$cfMembers = membersInACF($db, $char_crewid);

?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Crew Fronts Management</title>
	
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
    	<h1 class="mb-0">Crew Fronts Management</h1>
    		<?php
			
				if(isset($_GET['promo'])) {
					$promoMember = mysqli_real_escape_string($db, $_GET['promo']);
					if($findCFOwner == $char_name) {
						$findID = pullCrewID($db, $promoMember);
						if($findID != false) {
							$findOwner = findCrewOwner($db, $findID);
							if($findOwner == $char_name) {
								$pulledGEXP = pullGEXP($db, $promoMember);
								$pulledRank = pullRank($db, $promoMember);
								$findMemberID = findVictimID($db, $promoMember);
								$promoMember_eligiblePromo = 0;
								$eligiblePromo = eligibleForPromo($db, $promoMember, $pulledRank, $pulledGEXP);
								
								$rankWorth = 0;
								$otherRankWorth = 0;
								
								foreach($rank_array as $value) {
								$rankWorth += 1;
								if($value == $rank) {
									$rankWorth += 1;
									break;
									}
								}
								foreach($rank_array as $value) {
									$otherRankWorth += 1;
									if($value == $pulledRank) {
										$otherRankWorth += 1;
										break;
									}
								}

								if((($otherRankWorth+1) < $rankWorth) and $eligiblePromo == true) {
									$promoMember_eligiblePromo = 1;
								}
								
								if($promoMember_eligiblePromo == 1) {
									promoSomeone($db, $promoMember, $pulledRank);
									event_add($findMemberID, "You have been promoted!");
									echo("<div class='alert alert-success'>Member has been promoted!</div>");
								} else {
									echo("<div class='alert alert-danger'>They are not eligible for a promotion!</div>");
								}
							} else {
								echo("<div class='alert alert-danger'>You do not have permission for this!</div>");
							}
						} else {
							echo("<div class='alert alert-danger'>They are not in a crew!</div>");
						}
						
					} else {
						echo("<div class='alert alert-danger'>You do not have permission for this!</div>");
					}
					
				}
				if(isset($_GET['auth'])) {
					$authMember = mysqli_real_escape_string($db, $_GET['auth']);
					if($findCFOwner == $char_name) {
						$findID = pullCrewID($db, $authMember);
						if($findID != false) {
							$findOwner = findCrewOwner($db, $findID);
							if($findOwner == $char_name) {
								$pulledRank = pullRank($db, $authMember);
								$findMemberID = findVictimID($db, $authMember);
								$authMember_eligibleAuth = 0;
								$isAuthed = isAuthed($db, $authMember);
								
								if(($pulledRank == "Caporegime" or $pulledRank == "Boss" or $pulledRank == "Don") and $isAuthed == false) {
									$authMember_eligibleAuth = 1;
								}
								if($authMember_eligibleAuth == 1) {
									authSomeone($db, $authMember);
									event_add($findMemberID, "You have been authed!");
									echo("<div class='alert alert-success'>Member has been authed!</div>");
								} else {
									echo("<div class='alert alert-danger'>They are not eligible for an auth!</div>");
								}
							} else {
								echo("<div class='alert alert-danger'>You do not have permission for this!</div>");
							}
						} else {
							echo("<div class='alert alert-danger'>They are not in a crew!</div>");
						}
						
					} else {
						echo("<div class='alert alert-danger'>You do not have permission for this!</div>");
					}
				}
			
			?>
    		<hr/>
   			<form action='crewfronts-management-members.php' method="post">
				<a href="crewfronts-management-invites.php" class="btn btn-dark btn-sm">Invites</a>
				<a href="crewfronts-management.php" class="btn btn-dark btn-sm">Manage</a>
  				<br>
  				<br>
  				<h5>Members (<?php echo $cfMembers ?>)</h5>
  				<?php if(!(empty($crewMembers))) {
  					 foreach($crewMembers as $value) {
  						$query = "SELECT * FROM characters WHERE char_name='$value'";
						$result = mysqli_query($db, $query);
						$row = $result->fetch_assoc();
						
						$crewMember_rank = $row['rank'];
						$crewMember_gexp = $row['g_exp'];
						$crewMember_name = "";
						
						$crewMember_eligibleAuth = 0;
						$crewMember_eligiblePromo = 0;
						
						$rankWorth = 0;
						$otherRankWorth = 0;
						
						$crewMember_name = $value;
						$isAuthed = isAuthed($db, $crewMember_name);
						
						$eligiblePromo = eligibleForPromo($db, $crewMember_name, $crewMember_rank, $crewMember_gexp);
						
						echo("<strong>".$value . " - " . $crewMember_rank. "</strong>" . " " . " ");
						
						if(($crewMember_rank == "Caporegime" or $crewMember_rank == "Boss" or $crewMember_rank == "Don") and $isAuthed == false) {
							$crewMember_eligibleAuth = 1;
						}
						
						foreach($rank_array as $value) {
							$rankWorth += 1;
							if($value == $rank) {
								break;
							}
						}
						foreach($rank_array as $value) {
							$otherRankWorth += 1;
							if($value == $crewMember_rank) {
								break;
							}
						}
						if((($otherRankWorth+1) < $rankWorth) and $eligiblePromo == true) {
							$crewMember_eligiblePromo = 1;
						} else {
							$crewMember_eligiblePromo = 0;
						}
						
						
						if($crewMember_eligiblePromo == 1 and $crewMember_name != $char_name) {
							echo("<a href='crewfronts-management-members.php?promo=" . $crewMember_name . "' class='btn btn-sm btn-dark'>Promo</a>");
						}
						if($crewMember_eligibleAuth == 1 and $crewMember_name != $char_name){
							echo("<a href='crewfronts-management-members.php?auth=" . $crewMember_name . "' class='btn btn-sm btn-dark'>Auth</a>");
						}
						echo("<br>");
						echo("<br>");
						
  					}
				}
  				?>
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