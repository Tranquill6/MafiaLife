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
  
  	<style>
		tr, td {
			border: 1px solid black;
		}
	</style>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Inventory</title>
	
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
    <div class="container p-0" style="background-color: white; border-style: solid; height: inherit">
    	
    	<div class="my-auto">
    	<h1 class="mb-0 text-center">Inventory</h1>
    	<h3 class="mb-5 text-center">Who knows what you'll keep in here</h3>
    	<form action="crimes-petty.php" method="post">
    	<div class="text-center">
    		<div class="text-dark">
    		
    		<?php
				if(isset($_GET['drop'])) {
					$hasItem = 0;
					$itemIDToDrop = $_GET['drop'];
					foreach($char_inv_slots as $dropvalue) {
						if($dropvalue == $itemIDToDrop) {
							$hasItem = 1;
						}
					}
					if($hasItem == 1) {
						dropItem($db, $char_id, $itemIDToDrop, 1);
						echo("<div class='alert alert-success'>You have successfully dropped an item!</div>");
					}
				}
				
				if(isset($_GET['use'])) {
					$itemIDToUse = mysqli_real_escape_string($db, $_GET['use']);
					if($itemIDToUse == 8003) {
						$healthFound = findHealth($db, $char_name);
						if($healthFound == 100) {
							echo("<div class='alert alert-danger'>You already have full health!</div>");
						} else {
							$healthToRegen = rand(5, 10);
							$healthFound += $healthToRegen;
							
							if($healthFound > 100) {
								$healthFound = 100;
							}
							
							$foundID = findVictimID($db, $char_name);
							
							$query = "SELECT item_quantity FROM inventory WHERE char_id='$foundID' and item_id='8003'";
							$result = mysqli_query($db, $query);
							$row = $result->fetch_assoc();
							$foundQuantity = $row['item_quantity'];
							
							if($foundQuantity == 1) {
								$query = "DELETE FROM inventory WHERE WHERE char_id='$foundID' and item_id='8003'";
								mysqli_query($db, $query);
							} else {
								$foundQuantity -= 1;
								$query = "UPDATE inventory SET item_quantity='$foundQuantity' WHERE item_id='8003' and char_id='$foundID'";
								mysqli_query($db, $query);
							}
							
							$query = "UPDATE characters SET health='$healthFound' WHERE char_name='$char_name'";
							mysqli_query($db, $query);
							
							echo("<div class='alert alert-success'>You have used the bandage successfully!</div>");
						}
					}
				}
			?>
   		
    		<?php if(empty($char_inv_slots)) : ?>
    			<div class="alert-info">
    				Your inventory is empty.
    			</div>
    		<?php else: ?>
    		<table width=75% cellspacing=1 class='table'> 
				<tr style='background:gray; color: white;'>
					<th>Item</th>
					<th>Action</th>
				</tr>
				<?php
					if($char_inv_slots > 0) {
						foreach($char_inv_slots as $value) {
							$itemNameFind = findItemName($db, $value);
							
							$query = "SELECT item_quantity FROM inventory WHERE char_id='$char_id' AND item_id='$value'";
							$result = mysqli_query($db, $query);
							$row = $result->fetch_assoc();
							$itemQuantity = $row['item_quantity'];
							
							if($itemQuantity > 1) {
								echo("<tr><td>". $itemQuantity . "x" . " ". $itemNameFind . "<br></td>");
								if($value == 8003) {
									echo("<td><a href='inventory.php?use=$value' class='btn btn-dark btn-sm'>Use</a>");
									echo(" ");
									echo("<a href='inventory.php?drop=$value' class='btn btn-sm btn-danger'>Drop</a></tr>");
								} else {
									echo("<td><a href='inventory.php?drop=$value' class='btn btn-sm btn-danger'>Drop</a></tr>");
								}
							} else {
								echo("<tr><td>".$itemNameFind . "<br></td>");
								if($value == 8003) {
									echo("<td><a href='inventory.php?use=$value' class='btn btn-dark btn-sm'>Use</a>");
									echo(" ");
									echo("<a href='inventory.php?drop=$value' class='btn btn-sm btn-danger'>Drop</a></tr>");
								} else {
									echo("<td><a href='inventory.php?drop=$value' class='btn btn-sm btn-danger'>Drop</a></tr>");
								}
						}
					}
				} 	
			?>
  		</table>
  		<?php endif ?>
   		</div>
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