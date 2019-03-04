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
		#searchapp{
			padding-left:20%;
		}
		@media (max-width:992px){
			#searchapp{
				padding-top:10px;
				padding-left:0;
			}
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

	header("Access-Control-Allow-Origin: *");


      $date = date('Y-m-d', time());

      if(isset($_POST['search'])){
        $date = date("Y-m-d",strtotime(str_replace('/', '-',$_POST['date'])));
      }

      $ch = curl_init();

      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost/clinic/v3/api/appointments/doctor/queued/' . $_SESSION['username'] ."/". $date
      ));



      $appoint = json_decode(curl_exec($ch), true);

      echo $appoint['exists'];

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
                <li class="active">
                    <a href="booking.php">
                        <i class="pe-7s-note2"></i>
                        <p>Bookings</p>
                    </a>
                </li>
                <li>
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
                    <li><a href="settings.php">Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="../logout.php">Logout</a></li>
									</ul>
								</li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
               <!---->
                <div class="row">
                    <div class="col-md-16 card content" style="padding-bottom:0">
                        <form method="post" action="booking.php" id="searchapp">
                            <div class="col-md-6">
                                <div class="card card-user">
                                    <input name="date" type="date" class="form-control" required style="width:100%;height:40px;padding-left:10px">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card card-user">
                                    <button class="btn btn1" name="search" id="search" style="width:100%"> Search</button>
                                </div>
                            </div>
                        </form>
		                    <div class="cardbody">
		                        <div class="card" style="width:100%">
		                            <div class="content" style="padding:0px;width:100%;background-color: rgb(228, 230, 227);border-style:none">
		                              <!-- -->

		                                <?php $x=0; if(isset($appoint) && $appoint['exists'] == "true"){?>
		                                <?php foreach($appoint['appointments'] as $apt){?>
		                                    <form method="post" action="approveAppointment.php">
		                                        <div class="list_general1" id="doc<?php echo $x; ?>" style="margin-bottom:10px;background-color: rgb(255, 255, 255);border:none">
		                                            <ul>
		                                                <li style="padding-left:50px">
		                                                    <input type="hidden" name="appid" id="appid<?php echo $x;?>" value="<?php echo $apt['appid']; ?>">
		                                                    <h4 id="name<?php echo $x;?>" ><?php echo $apt['cfname']; ?> <?php echo $apt['clname']; ?></h4>
		                                                    <p style="font-size:14px" id="gender<?php echo $x; ?>"><i class="fa fa-inr"></i>&nbsp;<?php echo $apt['gender']; ?></p>
		                                                    <p style="font-size:14px" id="dob<?php echo $x; ?>"><i class="fa fa-inr"></i>DOB:&nbsp;<?php echo $apt['dob']; ?></p>
		                                                    <p style="font-size:14px" id="city<?php echo $x; ?>"><i class="fa fa-address-book"></i>&nbsp;<?php echo $apt['city']; ?>,&nbsp;<?php echo $apt['address'];?> <i class="fa fa-calendar"></i>&nbsp;<?php echo $apt['date'];?>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<?php echo $apt['time'];?><br></p>
		                                                    <p><button type="submit" name="approve" id="<?php echo $x; ?>" class="btn_1 gray view"><i class="fa fa-fw fa-user"></i> Approve</button></p>
		                                                    <ul class="buttons">
		                                                        <li><button type="submit" name="reject" id="btnreject" class="btn_1 gray delete"><i class="fa fa-times-circle"></i> Reject</button></li>
		                                                    </ul>
		                                                </li>
		                                            </ul>
		                                        </div>
		                                    </form>
		                                    <?php $x++; }}
		                                    elseif(isset($appoint) && $appoint['exists'] == "false")  echo "
																								<p>No appointment found</p>";  ?>
		                                    <!---->
		                            </div>
		                        </div>
		                     </div>
                    </div>
                </div>
                <!---->
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
