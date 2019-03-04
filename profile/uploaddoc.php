<!doctype html>
<html lang="en">
<head>
  <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="assets/img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>webclinic</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Charts Plugin -->
    <script src="assets/js/chartist.min.js"></script>

      <!--  Notifications Plugin    -->
      <script src="assets/js/bootstrap-notify.js"></script>

    <script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
    <style>
    canvas
    {
        pointer-events: none;       /* make the canvas transparent to the mouse - needed since canvas is position infront of image */
        position: absolute;
    }
    #detailform{
    position: absolute;
    z-index: 9;
    text-align: center;
    cursor: move;
    /*border: 1px solid #d3d3d3;*/
    }
    .detailbody{
      padding-top:15px;
      padding-left:2px;
      padding-right:2px;
      background-color:whitesmoke;
      border-radius:8px;
      box-shadow: 0 0 10px #000000;
    }
    .detailbody:hover{
      box-shadow: 0 0 15px #000000;
    }
    </style>
</head>
<body onload='myInit()'>

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

  $rpid = "";
  $ocr = 0;

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

  if(isset($_POST['detsave'])){

    $ch = curl_init();

    curl_setopt_array($ch, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => 'http://localhost/clinic/v3/api/client/' . $_SESSION['username'] . '/record',
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => http_build_query($_POST)
    ));

    $res = json_decode(curl_exec($ch));

    if($res->success == "true"){

      echo "Done";
      header("Location: http://localhost/clinic/v3/profile/medicalrecord.php");
    }
    else{
      echo $res->message;
      header("Location: http://localhost/clinic/v3/profile/uploaddoc.php");
    }

  }
  ?>
  <?php

  function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
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
          <a class="navbar-brand" href="#"><i class="fa pe-7s-note1" style="font-weight:bold"></i> &nbsp;Medical Record</a>
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
                  <div class="container-login100">
                    <div class="wrap-login100">
                        <div class="login100-form-title">
                                Medical records
                        </div>
                        <div class="medicalrecord">
                            <h4>Upload Document</h4>
                            <form enctype="multipart/form-data" id="upl" action="uploaddoc.php" method="POST" >
                                <div class="upload">
                                    <label for="doc">
                                        <img src="assets/img/upload.png" style="width:90%">
                                    </label>
                                <input type="file" required id="doc" style="width:150px;" name="uploaddocument">
                                </div>
                                <input type="date" required class="inputrec" name="date" style="width:50%;height:40px">
                                <input type="submit" value="Upload" class="btn btn1" style="width:20%">
                            </form>
                            <canvas id="myCanvas"></canvas>
                            <!--ocr php code-->

                            <?php
                              $api_key = 'AIzaSyCYXo5jeL_FU-DsrbbhrYz660e7Qlo7CxE';
                              $url = "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key;
                              $detection_type = "TEXT_DETECTION";
                              $allowed_types = array('image/jpeg','image/png','image/gif');
                              $proxy = '172.31.102.29:3128';
                              $proxyauth = 'edcguest:edcguest';
                              if($_FILES){
                                if(in_array($_FILES['uploaddocument']['type'],$allowed_types)){

                                    // base64 encode image
                                      imagejpeg(resize_image($_FILES['uploaddocument']['tmp_name'], 720, 1280), "../docs/temp/".$_FILES['uploaddocument']['name'] . "_res.jpg");
                                      $image = file_get_contents("../docs/temp/".$_FILES['uploaddocument']['name'] . "_res.jpg");
                                      $temp_file_path = "../docs/temp/".$_FILES['uploaddocument']['name'] . "_res.jpg";
                                      #$image = file_get_contents($_FILES['uploaddocument']['tmp_name']);
                                    $image_base64 = base64_encode($image);

                                    $json_request ='{
                                          "requests": [
                                          {
                                            "image": {
                                              "content":"' . $image_base64. '"
                                            },
                                            "features": [
                                                {
                                                  "type": "' .$detection_type. '",
                                              "maxResults": 200
                                                }
                                            ]
                                          }
                                        ]
                                      }';

                                    $curl = curl_init();

                                    curl_setopt($curl, CURLOPT_URL, $url);
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
                                    curl_setopt($curl, CURLOPT_POST, true);
                                          curl_setopt($curl, CURLOPT_POSTFIELDS, $json_request);
                                          curl_setopt($curl, CURLOPT_PROXY,$proxy);
                                          curl_setopt($curl, CURLOPT_PROXYUSERPWD,$proxyauth);

                                    $json_response = curl_exec($curl);
                                    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                                    curl_close($curl);

                                    // verify if we got a correct response
                                    if ( $status != 200 ) {
                                         die("Something when wrong. Status code: $status" );

                                      }

                                    // transform the json response to an associative array
                                    $response = json_decode($json_response, true);

                                    ?>
                                    <map name="mymap">
                                    <?php $i=0; $a=0;
                                    foreach($response['responses'][0]['textAnnotations'] as $box){
                                      if($a!=0)
                                      {
                                        $x=0;
                                        $x1;
                                        $x2;
                                        $y1;
                                        $y2;
                                        foreach($box['boundingPoly']['vertices'] as $vertex){
                                          if($x==0)
                                          {
                                            $x1=$vertex['x'];
                                            $y1=$vertex['y'];
                                          }
                                          if($x==2)
                                          {
                                            $x2=$vertex['x'];
                                            $y2=$vertex['y'];
                                          }
                                          $x++;
                                        }?>
                                        <area shape="rect" coords="<?php echo $x1?>,<?php echo $y1?>,<?php echo $x2?>,<?php echo $y2?>" onmouseover="myHover(this)" onmouseout="myLeave(this)" onclick="function1(this)" val="<?php echo $box['description'];?>" name="<?php echo$i;?>" id="<?php echo$i;?>">
                                        <?php
                                        //imagepolygon($im, $points, count($box['boundingPoly']['vertices']), $red);
                                      }
                                      $i++;
                                      $a++;
                                      }

                                      #$image_name = time().'.jpg';
                                      #imagejpeg($im, $image_name);
                                      $file_tmp = $_FILES['uploaddocument']['tmp_name'];
                                      $file_ext=strtolower(end(explode('.',$_FILES['uploaddocument']['name'])));
                                      $file_name = substr(md5(microtime()),rand(0,26),7) . '.' . $file_ext;
                                      $file_path = "../docs/prescription/".$file_name;
                                      move_uploaded_file($file_tmp,$file_path);



                                      $ch = curl_init();

                                      $rec = array('date' => $_POST['date'] , 'file_name' => $file_name);


                                      curl_setopt_array($ch, array(
                                        CURLOPT_RETURNTRANSFER => 1,
                                        CURLOPT_URL => 'http://localhost/clinic/v3/api/client/' . $_SESSION['username'] . '/record',
                                        CURLOPT_POST => 1,
                                        CURLOPT_POSTFIELDS => $rec
                                      ));

                                      $res = json_decode(curl_exec($ch));

                                      if($res->success == "true"){
                                        $rpid = $res->rpid;

                                        $ocr = 1;

                                      }
                                      else{
                                        #echo $res->message . $status;

                                      }


                                      }
                                     else{
                                    echo 'File type not allowed';
                                    }

                                }
                              ?>
                            </map>
                            <!---->
                        </div>
                        <div class="medicalrecord uploadbody">
                          <div class="detailbody"  id="detailform" style="<?php if($ocr == 1) echo "display:block"; else{echo "display:none";} ?>">
                            <div class="login100-form-title">
                                Fill Details
                            </div>
                            <div class="medicalrecord uploadform">
                              <form method="post" action="uploaddoc.php">
                                <input type="hidden" name="rpid" value="<?php echo $rpid; ?>">
                                <input type="text" required name="dname" class="inputrec" onclick="fillText(this)" placeholder="Doctor" id="docdetails" style="width:300px;margin-right:3px">
                                <input type="text" required name="diagnosis" class="inputrec" onclick="fillText(this)" placeholder="Diagnosis" id="diagnosisdetails" style="width:300px;margin-right:49px;margin-bottom:10px">
                                <div style="paddin-left:30px;padding-right:30px">
                                    <div id="pos">
                                        <div style="margin-bottom:10px">
                                            <input type="text" required name="mname0" onclick="fillText(this)" placeholder="Medicine Name" class="inputrec" style="width:200px">
                                            <input type="time" required name="time0" onclick="fillText(this)" placeholder="Time" class="inputrec" style="width:130px">
                                            <input type="text" required name="repetition0" onclick="fillText(this)" placeholder="Repetition" class="inputrec" style="width:135px">
                                            <input type="text" required name="duration0" onclick="fillText(this)" placeholder="Duration" class="inputrec" style="width:135px">
                                            <a style="text-decoration:none;color:blue" onclick="myfunc1(this)"><i class="fa fa-window-close"></i></a>
                                        </div>
                                    </div>
                                    <div >
                                        <button type="button" onclick="addslot()" style="margin-top:10px;margin-bottom:10px;width:130px;height:30px;border-radius:20px;background-color:silver"><span><i class="fa fa-plus"></i></span>New Medicine</button>
                                    </div>
                                </div>
                                <button type="submit" name="detsave" class="btn btn1" style="padding-top:6px;padding-bottom:6px;width:100px;float:right;margin-right:55px;margin-bottom:10px">Save</button>
                              </form>
                            </div>
                          </div>
                          <div class="uploadimg">
                              <div  id="animation" style="display:none">
                                <img src="assets/img/eye.gif">
                              </div>
                              <img src="<?php echo $temp_file_path; ?>" alt="" onload="imgload()" usemap="#mymap" id='imgdoc'>
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
</body>
<script>
$(document).ready(function(){
    $('#upl').submit(function(){
        //alert("Submitted");
        document.getElementById("animation").style.display="block";
    });
});
/*$(document).ready(function(){
function imgload()
{
  document.getElementById("detailform").style.display="block";
}
});*/
</script>
<script>
        var i=1;
        function addslot()
        {
            var cont=document.getElementById("pos");
            var pos=document.createElement("div");
            pos.style.marginBottom="10px";
            pos.id="slotpos"+i;
            var inpt0 = document.createElement('input');
            inpt0.type="text";
            inpt0.placeholder="Medicine";
            inpt0.name="mname"+i;
            inpt0.className="inputrec";
            inpt0.onclick=function(){fillText(this)};
            inpt0.style.width="200px";
            inpt0.style.marginLeft="2px";
            pos.appendChild(inpt0);

            var inpt1 = document.createElement('input');
            inpt1.type="time";
            inpt1.placeholder="Time";
            inpt1.name="time"+i;
            inpt1.className="inputrec";
            inpt1.style.width="130px";
            inpt1.onclick=function(){fillText(this)};
            inpt1.style.marginLeft="2px";
            pos.appendChild(inpt1);

            var inpt2 = document.createElement('input');
            inpt2.type="text";
            inpt2.placeholder="Repetition";
            inpt2.name="repetition"+i;
            inpt2.className="inputrec";
            inpt2.onclick=function(){fillText(this)};
            inpt2.style.width="135px";
            inpt2.style.marginLeft="2px";
            pos.appendChild(inpt2);

            var inpt3 = document.createElement('input');
            inpt3.type="text";
            inpt3.placeholder="Duration";
            inpt3.name="duration"+i;
            inpt3.className="inputrec";
            inpt3.onclick=function(){fillText(this)};
            inpt3.style.width="135px";
            inpt3.style.marginLeft="2px";
            pos.appendChild(inpt3);

            var anc = document.createElement('a');
            anc.innerHTML="<i class=\"fa fa-window-close\"></i>";
            anc.style.textdecoration="none";
            anc.id="slot"+i;
            anc.style.color="blue";
            anc.onclick=myfunc;
            anc.style.cursor="pointer";
            anc.style.margin="5px";
            pos.appendChild(anc);
            cont.appendChild(pos);
            i++;

        }
    function myfunc()
    {
        //alert(this.parentNode.id);
        this.parentNode.parentNode.removeChild(this.parentNode);
        i--;
    }
    function myfunc1(a)
    {
        //alert(this.parentNode.id);
        a.parentNode.parentNode.removeChild(a.parentNode);
        i=0;
    }
    </script>
<script>
//Make the DIV element draggagle:
dragElement(document.getElementById(("detailform")));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id)) {
    /* if present, the header is where you move the DIV from:*/
    document.getElementById(elmnt.id).onmousedown = dragMouseDown;
  } else {
    /* otherwise, move the DIV from anywhere inside the DIV:*/
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    /* stop moving when mouse button is released:*/
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
</script>
  <script>
  var t=0;
  var selectedtext="";
  var start=-1;
  var end=-1;
  function getText()
  {
  	var areas = document.getElementsByTagName('area')
  	var x1,y1,x2,y2;
  	for(var i=start-1;i<end;i++)
  	{
  		selectedtext+=areas[i].getAttribute("val")+" ";
  		//alert(areas[i].coords);
  		fillMyRect(areas[i].coords);
  	}
  	//alert(selectedtext);
  }
  function function1(a)
  {

  	if(t==0)
  	{
  		myLeaveStart();
  		selectedtext="";
  		start=a.getAttribute("name");
  		end=start;
  		fillMyRect(a.coords);
  		t=1;
  	}
  	else
  	{
  		end=a.getAttribute("name");
  		getText();
  		t=0;
  	}
  }
  </script>
  <script>
  function fillText(elem)
  {
    if(selectedtext!="")
    elem.value=selectedtext;
    selectedtext="";
  }
  </script>
  <script>
  // initialized in myInit, used in myHover and myLeave
  var hdc;

  // shorthand func
  function byId(e){return document.getElementById(e);}

  // draws a line from each co-ord pair to the next - assumes starting point needs to be repeated as ending point.

  function drawRect(coOrdStr)
  {
      var mCoords = coOrdStr.split(',');
      var top, left, bot, right;
      left = mCoords[0];
      top = mCoords[1];
      right = mCoords[2];
      bot = mCoords[3];
      hdc.strokeRect(left,top,right-left,bot-top);
  }
  function fillMyRect(coOrdStr)
  {
      var mCoords = coOrdStr.split(',');
      var top, left, bot, right;
      left = mCoords[0];
      top = mCoords[1];
      right = mCoords[2];
      bot = mCoords[3];
  	hdc.globalAlpha = 0.4;
  	hdc.fillStyle = "blue";
      hdc.fillRect(left,top,right-left,bot-top);
  }
  function clearMyRect(coOrdStr)
  {
      var mCoords = coOrdStr.split(',');
      var top, left, bot, right;
      left = mCoords[0];
      top = mCoords[1];
      right = mCoords[2];
      bot = mCoords[3];
  	hdc.clearRect(left,top,(right-left), (bot-top));
  }
  function myHover(element)
  {
      var hoveredElement = element;
      var coordStr = element.getAttribute('coords');
  	fillMyRect(coordStr);
  }

  function myLeave(a)
  {
  	var pos=a.getAttribute("name");
  	//alert(pos);
  	if(!(pos>=start&&pos<=end))
  	{
      	var canvas = byId('myCanvas');
  		var coords=a.coords;
  		clearMyRect(coords);
      	//hdc.clearRect(0, 0, canvas.width, canvas.height);
  	}
  }
  function myLeaveStart()
  {
      var canvas = byId('myCanvas');
  	hdc.clearRect(0, 0, canvas.width, canvas.height);
  }
  function myInit()
  {
      // get the target image
      var img = byId('imgdoc');

      var x,y, w,h;

      // get it's position and width+height
      x = img.offsetLeft;
      y = img.offsetTop;
      w = img.clientWidth;
      h = img.clientHeight;

      // move the canvas, so it's contained by the same parent as the image
      var imgParent = img.parentNode;
      var can = byId('myCanvas');
      imgParent.appendChild(can);

      // place the canvas in front of the image
      can.style.zIndex = 1;

      // position it over the image
      can.style.left = x+'px';
      can.style.top = y+'px';

      // make same size as the image
      can.setAttribute('width', w+'px');
      can.setAttribute('height', h+'px');

      // get it's context
      hdc = can.getContext('2d');

      // set the 'default' values for the colour/width of fill/stroke operations
      hdc.fillStyle = 'red';
      hdc.strokeStyle = 'red';
      hdc.lineWidth = 2;
  }
  </script>

    <!--   Core JS Files   -->


</html>
