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

	<!--    config ---->

	<?php
        session_start();

        echo $_SESSION['loggedIn'];
        echo $_SESSION['username'];
        echo $_SESSION['name'];
        echo $_SESSION['doc'];
	 ?>

	<!--   check if user already logged in ---->

	<?php

	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != "yes"  || !isset($_SESSION['doc'])){
		header("Location: http://localhost/clinic/v3/logindoc.php");
	}


	?>


	<?php


	############		Profile Image Upload ##################
				if(isset($_FILES['image'])){

				$errors= array();
				#$_FILES['image']['name'];
				$file_size = $_FILES['image']['size'];
				$file_tmp = $_FILES['image']['tmp_name'];
				$file_type = $_FILES['image']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
				$file_name = substr(md5(microtime()),rand(0,26),7) . '.' . $file_ext;

				$expensions= array("jpeg","jpg","png");

				if(in_array($file_ext,$expensions)=== false){
					 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
				}

				if($file_size > 2097152) {
					 $errors[]='File size must be exactly 2 MB';
				}

				if(empty($errors)==true) {
					 move_uploaded_file($file_tmp,"../docs/img/".$file_name);
					 echo "Success";

					 ##   Update in client pic id ##

				 $ch = curl_init();

					 curl_setopt_array($ch, array(
						 CURLOPT_RETURNTRANSFER => 1,
						 CURLOPT_URL => 'http://localhost/clinic/v3/api/doctor/update/' . $_SESSION['username'] . '/image',
						 CURLOPT_CUSTOMREQUEST => "PUT",
						 CURLOPT_POSTFIELDS => http_build_query(array('imid' => $file_name))
					 ));

					 $res = json_decode(curl_exec($ch));


					 if($res->success == "true"){

						 var_dump($res);
					 }
					 else{
						 echo $res->message;
					 }

					 ###        ####



				}else{
					 print_r($errors);
				}
				}


	############		Profile Upload ##################

			if($_POST){

					 $ch = curl_init();

			 			curl_setopt_array($ch, array(
			 		    CURLOPT_RETURNTRANSFER => 1,
			 		    CURLOPT_URL => 'http://localhost/clinic/v3/api/doctor/update/' . $_SESSION['username'],
			 		    CURLOPT_CUSTOMREQUEST => "PUT",
			 		    CURLOPT_POSTFIELDS => http_build_query($_POST)
			 			));

			 			$res = json_decode(curl_exec($ch));


			 			if($res->success == "true"){

			 				#var_dump($res);
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
				CURLOPT_URL => 'http://localhost/clinic/v3/api/doctor/' . $_SESSION['username']
			));

			$update = json_decode(curl_exec($ch));



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
                    <a href="user.php" class="active">
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
                <div class="row">
                    <div class="col-md-12">


													<?php if($update->doctor[0]->verified == "true"){
													echo "<div class=\"card card-user\" style=\"height:30px;width:100%;background:rgb(20, 170, 28);margin-bottom:0;white-space:nowrap\" id=\"status\">
													<p style=\"color:white;display:inline-block;padding:3px;text-align:center;padding-left:8px\">
														<i class=\"fa fa-check\" style=\"font-size:80%;\"></i>
													</p>
														<p style=\"color:white;display:inline-block;padding:3px;text-align:center;padding-left:0\">&nbsp;&nbsp;Verified and Live</p></div>";
													}
													else{
														echo "<div class=\"card card-user\" style=\"height:30px;width:100%;background:red;margin-bottom:0;white-space:nowrap\" id=\"status\">
														<p style=\"color:white;display:inline-block;padding:3px;text-align:center;padding-left:8px\">
															<i class=\"fa fa-remove\" style=\"font-size:80%;color:white\"></i>
														</p>
															<p style=\"color:white;display:inline-block;padding:3px;text-align:center;padding-left:0\">&nbsp;&nbsp;Unverified</p></div>";
													}
													?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-user">
                            <div class="image">
                                <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400"  alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
																	<form method = "POST" enctype = "multipart/form-data" action="user.php" style="padding-top:10px">
                                    <label for="imageupload">
                                        <img class="avatar border-gray" src="../docs/img/<?php echo $update->doctor[0]->imid;?>"  alt=""/>
                                    </label>
                                    <input type="file" id="imageupload" name="image" style="display:none">
                                    <br/>
                                    <button type="submit" class="btn btn1">Update</button>
																	</form>
                                    <br/>
                                    <br/>
                                    <h4 class="title"><?php echo $update->doctor[0]->uname; ?><br />
                                        <small>Dr. <?php echo $update->doctor[0]->fname; ?> <?php echo $update->doctor[0]->lname; ?></small>
                                    </h4>
                                </div>
                                <p class="description text-center" style="width:100%"><?php echo $update->doctor[0]->about; ?></p>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-16" style="padding-bottom:0">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Profile</h4>
                            </div>
                            <div class="content">

                                <form method="post" action="user.php">

                                    <div class="mystyle" id="mydiv1" onclick="myfunction1()">
                                        Personal details<i class="fa fa-angle-down" id="icon1" style="float:right;padding-top:5px;padding-right:5px"></i>
                                    </div>
                                    <div id="first">
                                        <div id="firstcard" style="display:none">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control" placeholder="First Name" name="fname" value="<?php echo $update->doctor[0]->fname; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control" placeholder="Last Name" name="lname" value="<?php echo $update->doctor[0]->lname; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Date of birth</label>
                                                        <input type="date" class="form-control" name="dob" value="<?php echo $update->doctor[0]->dob; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Gender</label>
                                                        <select class="form-control" name="gender">
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>About</label>
                                                            <input type="text" class="form-control" name="about" placeholder="about" value="<?php echo $update->doctor[0]->about; ?>">
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mystyle" id="mydiv2" onclick="myfunction2()">
                                        Professional details<i class="fa fa-angle-down" id="icon2" style="float:right;padding-top:5px;padding-right:5px"></i>
                                    </div>
                                    <div id="second">
                                        <div id="secondcard" style="display:none">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Speciality</label>
                                                        <input type="text" class="form-control" placeholder="Speciality" name="expert" value="<?php echo $update->doctor[0]->expert; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Rating</label>
                                                        <input type="text" class="form-control" readonly placeholder="Rating" value="<?php echo $update->doctor[0]->rating; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mystyle" id="mydiv3" onclick="myfunction3()">
                                        Contact Info<i class="fa fa-angle-down" id="icon3" style="float:right;padding-top:5px;padding-right:5px"></i>
                                    </div>
                                    <div id="third">
                                        <div id="thirdcard" style="display:none">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $update->doctor[0]->email; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="<?php echo $update->doctor[0]->phone; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" placeholder="Home Address" name="address" value="<?php echo $update->doctor[0]->address; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" class="form-control" placeholder="City" name="city" value="<?php echo $update->doctor[0]->city; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <input type="text" class="form-control" placeholder="Country" name="country" value="<?php echo $update->doctor[0]->country; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Postal Code</label>
                                                        <input type="number" class="form-control" placeholder="PIN Code" name="postal" value="<?php echo $update->doctor[0]->postal; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn1 pull-right">Update Profile</button>
                                </form>
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
    <script>
    function myFunction1() {
        document.getElementById("card1").style.height="700px";
        document.getElementById("card1").style.width="95%";
        document.getElementById("card2").style.display="none";
        document.getElementById("card3").style.display="none";
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


    var bool1=0;
    var bool2=0;
    var bool3=0;

    function myfunction1() {
        var element = document.getElementById("mydiv1");
        var element1 = document.getElementById("icon1");
        var element2 = document.getElementById("first");
        if(bool1==0)
        {
            element1.className = element1.className.replace(/\bfa fa-angle-down\b/g, "fa fa-angle-up");
            element2.style.height="auto";
            document.getElementById("firstcard").style.display="block";
            bool1=1;
        }
        else
        {
            element1.className = element1.className.replace(/\bfa fa-angle-up\b/g, "fa fa-angle-down");
            element2.style.height="0px";
            document.getElementById("firstcard").style.display="none";
            bool1=0;
        }
    }


    function myfunction2() {
        var element = document.getElementById("mydiv2");
        var element1 = document.getElementById("icon2");
        var element2 = document.getElementById("second");
        if(bool2==0)
        {
            element1.className = element1.className.replace(/\bfa fa-angle-down\b/g, "fa fa-angle-up");
            element2.style.height="auto";
            document.getElementById("secondcard").style.display="block";
            bool2=1;
        }
        else
        {
            element1.className = element1.className.replace(/\bfa fa-angle-up\b/g, "fa fa-angle-down");
            element2.style.height="0px";
            document.getElementById("secondcard").style.display="none";
            bool2=0;
        }
    }
    function myfunction3() {
        var element = document.getElementById("mydiv3");
        var element1 = document.getElementById("icon3");
        var element2 = document.getElementById("third");
        if(bool3==0)
        {
            element1.className = element1.className.replace(/\bfa fa-angle-down\b/g, "fa fa-angle-up");
            element2.style.height="auto";
            document.getElementById("thirdcard").style.display="block";
            bool3=1;
        }
        else
        {

            element1.className = element1.className.replace(/\bfa fa-angle-up\b/g, "fa fa-angle-down");
            element2.style.height="0px";
            document.getElementById("thirdcard").style.display="none";
            bool3=0;
        }
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
</html>
