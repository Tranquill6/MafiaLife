<?php
include('server.php');

if(isset($_SESSION['username'])) {
	$_SESSION = array();
	session_destroy();
	session_write_close();
	header('Location: index.php');
	exit;
} else {
	echo("You are not logged in!");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Signing Out</title>
</head>

<body>
</body>
</html>