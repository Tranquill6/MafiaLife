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

// Finds Your Trade Requests
$query = "SELECT * FROM trade WHERE receiver='$char_name'";
$result = mysqli_query($db, $query);
$tradeArray = array();
while($row = $result->fetch_assoc()){
	$tradeArray[] = $row['item_id'];
}

$query = "SELECT * FROM trade WHERE receiver='$char_name'";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$row = $result->fetch_assoc();
$c_tradingID = $row['trade_id'];

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
    
	<title>MafiaLife: Trades Pending</title>
	
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
    	<h1 class="mb-0">Trade(s) Pending</h1>
    	<br>
    	<br>
    	<?php
		
			if(isset($_GET['accept'])) {
				$query = "SELECT * FROM trade WHERE trade_id='".$c_tradingID."'";
				$result = mysqli_query($db, $query);
				$row = $result->fetch_assoc();
				$c_tradingReceiver = $row['receiver'];
				$c_tradingSender = $row['sender'];
				$c_tradingItemID = $row['item_id'];
				$c_tradingItemQuantity = $row['item_quantity'];
				
				$c_tradingSenderID = findVictimID($db, $c_tradingSender);
				if($c_tradingReceiver == $char_name) {
					giveItem($db, $char_id, $c_tradingItemID, $c_tradingItemQuantity);
					event_add($c_tradingSenderID, $char_name . " has accepted your trade!");
					event_add($char_id, "You have accepted " . $c_tradingSender . "'s trade!");
					deleteTradeRequest($db, $char_name, $c_tradingID);
					echo("<div class='alert alert-success'>You have accepted ".$c_tradingSender."'s trade!</div>");
				} else {
					echo("<div class='alert alert-danger'>This is not your trade!</div>");
				}
			}
			
			if(isset($_GET['decline'])) {
				$query = "SELECT * FROM trade WHERE trade_id='".$c_tradingID."'";
				$result = mysqli_query($db, $query);
				$row = $result->fetch_assoc();
				$c_tradingReceiver = $row['receiver'];
				$c_tradingSender = $row['sender'];
				$c_tradingItemID = $row['item_id'];
				$c_tradingItemQuantity = $row['item_quantity'];
				$c_tradingSenderID = findVictimID($db, $c_tradingSender);
				
				if($c_tradingReceiver == $char_name) {
					giveItem($db, $c_tradingSenderID, $c_tradingItemID, $c_tradingItemQuantity);
					deleteTradeRequest($db, $char_name, $c_tradingID);
					event_add($c_tradingSenderID, $char_name . " has declined your trade!");
					event_add($char_id, "You have declined " . $c_tradingSender . "'s trade!");
					echo("<div class='alert alert-danger'>You have declined ".$c_tradingSender."'s trade!</div>");
				} else {
					echo("<div class='alert alert-danger'>This is not your trade!</div>");
				}
			}
		
		?>
  			<?php if(!empty($tradeArray)) : ?>
  			<a href='trade.php' class='btn btn-block btn-dark'>Go Back</a>
   			<table width=75% cellspacing=1 class='table'> 
				<tr style='background:gray; color: white;'>
					<th>From</th>
					<th>Item</th>
					<th>Quantity</th>
					<th>Actions</th>
				</tr>
			<?php endif; ?>
  			<?php
				if(!empty($tradeArray)) {
					foreach($tradeArray as $value) {
						$query = "SELECT * FROM trade WHERE receiver='$char_name' AND item_id='$value'";
						$result = mysqli_query($db, $query);
						$row = $result->fetch_assoc();

						$trade_id = $row['trade_id'];
						$sender = $row['sender'];
						$item_quantity = $row['item_quantity'];
						$item_name = findItemName($db, $value);


						echo("<tr>");
						echo("<td>" . $sender);
						echo("<td>" . $item_name);
						echo("<td>" . $item_quantity);
						echo("<td><a href='trade-pending.php?accept=$trade_id' class='btn btn-dark'>Accept</a>");
						echo(" ");
						echo("<a href='trade-pending.php?decline=$trade_id' class='btn btn-dark btn-alert'>Decline</a>");
					}
				} else {
					echo("<div class='alert-info'>You have no trade requests.</div>");
					echo("<br>");
					echo("<br>");
					echo("<a href='trade.php' class='btn btn-sm btn-dark'>Go Back</a>");
					echo("<br>");
					echo("<br>");
					echo("<br>");
				}
			?>
   			</table>
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