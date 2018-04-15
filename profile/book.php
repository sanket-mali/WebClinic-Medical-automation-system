<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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


	if($_POST){

		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://localhost/clinic/v3/api/doctor/' . $_POST['location'] . '/' . $_POST['speciality']
		));

		$rec = json_decode(curl_exec($ch), true);
		echo "<script> var result = " . curl_exec($ch) . ";</script>";
	}

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
                <li>
                    <a href="symptomchecker.php">
                        <i class="pe-7s-help1"></i>
                        <p>Symptom Checker</p>
                    </a>
                </li>
                <li class="active">
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
					<a class="navbar-brand" href="#"><i class="fa pe-7s-ticket" style="font-weight:bold"></i> &nbsp;Doctor's Appointment</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
								<img src="../docs/img/<?php echo $update->client[0]->imid;?>" style="width:35px;height:35px;border-radius:50%;display:inline-block">
								<p style="float:right;padding-top:10px;padding-left:5px">
									Welcome,  <?php echo $_SESSION['name'] ?>
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
                                    <img src="assets/img/search.jpg" style="box-shadow:18px 18px 18px 18px white inset;">
                                </div>
                                <form class="login100-form validate-form" id="regForm" method="post" action="book.php">
                                    <div class="login100-form-title">
                                        Search doctor
                                    </div>
                                    <div class="wrap-input100">
                                        <input placeholder="location" name="location" class="input100" required>
                                        <span class="symbol-input100">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        </span>
                                    </div>

                                    <div class="wrap-input100">
                                        <input placeholder="Speciality" list="speciality" name="speciality" class="input100" required>
																				<datalist id="speciality">
																					<option value="General">
																					<option value="Gyno">
																					<option value="opthal">
																				</datalist>
                                        <span class="symbol-input100">
                                            <i class="fa fa-stethoscope" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <button type="submit" class="check-form-btn" id="search" style="width:100%;float:right">Search</button>
                                </form>
																<br/>
																<br/>

																<!--dynamically load-->
																<?php $x=0; if(isset($rec) && $rec['exists'] == "true"){?>
																	<div class="doctor-main-card"><select id="field"><option value="Rating">Rating</option><option value="Votes">Votes</option>
																	<option value="Fees">Fees</option></select><select id="order"><option value="Asc">Low-to-High</option><option value="Desc">High-to-Low</option></select><button style="background:green;margin-left:4px;padding:4px" onclick="sortedUpdate()">sort</button></div>
																 	<?php foreach($rec['doctor'] as $doc){?>
																		<form class="doctor-main-card" method="post" action="createAppointment.php">
																<div class="doctor-main-card" style="margin-top:15px;" id="doc<?php echo $x; ?>">
																	<input type="hidden" name="did" id="did<?php echo $x;?>" value="<?php echo $doc['did'];?>">
												            <div class="row docup">
												                <div class="col-md-2">
																					<div class="doc-card-image"><img id="imid<?php echo $x;?>" <?php if($doc['imid'] != "") echo "src=\"../docs/img/" .$doc['imid'] . "\""; else echo "src=\"assets/img/default-avatar.png\"";?> alt=""></div>
																				</div>
																				<div class="col-md-8">
												                <div class="doc-card-info" >
												                    <h2 id="name<?php echo $x;?>" >Dr. <?php echo $doc['fname']; ?> <?php echo $doc['lname']; ?></h2>
												                    <label id="verified<?php echo $x;?>"><?php if($doc['verified'] == "true") echo "<i class=\"fas fa-check-circle\" style=\"color:green\"></i>&nbsp;&nbsp;Registration Verified"; else echo "<i class=\"fas fa-check-circle\" style=\"color:red\"></i>&nbsp;&nbsp;Unverified Doctor"; ?></label>
												                    <br/><label id="rating<?php echo $x;?>"><?php if($doc['rating'] >= 2.5)
																																														echo "<i class=\"fa fa-thumbs-up\" aria-hidden=\"true\" style=\"color:green\"></i>&nbsp;&nbsp";
																																													else
																																														echo "<i class=\"fas fa-thumbs-down\" aria-hidden=\"true\" style=\"color:red\"></i>&nbsp;&nbsp";

																																													echo $doc['rating']*100/5 ."%". "( ".$doc['votes']." votes )"; ?></label>
												                    <div class="specialization" id="expert<?php echo $x;?>"><p ><?php echo $doc['expert'] ?></p></div>
																				</div>
																			</div>
												            </div>
																		<div class="row doclower">
													               <div class="doc-address">
													                   <h2 id="city<?php echo $x;?>"><?php echo $doc['city'];?></h2>
													                   <div class="address" id="address<?php echo $x;?>"><p><?php echo $doc['address'];?></p></div>
													               </div>
																				<!--doctor schedule-->
												                 <div>
																					 	<div class="schedule">
																						 	<select name="slotid" style="display:none;color:white" id="timeslot<?php echo $x;?>" onchange="getAppointDate(this)"></select>
																							<input type="text" name="date" id="calender<?php echo $x;?>" style="display:none;padding:2px;color:white" readonly>
																					 </div>
												                 </div>
																			<!--Doctor schedule end-->
												                <div class="fee">
												                    <h3 id="fees<?php echo $x;?>">Rs. <?php echo $doc['fees']; ?></h3><br/>
												                </div>
																			</div>
																			<div class="row doclower" style="padding:0px;">
																			<div class="operation">
																				<button type="button" class="btn btn1 btnbook" id="<?php echo $x;?>" style="border-right:4px solid #008080;font-weight:500px;border-radius:15px 0px 0px 15px;float:left;width:50%" onclick="fetchSlots(this.id)">Get slots</button>
																				<button type="submit" name="appointment" class="btn btn1 btnbook" style="float:right;width:50%;border-radius:0px 15px 15px 0px" name="appoint"><div>Make appointment</div></button>
																			</div>
												            </div>
																</div>
															</form>
															<?php $x++; }}
																elseif(isset($rec) && $rec['exists'] == "false")  echo "<div class=\"content\">
													            <div class=\"container-fluid\">
																				<p>No doctor found</p>
																			</div>
																			</div>";  ?>


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
var doc1=result['doctor'];

function sortedUpdate()
{
	var choicefld=document.getElementById('field');
	var field=choicefld.options[choicefld.selectedIndex].text;
	var choiceordr=document.getElementById('order');
	var order=choiceordr.options[choiceordr.selectedIndex].value;
	switch(field)
	{
		case "Rating":
			if(order=="Desc")
				ratingSortDesc();
		  else
				ratingSortAsc();
			break;
		case "Votes":
			if(order=="Desc")
					votesSortDesc();
			else
					votesSortAsc();
			break;
		case "Fees":
			if(order=="Desc")
				feeSortDesc();
			else
				feeSortAsc();
			break;
	}

	for(var i=0;i<doc1.length;i++)
	{
		document.getElementById("name"+i).innerHTML="Dr." + doc1[i]['fname'] + " " + doc1[i]['lname'];
		console.log(doc1[i]['verified']);

		document.getElementById("did"+i).value=doc1[i]['did'];

		if(doc1[i]['verified'] == "true")
				document.getElementById("verified"+i).innerHTML="<i class=\"fas fa-check-circle\" style=\"color:green\"></i>&nbsp;&nbsp;Registration Verified";
		else
				document.getElementById("verified"+i).innerHTML="<i class=\"fas fa-check-circle\" style=\"color:red\"></i>&nbsp;&nbsp;Unverified Doctor";

		if(doc1[i]['imid'] != ""){
				document.getElementById("imid"+i).src="../docs/img/" + doc1[i]['imid'];
			}
		else
				document.getElementById("imid"+i).src="assets/img/default-avatar.png";

		if(parseFloat(doc1[i]['rating'])>= 2.5)
				document.getElementById("rating"+i).innerHTML="<i class=\"fa fa-thumbs-up\" aria-hidden=\"true\" style=\"color:green\"></i>&nbsp;&nbsp;" + parseFloat(doc1[i]['rating']*100/5) + "%" + "( " + doc1[i]['votes'] + " votes )";
		else
				document.getElementById("rating"+i).innerHTML="<i class=\"fas fa-thumbs-down\" aria-hidden=\"true\" style=\"color:red\"></i>&nbsp;&nbsp;" + parseFloat(doc1[i]['rating']*100/5) + "%" + "( " + doc1[i]['votes'] + " votes )";

		document.getElementById("expert"+i).innerHTML= doc1[i]['expert'];
		document.getElementById("city"+i).innerHTML= doc1[i]['city'];
		document.getElementById("address"+i).innerHTML= doc1[i]['address'];
		document.getElementById("fees"+i).innerHTML= "Rs. " + doc1[i]['fees'];



	}
	//console.log(doc1);
}

function feeSortDesc(){
	doc1.sort(function(a,b){
		return parseFloat(b.fees)-parseFloat(a.fees);
	});
}

function feeSortAsc(){
	doc1.sort(function(a,b){
		return parseFloat(a.fees)-parseFloat(b.fees);
	});
}

function ratingSortDesc(){
	doc1.sort(function(a,b){
		return parseFloat(b.rating)-parseFloat(a.rating);
	});
}

function ratingSortAsc(){
	doc1.sort(function(a,b){
		return parseFloat(a.rating)-parseFloat(b.rating);
	});
}

function votesSortDesc(){
	doc1.sort(function(a,b){
		return parseFloat(b.votes)-parseFloat(a.votes);
	});
}

function votesSortAsc(){
	doc1.sort(function(a,b){
		return parseFloat(a.votes)-parseFloat(b.votes);
	});
}

</script>


<script>

function fetchSlots(id){
	var docID = document.getElementById("did"+id).value;

	var resultslot;
	$.ajax({url: "http://localhost/clinic/v3/api/appointment/available_slots/" + docID, success : function(result){
		//resultslot=result['appointment'][0];
		var pos=document.getElementById("timeslot"+id);
		pos.style.display="block";

		var nopt = document.createElement('option');
		nopt.innerHTML = "--";
		pos.appendChild(nopt);


		for (var i = 0; i<result['appointment'].length; i++){
	    var opt = document.createElement('option');
	    opt.value = result['appointment'][i]['slotid'];
	    opt.innerHTML = result['appointment'][i]['day']+" "+result['appointment'][i]['from_time']+" "+result['appointment'][i]['to_time'];
	    pos.appendChild(opt);
		}
	}});


}


function getAppointDate(sel) {

		var dayOfWeek = sel.options[sel.selectedIndex].text;
		var today = new Date();
		var days = {"Sunday": 0, "Monday": 1 , "Tuesday": 2, "Wednesday": 3, "Thursday": 4, "Friday": 5, "Saturday": 6, "Sunday": 7};
		var day = days[dayOfWeek.substr(0,dayOfWeek.indexOf(' '))];
    var resultDate = new Date(today.getTime());

    resultDate.setDate(resultDate.getDate() + (day + 7 - resultDate.getDay()) % 7);

		var dd = resultDate.getDate();
		var mm = resultDate.getMonth()+1;

		var yyyy = resultDate.getFullYear();
		if(dd<10){
		    dd='0'+dd;
		}
		if(mm<10){
		    mm='0'+mm;
		}
		var today = yyyy+'-'+mm+'-'+dd;
		document.getElementById("calender"+sel.id.substr(8)).style.display="block";
		document.getElementById("calender"+sel.id.substr(8)).value = today;

    alert("Tentative appointment on " + resultDate.toDateString());
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
