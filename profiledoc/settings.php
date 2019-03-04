<!doctype html PUBLIC "-//W3C//DTD HTML 4.01//EN"
											"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>webclinic</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>

    <!--     Fonts and icons     -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/check.css">
    <!--<link rel="stylesheet" href="assets\fonts\font-awesome-4.7.0\css\font-awesome.min.css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/admin.css">
    <style>
        .inputpass{
            padding:5px;
            background-color:rgb(250,245,249);
            border:1px solid rgb(210,210,200);
            border-radius:5px;
            width:100%;
            height:35px;
            padding-left;10px;
        }
    </style>

</head>
<body>



	<!-- ========= * PHP * ===========================================================================-->

	<!--    config -->

	<?php
        session_start();
	 ?>

	<!--   check if user already logged in -->

	<?php

	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != "yes"  || !isset($_SESSION['doc']) || $_SESSION['doc'] != "true"){
		header("Location: http://localhost/clinic/v3/logindoc.php");
	}


	?>

	<?php

	if(isset($_POST['saveslot'])){

		$ch = curl_init();

		//var_dump($_POST);

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://localhost/clinic/v3/api/appointment/slots/' . $_SESSION['username'],
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $_POST
		));

		$res = json_decode(curl_exec($ch));

		if($res->success == "true"){

			echo "Done";
		}
		else{
			echo $res->message;
		}

	}


	if(isset($_POST['deleteslot'])){

		$ch = curl_init();

		//var_dump($_POST);

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://localhost/clinic/v3/api/appointment/slots/' . $_SESSION['username'] .'/delete/' . $_POST['slotid'],
			CURLOPT_CUSTOMREQUEST => "DELETE"
		));

		$res = json_decode(curl_exec($ch));

		if($res->success == "true"){

			echo "Delete Done";
		}
		else{
			echo $res->message;
		}

	}


	?>

	<?php

	header("Access-Control-Allow-Origin: *");

      $ch = curl_init();

      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost/clinic/v3/api/appointment/slots/' . $_SESSION['username']
      ));


			$s = curl_exec($ch);
      $slots = json_decode($s, true);

      echo "<script> var s = " . $s . "</script>";

	?>





<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-5.jpg">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    Webclinic
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
				            <li>
                    <a href="user.php">
                        <i class="pe-7s-user"></i>
                        <p>Manage Profile</p>
                    </a>
                </li>
                <li>
                    <a href="booking.php">
                        <i class="pe-7s-note2"></i>
                        <p>Bookings</p>
                    </a>
                </li>
                <li class="active">
                    <a href="settings.php">
                        <i class="pe-7s-settings"></i>
                        <p>Setting</p>
                    </a>
                </li>
                <!--<li>
                    <a href="book.php">
                        <i class="pe-7s-ticket"></i>
                        <p>Doctor's Appointment</p>
                    </a>
                </li>-->
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
					<a class="navbar-brand" href="#"> <i class="pe-7s-graph" style="font-weight:bold"></i> &nbsp;Dashboard
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<p>
									Welcome, <?php echo $_SESSION['name'] ?>
										<b class="caret"></b>
								</p>
						    </a>
					        <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li><a href="../logout.php">Logout</a></li>
							</ul>
						</li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content" style="padding-top:10px">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-sm-16">
                        <!---->
                            <div class="cardbody" style="padding-top:0">
                                <div class="card" style="width:100%">
                                    <div class="content list_general1" style="margin-left:0;padding:0px;width:100%;background-color: rgb(240, 237, 238);border-style:none">
                                        <!-- -->
                                        <div class="login100-form-title" style="padding-top:10px;font-size:20px;font-family:Poppins-Medium">
                                            Change Password
                                        </div>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="inputpass" placeholder="Old Password">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="inputpass" placeholder="New Password">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="inputpass" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn1" style="width:100%">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!---->
                                    </div>
                                </div>
                            </div>
                        <!---->
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-16">
                        <!---->
                            <div class="cardbody" style="padding-top:0">
                                <div class="card" style="width:100%">
                                    <div class="content list_general1" style="margin-left:0;padding:0px;width:100%;background-color: rgb(240, 237, 238);border-style:none">
                                        <!-- -->
                                        <div class="login100-form-title" style="padding-top:10px;font-size:20px;font-family:Poppins-Medium">
                                            Manage Slots
                                        </div>
                                        <div class="row">
                                            <div class="col-md-16" id="pos" style="padding-left:10%;padding-right:10%;padding-bottom:10px">
																							<?php $x=0; if(isset($slots) && $slots['exists'] == "true"){
																								foreach($slots['slots'] as $slot){?>
																								<div>
																									<form method="post" action="settings.php">
																											<input type="hidden" name="slotid" value="<?php echo $slot['slotid'];?>">
																											<input type="text" name="day" placeholder="day" class="inputpass" style="width:25%" value="<?php echo $slot['day'];?>" readonly>
	                                                    <input type="time" name="from_time" placeholder="Start time" class="inputpass" style="width:25%" value="<?php echo $slot['from_time'];?>" readonly>
	                                                    <input type="time" name="to_time" placeholder="End time" class="inputpass" style="width:25%" value="<?php echo $slot['to_time'];?>" readonly>
																											<input type="text" name="max_allowed" placeholder="max" class="inputpass" style="width:15%" value="<?php echo $slot['max_allowed'];?>" readonly>
																											<button type="submit" name="deleteslot" style="text-decoration:none;color:blue"><i class="fa fa-window-close"></i></button>
																									</form>
                                                </div>
																							<?php }}?>
                                            </div>
																				</div>
																				<div class="row">
																					<form method="post" action="settings.php">
																							<div class="col-md-16" id="pos" style="padding-left:10%;padding-right:10%;padding-bottom:10px">
																									<div>
	                                                    <select style="width:25%" name="day" class="inputpass">
	                                                        <option value="Sunday">Sunday</option>
																													<option value="Monday">Monday</option>
																													<option value="Tuesday">Tuesday</option>
																													<option value="Wednesday">Wednesday</option>
																													<option value="Thursday">Thursday</option>
																													<option value="Friday">Friday</option>
																													<option value="Saturday">Saturday</option>
	                                                    </select>
	                                                    <input type="time" name="from_time" placeholder="Start time" class="inputpass" style="width:25%" value="">
	                                                    <input type="time" name="to_time" placeholder="End time" class="inputpass" style="width:25%">
																											<input type="text" name="max_allowed" placeholder="Max allowed" class="inputpass" style="width:15%">
	                                                    <!--<a style="text-decoration:none;color:blue"><i class="fa fa-window-close"></i></a>-->
	                                                </div>
	                                            </div>
																							<div class="row">
			                                            <div class="col-md-4">
			                                            </div>
			                                            <div class="col-md-4">
			                                                <button type="submit" name="saveslot" class="btn btn1" style="width:100%;margin-bottom:5px">Save</button>
			                                            </div>
			                                        </div>
																					</form>
                                        </div>
                                        <!---->

                                    </div>
                                </div>
                            </div>
                        <!---->
                    </div>
                </div>
           </div>
        </div>


        <footer class="footer">
            <ul>
                <li>
                    <a href="#">
                        Home
                    </a>
                </li>
                <li>
                    <a href="../about.html">
                        About
                    </a>
                </li>
                <li>
                <a href="../contact.html">
                    Contact
                </a>
                </li>
            </ul>
            <p class="copyright ">
                &copy; <script>document.write(new Date().getFullYear())</script> <a href="">&copy;WebclinicTech</a>, made with &hearts;
            </p>
        </footer>
    </div>
</div>
</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
</html>
