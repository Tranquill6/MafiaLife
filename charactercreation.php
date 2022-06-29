<?php
include('server.php');

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You need  to login first.";
	header('location: index.php');
} if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
} 

$query = "SELECT * FROM characters WHERE acc_username='$username_proc' AND char_status='0'";
$result = mysqli_query($db, $query);
while($row = mysqli_fetch_array($result)) {
	if($char_status == 0) {
		$_SESSION['msg'] = "You already have a character!";
		header("location: characters.php");
	}
}

?>


<!doctype html>
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<title>MafiaLife: Character Creation</title>
	
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

<body style="background-image: url(img/mafialifebackground.jpg)">
   	<br>
    <div class="container" style="margin-left: 250px">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center mb-0">Character Creation</h4>
            </div>
            <div class="card-body text-center">
            <form action="charactercreation.php" method="post">
				<?php include("errors.php"); ?>
				<div class="character name">
					<label>Name:</label>
					<input type="text" name="char_name">
				</div>
				<div class="starting location">
					<br>
					<label>Starting Location:</label>
					<select name="startinglocation">
						<option name="startinglocation" value="Chicago">Chicago</option>
						<option name="startinglocation" value="Detroit">Detroit</option>
					</select>
				</div>
				<div class="character answers">
					<br>
					<h2 class="mb-1">Questionarie:</h2>
					<h3>How do you handle a bank robbery?</h3>
					<input type="radio" name="answer1" value="ans1"> Go guns a'blazing through the front door.<br>
					<input type="radio" name="answer1" value="ans2"> Grab someone and use them to keep the cops away.<br>
					<input type="radio" name="answer1" value="ans3"> Sneak around the back and cut the wires.<br>
					<input type="radio" name="answer1" value="ans4"> Scoop out the place before you rob it.<br>
					<br>
					<h3>A local mobster is trying to step up to you.</h3>
					<input type="radio" name="answer2" value="ans1"> Knock his teeth in and set an example.<br>
					<input type="radio" name="answer2" value="ans2"> Uncle taught me how to negtoiate like a champ.<br>
					<input type="radio" name="answer2" value="ans3"> Figure out a way to saboitage his businesses.<br>
					<input type="radio" name="answer2" value="ans4"> Send your best man Hector to take care of him.<br>
					<br>
				</div>
			
            </div>
            <div class="card-footer text-center">
            	<button type="submit" name="create_char" class="btn btn-dark btn-med">Create Character</button>
            	<a href='characters.php' class="btn btn-med btn-dark">Back</a>
            	<a href="logout.php" class="btn btn-med btn-dark">Log Out</a>
            </div>
            </form>
        </div>
    </div>
</body>
</html>