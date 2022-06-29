<?php include('server.php'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>MafiaLife: Login</title>

<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

<!-- Plugin CSS -->
<link rel="stylesheet" href="device-mockups/device-mockups.min.css">

<!-- Custom styles for this template -->
<link href="css/new-age-login.css" rel="stylesheet">
<link href="css/login.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	<div class="container">
		<a class="navbar-brand js-scroll-trigger" style="color: white" href="index.php">Home</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			Menu
			<i class="fas fa-bars"></i>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link js-scroll-trigger" style="color: white; font-family: 'Lato', 'Helvetica', 'Arial', 'sans-serif'; font-size: 11px; letter-spacing: 2px; text-transform: uppercase" href="register.php">Register</a>
				<a class="nav-link js-scroll-trigger" style="color: white; font-family: 'Lato', 'Helvetica', 'Arial', 'sans-serif'; font-size: 11px; letter-spacing: 2px; text-transform: uppercase" href="login.php">Login</a>
			</li>
			</u>
		</div>
	</div>
</nav>

<header class="masthead">
<div class="container" style="margin: auto">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
            <span><img src="img/MLlogo_transp.png" class="w-75" alt="Logo"></span><br/>
            <hr/>
            <span class="logo_title mt-5"> Login </span>
        </div>
        <?php include('errors.php'); ?>
        <div class="card-body">
            <form action="login.php" method="post">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>

                <div class="form-group">
                    <input type="submit" name="login_user" value="Login" class="btn btn-outline-danger float-right login_btn">
                </div>
            </form>
        </div>
    </div>
</div>
</header>
	
	<!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>
	


</body>
</html>