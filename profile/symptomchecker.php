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
    <style>
            .tab {
              display: none;
            }
            #prevBtn {
              background-color: #bbbbbb;
            }
            /* Make circles that indicate the steps of the form: */
            .step {
              height: 15px;
              width: 15px;
              margin: 0 2px;
              background-color: #bbbbbb;
              border: none;
              border-radius: 50%;
              display: inline-block;
              opacity: 0.5;
            }
            .step.active {
              opacity: 1;
            }
            /* Mark the steps that are finished and valid: */
            .step.finish {
              background-color: #4CAF50;
            }
            </style>


</head>
<body>

	<!-- ========= * PHP * ===========================================================================-->

	<!--    config ---->

	<?php
		session_start();
	 ?>

	<!--   check if user already logged in ---->

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


<div class="wrapper">
    <div class="sidebar" data-color="green" data-image="assets/img/sidebar-5.jpg">

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
                    <a href="medicalrecord.php">
                        <i class="pe-7s-note2"></i>
                        <p>Medical Record</p>
                    </a>
                </li>
                <li class="active">
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
					<a class="navbar-brand" href="#"><i class="fa pe-7s-help1" style="font-weight:bold"></i> &nbsp;Symptom Checker</a>
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


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                        <div class="container-login100">
                                <div class="wrap-login100">
                              <div class="login100-pic">
                                  <img src="assets/img/body1.jpg" style="box-shadow:18px 18px 18px 18px white inset;">
                              </div>
                              <form class="login100-form validate-form" id="regForm" action="../index.html">
                                <div class="login100-form-title">
                                    Symptom Checker
                                </div>
                                <div class="form-body">
                                  <!-- pages for symptom checker -->
                                  <div class="tab wrap-input100 validate-input" data-validate = "Please enter age" style="padding-top:10%">
                                    <h5 style="float:left;padding-top:10px;padding-left:10px;padding-right:15px">Gender</h5>
                                    <div class="wrap-content">
                                      <label class="rad" style="padding-right:10px">
                                        <input type="radio" name="gender" class="input100" value="m"><i class="fa fa-male gendericon"></i>
                                      </label>
                                      <label class="rad">
                                        <input type="radio" name="gender" class="input100" value="f"><i class="fa fa-female gendericon"></i>
                                      </label>
                                    </div>
                                    <div class="wrap-input100">
                                        <input placeholder="Age" name="age" class="input100" style="width:70%" required>
                                    </div>
                                  </div>

                                  <div class="tab wrap-input100 validate-input"><h5 style="float:left;padding-top:10px;padding-left:10px">Add symptom</h5>
                                    <br><br>
                                    <input placeholder="e.g. Headache" name="symptoms" class="input100">
                                  </div>

                                  <div class="tab wrap-input100 validate-input">
                                    <h5 style="text-align:center;padding-bottom:5px">Duration of symptom</h5><input placeholder="duration" name="duration" class="input100" style="margin-bottom:5px;">
                                    <select name="time" class="input100">
                                      <option value="hour">Hours</option>
                                      <option value="day">Days</option>
                                      <option value="week">Weeks</option>
                                    </select>
                                    <br><h5 style="text-align:center;padding-bottom:5px">Current medication</h5><input placeholder="e.g. Lipitor" name="currentmed" class="input100">
                                    <br><h5 style="text-align:center;padding-bottom:5px">Past or current condition</h5><input placeholder="e.g. Migrain" name="currentcond" class="input100">
                                  </div>

                                  <div class="tab wrap-input100 validate-input"><h5>Conditions</h5>

                                  </div>
                                </div>
                                <div style="overflow:auto;">
                                  <div style="float:right;">
                                    <button type="button" class="check-form-btn" id="prevBtn" onclick="nextPrev(-1)" style="align-items:left">Previous</button>
                                    <button type="button" class="check-form-btn" id="nextBtn" onclick="nextPrev(1)" style="float:right">Next</button>
                                  </div>
                                </div>
                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                  <span class="step"></span>
                                  <span class="step"></span>
                                  <span class="step"></span>
                                  <span class="step"></span>
                                </div>
                              </form>
                          </div>
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
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the crurrent tab

        function showTab(n) {
          // This function will display the specified tab of the form...
          var x = document.getElementsByClassName("tab");
          x[n].style.display = "block";
          //... and fix the Previous/Next buttons:
          if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
          } else {
            document.getElementById("prevBtn").style.display = "inline";
          }
          if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
          } else {
            document.getElementById("nextBtn").innerHTML = "Next";
          }
          //... and run a function that will display the correct step indicator:
          fixStepIndicator(n)
        }

        function nextPrev(n) {
          // This function will figure out which tab to display
          var x = document.getElementsByClassName("tab");
          // Exit the function if any field in the current tab is invalid:
          // Hide the current tab:
          x[currentTab].style.display = "none";
          // Increase or decrease the current tab by 1:
          currentTab = currentTab + n;
          //alert(" "+currentTab);
          // if you have reached the end of the form...
          if (currentTab == x.length) {
            // ... the form gets submitted:
           //var y=document.getElementById("regForm").className;
            alert(x.length);
            document.getElementById("regForm").submit(function(){alert("ok");});
            return false;
          }
          // Otherwise, display the correct tab:
          showTab(currentTab);
        }


        function fixStepIndicator(n) {
          // This function removes the "active" class of all steps...
          var i, x = document.getElementsByClassName("step");
          for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
          }
          //... and adds the "active" class on the current step:
          x[n].className += " active";
        }
        </script>

    <script src="assets/js/main.js" type="text/javascript"></script>
    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
</html>
