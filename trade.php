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

// Fetchs ALL inventory slots of a character
$query = "SELECT * FROM inventory WHERE char_id='$char_id'";
$result = mysqli_query($db, $query);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$char_inv_slots[] = $row['item_id'];
}

?>
<!doctype html>
<html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Trade</title>
	
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
    	<h1 class="mb-0">Trade</h1>
    	<a href="trade-pending.php" class="btn-med btn btn-dark">Pending Trades</a>
    	<br>
    	<br>
    	<?php
		
			if(isset($_POST['tradingsubmit'])) {
				if(!empty($_POST['tradingitem'])) {
					$tradingItem = mysqli_real_escape_string($db, $_POST['tradingitem']);
					$tradingQuantity = mysqli_real_escape_string($db, $_POST['tradingquantity']);
					$tradingPartner = mysqli_real_escape_string($db, $_POST['tradingpartner']);

					if($tradingQuantity <= 0) {
						echo("<div class='alert alert-danger'>You have to give a quantity greater than zero!</div>");
					}
					$checkName = findVictimName($db, $tradingPartner);
					if($tradingPartner == $checkName) {
						$tradingItemID = findItemID($db, $tradingItem);
						$itemSearch = findItemInInventory($db, $char_id, $tradingItemID);
						if($itemSearch == true) {
							$quantityFind = findItemQuantityInInventory($db, $char_id, $tradingItemID);
							if($tradingQuantity <= $quantityFind) {
								sendTradeRequest($db, $char_name, $tradingPartner, $tradingItemID, $tradingQuantity);
								$tradingPartnerID = findVictimID($db, $tradingPartner);
								event_add($tradingPartnerID, $char_name . " has sent you a trade!");
								echo("<div class='alert alert-success'>Trade request sent!</div>");
							} else {
								echo("<div class='alert alert-danger'>You do not have that much of that item!</div>");
							}
						} else {
							echo("<div class='alert alert-danger'>Sorry, you do not have that item!</div>");
						}
					} else {
						echo("<div class='alert alert-danger'>This person does not exist!</div>");
					}
			} else {
				echo("<div class='alert alert-danger'>You have to pick an item!</div>");
			}
		}
		
		?>
   			<form action='trade.php' method="post">
   				<br>
   				<br>
   				<h4>Item:</h4>
   				<select name="tradingitem">
   					<?php foreach($char_inv_slots as $value) : ?>
   						<?php $value = findItemName($db, $value); ?>
   						<option name='<?php echo $value ?>'><?php echo $value ?></option>
   					<?php endforeach; ?>
   				</select>
   				<br>
   				<br>
   				<h4>Quantity:</h4>
   				<input type="number" style="width: 80px" name="tradingquantity">
   				<br>
   				<br>
   				<h4>To who:</h4>
   				<input type="text" name="tradingpartner">
   				<br>
   				<br>
   				<button type="submit" name="tradingsubmit" class="btn btn-dark btn-sm">Send Trade</button>
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