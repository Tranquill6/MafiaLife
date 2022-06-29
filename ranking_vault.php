<?php

// Checks for Gangster promotions
if($char_gexp < 200) {
	$job = "Civilian";
	$rank = "";
	$query = "UPDATE characters SET job='$job', rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 200 and $char_gexp < 500 and $job == "Civilian") {
	$job = "Criminal";
	$rank = "Thug";
	$query = "UPDATE characters SET job='$job', rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 500 and $char_gexp < 1000) {
	$rank = "Gangster";
	$query = "UPDATE characters SET rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 1000 and $char_gexp < 2000) {
	$rank = "Earner";
	$query = "UPDATE characters SET rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 2000 and $char_gexp < 3500) {
	$rank = "Wise Guy";
	$query = "UPDATE characters SET rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 3500 and $char_gexp < 5500) {
	$rank = "Made Man";
	$query = "UPDATE characters SET rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 5500 and $char_gexp < 8000) {
	$rank = "Caporegime";
	$query = "UPDATE characters SET rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 8000 and $char_gexp < 10000) {
	$rank = "Boss";
	$query = "UPDATE characters SET rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 10000 and $char_gexp < 18000) {
	$rank = "Don";
	$query = "UPDATE characters SET rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
if($char_gexp >= 50000) {
	$rank = "Godfather";
	$query = "UPDATE characters SET rank='$rank' WHERE char_name='$char_name'";
	mysqli_query($db, $query);
}
// End of Gangster Promotions


?>