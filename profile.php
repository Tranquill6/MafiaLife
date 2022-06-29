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

if(isset($_GET['char_id'])) {
	$query = "SELECT * FROM characters WHERE char_id='". (int)$_GET['char_id'] ."'";
	$result = mysqli_query($db, $query);
	if($result == False) {
	 // Nothing
	} else {
		$row = $result->fetch_assoc();
		$char_name = $row['char_name'];
		$char_money = $row['money'];
		$job = $row['job'];
		$rank = $row['rank'];
		$totalCrimes = $row['totalCrimes'];
		$char_exp = $row['exp'];
		$char_gexp = $row['g_exp'];
		$char_id = $row['char_id'];
		$profilepic = $row['profilepic'];
		$char_status = $row['char_status'];
		$char_startingcity = $row['starting_city'];
		$char_currentcity = $row['current_city'];
		$char_lastactive = $row['lastactive'];
		$char_lastactivetimestamp = $row['lastactive_timestamp'];
		$char_wealthstatus = $row['wealth_status'];
		$char_quote = $row['quote'];
		$char_crewid = $row['crewfront_id'];
		
		// Determines if your character is dead
		if($char_status == 0) {
			$char_deadalive = "Alive";
		} elseif ($char_status == 1) {
			$char_deadalive = "Dead";
			} else {
				$char_deadalive = "Undetermined";
			}
	}
}

$crewName = findCrewName($db, $char_crewid);
$crewLeader = findCrewOwner($db, $char_crewid);


?>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Profile</title>
	
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
    	<h1 class="mb-0 text-center">Profile</h1>
    	<hr/>
    	<form action="profile.php" method="post">
    	<br>
		<?php
		// Determines if your character is dead
		if($char_status == 0) {
			$char_deadalive = "Alive";
		} elseif ($char_status == 1) {
			$char_deadalive = "Dead";
		} elseif ($char_status == 2) {
			$char_deadalive = "Retired";
		} else {
			$char_deadalive = "Undetermined";
		}
		?>
    	<img src='<?php echo($profilepic); ?>' class='position-relative float-left' style="padding-left: 70px">
		<br>
		<table height="174" cellspacing="0" id="profile" style="margin: auto auto; color:black; width: 600px; border: solid; position: relative" class="text-center">
			<tbody>
				<tr style="border: solid">
					<td height="33" style="margin: 0">
						<strong>Name:</strong> <?php echo("$char_name"); ?> 
					</td>
				</tr>
				<tr style="border: solid">
					<td height="33" style="margin: 0">
						<strong>Job: </strong> <?php echo($job); ?>
					</td>
				</tr>
   				<tr style="border: solid">
   					<td height="49" style="margin: 0">
   						<strong>Rank: </strong><?php echo($rank); ?> <?php if($job == "Civilian") echo("---") ?>
					</td>
   				</tr>
   				<tr style="border: solid">
   					<td style="margin: 0">
						<p><strong>Leader: </strong> <?php echo($crewLeader); ?><?php if($job == "Civilian") echo("---") ?> </p>
					</td>
   				</tr>
   				<tr style="border: solid">
   					<td style="margin: 0">
						<p><strong>Status: </strong> <?php echo($char_deadalive); ?></p>
					</td>
   				</tr>
   				<tr style="border: solid">
   					<td style="margin: 0">
						<p><strong>Home City: </strong> <?php echo($char_startingcity); ?></p>
					</td>
   				</tr>
   				<tr style="border: solid">
   					<td style="margin: 0">
						<p><strong>Wealth: </strong> <?php echo($char_wealthstatus); ?></p>
					</td>
   				</tr>
   				<tr style="border: solid">
   					<td style="margin: 0">
						<p><strong>Last Active: </strong> <?php echo gmdate('F d, h:i A', $char_lastactivetimestamp); ?></p>
					</td>
   				</tr>
    		</tbody>
    	</table>
    	<br>
    	<?php if(!(is_null($char_crewid)) and $char_crewid != 0 and $crewName != "") : ?>
    		<br>
    		<br>
    		<strong><div class="text-center"><?php echo($crewName); ?></div></strong>
		<?php endif; ?>
    	<br>
    	<br>
		<div class="well" style="min-height: 150px">
		<?php echo $char_quote ?>
		</div>
		<br>
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
<?php include("footerbottom.php"); ?>
<br>
<br>
</body>
</html>