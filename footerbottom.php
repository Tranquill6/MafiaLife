	<!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/resume.css" rel="stylesheet">


<body>
	<style>
	
		.label {
		  display: inline;
		  padding: 0.2em 0.6em 0.3em;
		  font-size: 75%;
		  font-weight: 700;
		  line-height: 1;
		  color: #fff;
		  text-align: center;
		  white-space: nowrap;
		  vertical-align: baseline;
		  border-radius: 0.25em;
		  text-decoration: none;
		}
		a.label:hover,
		a.label:focus {
		  color: #fff;
		  text-decoration: none;
		  cursor: pointer;
		}
		.label:empty {
		  display: none;
		}
		.btn .label {
		  position: relative;
		  top: -1px;
		  text-decoration: none;
		}
		.label-default {
		  background-color: #000000;
		  text-decoration: none;
		}
		.label-default[href]:hover,
		.label-default[href]:focus {
		  background-color: #5e5e5e;
		  text-decoration: none;
		}
		.label-primary {
		  background-color: #337ab7;
		  text-decoration: none;
		}
		.label-primary[href]:hover,
		.label-primary[href]:focus {
		  background-color: #286090;
		  text-decoration: none;
		}
		.label-success {
		  background-color: #5cb85c;
		}
		.label-success[href]:hover,
		.label-success[href]:focus {
		  background-color: #449d44;
		  text-decoration: none;
		}
		.label-info {
		  background-color: #5bc0de;
		}
		.label-info[href]:hover,
		.label-info[href]:focus {
		  background-color: #31b0d5;
		}
		.label-warning {
		  background-color: #f0ad4e;
		}
		.label-warning[href]:hover,
		.label-warning[href]:focus {
		  background-color: #ec971f;
		}
		.label-danger {
		  background-color: #d9534f;
		}
		.label-danger[href]:hover,
		.label-danger[href]:focus {
		  background-color: #c9302c;
		}
		a:hover {
			text-decoration: none;
		}
	
	</style>
	<div class="container p-0" style="background-color: white; border-bottom: solid; border-left: solid; border-right: solid">
		<div class="footer" style="text-align: center; background-color: white; height: 15%; width: 100%">
			<div class="list">
				<table height="94">
					<h4 class="mb-0 text-center"><strong>Members on in the past 15 minutes:</strong></h4>
					<div class="bottomDiv" style="color: white">
					<?php

						$query = "SELECT * FROM characters WHERE DATE_SUB(NOW(), INTERVAL 15 MINUTE) <= lastactive";
						$result = mysqli_query($db, $query);
						$count = mysqli_num_rows($result);
						$i = 1;
						
						
						while($row = mysqli_fetch_object($result)) {
							$online_name = htmlspecialchars($row->char_name);
							$online_id = htmlspecialchars($row->char_id);
							$online_charstatus = htmlspecialchars($row->char_status);
							$online_rank = htmlspecialchars($row->rank);
							$haveCF = doYouHaveCF($db, $online_name);
							
									// Determines if your character is dead
									if($char_status == 0) {
										$char_deadalive = "Alive";
									} elseif ($char_status == 1) {
										$char_deadalive = "Dead";
									} else {
										$char_deadalive = "Undetermined";
										}
							
							
							if($online_charstatus == 0) {
								if($online_rank == "Godfather") {
									echo("<a href=\"profile.php?char_id=". $online_id ."\" onfocus=\"if(this.blur)this.blur()\"><span class='label label-default' style='color: yellow'><strong>".$online_name."</strong></span></a>");
								} elseif ($haveCF == true) {
									echo("<a href=\"profile.php?char_id=". $online_id ."\" onfocus=\"if(this.blur)this.blur()\"><span class='label label-default' style='color: deepskyblue'><strong>".$online_name."</strong></span></a>");
								} else {
									echo("<a href=\"profile.php?char_id=". $online_id ."\" onfocus=\"if(this.blur)this.blur()\"><span class='label label-default'><strong>".$online_name."</strong></span></a>");
								}
							} elseif($online_charstatus == 1) {
								echo("<a href=\"profile.php?char_id=". $online_id ."\" onfocus=\"if(this.blur)this.blur()\"><span class='label label-default' style='color: red'><strong>".$online_name."</strong></span></a>");
							}
							
							if($i != $count) {
								echo(" ");
							}
							$i++;
						}
					
					?>
					</div>
				</table>
			</div>
		</div>
	</div>
</body>
