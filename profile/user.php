<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Webclinic</title>

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
					 CURLOPT_URL => 'http://localhost/clinic/v3/api/client/update/' . $_SESSION['username'] . '/image',
					 CURLOPT_CUSTOMREQUEST => "PUT",
					 CURLOPT_POSTFIELDS => http_build_query(array('imid' => $file_name))
				 ));

				 $res = json_decode(curl_exec($ch));


				 if($res->success == "true"){


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
		 		    CURLOPT_URL => 'http://localhost/clinic/v3/api/client/update/' . $_SESSION['username'],
		 		    CURLOPT_CUSTOMREQUEST => "PUT",
		 		    CURLOPT_POSTFIELDS => http_build_query($_POST)
		 			));

		 			$res = json_decode(curl_exec($ch));


		 			if($res->success == "true"){

		 				echo $res->message;
						echo "<script> alert(\"Updated Successfully\"); </script>";
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
			CURLOPT_URL => 'http://localhost/clinic/v3/api/client/' . $_SESSION['username']
		));

		$update = json_decode(curl_exec($ch));



?>


<div class="wrapper">
    <div class="sidebar" data-color="green" data-image="assets/img/sidebar-5.jpg">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="../index.html" class="simple-text">
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
                <li class="active">
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
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><i class="fa pe-7s-user" style="font-weight:bold"></i> &nbsp;User</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../docs/img/<?php echo $update->client[0]->imid;?>" style="width:40px;height:40px;border-radius:50%;display:inline-block">
                                <p style="float:right;padding-top:10px;padding-left:5px">
									Hello, <?php echo $_SESSION['name'] ?>
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
                    <div class="col-md-12">
                        <div class="card card-user">
                          <!--  <div class="image">
                              <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400" alt="..."/>

                            </div>-->
                            <div class="content" style="background:#e0e2e5">
							    <div class="author">
									<!--<label for="title">
										<img class="avatar border-gray" src="../docs/img/" alt="..."/>
									</label>-->
									<form method = "POST" enctype = "multipart/form-data" action="user.php" style="padding-top:10px">
										<div>
											<label for="title">
												<img class="avatar border-gray" src="../docs/img/<?php echo $update->client[0]->imid;?>" alt="assets/img/default-avatar.png"/>
											</label>
											<input type="file" id="title" name="image" style="display:none"><br/>
											<button type="submit" class="btn btn1">Update</button>
										</div>
									</form>
                                    <h4 ><?php echo $update->client[0]->uname; ?><br />
                                        <small><?php echo $update->client[0]->fname; ?> <?php echo $update->client[0]->lname; ?></small>
                                    </h4>
										<label>About</label>
									<br>
                                    <p style="color:gray"><?php echo $update->client[0]->about; ?></p>
								</div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">

                                <form method="post" action="user.php">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>First Name</label>
											    <input type="text" class="form-control" name="fname" placeholder="ex. John" value="<?php echo $update->client[0]->fname; ?>" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Last Name</label>
												<input type="text" class="form-control" name="lname" placeholder="ex. John" value="<?php echo $update->client[0]->lname; ?>" >
											</div>
										</div>
									</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" name="email" placeholder="ex. abc@xyz.com" value="<?php echo $update->client[0]->email; ?>">
                                            </div>
                                        </div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Gender</label>
												<select class="form-control" name="gender" value="<?php echo $update->client[0]->gender; ?>">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
												</select>
											</div>
										</div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Age</label>
                                                    <input type="text" class="form-control" placeholder="Age" >
                                                </div>
                                            </div>
																						<div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of birth</label>
                                                    <input type="date" class="form-control" name="dob" value="<?php echo $update->client[0]->dob; ?>" >
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address" placeholder="ex. 21B, Baker St." value="<?php echo $update->client[0]->address; ?>" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city" placeholder="ex. London" value="<?php echo $update->client[0]->city ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" name="country" placeholder="ex. Great Britain" value="<?php echo $update->client[0]->country ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="text" class="form-control" name="postal" placeholder="ex. 100001" value="<?php echo $update->client[0]->postal ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" name="phone" placeholder="Phone Number" value="<?php echo $update->client[0]->phone; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Blood group</label>
                                                <input type="text" class="form-control" name="bloodGroup" placeholder="Blood Group" value="<?php echo $update->client[0]->bloodGroup; ?>">
                                            </div>
                                        </div>
                                    </div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>About</label>
												<input type="text" class="form-control" name="about" placeholder="About" value="<?php echo $update->client[0]->about; ?>">
											</div>
										</div>
									</div>
                                    <button type="submit" class="btn btn1 pull-right">Update Profile</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
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
                    <a href="../index.html">
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

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

</html>
