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
    <style>
    @media screen and (max-width: 992px) {
      #multiparts  {
        margin-top:20px;
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

      $ch = curl_init();

      curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost/clinic/v3/api/client/' . $_GET["rid"] ."/medicines"
      ));



      $medrecords = json_decode(curl_exec($ch), true);

      echo $medrecords['exists'];


      echo $_GET["rid"];

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


        <div class="content">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-sm-16">
                        <!---->
                        <?php $x=0; if(isset($medrecords) && $medrecords['exists'] == "true"){?>
                        <?php foreach($medrecords['medicines'] as $rec){?>
                            <div class="cardbody" style="padding-top:0px">
                                <div class="card" style="width:100%;margin-bottom:0px">
                                    <div class="content" style="padding:0px;width:100%;background-color: rgb(228, 230, 227);border-style:none">
                                        <!-- -->

                                        <form method="post">
                                            <div class="list_general1" id="doc<?php echo $x; ?>" style="background-color: rgb(255, 255, 255);border:none;box-shadow:none">
                                                <ul>
                                                    <li style="padding:20px">
                                                        <input type="text" style="padding:5px;background-color:silver;border-radius:10px" id="medname<?php echo $x;?>" value="<?php echo $rec['mname']; ?>">
                                                        <input type="time" style="background-color:silver;border-radius:10px;padding:5px" id="time<?php echo $x; ?>" value="<?php echo $rec['time']; ?>">
                                                        <input style="font-size:14px;padding:5px;background-color:silver;border-radius:10px" id="rep<?php echo $x; ?>" value="<?php echo $rec['repetition']; ?>">
                                                        <input style="font-size:14px;padding:5px;background-color:silver;border-radius:10px" id="dur<?php echo $x; ?>" value="<?php echo $rec['duration']; ?>">
                                                        <!--<p><button type="button" id="<?//php echo $x; ?>" class="btn_1 gray view"><i class="fa fa-fw fa-user"></i> Approve</button></p>-->
                                                        <button type="button" id="multipart"  class="btn_1 gray view wishlist_close" id="fetch" onclick="medicines(this)">Update</button>
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

<script>
/*function medicines(element)
{
  var id=element.getAttribute('data-id');
  fetchMeds(id);
}
function fetchMeds(id){
	var rpid = document.getElementById("rpid"+id).value;
	//var resultslot;
	$.ajax({url: "http://localhost/clinic/v3/api/client/" + rpid + "/medicines", success : function(result){
		//resultslot=result['appointment'][0]['day'];
		//document.getElementById("bookdate").value=date;
		var pos=document.getElementById("modalpos");

		//$('#display').remove();*/
    //div1.parentNode.removeChild(div1);
    //var div1=document.createElement("div");
		//pos.appendChild(div1);
		//div1.id="display";
		/*for(var i=0;i<result['medicines'].length;i++)
		{
			var radio=document.createElement("input");
			radio.type="text";
      radio.className="form-control";
			radio.value=result['medicines'][i]['mname'];
      radio.width="25px";
			div1.appendChild(radio);
      var timeslot=document.createElement("input");
      timeslot.type="text";
      timeslot.className="form-control";
      timeslot.value=result['medicines'][i]['time'];
      timeslot.width="25%";
      div1.appendChild(timeslot);
      var rep=document.createElement("input");
      rep.type="text";
      rep.value=result['medicines'][i]['repetition'];
      rep.className="form-control";
      rep.width="25%;"
      div1.appendChild(rep);

		}
    pos.appendChild(div1);
    //alert(result['medicines'][0].mname);
	}});


}*?

</script>


</body>

    <!--   Core JS Files   -->

	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
</html>
