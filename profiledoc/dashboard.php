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
        CURLOPT_URL => 'http://localhost/clinic/v3/api/appointments/doctor/' . $_SESSION['username'] ."/". $date
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
                <!--<li>
                    <a href="medicalrecord.php">
                        <i class="pe-7s-note2"></i>
                        <p>Medical Record</p>
                    </a>
                </li>
                <li>
                    <a href="symptomchecker.php">
                        <i class="pe-7s-help1"></i>
                        <p>Symptom Checker</p>
                    </a>
                </li>
                <li>
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
					        <li><a href="#">Action1</a></li>
							<li><a href="#">Action2</a></li>
							<li><a href="#">Action 3</a></li>
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
                <div class="row ">
                  <form method="post" action="dashboard.php">
                    <div class="col-md-5">
                      <div class="card card-user">
                        <input name="date" type="date" style="width:100%">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="card card-user">
                        <button class="btn btn1" name="search" id="search" style="padding:0px;"> Search</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="row" style="padding-left:10%">
                    <div class="col-md-16 card content" style="padding-bottom:0">
                              <!-- -->
                              <?php $x=0; if(isset($appoint) && $appoint['exists'] == "true"){?>
                              <?php foreach($appoint['appointments'] as $apt){?>
                                <form class="doctor-main-card" method="post" action="approveAppointment.php">
                                    <div class="doctor-main-card" style="margin-top:15px;" id="doc<?php echo $x; ?>">
                                      <input type="hidden" name="appid" id="appid<?php echo $x;?>" value="<?php echo $apt['appid']; ?>">
                                        <div class="row docup">
                                            <div class="col-md-8">
                                            <div class="doc-card-info" >
                                                <h2 id="name<?php echo $x;?>" ><?php echo $apt['cfname']; ?> <?php echo $apt['clname']; ?></h2>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row doclower">
                                             <div class="doc-address">
                                                 <h2 id="city<?php echo $x;?>"><?php echo $apt['city']; ?></h2>
                                                 <div class="address" id="address<?php echo $x;?>"><p><?php echo $apt['address']; ?></p></div>
                                             </div>
                                            <!--doctor schedule-->
                                             <div>
                                                <div class="schedule">
                                                  <h2  id="calenderdate<?php echo $x;?>" >Date: <?php echo $apt['date']?></h2>
                                                  <h4  id="calendertime<?php echo $x;?>" >Time: <?php echo $apt['time']?></h4>
                                                  <h4  id="dob<?php echo $x;?>" >DOB: <?php echo $apt['dob']?></h4>
                                               </div>
                                            </div>
                                          <!--Doctor schedule end-->
                                            <div class="fee" style="font-size:150%">
                                                <h3 id="gender<?php echo $x;?>">Gender : <?php echo $apt['gender']; ?></h3><br/>
                                            </div>
                                        </div>
                                        <div class="row doclower" style="padding:0px;">
                                          <div class="operation">
                                            <button type="button" class="btn btnbook1" id="<?php echo $x;?>" style="font-weight:500px;border-radius:15px 0px 0px 15px;float:left;width:50%" >Approve</button>
                                            <button type="submit" class="btn btn1 btnbook2" style="float:right;width:50%;border-radius:0px 15px 15px 0px" name="reject"><div>Reject</div></button>
                                          </div>
                                        </div>
                                    </div>
                                  </form>
                          <?php $x++; }}
                            elseif(isset($appoint) && $appoint['exists'] == "false")  echo "<div class=\"content\">
                                  <div class=\"container-fluid\">
                                    <p>No appointment found</p>
                                  </div>
                                  </div>";  ?>




                      <!---->
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
