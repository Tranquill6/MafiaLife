<?php
session_start();
ob_start();

// initializing variables
$username = "";
$email = "";
$job = "Civilian";
$rank = "";
$char_name = "";
$char_money = 100;
$current_time = date("M,d h:i A") . "\n";
$char_exp = 0;
$char_gexp = 0;
$char_inv_totalslots = 9;
$char_deadalive = "";
$char_wealthstatus = "";
$char_jailtime = 0;
$char_jailtimestarted = 0;
$char_traveltime = 0;
$char_quote = "";
$char_hp = 0;
$totalCrimes = 0;
$startinglocation = "";
$gunstat = 0;
$defstat = 0;
$homecity_bonus = 0;
$v_homecity_bonus = 0;
$visionstat = 0;
$item_id=0;
$item_name = "";
$stealthstat = 0;
$luckstat = 0;
$event_text = "";
$errors = array();
$successes = array();
$cities = array();
$hasChar = 0;
$moneystored = 0;
$username_proc = "";
$profilepic = "img/default-profile.jpg";
$mail_sender = "";
$mail_subject = "";
$mail_message = "";
$mail_receiver = "";
$vname = "";
$vgun = 0;
$vdef = 0;
$vluck = 0;
$vsight = 0;
$killname = "";
$foundName = "";
$vCurrentcity = "";
$vid = 0;
$lasttime = 0;
$now = time();
$remainingTime = 0;
$traveltime_seconds = 0;
$traveltime_minutes = 0;
$traveltime_hours = 0;
$depositAmount = 0;
$withdrawAmount = 0;
$transferAmount = 0;
$transferTarget = "";
$foundGun = false;
$char_inv_slots = array();

//gexp multipler
$gexp_multiplier = 1;
//

$wealth_array = array("Broke", "Very Poor", "Poor", "Middle-Class", "Wealthy", "Rich", "Extremely Rich", "Insanely Rich");

// connect to the database
$db = mysqli_connect('localhost', 'root', 'Goawayman12', 'mafia');

if(isset($_SESSION['username'])) {

// Fetchs the character data
$username_proc = $_SESSION['username'];
$query = "SELECT * FROM characters WHERE acc_username='$username_proc' ORDER BY lastactive_timestamp DESC LIMIT 1;";
$result = mysqli_query($db, $query);
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
$char_nextcrime = $row['nextcrime_timestamp'];
$char_crewid = $row['crewfront_id'];
$gunstat = $row['gunstat'];
$luckstat = $row['luckstat'];
$defstat = $row['defstat'];
$char_jailtime = $row['jailtime'];
$char_traveltime = $row['traveltime'];
$char_hp = $row['health'];
$char_authed = $row['authed'];
$char_quote = $row['quote'];
$thugpromo = $row['thugpromo'];
$gangsterpromo = $row['gangsterpromo'];
$earnerpromo = $row['earnerpromo'];
$wgpromo = $row['wgpromo'];
$mmpromo = $row['mmpromo'];
$capopromo = $row['capopromo'];
$bosspromo = $row['bosspromo'];
$donpromo = $row['donpromo'];
$godfatherpromo = $row['godfatherpromo'];

$luckCategory = calculateLuckCategory($db, $luckstat);

// Pulls Bank Data
$query = "SELECT money_stored FROM bank WHERE char_id='$char_id'";
$result = mysqli_query($db, $query);
$row = $result->fetch_assoc();
$moneystored = $row['money_stored'];

if($char_money <= 1000) {
	$char_wealthstatus = $wealth_array[0];
	updateWealthStatus($db, $char_name, $char_wealthstatus);
} if ($char_money > 1000) {
	$char_wealthstatus = $wealth_array[1];
	updateWealthStatus($db, $char_name, $char_wealthstatus);
} if ($char_money >= 100000) {
	$char_wealthstatus = $wealth_array[2];
	updateWealthStatus($db, $char_name, $char_wealthstatus);
} if ($char_money >= 1000000) {
	$char_wealthstatus = $wealth_array[3];
	updateWealthStatus($db, $char_name, $char_wealthstatus);
} if ($char_money >= 10000000) {
	$char_wealthstatus = $wealth_array[4];
	updateWealthStatus($db, $char_name, $char_wealthstatus);
} if ($char_money >= 100000000) {
	$char_wealthstatus = $wealth_array[5];
	updateWealthStatus($db, $char_name, $char_wealthstatus);
} if ($char_money >= 1000000000) {
	$char_wealthstatus = $wealth_array[6];
	updateWealthStatus($db, $char_name, $char_wealthstatus);
} if ($char_money > 10000000000) {
	$char_wealthstatus = $wealth_array[7];
	updateWealthStatus($db, $char_name, $char_wealthstatus);
}
}



// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $alpha_key = mysqli_real_escape_string($db, $_POST['alphakey']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "<div class='alert alert-danger'>Username is required</div>"); }
  if (empty($email)) { array_push($errors, "<div class='alert alert-danger'>Email is required</div>"); }
  if (empty($password)) { array_push($errors, "<div class='alert alert-danger'>Password is required</div>"); }
  if (empty($alpha_key)) { array_push($errors, "<div class='alert alert-danger'>Alpha Key is required</div>"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM accounts WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "<div class='alert alert-danger'>Username already exists</div>");
    } if ($user['email'] === $email) {
      array_push($errors, "<div class='alert alert-danger'>Email address already exists</div>");
    }
  }
  
  //Alpha Key Checker
  $query = "SELECT * FROM alpha_keys WHERE alpha_key='$alpha_key'";
  $result = mysqli_query($db, $query);
  $isTaken = mysqli_fetch_assoc($result);
  
  if($isTaken) {
  	if($isTaken['taken'] == 1) {
		array_push($errors, "<div class='alert alert-danger'>This alpha key is already taken!</div>");
	}
  } else {
		array_push($errors, "<div class='alert alert-danger'>This alpha key is invalid!</div>");
	}

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password_hashed = md5($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO accounts (username, email, password) 
  			  VALUES('$username', '$email', '$password_hashed')";
  	mysqli_query($db, $query);
	$alphakey_query = "UPDATE alpha_keys SET taken='1' WHERE alpha_key='$alpha_key'";
	mysqli_query($db, $alphakey_query);
  	$_SESSION['username'] = $username;
  	array_push($successes, "<div class='alert alert-success'>You have successfully registered, please login!</div>");
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "<div class='alert alert-danger'>Username is required</div>");
  }
  if (empty($password)) {
  	array_push($errors, "<div class='alert alert-danger'>Password is required</div>");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM accounts WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "<div class='alert alert-success'>You are now logged in</div>";
  	  header('location: characters.php');
  	}else {
  		array_push($errors, "<div class='alert alert-danger'>Wrong username/password combination</div>");
  	}
  }
}

// CHARACTER CREATE
if (isset($_POST['create_char'])) {
	$username_1 = $_SESSION['username'];
	$char_name = mysqli_real_escape_string($db, $_POST['char_name']);
	$char_money = 1500;
	$char_exp = 0;
	$char_gexp = 0;
	$job = "Civilian";
	$rank = " ";
	$totalCrimes = 0;
	$profilepic = "img/default-profile.jpg";
	
	$query = "SELECT acc_id FROM accounts WHERE username='$username_1'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$account_ID = $row['acc_id'];
	
	$charname_check_query = "SELECT * FROM characters WHERE char_name='$char_name' LIMIT 1";
	$result = mysqli_query($db, $charname_check_query);
	$charname = mysqli_fetch_assoc($result);
	
	// Making sure the character name isn't taken
	if($charname) {
		if($charname['char_name'] === $char_name) {
			array_push($errors, "<div class='alert alert-danger'>Character name is taken!</div>");
		}
	}
	
	if(empty($char_name)) {
		array_push($errors, "<div class='alert alert-danger'>A character name must be supplied.</div>");
	} if(empty($_POST['answer1']) or empty($_POST['answer2'])) {
		array_push($errors, "<div class='alert alert-danger'>You must fill out an answer for all the questions!</div>");
	}
	
	if (count($errors) == 0) {
		switch($_POST['answer1']) {
			case "ans1":
				$gunstat = 3;
				break;
			case "ans2":
				$defstat = 3;
				break;
			case "ans3":
				$stealthstat = 3;
				break;
			case "ans4":
				$visionstat = 3;
				break;
		} switch($_POST['answer2']) {
			case "ans1":
				$gunstat = $gunstat + 4;
				break;
			case "ans2":
				$defstat = $defstat + 4;
				break;
			case "ans3":
				$stealthstat = $stealthstat + 4;
				break;
			case "ans4":
				$visionstat = $visionstat + 4;
				break;
		}
		$hasChar = 1;
		$startinglocation = $_POST['startinglocation'];
		
		$query = "UPDATE accounts SET has_char='1' WHERE username='$username_1'";
		mysqli_query($db, $query);
		
		$query = "INSERT INTO characters (char_id, acc_id, acc_username, char_name, starting_city, current_city, gunstat, defstat, sightstat, stealthstat, luckstat, char_status, money, wealth_status, exp, g_exp, health, job, totalCrimes, profilepic, jailtime, jailtime_started, traveltime, quote, lastactive_timestamp, crewfront_id, authed) VALUES ('', '$account_ID', '$username_1', '$char_name', '$startinglocation', '$startinglocation', '$gunstat', '$defstat', '$visionstat', '$stealthstat', '$luckstat', '0', '$char_money', 'Very Poor', '$char_exp', '$char_gexp', '100', '$job', '0', '$profilepic', '0', '0', '0', '', UNIX_TIMESTAMP(), '0', '0')";
		mysqli_query($db, $query);
		
		$query = "INSERT INTO bank (char_id, char_name, money_stored) VALUES ('$char_id', '$char_name', '0')";
		mysqli_query($db, $query);

		header("location: characters.php");
		
	}
}

// Functions
function findNextHospitalUse($db, $char_name) {
	$query = "SELECT hospital_timestamp FROM characters WHERE char_name='$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	return $row['hospital_timestamp'];
}
function subtractHealth($db, $vname, $subtract_amount) {
	$vHealth = findHealth($db, $vname);
	$newHealth = $vHealth - $subtract_amount;
	
	if($newHealth <= 0) {
		$query = "UPDATE characters SET health='$newHealth' where char_name='$vname'";
		$result = mysqli_query($db, $query);
		killSomeone($db, $vname);
	} else {
		$query = "UPDATE characters SET health='$newHealth' where char_name='$vname'";
		$result = mysqli_query($db, $query);
	}
}
function findHealth($db, $char_name) {
	$query = "SELECT health FROM characters WHERE char_name = '$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$healthPulled = $row['health'];
	return $healthPulled;
}
function calculatePower($db, $char_id) {
	$query = "SELECT * FROM characters WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
			
	$pulledGunStat = $row['gunstat'];
	$pulledDefStat = $row['defstat'];
	$pulledSightStat = $row['sightstat'];
	$pulledStealthStat = $row['stealthstat'];
	$pulledLuckStat = $row['luckstat'];
	$pulledGEXP = $row['g_exp'];
	
	$power = ($pulledGEXP + $pulledGunStat + $pulledDefStat + $pulledSightStat + $pulledStealthStat + $pulledLuckStat) / 10;
	
	$query = "UPDATE characters SET power='$power' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	return 1;
}
function addCrimeTime($db, $char_id, $time) {
	$timeAdded = time()+$time;
	
	$query = "UPDATE characters SET nextcrime_timestamp='$timeAdded' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
}
function increaseStatsForRanking($db, $char_id, $rank, $luckstat) {
	$gunRoll = 0;
	$defRoll = 0;
	$visionRoll = 0;
	$luckRoll = 0;
	$stealthRoll = 0;
	
	$statMultiplier = 1;
	
	$query = "SELECT * FROM characters WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
			
	$pulledGunStat = $row['gunstat'];
	$pulledDefStat = $row['defstat'];
	$pulledSightStat = $row['sightstat'];
	$pulledStealthStat = $row['stealthstat'];
	$pulledLuckStat = $row['luckstat'];
	
	switch($rank) {
		case "Thug":
			if($luckstat > 5) {
				$gunRoll = (($luckstat/5)*$statMultiplier)*random_float(1, 2);
				$defRoll = (($luckstat/5)*$statMultiplier)*random_float(1, 2);
				$visionRoll = (($luckstat/5)*$statMultiplier)*random_float(1, 2);
				$stealthRoll = (($luckstat/5)*$statMultiplier)*random_float(1, 2);
				$luckRoll = (($luckstat/5)*$statMultiplier)*random_float(0.5, 1);
			} else {
				$gunRoll = $statMultiplier*random_float(1, 2);
				$defRoll = $statMultiplier*random_float(1, 2);
				$visionRoll = $statMultiplier*random_float(1, 2);
				$stealthRoll = $statMultiplier*random_float(1, 2);
				$luckRoll = $statMultiplier*random_float(0.5, 1);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Gangster":
			if($luckstat > 5) {
				$gunRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2.5);
				$defRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2.5);
				$visionRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2.5);
				$stealthRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2.5);
				$luckRoll = (($luckstat/5)*$statMultiplier)*random_float(0.75, 1.25);
			} else {
				$gunRoll = $statMultiplier*random_float(1.5, 2.5);
				$defRoll = $statMultiplier*random_float(1.5, 2.5);
				$visionRoll = $statMultiplier*random_float(1.5, 2.5);
				$stealthRoll = $statMultiplier*random_float(1.5, 2.5);
				$luckRoll = $statMultiplier*random_float(0.75, 1.25);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Earner":
			if($luckstat > 5) {
				$gunRoll = (($luckstat/5)*$statMultiplier)*random_float(2, 3);
				$defRoll = (($luckstat/5)*$statMultiplier)*random_float(2, 3);
				$visionRoll = (($luckstat/5)*$statMultiplier)*random_float(2, 3);
				$stealthRoll = (($luckstat/5)*$statMultiplier)*random_float(2, 3);
				$luckRoll = (($luckstat/5)*$statMultiplier)*random_float(1.25, 1.75);
			} else {
				$gunRoll = $statMultiplier*random_float(2, 3);
				$defRoll = $statMultiplier*random_float(2, 3);
				$visionRoll = $statMultiplier*random_float(2, 3);
				$stealthRoll = $statMultiplier*random_float(2, 3);
				$luckRoll = $statMultiplier*random_float(1.25, 1.75);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Wise Guy":
			if($luckstat > 5) {
				$gunRoll = (($luckstat/5)*$statMultiplier)*random_float(2.5, 3.5);
				$defRoll = (($luckstat/5)*$statMultiplier)*random_float(2.5, 3.5);
				$visionRoll = (($luckstat/5)*$statMultiplier)*random_float(2.5, 3.5);
				$stealthRoll = (($luckstat/5)*$statMultiplier)*random_float(2.5, 3.5);
				$luckRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2);
			} else {
				$gunRoll = $statMultiplier*random_float(2.5, 3.5);
				$defRoll = $statMultiplier*random_float(2.5, 3.5);
				$visionRoll = $statMultiplier*random_float(2.5, 3.5);
				$stealthRoll = $statMultiplier*random_float(2.5, 3.5);
				$luckRoll = $statMultiplier*random_float(1.5, 2);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Made Man":
			if($luckstat > 10) {
				$gunRoll = (($luckstat/5)*$statMultiplier)*random_float(3, 4);
				$defRoll = (($luckstat/5)*$statMultiplier)*random_float(3, 4);
				$visionRoll = (($luckstat/5)*$statMultiplier)*random_float(3, 4);
				$stealthRoll = (($luckstat/5)*$statMultiplier)*random_float(3, 4);
				$luckRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2);
			} else {
				$gunRoll = $statMultiplier*random_float(3, 4);
				$defRoll = $statMultiplier*random_float(3, 4);
				$visionRoll = $statMultiplier*random_float(3, 4);
				$stealthRoll = $statMultiplier*random_float(3, 4);
				$luckRoll = $statMultiplier*random_float(1.5, 2);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Caporegime":
			if($luckstat > 10) {
				$gunRoll = (($luckstat/5)*$statMultiplier)*random_float(4, 5.5);
				$defRoll = (($luckstat/5)*$statMultiplier)*random_float(4, 5.5);
				$visionRoll = (($luckstat/5)*$statMultiplier)*random_float(4, 5.5);
				$stealthRoll = (($luckstat/5)*$statMultiplier)*random_float(4, 5.5);
				$luckRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2);
			} else {
				$gunRoll = $statMultiplier*random_float(4, 5.5);
				$defRoll = $statMultiplier*random_float(4, 5.5);
				$visionRoll = $statMultiplier*random_float(4, 5.5);
				$stealthRoll = $statMultiplier*random_float(4, 5.5);
				$luckRoll = $statMultiplier*random_float(1.5, 2);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Boss":
			if($luckstat > 10) {
				$gunRoll = (($luckstat/5)*$statMultiplier)*random_float(5, 7);
				$defRoll = (($luckstat/5)*$statMultiplier)*random_float(5, 7);
				$visionRoll = (($luckstat/5)*$statMultiplier)*random_float(5, 7);
				$stealthRoll = (($luckstat/5)*$statMultiplier)*random_float(5, 7);
				$luckRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2);
			} else {
				$gunRoll = $statMultiplier*random_float(5, 7);
				$defRoll = $statMultiplier*random_float(5, 7);
				$visionRoll = $statMultiplier*random_float(5, 7);
				$stealthRoll = $statMultiplier*random_float(5, 7);
				$luckRoll = $statMultiplier*random_float(1.5, 2);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Don":
			if($luckstat > 10) {
				$gunRoll = (($luckstat/5)*$statMultiplier)*random_float(7, 12);
				$defRoll = (($luckstat/5)*$statMultiplier)*random_float(7, 12);
				$visionRoll = (($luckstat/5)*$statMultiplier)*random_float(7, 12);
				$stealthRoll = (($luckstat/5)*$statMultiplier)*random_float(7, 12);
				$luckRoll = (($luckstat/5)*$statMultiplier)*random_float(1.5, 2);
			} else {
				$gunRoll = $statMultiplier*random_float(7, 12);
				$defRoll = $statMultiplier*random_float(7, 12);
				$visionRoll = $statMultiplier*random_float(7, 12);
				$stealthRoll = $statMultiplier*random_float(7, 12);
				$luckRoll = $statMultiplier*random_float(1.5, 2);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Godfather":
			if($luckstat > 20) {
				$statMultiplier = 2;
				$pulledGunStat *= $statMultiplier;
				$pulledDefStat *= $statMultiplier;
				$pulledSightStat *= $statMultiplier;
				$pulledStealthStat *= $statMultiplier;
				$pulledLuckStat += $statMultiplier*random_float(2, 3);
			} else {
				$statMultiplier = 1.5;
				$pulledGunStat *= $statMultiplier;
				$pulledDefStat *= $statMultiplier;
				$pulledSightStat *= $statMultiplier;
				$pulledStealthStat *= $statMultiplier;
				$pulledLuckStat += $statMultiplier*random_float(2, 3);
				
			}
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
	}
}
function increaseStatsForCrimes($db, $char_id, $crimeCategory, $luckCategory) {
	$gunRoll = 0;
	$defRoll = 0;
	$visionRoll = 0;
	$luckRoll = 0;
	$stealthRoll = 0;
	
	$query = "SELECT * FROM characters WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
			
	$pulledGunStat = $row['gunstat'];
	$pulledDefStat = $row['defstat'];
	$pulledSightStat = $row['sightstat'];
	$pulledStealthStat = $row['stealthstat'];
	$pulledLuckStat = $row['luckstat'];
	
	switch($crimeCategory) {
		case "Petty":
			if($luckCategory == 1) {
				$gunRoll = random_float(0.05, 0.1);
				$defRoll = random_float(0.05, 0.1);
				$visionRoll = random_float(0.05, 0.1);
				$luckRoll = random_float(0.025, 0.05);
				$stealthRoll = random_float(0.05, 0.1);
			} elseif($luckCategory == 2) {
				$gunRoll = random_float(0.07, 0.12);
				$defRoll = random_float(0.07, 0.12);
				$visionRoll = random_float(0.07, 0.12);
				$luckRoll = random_float(0.030, 0.055);
				$stealthRoll = random_float(0.07, 0.12);
			} elseif($luckCategory == 3) {
				$gunRoll = random_float(0.09, 0.14);
				$defRoll = random_float(0.09, 0.14);
				$visionRoll = random_float(0.09, 0.14);
				$luckRoll = random_float(0.035, 0.060);
				$stealthRoll = random_float(0.09, 0.14);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Felony":
			if($luckCategory == 1) {
				$gunRoll = random_float(0.25, 0.5);
				$defRoll = random_float(0.25, 0.5);
				$visionRoll = random_float(0.25, 0.5);
				$luckRoll = random_float(0.125, 0.20);
				$stealthRoll = random_float(0.25, 0.5);
			} elseif($luckCategory == 2) {
				$gunRoll = random_float(0.35, 0.6);
				$defRoll = random_float(0.35, 0.6);
				$visionRoll = random_float(0.35, 0.6);
				$luckRoll = random_float(0.155, 0.30);
				$stealthRoll = random_float(0.35, 0.6);
			} elseif($luckCategory == 3) {
				$gunRoll = random_float(0.5, 0.75);
				$defRoll = random_float(0.5, 0.75);
				$visionRoll = random_float(0.5, 0.75);
				$luckRoll = random_float(0.2, 0.35);
				$stealthRoll = random_float(0.5, 0.75);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
		case "Racket":
			if($luckCategory == 1) {
				$gunRoll = random_float(0.5, 1);
				$defRoll = random_float(0.5, 1);
				$visionRoll = random_float(0.5, 1);
				$luckRoll = random_float(0.25, 0.5);
				$stealthRoll = random_float(0.5, 1);
			} elseif($luckCategory == 2) {
				$gunRoll = random_float(0.8, 1.4);
				$defRoll = random_float(0.8, 1.4);
				$visionRoll = random_float(0.8, 1.4);
				$luckRoll = random_float(0.35, 0.65);
				$stealthRoll = random_float(0.8, 1.4);
			} elseif($luckCategory == 3) {
				$gunRoll = random_float(1.3, 2);
				$defRoll = random_float(1.3, 2);
				$visionRoll = random_float(1.3, 2);
				$luckRoll = random_float(0.45, 0.75);
				$stealthRoll = random_float(1.3, 2);
			}
			
			$pulledGunStat += $gunRoll;
			$pulledDefStat += $defRoll;
			$pulledSightStat += $visionRoll;
			$pulledStealthStat += $stealthRoll;
			$pulledLuckStat += $luckRoll;
			
			$query = "UPDATE characters SET gunstat='$pulledGunStat', defstat='$pulledDefStat', sightstat='$pulledSightStat', stealthstat='$pulledStealthStat', luckstat='$pulledLuckStat' WHERE char_id='$char_id'";
			mysqli_query($db, $query);
			break;
	}
}
function random_float($min, $max, $decimals = 2) {
  $scale = pow(10, $decimals);
  return mt_rand($min * $scale, $max * $scale) / $scale;
}
function successfulCrime($db, $char_id, $char_money, $crime_money, $totalCrimes, $char_gexp, $crime_gexp) {
	$add_money = $char_money + $crime_money;
	$addtotalCrimes = $totalCrimes + 1;
	$add_gexp = $char_gexp + $crime_gexp;
	$query = "UPDATE characters SET money='$add_money', totalCrimes='$addtotalCrimes', g_exp='$add_gexp' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	return 1;
}
function godfatherCheck($db, $home_city) {
	$query = "SELECT char_name FROM characters WHERE rank='Godfather' AND starting_city='$home_city' AND char_status='0'";
	$result = mysqli_query($db, $query);
	if(mysqli_num_rows($result) > 0) {
		return true;
	} else {
		return false;
	}
}
function calculateLuckCategory($db, $luckstat) {
	if($luckstat <= 3) {
		return 1;
	} elseif($luckstat > 3 and $luckstat <= 6) {
		return 2;
	} else {
		return 3;
	}
}
function destroyCrewFront($db, $crew_id) {
	$query = "DELETE FROM crew_fronts WHERE id='$crew_id'";
	mysqli_query($db, $query);
	return 1;
}
function haveTwoBosses($db, $char_name) {
	if(doYouHaveCF($db, $char_name) == true) {
		$bossCount = 0;
		$crew_id = pullCrewID($db, $char_name);
		$allMembers = eachMemberInCF($db, $crew_id);
		foreach($allMembers as $value) {
			if(pullRank($db, $value) == "Boss") {
				$bossCount += 1;
			}
		}
		return $bossCount;
	}
}
function isAuthed($db, $char_name) {
	$query = "SELECT authed FROM characters WHERE char_name='$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$isAuthed = $row['authed'];
	
	if($isAuthed == 1) {
		return true;
	} else {
		return false;
	}
}
function deleteAllCrewInvites($db, $char_id) {
	$query = "DELETE FROM events WHERE is_invite='1' AND char_id='$char_id'";
	mysqli_query($db, $query);
	return 1;
}
function markEventInvite($db, $event_id) {
	$query = "UPDATE events SET is_invite='1' WHERE event_db_id='$event_id'";
	mysqli_query($db, $query);
	return 1;
}
function leaveCrew($db, $char_name) {
	$query = "UPDATE characters SET crewfront_id='0' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
	return 1;
}
function authSomeone($db, $char_name) {
	$query = "UPDATE characters SET authed='1' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
	return 1;
}
function promoSomeone($db, $char_name, $rank) {
	switch($rank) {
		case "Wise Guy":
			$promoRank = "Made Man";
			$query = "UPDATE characters SET rank='Made Man' WHERE char_name='$char_name'";
			tickPromo($db, $char_name, $promoRank);
			mysqli_query($db, $query);
			break;
		case "Made Man":
			$promoRank = "Caporegime";
			$query = "UPDATE characters SET rank='Caporegime' WHERE char_name='$char_name'";
			tickPromo($db, $char_name, $promoRank);
			mysqli_query($db, $query);
			break;
		case "Caporegime":
			$promoRank = "Boss";
			$query = "UPDATE characters SET rank='Boss' WHERE char_name='$char_name'";
			tickPromo($db, $char_name, $promoRank);
			mysqli_query($db, $query);
			break;
		case "Boss":
			$promoRank = "Don";
			$query = "UPDATE characters SET rank='Don' WHERE char_name='$char_name'";
			tickPromo($db, $char_name, $promoRank);
			mysqli_query($db, $query);
			break;
		default:
			return "Error!";
	}
}
function pullGEXP($db, $char_name) {
	$query = "SELECT g_exp FROM characters WHERE char_name='$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$pulledGEXP = $row['g_exp'];
	return $pulledGEXP;
}
function pullRank($db, $char_name) {
	$query = "SELECT rank FROM characters WHERE char_name='$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$pulledRank = $row['rank'];
	return $pulledRank;
}
function pullCrewID($db, $char_name) {
	$query = "SELECT crewfront_id FROM characters WHERE char_name='$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$pulledID = $row['crewfront_id'];
	if($pulledID == 0) {
		return false;
	} else {
		return $pulledID;
	}
}
function eligibleForPromo($db, $char_name, $rank, $gexp) {
	switch($rank) {
		case "Wise Guy":
			if($gexp >= 3500) {
				return true;
			} else {
				return false;
			}
			break;
		case "Made Man":
			if($gexp >= 5500) {
				return true;
			} else {
				return false;
			}
			break;
		case "Caporegime":
			if($gexp >= 8000) {
				return true;
			} else {
				return false;
			}
			break;
		case "Boss":
			if($gexp >= 13000) {
				return true;
			} else {
				return false;
			}
			break;
	}
}
function isInCrew($db, $char_name) {
	$query = "SELECT crewfront_id FROM characters WHERE char_name='$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$target_crewID = $row['crewfront_id'];
	
	if($target_crewID != 0) {
		return true;
	} else {
		return false;
	}
}
function changeCrew($db, $char_name, $crew_id) {
	$query = "UPDATE characters SET crewfront_id='$crew_id' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
	return 1;
}
function createCrewInvite($db, $target_name, $char_name, $crew_id) {
	$query = "INSERT INTO crew_invites (id, name, sent_by, crew_id) VALUES ('', '$target_name', '$char_name', '$crew_id')";
	mysqli_query($db, $query);
	
	$query = "SELECT char_id FROM characters WHERE char_name='$target_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$target_id = $row['char_id'];
	
	$query = "SELECT id FROM crew_invites WHERE name='$target_name' AND sent_by='$char_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$invite_id = $row['id'];
	
	event_add($target_id, "You have received a crew invite from " . $char_name . ". Click <a style='color: blue' href='events.php?acceptinvite=$invite_id'>here</a> to accept!");
}
function deleteCrewInvite($db, $invite_ID) {
	$query = "DELETE FROM crew_invites WHERE id='$invite_ID'";
	mysqli_query($db, $query);
}
function findCFType($db, $owner) {
	$query = "SELECT type FROM crew_fronts WHERE owner='$owner'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$crew_type = $row['type'];
	
	return $crew_type;
}
function isCriminal($db, $target_name) {
	$query = "SELECT job FROM characters WHERE char_name='$target_name'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$target_job = $row['job'];
	
	if($target_job == "Criminal") {
		return true;
	} else {
		return false;
	}
}
function tickPromo($db, $char_name, $promo) {
	switch($promo) {
		case "Thug":
			$query = "UPDATE characters SET thugpromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "Gangster":
			$query = "UPDATE characters SET gangsterpromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "Earner":
			$query = "UPDATE characters SET earnerpromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "Wise Guy":
			$query = "UPDATE characters SET wgpromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "Made Man":
			$query = "UPDATE characters SET mmpromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "Caporegime":
			$query = "UPDATE characters SET capopromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "Boss":
			$query = "UPDATE characters SET bosspromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "Don":
			$query = "UPDATE characters SET donpromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "Godfather":
			$query = "UPDATE characters SET godfatherpromo='1' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		default:
			return "ERROR!";
			break;
	}
}
function numberOfCrews($db, $char_id) {
	$query = "SELECT starting_city FROM characters WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$char_startingcity = $row['starting_city'];
	
	$crewfronts_incity = 0;
	
	$query = "SELECT crew_name FROM crew_fronts WHERE city='$char_startingcity'";
	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_array($result)) {
		$crewfronts_incity += 1;
		
		return $crewfronts_incity;
	}
}
function isThereCrews($db, $char_id) {
	$query = "SELECT starting_city FROM characters WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$char_startingcity = $row['starting_city'];
	
	$crewfronts_incity = array();
	
	$query = "SELECT * FROM crew_fronts WHERE city='$char_startingcity'";
	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_array($result)) {
		$crewfronts_incity[] = $row['city'];
		if(empty($crewfronts_incity)) {
			return false;
		} else {
			return true;
		}
	}
}
function doYouHaveCF($db, $char_name) {
	$query = "SELECT * FROM crew_fronts WHERE owner='$char_name'";
	$result = mysqli_query($db, $query);
	if(mysqli_num_rows($result) == 0) {
		return false;
	} else {
		return true;
	}
}
function doYouHaveTypeCF($db, $char_name, $type) {
	$query = "SELECT * FROM crew_fronts WHERE owner='$char_name' AND type='$type'";
	$result = mysqli_query($db, $query);
	if(mysqli_num_rows($result) == 0) {
		return false;
	} else {
		return true;
	}
}
function findCrewName($db, $crew_id) {
	$query = "SELECT crew_name FROM crew_fronts WHERE id='$crew_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$crewname = $row['crew_name'];
	
	return $crewname;
}
function findCrewOwner($db, $crewfront_id) {
	$query = "SELECT owner FROM crew_fronts WHERE id='$crewfront_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$crewOwner = $row['owner'];
	
	return $crewOwner;
}
function buyCF($db, $char_name, $char_id, $char_currentcity, $type) {
	switch($type) {
		case "pizzaplace":
			removeMoney($db, $char_id, 500000);
			
			$query = "INSERT INTO crew_fronts (id, owner, type, city) VALUES ('', '$char_name', '$type', '$char_currentcity')";
			mysqli_query($db, $query);
			
			$query = "SELECT id FROM crew_fronts WHERE owner='$char_name'";
			$result = mysqli_query($db, $query);
			$row = $result->fetch_assoc();
			$crewfront_id = $row['id'];
			
			$query = "UPDATE characters SET crewfront_id='$crewfront_id', starting_city='$char_currentcity' WHERE char_name='$char_name'";
			mysqli_query($db, $query);
			break;
		case "hotel":
			removeMoney($db, $char_id, 1000000);
			
			$query = "UPDATE crew_fronts SET type='$type' WHERE owner='$char_name'";
			mysqli_query($db, $query);
			break;
		case "casino":
			removeMoney($db, $char_id, 2000000);
			
			$query = "UPDATE crew_fronts SET type='$type' WHERE owner='$char_name'";
			mysqli_query($db, $query);
			break;
		default:
			return "An error has occurred!";
			break;
	}
}
function membersInACF($db, $crewfront_id) {
	$crewMembers = 0;
	
	$query = "SELECT crewfront_id FROM characters WHERE crewfront_id='$crewfront_id'";
	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_array($result)) {
		$crewMembers += 1;
	}
	return $crewMembers;
}
function eachMemberInCF($db, $crewfront_id) {
	$crewMembers = array();
	
	$query = "SELECT char_name FROM characters WHERE crewfront_id='$crewfront_id'";
	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_array($result)) {
		$crewMembers[] = $row['char_name'];
	}
	return $crewMembers;
}
function findItemName($db, $item_id) {
	$query = "SELECT item_name FROM items WHERE id='$item_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$item_name = $row['item_name'];
	return $item_name;
}
function addForumReply($db, $postID, $postType, $sender, $message) {
	$query = "INSERT INTO forum_replies (id, forum_id, forum_type, sender, reply, time) VALUES ('', '$postID', '$postType', '$sender', '$message', UNIX_TIMESTAMP())";
	mysqli_query($db, $query);
}
function findItemInInventory($db, $char_id, $item_id) {
	$query = "SELECT * FROM inventory WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$findItemArray = array();
	
	while($row = $result->fetch_assoc()) {
		$findItemArray[] = $row['item_id'];
	}
	
	foreach($findItemArray as $value) {
		if($value == $item_id) {
			return true;
		}
	}
}
function gangsterPromote($db, $char_name, $rank, $job) {
	$query = "UPDATE characters SET rank='$rank', job='$job' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
	return 1;
}
function generateAlphaKey($db) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $alpha_key = '';
    for ($i = 0; $i < 20; $i++) {
        $alpha_key .= $characters[rand(0, $charactersLength - 1)];
    }
	$query = "INSERT INTO alpha_keys (alpha_key, taken) VALUES ('$alpha_key', '0')";
	mysqli_query($db, $query);
	return 1;
}
function updateWealthStatus($db, $char_name, $char_wealthstatus) {
	$query = "UPDATE characters SET wealth_status='$char_wealthstatus' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
	return 1;
}
function updateQuote($db, $char_id, $quote) {
	$query = "UPDATE characters SET quote='$quote' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	return 1;
}
function sendTradeRequest($db, $char_name, $target_name, $item_id, $item_quantity) {
	$query = "INSERT INTO trade (trade_id, sender, receiver, item_id, item_quantity) VALUES ('', '$char_name', '$target_name', '$item_id', '$item_quantity')";
	mysqli_query($db, $query);
	
	$char_id = findVictimID($db, $char_name);
	$itemQuantity = findItemQuantityInInventory($db, $char_id, $item_id);
	$itemQuantity -= $item_quantity;
	
	if($itemQuantity == 0) {
		$query = "DELETE FROM inventory WHERE char_id='$char_id' AND item_id='$item_id'";
		mysqli_query($db, $query);
		return 1;
	} else {
		$query = "UPDATE inventory SET item_quantity='$itemQuantity' WHERE char_id='$char_id' AND item_id='$item_id'";
		mysqli_query($db, $query);
		return 1;
	}
	
}
function deleteTradeRequest($db, $char_name, $trade_id) {
	$query = "DELETE FROM trade WHERE receiver='$char_name' AND trade_id='$trade_id'";
	mysqli_query($db, $query);
	return 1;
}
function findItemQuantityInInventory($db, $char_id, $item_id) {
	$query = "SELECT item_quantity FROM inventory WHERE char_id='$char_id' AND item_id='$item_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$foundItemQuantity = $row['item_quantity'];
	return $foundItemQuantity;
}
function findItemID($db, $item_name) {
	$query = "SELECT id FROM items WHERE item_name='$item_name'";
	$result = mysqli_query($db, $query); 
	$row = $result->fetch_assoc();
	$item_id = $row['id'];
	return $item_id;
}
function giveItem($db, $char_id, $item_id, $item_quantity) {
	$storageArray = array();
	$stackQuantities = 0;
	
	$query = "SELECT * FROM inventory WHERE char_id='$char_id' AND item_id='$item_id'";
	$result = mysqli_query($db, $query);
	$itemExist = mysqli_fetch_assoc($result);
	
	if($itemExist) {
		if($itemExist['item_id'] == $item_id) {
			$query = "SELECT item_quantity FROM inventory WHERE char_id='$char_id' AND item_id='$item_id'";
			$result = mysqli_query($db, $query);
			$row = $result->fetch_assoc();
			$newItemQuantity = $row['item_quantity'];
				
			$newItemQuantity += $item_quantity;
				
			$query = "UPDATE inventory SET item_quantity='$newItemQuantity' WHERE char_id='$char_id' AND item_id='$item_id'";
			mysqli_query($db, $query);
			return 1;
			}
		} else {
			$query = "INSERT INTO inventory (inv_id, char_id, item_id, item_quantity) VALUES ('', '$char_id', '$item_id', '$item_quantity')";
			mysqli_query($db, $query);
			return 1;
	}
}
function findEventOwnerID($db, $event_id) {
	$query = "SELECT char_id FROM events WHERE event_db_id='$event_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$eventOwnerID = $row['char_id'];
	return $eventOwnerID;
}
function findMailOwnerName($db, $mail_id) {
	$query = "SELECT receiver FROM mail WHERE mail_id='$mail_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$mailOwnerName = $row['receiver'];
	return $mailOwnerName;
}
function dropItem($db, $char_id, $item_id, $item_dropquantity) {
	$query = "SELECT item_quantity FROM inventory WHERE char_id='$char_id' AND item_id='$item_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$pulledQuantity = $row['item_quantity'];
	
	$pulledQuantity -= $item_dropquantity;
	if($pulledQuantity == 0) {
		$query = "DELETE FROM inventory WHERE char_id='$char_id' AND item_id='$item_id'";
		mysqli_query($db, $query);
		return 1;
	} else {
		$query = "UPDATE inventory SET item_quantity='$pulledQuantity' WHERE char_id='$char_id' AND item_id='$item_id'";
		mysqli_query($db, $query);
		return 1;
	}
}
function changeProfilePic($db, $char_id, $image_name) { 
	$image_name = "img/" . $image_name;
	$query = "UPDATE characters SET profilepic='$image_name' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
}
function deleteEvent($db, $event_id) {
	$query = "DELETE FROM events WHERE event_db_id='$event_id'";
	mysqli_query($db, $query);
	return 1;
}
function depositMoney($db, $char_id, $char_money, $moneystored, $amount) {
	$moneystored = $moneystored + $amount;
	
	$query = "UPDATE bank SET money_stored='$moneystored' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	
	$char_money = $char_money - $amount;
	
	$query = "UPDATE characters SET money='$char_money' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	
}
function withdrawMoney($db, $char_id, $char_money, $moneystored, $amount) {
	$moneystored = $moneystored - $amount;
	
	$query = "UPDATE bank SET money_stored='$moneystored' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	
	$char_money = $char_money + $amount;
	
	$query = "UPDATE characters SET money='$char_money' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
}
function transferMoney($db, $char_id, $target_char_id, $moneystored, $amount) {
	$moneystored = $moneystored - $amount;
	
	$query = "UPDATE bank SET money_stored='$moneystored' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	
	$query = "SELECT money_stored FROM bank WHERE char_name='$target_char_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$target_moneystored = $row['money_stored'];
	
	$target_moneystored += $amount;
	
	$query = "UPDATE bank SET money_stored='$target_moneystored' WHERE char_name='$target_char_id'";
	mysqli_query($db, $query);
	
}
function removeMoney($db, $char_id, $amount) {
	$query = "SELECT money FROM characters WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$moneyOnHand = $row['money'];
	
	$moneyOnHand -= $amount;
	
	$query = "UPDATE characters SET money='$moneyOnHand' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	return 1;
}
function findMoney($db, $char_id) {
	$query = "SELECT money FROM characters WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	return $row['money'];
}
function addJailTime($db, $char_id, $char_jailtime, $char_jailtimestarted) {
	$query = "UPDATE characters SET jailtime='$char_jailtime' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	
	$query = "UPDATE characters SET jailtime_started='$char_jailtimestarted' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
}
function clearJailTime($db, $char_id) {
	$query = "UPDATE characters SET jailtime='0' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
}
function addTravelTime($db, $char_id, $char_traveltime) {
	$query = "UPDATE characters SET traveltime='$char_traveltime' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
}
function clearTravelTime($db, $char_id) {
	$query = "UPDATE characters SET traveltime='0' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
}
function moveCities($db, $char_id, $destination, $char_traveltime) {
	$query = "UPDATE characters SET current_city='$destination' WHERE char_id='$char_id'";
	mysqli_query($db, $query);
	
	addTravelTime($db, $char_id, $char_traveltime);
}
function crimeMakeTime($char_jailtime) {
	$now = time();
	$difference = $char_jailtime - $now;
	
	$days = floor($difference/86400);
	$difference = $difference - ($days*86400);
	
	$hours = floor($difference/3600);
	$difference = $difference - ($days*3600);
	
	$minutes = floor($difference/60);
	$difference = $difference - ($days*60);
	
	$seconds = difference;
	$output = "$minutes Minutes and $seconds Seconds.";
	
	return $output;
}
function findVictimName($db, $vname) {
	$query = "SELECT char_name FROM characters WHERE char_name='$vname'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$foundName = $row['char_name'];
	
	return $foundName;
}
function findVictimID($db, $vname) {
	$query = "SELECT char_id FROM characters WHERE char_name='$vname'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$foundID = $row['char_id'];
	
	return $foundID;
}
function findVictimCity($db, $vname) {
	$query = "SELECT current_city FROM characters WHERE char_name='$vname'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$vCurrentcity = $row['current_city'];
	return $vCurrentcity;
}
function killSomeone($db, $killname) {
	$query = "UPDATE characters SET char_status='1' WHERE char_name='$killname'";
	$result = mysqli_query($db, $query);
	
	$query = "SELECT * FROM characters WHERE char_name='$killname'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$vid = $row['char_id'];
	$vRank = $row['rank'];
	$vJob = $row['job'];
	
	$query = "DELETE FROM events WHERE char_id='$vid'";
	mysqli_query($db, $query);
	
	$query = "DELETE FROM inventory WHERE char_id='$vid'";
	mysqli_query($db, $query);
	
	$query = "DELETE FROM bank WHERE char_id='$vid'";
	mysqli_query($db, $query);
	
	$query = "DELETE FROM trade WHERE sender='$killname'";
	mysqli_query($db, $query);
	
	$query = "INSERT INTO obituaries (obit_id, char_id, char_name, job, rank, death_timestamp) VALUES ('', '$vid', '$killname', '$vJob', '$vRank', UNIX_TIMESTAMP())";
	mysqli_query($db, $query);
	
	return 0;
}
function retireSomeone($db, $retirename, $final_words) {
	$query = "UPDATE characters SET char_status='2' WHERE char_name='$retirename'";
	$result = mysqli_query($db, $query);
	
	$query = "SELECT * FROM characters WHERE char_name='$retirename'";
	$result = mysqli_query($db, $query);
	$row = $result->fetch_assoc();
	$vid = $row['char_id'];
	$vRank = $row['rank'];
	$vJob = $row['job'];
	
	$query = "DELETE FROM events WHERE char_id='$vid'";
	mysqli_query($db, $query);
	
	$query = "DELETE FROM inventory WHERE char_id='$vid'";
	mysqli_query($db, $query);
	
	$query = "DELETE FROM bank WHERE char_id='$vid'";
	mysqli_query($db, $query);
	
	$query = "DELETE FROM trade WHERE sender='$retirename'";
	mysqli_query($db, $query);
	
	$query = "INSERT INTO retired (retired_id, char_id, char_name, retired_timestamp, final_words) VALUES ('', '$vid', '$retirename', UNIX_TIMESTAMP(), '$final_words')";
	mysqli_query($db, $query);
	
	return 0;
}
function findVictimStats($db, $vname) {
	$query = "SELECT * FROM characters WHERE char_name='$vname'";
	$result = mysqli_query($db, $query);
	return $result;
}
function checkForGun($db, $char_id) {
	$query = "SELECT item_id FROM inventory WHERE char_id='$char_id'";
	$result = mysqli_query($db, $query);
	$gunOrNot = array();
	while($row = $result->fetch_assoc()){
		$gunOrNot[] = $row['item_id'];
	}
	foreach($gunOrNot as $value) {
		if($value == 8000) {
			return true;
		}
	}
}
function event_add($char_id, $event_text) {
	global $db;
	$event_text = mysqli_real_escape_string($db, $event_text);
	$query= "INSERT INTO events VALUES('', $char_id, '$event_text', UNIX_TIMESTAMP(), '0')";
	mysqli_query($db, $query) or die(mysqli_error($db));
	return 1;
}
function send_mail($db, $mail_subject, $mail_message, $mail_receiver, $mail_sender) {
	$query= "INSERT INTO mail VALUES('', UNIX_TIMESTAMP(), '$mail_sender', '$mail_receiver', '$mail_subject', '$mail_message')";
	mysqli_query($db, $query) or die(mysqli_error($db));
	return 1;
}
function delete_mail($mail_id) {
	global $db;
	$query = "DELETE FROM mail WHERE mail_id='$mail_id'";
	mysqli_query($db, $query) or die(mysqli_error($db));
	return 1;
}

?>