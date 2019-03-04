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
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="Chrissy Collins" name="author">
	<link href="assets/css/vanillaCalendar.css" rel="stylesheet">

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
	<link rel="stylesheet" type="text/css" href="assets/css/admin.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
	<style>
        .modal-dialog{
            width:80%;
            padding-top:3%;
            padding-left:15%;
            height:auto;
        }

        @media screen and (max-width: 992px) {
	    .modal-dialog  {
            width:90%;
            padding-left:2%;
			}
		}

		@import "lesshat";

		.star-ratings-sprite {
			background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2605/star-rating-sprite.png") repeat-x;

			overflow: hidden;
			width: 110px;
			margin: 0;
			padding:0;
		}
		.star-ratings-sprite-rating {
			background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2605/star-rating-sprite.png") repeat-x;

		}

		#slot{
			color:black;
			width:20px;
		}

    </style>
</head>
<body >


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

    <div class="main-panel" >
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


        <div class="content" >
            <div class="container-fluid">
				<div class="login100-form-title">
				Search doctor
				</div>
                <div class="row">
					<form class=" validate-form" id="regForm" method="post" action="book.php">
						<div class="doc-search-form col-md-10">
							<div style="float:left;width:50%;border-right:2px solid #93969b">
								<input type="text" class="inputrec" name="location" style="width:100%;border-radius:5px 0px 0px 5px;" placeholder="location" required>
							</div>
							<div style="display:inline-block;width:50%;">
								<input type="text" class="inputrec" list="speciality" name="speciality" style="width:100%;border-radius:0px 5px 5px 0px" placeholder="specialization" required>
								<datalist id="speciality">
									<option value="General">
									<option value="Gyno">
									<option value="opthal">
								</datalist>
							</div>
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn1" id="search" style="width:100%;float:left;padding:6px">Search</button>
						</div>
					</form>
				</div>

					<!--dynamically load-->
					<?php $x=0; if(isset($rec) && $rec['exists'] == "true"){?>
					<div class="row">
							<div style="float:right;margin-right:22px;margin-top:10px">
								<select id="field">
									<option value="Rating">Rating</option>
										<option value="Votes">Votes</option>
										<option value="Fees">Fees</option>
								</select>
								<select id="order">
									<option value="Asc">Low-to-High</option>
									<option value="Desc">High-to-Low</option>
								</select>
								<button class="btn btn1" style="padding:2px;padding-left:10px;padding-right:10px" onclick="sortedUpdate()">sort</button>
							</div>
					</div>
					<div class="row">
						<div id="treatment" class="cardbody" style="padding-top:10px">
                            <div class="card" style="width:100%">
                                <div class="content" style="padding:0px;width:100%;background-color: rgb(228, 230, 227);border-style:none">
									<?php foreach($rec['doctor'] as $doc){?>
										<!--<form method="post" action="createAppointment.php">-->
											<div class="list_general1" style="margin-bottom:10px;background-color: rgb(255, 255, 255);border:none">
												<ul>
													<li>
														<figure><img id="imid<?php echo $x;?>" <?php if($doc['imid'] != "") echo "src=\"../docs/img/" .$doc['imid'] . "\""; else echo "src=\"assets/img/default-avatar.png\"";?> alt=""></figure>
														<input type="hidden" name="did" id="did<?php echo $x;?>" value="<?php echo $doc['did'];?>">
														<small id="expert<?php echo $x;?>"><?php echo $doc['expert'] ?></small>
														<h4 id="name<?php echo $x;?>">Dr. <?php echo $doc['fname']; ?> <?php  echo $doc['lname']; ?></h4>
														<p style="font-size:12px;" id="verified<?php echo $x; ?>"><?php if($doc['verified'] == "true") echo "<i class=\"fas fa-check-circle\" style=\"color:green\"></i>&nbsp;&nbsp;Registration Verified"; else echo "<i class=\"fas fa-check-circle\" style=\"color:red\"></i>&nbsp;&nbsp;Unverified Doctor"; ?></p>
														<div class="star-ratings-sprite"><span style="width:52%" class="star-ratings-sprite-rating"></span></div><br/>
														<p style="font-size:14px;float:left;margin-bottom:1px" id="city<?php echo $x;?>"><i class="fa fa-address-book"></i>&nbsp;<?php echo $doc['city']; ?>,&nbsp;<p style="font-size:14px;display:inline-block;margin-bottom:1px" id="address<?php echo $x;?>"><?php echo $doc['address'];?></p><br></p>
														<p style="font-size:14px" id="fees<?php echo $x; ?>"><i class="fa fa-inr"></i>&nbsp;<?php echo $doc['fees']; ?></p>
														<!--<p><button type="button" id="btnview" data-id="<?//php echo $x;?>" data-toggle="modal" data-target="#myModal" class="btn_1 gray view"><i class="fa fa-fw fa-user"></i> View profile</button></p>-->
														<ul class="buttons">
															<li><button type="button" id="btncancel" data-id="<?php echo $x;?>" data-toggle="modal" data-target="#myModal" class="btn_1 gray delete wishlist_close" id="0"><i class="fa fa-check"></i> Book Now</button></li>
														</ul>
													</li>
												</ul>
											</div>
										<!--</form>-->
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

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="float:left;width:100%">

	  <!-- Modal content-->
	  <form method="post" action="createAppointment.php">
			<div class="modal-content" style="float:left;width:100%">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Book Appointment</h4>
				</div>
				<div class="modal-body" style="float:left;width:100%;padding:0;padding-left:15px">
					<!--calender-->
					<div class="container" style="float:left;padding-left:0;width:100%">
						<div id="v-cal" style="float:left">
							<div class="vcal-header">
								<button type="button" class="vcal-btn" data-calendar-toggle="previous">
									<svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
									</svg>
								</button>

								<div class="vcal-header__label" data-calendar-label="month">

								</div>
								<button type="button" class="vcal-btn" data-calendar-toggle="next">
									<svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
									</svg>
								</button>
							</div>
							<div class="vcal-week">
								<span>Mon</span>
								<span>Tue</span>
								<span>Wed</span>
								<span>Thu</span>
								<span>Fri</span>
								<span>Sat</span>
								<span>Sun</span>
							</div>
							<div class="vcal-body" data-calendar-area="month"></div>
							<p>
								<input type="hidden" id="date" data-calendar-label="picked"></span>
							</p>
							<button type="button" class="btn_1 gray view wishlist_close" id="fetch">Fetch Slot</button>
							<h5 >
								<a href="https://github.com/chrisssycollins">@chrisssycollins</a>
							</h5>
						</div>
						<input type="hidden" id="docid" name="docid" value="">
						<input type="hidden" id="bookdate" name="bookdate" value="">
						<div id="displaypos" style="display:inline-block;padding-left:10%;width:40%">
							<div id="display" style="display:inline-block;padding-left:10%;width:40%">
							</div>
						</div>
					</div>

					<!---->
				</div>
				<div style="float:right;padding-right:15px;padding-bottom:15px">
					<button type="submit" name="appointment" class="btn_1 gray view wishlist_close">Confirm</button>
				</div>
			</form>
		</div>
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

		/*if(doc1[i]['verified'] == "true")
				document.getElementById("verified"+i).innerHTML="<i class=\"fas fa-check-circle\" style=\"color:green\"></i>&nbsp;&nbsp;Registration Verified";
		else
				document.getElementById("verified"+i).innerHTML="<i class=\"fas fa-check-circle\" style=\"color:red\"></i>&nbsp;&nbsp;Unverified Doctor";
		*/
		if(doc1[i]['imid'] != ""){
				document.getElementById("imid"+i).src="../docs/img/" + doc1[i]['imid'];
			}
		else
				document.getElementById("imid"+i).src="assets/img/default-avatar.png";
/*
		if(parseFloat(doc1[i]['rating'])>= 2.5)
				document.getElementById("rating"+i).innerHTML="<i class=\"fa fa-thumbs-up\" aria-hidden=\"true\" style=\"color:green\"></i>&nbsp;&nbsp;" + parseFloat(doc1[i]['rating']*100/5) + "%" + "( " + doc1[i]['votes'] + " votes )";
		else
				document.getElementById("rating"+i).innerHTML="<i class=\"fas fa-thumbs-down\" aria-hidden=\"true\" style=\"color:red\"></i>&nbsp;&nbsp;" + parseFloat(doc1[i]['rating']*100/5) + "%" + "( " + doc1[i]['votes'] + " votes )";
		*/document.getElementById("expert"+i).innerHTML= doc1[i]['expert'];
		document.getElementById("city"+i).innerHTML= doc1[i]['city'];
		document.getElementById("address"+i).innerHTML= doc1[i]['address'];
		document.getElementById("fees"+i).innerHTML= "<i class=\"fa fa-inr\"></i>&nbsp;" + doc1[i]['fees'];



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

	var date = getSQLDate(document.getElementById("date").innerText);
	//var resultslot;
	$.ajax({url: "http://localhost/clinic/v3/api/appointment/available_slots/" + docID + "/" + date, success : function(result){
		//resultslot=result['appointment'][0]['day'];
		document.getElementById("bookdate").value=date;
		var pos=document.getElementById("displaypos");
		$('#display').remove();
		var div1=document.createElement("div");
		pos.appendChild(div1);
		div1.id="display";
		if(result['exists'] == "false"){
			var label = document.createElement("label");
			label.innerHTML = "No slots on this day";
			div1.appendChild(label);

		}
		for(var i=0;i<result['appointment'].length;i++)
		{
			var label = document.createElement("label");
			var radio=document.createElement("input");
			radio.type="radio";
			radio.name="slotid";
			radio.id="slotid";
			radio.value=result['appointment'][i]['slotid'];
			label.appendChild(radio);
			label.appendChild(document.createTextNode(result['appointment'][i]['from_time']+ " to " +result['appointment'][i]['to_time']));
			//radio.innerText=result['appointment'][i]['from_time']+result['appointment'][i]['to_time'];
			//radio.innerHTML="hgd";
			div1.appendChild(label);
		}
	}});


}


function getSQLDate(d) {

    var resultDate = new Date(d);

		var dd = resultDate.getDate();
		var mm = resultDate.getMonth()+1;

		var yyyy = resultDate.getFullYear();
		if(dd<10){
		    dd='0'+dd;
		}
		if(mm<10){
		    mm='0'+mm;
		}
		resultDate = yyyy+'-'+mm+'-'+dd;
    //alert("Tentative appointment on " + resultDate.toDateString());

		return resultDate;
}
</script>


	<script>
    /*$(document).on("click", ".view", function () {
     var myBookId = $(this).data('id');
     $(".modal-title").text( myBookId );
    $('#myModal').modal('show');
	});*/
	</script>
	<script>
	var Id;
		$(document).on("click", ".delete", function () {
		Id = $(this).data('id');
		document.getElementById("docid").value=document.getElementById("did"+Id).value;
		//alert(Id);
		//$(".modal-title").text( myBookId );
		});
	</script>
	<!--   Calender   -->
	<script src="assets/js/vanillaCalendar.js" type="text/javascript"></script>

	<script>
		window.addEventListener('load', function () {
			vanillaCalendar.init({
				disablePastDays: true
			});
		})
	</script>
	<script>
	$("#fetch").on("click", function () {
		fetchSlots(Id);
	});
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
