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
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
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

      $ch = curl_init();

      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost/clinic/v3/api/client/' . $_GET["var"] ."/allrecords"
      ));



      $records = json_decode(curl_exec($ch), true);

      echo $records['exists'];


      echo $_GET["var"];

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
                <li class="active">
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
                <li>
                    <a href="settings.php">
                        <i class="pe-7s-settings"></i>
                        <p>Settings</p>
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


        <div class="content" style="padding:5px">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-sm-16">
                        <!---->
                        <h4 style="padding-left:15px">Patient Information</h4>
                        <?php $x=0; if(isset($records) && $records['exists'] == "true"){?>
                        <?php foreach($records['records'] as $rec){?>
                            <div class="cardbody" style="padding-top:0px">
                                <div class="card" style="width:100%">
                                    <div class="content" style="padding:0px;width:100%;background-color: rgb(228, 230, 227);border-style:none">
                                        <!-- -->

                                        <form method="post">
                                            <div class="list_general1" id="doc<?php echo $x; ?>" style="margin-bottom:10px;background-color: rgb(255, 255, 255);border:none">
                                                <ul>
                                                    <li style="padding-left:50px">
                                                        <input type="hidden" name="rpid" id="rpid<?php echo $x;?>" value="<?php echo $rec['rpid']; ?>">
                                                        <h4 id="name<?php echo $x;?>"<?php echo $rec['dname']; ?></h4>

                                                        <p style="font-size:14px" id="date<?php echo $x; ?>"><i class="fa fa-calendar"></i>Date: &nbsp;<?php echo $rec['date']; ?></p>
                                                        <p style="font-size:14px" id="diagnosis<?php echo $x; ?>"><i class="fa fa-address-book"></i>&nbsp;<?php echo $rec['diagnosis']; ?></p>
                                                        <p><a type="button" id="<?php echo $x;?>" class="btn_1 gray view wishlist_close" href="patdetails.php?rid=<?php echo $rec['rpid']?>"><i class="fas fa-medkit"></i> Medicines</a></p>
                                                        <ul class="buttons">
                                                            <a href=<?php if($rec['prescid'] != "") echo "../docs/prescription/".$rec['prescid']; else{echo "assets/img/noimg.png";}?> class="btn_1 gray view wishlist_close" ><i class="fas fa-prescription-bottle-alt"></i>Prescriptions</a>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <?php $x++; }}
                            elseif(isset($records) && $records['exists'] == "false")  echo "
                                    <p style=\"text-align:center\">No previous records found</p>"  ?>
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

	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
</html>
