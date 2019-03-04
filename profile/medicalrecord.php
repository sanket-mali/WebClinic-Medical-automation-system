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
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
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

		$update1 = json_decode(curl_exec($ch));
	?>

	<?php


	$file_name = "";
  $status = "";

  ############		Prescription Upload ##################
  if(isset($_FILES['prescription'])){

  			$errors= array();
  			#$_FILES['image']['name'];
  			$file_size = $_FILES['prescription']['size'];
  			$file_tmp = $_FILES['prescription']['tmp_name'];
  			$file_type = $_FILES['prescription']['type'];
  			$file_ext=strtolower(end(explode('.',$_FILES['prescription']['name'])));
  			$file_name = substr(md5(microtime()),rand(0,26),7) . '.' . $file_ext;

  			$expensions= array("pdf","jpg","jpeg","png");

  			if(in_array($file_ext,$expensions)=== false){
  				 $errors[]="extension not allowed, please choose a Pdf or image file.";
  			}

  			if($file_size > 2097152) {
  				 $errors[]='File size must be exactly 2 MB';
  			}

  			if(empty($errors)==true) {
  				 move_uploaded_file($file_tmp,"../docs/prescription/".$file_name);
  				 $status = "success";
         }
         else{
           $status = "failed";
         }
    }

		if($_POST && $status == "success"){

			$ch = curl_init();

			$rec = array('date' => $_POST['date'] , 'diagnosis' => $_POST['diagnosis'] , 'file_name' => $file_name);


			curl_setopt_array($ch, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://localhost/clinic/v3/api/client/' . $_SESSION['username'] . '/record',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $rec
			));

			$res = json_decode(curl_exec($ch));

			if($res->success == "true"){

				echo $res->message . $status;
			}
			else{
				echo $res->message . $status;
			}


		}

		######  Fetch records ##############

		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://localhost/clinic/v3/api/client/' . $_SESSION['username'] . '/record'
		));

		$update = json_decode(curl_exec($ch), true);


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
                <li class="active">
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
						<a class="navbar-brand" href="#"><i class="fa pe-7s-note2" style="font-weight:bold"></i> &nbsp;Medical Record</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../docs/img/<?php echo $update1->client[0]->imid;?>" style="width:35px;height:35px;border-radius:50%;display:inline-block">
									<p style="float:right;padding-top:10px;padding-left:5px">
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


		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div >
						<div >
							<div class="login100-form-title">
								Medical records
							</div>
							<form method = "POST" enctype = "multipart/form-data"  action="medicalrecord.php" style="width:100%;margin-bottom:20px">
							<div class="recordsearch" style="width:100%">
								<h4 style="margin-left:10px">Upload Document</h4>
								<br/>
									<div id="upbt" style="float:right;width:15%">
											<a href="uploaddoc.php" class="btn btn1" style="width:100%;padding:2%;height:35px;padding-top:8px">Upload Document</a>
									</div>
									<!--<input type="submit" value="Upload" class="btn btn1" style="width:100%;padding:2%;height:35px">-->

								</div>
							</form>
							</div>
							<br>
							<div class="wrap-table100">
								<div class="table100">
									<table>
										<thead>
											<tr class="table100-head">
												<th class="column1">Record</th>
												<th class="column2">Doctor</th>
												<th class="column3">Diagnosis</th>
												<th class="column4">Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($update['records'] as $rec){
											if($rec['prescid'] != ""){
													echo "<tr onclick=\"window.location='../docs/prescription/". $rec['prescid']."';\">";
													echo	"    	<td>" . $rec['rpid'] ."</td>";
													echo	"		<td>" . $rec['dname'] ."</td>";
													echo	"		<td>" . $rec['diagnosis'] ."</td>";
													echo	"    <td>" . $rec['date'] . "</td>";
													echo  "</tr>";
											}}?>
										</tbody>
									</table>
								</div>
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


  </div>
</div></body>
  <!--   Core JS Files   -->
  <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

  <!--  Notifications Plugin    -->
  <script src="assets/js/bootstrap-notify.js"></script>

	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
</html>
