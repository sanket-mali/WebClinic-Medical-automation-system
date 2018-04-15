<!doctype html>
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
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/check.css">
    <!--<link rel="stylesheet" href="assets\fonts\font-awesome-4.7.0\css\font-awesome.min.css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/admin.css">

</head>
<body>


	<!-- ========= * PHP * ===========================================================================-->

	<!--    config -->

	<?php
        session_start();
	 ?>

	<!--   check if user already logged in -->

	<?php

	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != "yes" || !isset($_SESSION['patient'])){
		header("Location: http://localhost/clinic/v3/login.php");
	}
	?>

    <?php

        header("Access-Control-Allow-Origin: *");

        $ch = curl_init();

        curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost/clinic/v3/api/client/' . $_SESSION['username']
        ));

        $update = json_decode(curl_exec($ch));
    ?>

	<?php

	$ch = curl_init();

	curl_setopt_array($ch, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://localhost/clinic/v3/api/appointments/client/' . $_SESSION['username']
	));

	$appoint = json_decode(curl_exec($ch), true);


	?>
<div class="wrapper">
    <div class="sidebar" data-color="green" data-image="assets/img/sidebar-5.jpg">

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
                        <p>Appointment</p>
                    </a>
                </li>
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
                                <img src="../docs/img/<?php echo $update->client[0]->imid;?>" style="width:35px;height:35px;border-radius:50%;display:inline-block">
								<p style="float:right;padding-top:10px;padding-left:5px">
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


        <div class="content" style="padding-top:15px;">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-sm-16 patientcard" onclick="myFunction1()" id="card1">
                        <p class="cardhead">Appointment</p>
                        <a href="dashboard.php"><img src="assets/img/cross.png" id="cross1" style="float:right;padding-right:40px;font-size:20px;visibility:hidden"></a>
						<div id="pat-card1" class="pat-first-card">
                        <!---->
                        <?php if(isset($appoint) && $appoint['exists'] == "true"){?>
                            <form>
                                <div class="list_general">
                                    <ul>
                                        <li>
                                            <figure><img src="assets/img/default-avatar.png" alt=""></figure>
                                            <small><?php echo $appoint['appointments'][0]['expert']; ?></small>
                                            <h4>Dr. <?php echo $appoint['appointments'][0]['dfname']; ?> <?php  echo $appoint['appointments'][0]['dlname']; ?></h4>
                                            <p style="font-size:14px"><i class="fa fa-address-book">&nbsp;</i><?php echo $appoint['appointments'][0]['city']; ?>,&nbsp;<?php echo $appoint['appointments'][0]['address'];?> <i class="fa fa-calendar"></i>&nbsp;<?php echo $appoint['appointments'][0]['date'];?>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<?php echo $appoint['appointments'][0]['time'];?><br></p>
                                            <p style="font-size:14px"><i class="fa fa-inr"></i>&nbsp;<?php echo $appoint['appointments'][0]['fees']; ?></p>
                                            <p><button type="submit" id="btnview" class="btn_1 gray view"><i class="fa fa-fw fa-user"></i> View profile</button></p>
                                            <ul class="buttons">
                                                <li><button type="submit" id="btncancel" class="btn_1 gray delete wishlist_close" id="0"><i class="fa fa-times-circle"></i> Cancel</button></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        <?php }?>
                        </div>  
                        <!---->
                        <!--================================-->
					    <div id="treatment" class="cardbody" style="display:none">
                            <div class="card" style="width:100%">
                                <div class="content" style="padding:0px;width:100%;background-color: rgb(228, 230, 227);border-style:none">

                                    <!---->
                                    <?php $x=0; if(isset($appoint) && $appoint['exists'] == "true") { ?>
                                        <?php foreach ($appoint['appointments'] as $apt) { ?>
                                            <div class="list_general1" style="margin-bottom:10px;background-color: rgb(255, 255, 255);border:none">
                                                <ul>
                                                    <li>
                                                        <figure><img src="assets/img/default-avatar.png" alt=""></figure>
                                                        <input type="hidden" id="did" value="">
                                                        <small id="expert<?php echo $x; ?>"><?php echo $apt['expert']; ?></small>
                                                        <h4>Dr. <?php echo $apt['dfname']; ?> <?php  echo $apt['dlname']; ?></h4><p style="font-size:12px;" id="verified<?php echo $x; ?>"><?php if ($apt['verified'] == "true") echo "<i class=\"fas fa-check-circle\" style=\"color:green\"></i>&nbsp;&nbsp;Registration Verified"; else echo "<i class=\"fas fa-check-circle\" style=\"color:red\"></i>&nbsp;&nbsp;Unverified Doctor"; ?></p>
                                                        <p style="font-size:14px" id="city<?php echo $x; ?>"><i class="fa fa-address-book"></i>&nbsp;<?php echo $apt['city']; ?>,&nbsp;<?php echo $apt['address'];?> <i class="fa fa-calendar"></i>&nbsp;<?php echo $apt['date'];?>&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;<?php echo $apt['time'];?><br></p>
                                                        <p style="font-size:14px" id="fees<?php echo $x; ?>"><i class="fa fa-inr"></i>&nbsp;<?php echo $apt['fees']; ?></p>
                                                        <p><button type="submit" id="btnview" class="btn_1 gray view"><i class="fa fa-fw fa-user"></i> View profile</button></p>
                                                        <ul class="buttons">
                                                            <li><button type="submit" id="btncancel" class="btn_1 gray delete wishlist_close" id="0"><i class="fa fa-times-circle"></i> Cancel</button></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                         <?php $x++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-16 patientcard" onclick="myFunction2()" id="card2">
                        <p class="cardhead">Read about medicine</p>
                        <a href="dashboard.php"><img src="assets/img/cross.png" id="cross2" style="float:right;padding-right:40px;font-size:20px;visibility:hidden"></a>
                        <img src="assets/img/medicine.png" class="patientcard-pic" id="img2">
                        <!--===========-->
                        <div class="container-login100" style="display:none" id="med">
                                <div class="wrap-login101">
                                    <div class="login100-pic1">
                                        <img src="assets/img/medicine.png">
                                    </div>
                                    <form class="login100-form validate-form" action="../index.html">
                                        <div class="login100-form-title">
                                            Read about medicines
                                        </div>
                                        <div class="wrap-input100">
                                            <input placeholder="medicine name e.g Aspirin" name="searchmed" class="input100" required>
                                            <span class="symbol-input100">
                                                <i class="fa fa-prescription-bottle-alt" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <button type="button" class="check-form-btn" id="search" float="right" style="width:100%;float:right">Search</button>
                                    </form>
                                </div>
                        </div>
                        <!--============-->
                    </div>
                    <div class="col-sm-8 patientcard" onclick="myFunction3()" id="card3">
                        <p class="cardhead">Reminder</p>
                        <a href="dashboard.php"><img src="assets/img/cross.png" id="cross3" style="float:right;padding-right:40px;font-size:20px;visibility:hidden"></a>
                        <img src="assets/img/reminder.png" class="patientcard-pic1" id="img3" style="width:80%">
                        <!--======================-->
                        <div class="container-login100" style="display:none" id="rem">
                                <div class="wrap-login101">
                                    <div class="login100-pic1">
                                        <img src="assets/img/reminder.png" style="width:100%;padding-left:5px">
                                    </div>
                                    <form class="login100-form validate-form" action="../index.html">
                                        <div class="login100-form-title">
                                            Set reminder
                                        </div>
                                        <div class="wrap-input100">
                                            <input placeholder="Title" name="remtitle" class="input100" required>
                                            <span class="symbol-input100">
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <!--<div class="wrap-input100">-->
                                            <label class="login100-form-title" style="font-size:16px;padding-bottom:2px">Start</label>
                                        <!--</div>-->
                                        <div class="wrap-input100">
                                            <input type="date" value="01/01/2010" class="input100">
                                            <span class="symbol-input100">
                                                <i class="fas fa-calendar-check"></i>
                                            </span>
                                        </div>
                                        <!--==============-->
                                        <!--<div class="wrap-input100">-->
                                            <label class="login100-form-title" style="font-size:16px;padding-bottom:2px">End</label>
                                        <!--</div>-->
                                        <div class="wrap-input100">
                                            <input type="date" value="01/01/2010" class="input100">
                                            <span class="symbol-input100">
                                                <i class="fas fa-calendar-check"></i>
                                            </span>
                                        </div>
                                        <div class="wrap-input100">
                                            <input type="time" value="12:00AM" class="input100">
                                            <span class="symbol-input100">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        </div>
                                        <div class="wrap-input100">
                                            <input placeholder="Description" name="description" class="input100" required >
                                            <span class="symbol-input100">
                                                <i class="fas fa-book"></i>
                                            </span>
                                        </div>
                                        <label class="login100-form-title" style="font-size:16px;padding-bottom:2px">Reminder</label>
                                        <div class="wrap-input100">
                                            <a href="#"><button type="button" class="input100" id="search" float="right">Add new reminder</button></a>
                                            <span class="symbol-input100">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="remset">
                                            <div class="wrap-input100">
                                                <select class="input100" style="width:200px;display:inline-block">
                                                    <option value="on time">On time</option>
                                                    <option value="1 min">1 min before</option>
                                                    <option value="5 min">5 min before</option>
                                                    <option value="10 min">10 min before</option>
                                                    <option value="15 min">15 min before</option>
                                                    <option value="20 min">20 min before</option>
                                                    <option value="25 min">25 min before</option>
                                                    <option value="30 min">30 min before</option>
                                                    <option value="45 min">45 min before</option>
                                                    <option value="1 hour">1 hours before</option>
                                                    <option value="2 hours">2 hours before</option>
                                                    <option value="3 hours">3 hours before</option>
                                                    <option value="12 hours">12 hours before</option>
                                                    <option value="1 day">1 day before</option>
                                                    <option value="2 days">2 days before</option>
                                                    <option value="1 week">1 week before</option>
                                                </select>
                                                <p style="display:inline-block">event</p>
                                                <i class="fa fa-remove" style="display:inline-block"></i>
                                                <span class="symbol-input100">
                                                    <i class="fas fa-bell"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <!--============-->
                                        <button type="button" class="check-form-btn" id="search" float="right" style="width:100%;float:right">Save</button>
                                    </form>
                                </div>
                        </div>
                        <!--===============-->
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
    <script>
    function myFunction1() {
        document.getElementById("card1").style.height="auto";
        document.getElementById("card1").style.width="100%";
        document.getElementById("card2").style.display="none";
        document.getElementById("card3").style.display="none";
		document.getElementById("pat-card1").style.display="none";
        document.getElementById("cross1").style.visibility="visible";
        document.getElementById("treatment").style.display="block";
    }
    function myFunction2() {
        document.getElementById("card2").style.height="500px";
        document.getElementById("card2").style.width="95%";
        document.getElementById("card1").style.display="none";
        document.getElementById("card3").style.display="none";
        document.getElementById("cross2").style.visibility="visible";
        document.getElementById("img2").style.display="none";
        document.getElementById("med").style.display="block";
    }
    function myFunction3() {
        document.getElementById("card3").style.height="auto";
        document.getElementById("card3").style.width="95%";
        document.getElementById("card3").style.marginLeft="10px";
        document.getElementById("card1").style.display="none";
        document.getElementById("card2").style.display="none";
        document.getElementById("cross3").style.visibility="visible";
        document.getElementById("img3").style.display="none";
        document.getElementById("rem").style.display="block";
        document.getElementById("id3").style.marginLeft="5px;";
    }
    </script>
    
    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#btnview').click(function(e){
            e.stopPropagation();
        });
        $("#btncancel").click(function(e){
            e.stopPropagation();
        });
    });
    </script>
</html>
